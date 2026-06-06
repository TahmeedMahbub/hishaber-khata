<?php

namespace App\Domains\Inventory\Repositories;

use App\Domains\Common\Repositories\BaseRepository;
use App\Domains\Inventory\Models\Damage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DamageRepository extends BaseRepository
{
    public function __construct(Damage $model)
    {
        parent::__construct($model);
    }

    /**
     * Paginated list for the current tenant, optionally filtered by search.
     */
    public function list(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->query()
            ->with('product')
            ->when($search, fn ($q) => $q->where(function ($w) use ($search) {
                $w->where('reason', 'like', "%{$search}%")
                    ->orWhereHas('product', fn ($p) => $p->where('name', 'like', "%{$search}%"));
            }))
            ->orderByDesc('damage_date')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }
}
