<?php

namespace App\Domains\Inventory\Services;

use App\Domains\Common\Services\BaseService;
use App\Domains\Inventory\Models\Damage;
use App\Domains\Inventory\Repositories\DamageRepository;
use App\Domains\Product\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DamageService extends BaseService
{
    public function __construct(protected DamageRepository $damages)
    {
    }

    public function paginate(?string $search = null): LengthAwarePaginator
    {
        return $this->damages->list($search);
    }

    /**
     * Record a damage/lost entry and reduce product stock.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Damage
    {
        return $this->transaction(function () use ($data) {
            $user = auth()->user();
            $product = Product::findOrFail($data['product_id']);
            $qty = (float) $data['qty'];

            $damage = $this->damages->create([
                'branch_id'   => $user->branch_id ?? null,
                'product_id'  => $product->id,
                'type'        => $data['type'] ?? 'damage',
                'qty'         => $qty,
                'unit_cost'   => (float) $product->purchase_price,
                'reason'      => $data['reason'] ?? null,
                'damage_date' => $data['damage_date'] ?? now()->toDateString(),
            ]);

            $product->decrement('stock_qty', $qty);

            return $damage;
        });
    }

    /**
     * Delete a damage/lost entry and restore product stock.
     */
    public function delete(Damage $damage): bool
    {
        return $this->transaction(function () use ($damage) {
            Product::where('id', $damage->product_id)->increment('stock_qty', $damage->qty);

            return (bool) $damage->delete();
        });
    }
}
