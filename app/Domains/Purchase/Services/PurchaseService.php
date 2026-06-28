<?php

namespace App\Domains\Purchase\Services;

use App\Domains\Common\Services\BaseService;
use App\Domains\Product\Models\Product;
use App\Domains\Purchase\Models\Purchase;
use App\Domains\Purchase\Repositories\PurchaseRepository;
use App\Domains\Supplier\Models\Supplier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PurchaseService extends BaseService
{
    public function __construct(protected PurchaseRepository $purchases)
    {
    }

    public function paginate(?string $search = null): LengthAwarePaginator
    {
        return $this->purchases->list($search);
    }

    public function find(int $id): Purchase
    {
        return $this->purchases->findOrFail($id);
    }

    /**
     * Create a purchase with its items, increment stock and update supplier due.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Purchase
    {
        return $this->transaction(function () use ($data) {
            $user = auth()->user();

            $lines = [];
            $subtotal = 0;
            foreach ($data['items'] as $row) {
                $product = Product::findOrFail($row['product_id']);
                $qty = (float) $row['qty'];
                $unitPrice = (float) $row['unit_price'];
                $lineTotal = round($qty * $unitPrice, 2);

                $lines[] = [
                    'product'    => $product,
                    'qty'        => $qty,
                    'unit_price' => $unitPrice,
                    'total'      => $lineTotal,
                ];
                $subtotal += $lineTotal;
            }

            $total = max(0, round($subtotal, 2));
            $paid = isset($data['paid']) ? round((float) $data['paid'], 2) : $total;
            $due = max(0, round($total - $paid, 2));

            $purchase = Purchase::create([
                'branch_id'     => $user->branch_id ?? null,
                'supplier_id'   => $data['supplier_id'] ?? null,
                'user_id'       => $data['user_id'] ?? $user->id ?? null,
                'status'        => 'completed',
                'total'         => $total,
                'paid'          => $paid,
                'due'           => $due,
                'purchase_date' => $data['purchase_date'] ?? now()->toDateString(),
                'note'          => $data['note'] ?? null,
            ]);

            $purchase->update(['invoice_no' => 'PUR-' . str_pad((string) $purchase->id, 5, '0', STR_PAD_LEFT)]);

            foreach ($lines as $line) {
                $purchase->items()->create([
                    'product_id' => $line['product']->id,
                    'qty'        => $line['qty'],
                    'unit_price' => $line['unit_price'],
                    'total'      => $line['total'],
                ]);

                // Increase stock and refresh the latest purchase price.
                $line['product']->increment('stock_qty', $line['qty']);
                $line['product']->update(['purchase_price' => $line['unit_price']]);
            }

            if ($purchase->supplier_id && $due > 0) {
                Supplier::where('id', $purchase->supplier_id)->increment('due_balance', $due);
            }

            return $purchase;
        });
    }

    /**
     * Delete a purchase, reverse stock and supplier due.
     */
    public function delete(Purchase $purchase): bool
    {
        return $this->transaction(function () use ($purchase) {
            $purchase->loadMissing('items');

            foreach ($purchase->items as $item) {
                Product::where('id', $item->product_id)->decrement('stock_qty', $item->qty);
            }

            if ($purchase->supplier_id && $purchase->due > 0) {
                Supplier::where('id', $purchase->supplier_id)->decrement('due_balance', $purchase->due);
            }

            return (bool) $purchase->delete();
        });
    }

    /**
     * Update an existing purchase: reverse old side-effects, apply new ones.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(Purchase $purchase, array $data): Purchase
    {
        return $this->transaction(function () use ($purchase, $data) {
            $purchase->loadMissing('items');

            // ── 1. Reverse old side-effects ───────────────────────────
            foreach ($purchase->items as $item) {
                Product::where('id', $item->product_id)->decrement('stock_qty', $item->qty);
            }
            if ($purchase->supplier_id && $purchase->due > 0) {
                Supplier::where('id', $purchase->supplier_id)->decrement('due_balance', $purchase->due);
            }

            // ── 2. Delete old items ───────────────────────────────────
            $purchase->items()->delete();

            // ── 3. Build new line items ───────────────────────────────
            $lines    = [];
            $subtotal = 0;
            foreach ($data['items'] as $row) {
                $product   = Product::findOrFail($row['product_id']);
                $qty       = (float) $row['qty'];
                $unitPrice = (float) $row['unit_price'];
                $lineTotal = round($qty * $unitPrice, 2);

                $lines[] = [
                    'product'    => $product,
                    'qty'        => $qty,
                    'unit_price' => $unitPrice,
                    'total'      => $lineTotal,
                ];
                $subtotal += $lineTotal;
            }

            $total = max(0, round($subtotal, 2));
            $paid  = isset($data['paid']) ? round((float) $data['paid'], 2) : $total;
            $due   = max(0, round($total - $paid, 2));

            // ── 4. Update purchase header ─────────────────────────────
            $purchase->update([
                'supplier_id'   => $data['supplier_id'] ?? null,
                'total'         => $total,
                'paid'          => $paid,
                'due'           => $due,
                'purchase_date' => $data['purchase_date'] ?? $purchase->purchase_date,
                'note'          => $data['note'] ?? null,
            ]);

            // ── 5. Create new items, update stock & purchase price ────
            foreach ($lines as $line) {
                $purchase->items()->create([
                    'product_id' => $line['product']->id,
                    'qty'        => $line['qty'],
                    'unit_price' => $line['unit_price'],
                    'total'      => $line['total'],
                ]);
                $line['product']->increment('stock_qty', $line['qty']);
                $line['product']->update(['purchase_price' => $line['unit_price']]);
            }

            // ── 6. Apply new supplier due ─────────────────────────────
            if ($purchase->supplier_id && $due > 0) {
                Supplier::where('id', $purchase->supplier_id)->increment('due_balance', $due);
            }

            return $purchase->fresh();
        });
    }
}
