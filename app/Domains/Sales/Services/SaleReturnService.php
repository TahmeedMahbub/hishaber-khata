<?php

namespace App\Domains\Sales\Services;

use App\Domains\Common\Services\BaseService;
use App\Domains\Customer\Models\Customer;
use App\Domains\Product\Models\Product;
use App\Domains\Sales\Models\Sale;
use App\Domains\Sales\Models\SaleReturn;
use App\Domains\Sales\Models\SaleReturnItem;

class SaleReturnService extends BaseService
{
    /**
     * Create a sale return: restore stock, adjust customer due, record refund.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(Sale $sale, array $data): SaleReturn
    {
        return $this->transaction(function () use ($sale, $data) {
            $sale->loadMissing('items');

            $lines = [];
            $total = 0;

            foreach ($data['items'] as $row) {
                $qty = (float) ($row['qty'] ?? 0);
                if ($qty <= 0) {
                    continue;
                }

                $saleItem = $sale->items->firstWhere('id', $row['sale_item_id']);
                if (! $saleItem) {
                    continue;
                }

                $returnableQty = $saleItem->returnableQty();
                $qty = min($qty, $returnableQty);

                if ($qty <= 0) {
                    continue;
                }

                $lineTotal = round($qty * (float) $saleItem->unit_price, 2);

                $lines[] = [
                    'sale_item'  => $saleItem,
                    'qty'        => $qty,
                    'unit_price' => (float) $saleItem->unit_price,
                    'cost_price' => (float) $saleItem->cost_price,
                    'total'      => $lineTotal,
                ];
                $total += $lineTotal;
            }

            abort_if(empty($lines), 422, __('No valid return items.'));

            // Determine refund split: reduce due first, rest as cash
            $previousAdjustments = (float) $sale->returns()->sum('adjusted_due');
            $remainingDue = max(0, (float) $sale->due - $previousAdjustments);

            $adjustedDue = $sale->customer_id ? min($total, $remainingDue) : 0;
            $refunded = round($total - $adjustedDue, 2);

            $return = SaleReturn::create([
                'branch_id'    => $sale->branch_id,
                'sale_id'      => $sale->id,
                'customer_id'  => $sale->customer_id,
                'user_id'      => auth()->id(),
                'total'        => $total,
                'refunded'     => $refunded,
                'adjusted_due' => $adjustedDue,
                'reason'       => $data['reason'] ?? null,
                'return_date'  => now()->toDateString(),
            ]);

            $return->update([
                'return_no' => 'RET-' . str_pad((string) $return->id, 5, '0', STR_PAD_LEFT),
            ]);

            // Create return items and restore stock
            foreach ($lines as $line) {
                $return->items()->create([
                    'sale_item_id' => $line['sale_item']->id,
                    'product_id'   => $line['sale_item']->product_id,
                    'qty'          => $line['qty'],
                    'unit_price'   => $line['unit_price'],
                    'cost_price'   => $line['cost_price'],
                    'total'        => $line['total'],
                ]);

                Product::where('id', $line['sale_item']->product_id)
                    ->increment('stock_qty', $line['qty']);
            }

            // Reduce customer due balance
            if ($sale->customer_id && $adjustedDue > 0) {
                Customer::where('id', $sale->customer_id)
                    ->decrement('due_balance', $adjustedDue);
            }

            return $return;
        });
    }

    /**
     * Delete a return: reverse stock restore and re-apply customer due.
     */
    public function delete(SaleReturn $return): bool
    {
        return $this->transaction(function () use ($return) {
            $return->loadMissing('items');

            // Reverse stock increments
            foreach ($return->items as $item) {
                Product::where('id', $item->product_id)
                    ->decrement('stock_qty', $item->qty);
            }

            // Restore customer due
            if ($return->customer_id && $return->adjusted_due > 0) {
                Customer::where('id', $return->customer_id)
                    ->increment('due_balance', $return->adjusted_due);
            }

            return (bool) $return->delete();
        });
    }
}
