<?php

namespace App\Domains\Sales\Services;

use App\Domains\Common\Services\BaseService;
use App\Domains\Customer\Models\Customer;
use App\Domains\Product\Models\Product;
use App\Domains\Sales\Models\Sale;
use App\Domains\Sales\Repositories\SaleRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SaleService extends BaseService
{
    public function __construct(protected SaleRepository $sales)
    {
    }

    public function paginate(?string $search = null): LengthAwarePaginator
    {
        return $this->sales->list($search);
    }

    public function find(int $id): Sale
    {
        return $this->sales->findOrFail($id);
    }

    /**
     * Create a sale with its items, decrement stock and update customer due.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Sale
    {
        return $this->transaction(function () use ($data) {
            $user = auth()->user();

            // Build line items from posted products.
            $lines = [];
            $subtotal = 0;
            foreach ($data['items'] as $row) {
                $product = Product::findOrFail($row['product_id']);
                $qty = (float) $row['qty'];
                $unitPrice = isset($row['unit_price']) ? (float) $row['unit_price'] : (float) $product->sale_price;
                $lineTotal = round($qty * $unitPrice, 2);

                $lines[] = [
                    'product'    => $product,
                    'qty'        => $qty,
                    'unit_price' => $unitPrice,
                    'cost_price' => (float) $product->purchase_price,
                    'total'      => $lineTotal,
                ];
                $subtotal += $lineTotal;
            }

            $discount = round((float) ($data['discount'] ?? 0), 2);
            $total = max(0, round($subtotal - $discount, 2));
            $paid = isset($data['paid']) ? round((float) $data['paid'], 2) : $total;
            $due = max(0, round($total - $paid, 2));

            $sale = Sale::create([
                'branch_id'   => $user->branch_id ?? null,
                'customer_id' => $data['customer_id'] ?? null,
                'user_id'     => $data['user_id'] ?? $user->id ?? null,
                'status'      => 'completed',
                'total'       => $total,
                'discount'    => $discount,
                'paid'        => $paid,
                'due'         => $due,
                'sale_date'   => now()->toDateString(),
                'note'        => $data['note'] ?? null,
            ]);

            $sale->update(['invoice_no' => 'INV-' . str_pad((string) $sale->id, 5, '0', STR_PAD_LEFT)]);

            foreach ($lines as $line) {
                $sale->items()->create([
                    'product_id' => $line['product']->id,
                    'qty'        => $line['qty'],
                    'unit_price' => $line['unit_price'],
                    'cost_price' => $line['cost_price'],
                    'total'      => $line['total'],
                ]);

                $line['product']->decrement('stock_qty', $line['qty']);
            }

            if ($sale->customer_id && $due > 0) {
                Customer::where('id', $sale->customer_id)->increment('due_balance', $due);
            }

            return $sale;
        });
    }

    /**
     * Delete a sale, restore stock and reverse customer due.
     */
    public function delete(Sale $sale): bool
    {
        return $this->transaction(function () use ($sale) {
            $sale->loadMissing('items');

            foreach ($sale->items as $item) {
                Product::where('id', $item->product_id)->increment('stock_qty', $item->qty);
            }

            if ($sale->customer_id && $sale->due > 0) {
                Customer::where('id', $sale->customer_id)->decrement('due_balance', $sale->due);
            }

            return (bool) $sale->delete();
        });
    }

    /**
     * Update an existing sale: reverse old side-effects, apply new ones.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(Sale $sale, array $data): Sale
    {
        return $this->transaction(function () use ($sale, $data) {
            $sale->loadMissing('items');

            // ── 1. Reverse old side-effects ───────────────────────────
            foreach ($sale->items as $item) {
                Product::where('id', $item->product_id)->increment('stock_qty', $item->qty);
            }
            if ($sale->customer_id && $sale->due > 0) {
                Customer::where('id', $sale->customer_id)->decrement('due_balance', $sale->due);
            }

            // ── 2. Delete old items ───────────────────────────────────
            $sale->items()->delete();

            // ── 3. Build new line items ───────────────────────────────
            $lines    = [];
            $subtotal = 0;
            foreach ($data['items'] as $row) {
                $product   = Product::findOrFail($row['product_id']);
                $qty       = (float) $row['qty'];
                $unitPrice = isset($row['unit_price']) ? (float) $row['unit_price'] : (float) $product->sale_price;
                $lineTotal = round($qty * $unitPrice, 2);

                $lines[] = [
                    'product'    => $product,
                    'qty'        => $qty,
                    'unit_price' => $unitPrice,
                    'cost_price' => (float) $product->purchase_price,
                    'total'      => $lineTotal,
                ];
                $subtotal += $lineTotal;
            }

            $discount = round((float) ($data['discount'] ?? 0), 2);
            $total    = max(0, round($subtotal - $discount, 2));
            $paid     = isset($data['paid']) ? round((float) $data['paid'], 2) : $total;
            $due      = max(0, round($total - $paid, 2));

            // ── 4. Update the sale header ─────────────────────────────
            $sale->update([
                'customer_id' => $data['customer_id'] ?? null,
                'total'       => $total,
                'discount'    => $discount,
                'paid'        => $paid,
                'due'         => $due,
                'sale_date'   => $data['sale_date'] ?? $sale->sale_date->toDateString(),
                'note'        => $data['note'] ?? null,
            ]);

            // ── 5. Create new items & apply stock ─────────────────────
            foreach ($lines as $line) {
                $sale->items()->create([
                    'product_id' => $line['product']->id,
                    'qty'        => $line['qty'],
                    'unit_price' => $line['unit_price'],
                    'cost_price' => $line['cost_price'],
                    'total'      => $line['total'],
                ]);
                $line['product']->decrement('stock_qty', $line['qty']);
            }

            // ── 6. Apply new customer due ─────────────────────────────
            if ($sale->customer_id && $due > 0) {
                Customer::where('id', $sale->customer_id)->increment('due_balance', $due);
            }

            return $sale->fresh();
        });
    }
}
