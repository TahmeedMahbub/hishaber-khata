<?php

namespace App\Domains\Purchase\Services;

use App\Domains\Common\Services\BaseService;
use App\Domains\Product\Models\Product;
use App\Domains\Purchase\Models\Purchase;
use App\Domains\Purchase\Models\PurchaseReturn;
use App\Domains\Purchase\Models\PurchaseReturnItem;
use App\Domains\Supplier\Models\Supplier;

class PurchaseReturnService extends BaseService
{
    /**
     * Create a purchase return: decrement stock, adjust supplier due.
     *
     * Purchase return logic:
     * - You're sending items BACK to supplier → stock decreases
     * - Supplier owes you money back:
     *   • First reduce your due to supplier (adjusted_due)
     *   • Remainder is cash you receive from supplier (refunded)
     *
     * @param  array<string, mixed>  $data
     */
    public function create(Purchase $purchase, array $data): PurchaseReturn
    {
        return $this->transaction(function () use ($purchase, $data) {
            $purchase->loadMissing('items');

            $lines = [];
            $total = 0;

            foreach ($data['items'] as $row) {
                $qty = (float) ($row['qty'] ?? 0);
                if ($qty <= 0) {
                    continue;
                }

                $purchaseItem = $purchase->items->firstWhere('id', $row['purchase_item_id']);
                if (! $purchaseItem) {
                    continue;
                }

                $returnableQty = $purchaseItem->returnableQty();
                $qty = min($qty, $returnableQty);

                if ($qty <= 0) {
                    continue;
                }

                $lineTotal = round($qty * (float) $purchaseItem->unit_price, 2);

                $lines[] = [
                    'purchase_item' => $purchaseItem,
                    'qty'           => $qty,
                    'unit_price'    => (float) $purchaseItem->unit_price,
                    'total'         => $lineTotal,
                ];
                $total += $lineTotal;
            }

            abort_if(empty($lines), 422, __('No valid return items.'));

            // Determine refund split: reduce supplier due first, rest as cash received
            $previousAdjustments = (float) $purchase->returns()->sum('adjusted_due');
            $remainingDue = max(0, (float) $purchase->due - $previousAdjustments);

            $adjustedDue = $purchase->supplier_id ? min($total, $remainingDue) : 0;
            $refunded = round($total - $adjustedDue, 2);

            $return = PurchaseReturn::create([
                'branch_id'    => $purchase->branch_id,
                'purchase_id'  => $purchase->id,
                'supplier_id'  => $purchase->supplier_id,
                'user_id'      => auth()->id(),
                'total'        => $total,
                'refunded'     => $refunded,
                'adjusted_due' => $adjustedDue,
                'reason'       => $data['reason'] ?? null,
                'return_date'  => now()->toDateString(),
            ]);

            $return->update([
                'return_no' => 'PRET-' . str_pad((string) $return->id, 5, '0', STR_PAD_LEFT),
            ]);

            // Create return items and DECREMENT stock (items go back to supplier)
            foreach ($lines as $line) {
                $return->items()->create([
                    'purchase_item_id' => $line['purchase_item']->id,
                    'product_id'       => $line['purchase_item']->product_id,
                    'qty'              => $line['qty'],
                    'unit_price'       => $line['unit_price'],
                    'total'            => $line['total'],
                ]);

                Product::where('id', $line['purchase_item']->product_id)
                    ->decrement('stock_qty', $line['qty']);
            }

            // Reduce supplier due balance (we owe them less now)
            if ($purchase->supplier_id && $adjustedDue > 0) {
                Supplier::where('id', $purchase->supplier_id)
                    ->decrement('due_balance', $adjustedDue);
            }

            return $return;
        });
    }

    /**
     * Delete a return: reverse stock decrement and restore supplier due.
     */
    public function delete(PurchaseReturn $return): bool
    {
        return $this->transaction(function () use ($return) {
            $return->loadMissing('items');

            // Reverse stock decrements (items come back to us)
            foreach ($return->items as $item) {
                Product::where('id', $item->product_id)
                    ->increment('stock_qty', $item->qty);
            }

            // Restore supplier due
            if ($return->supplier_id && $return->adjusted_due > 0) {
                Supplier::where('id', $return->supplier_id)
                    ->increment('due_balance', $return->adjusted_due);
            }

            return (bool) $return->delete();
        });
    }
}
