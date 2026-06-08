<?php

namespace App\Domains\Supplier\Repositories;

use App\Domains\Common\Repositories\BaseRepository;
use App\Domains\Supplier\Models\Supplier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SupplierRepository extends BaseRepository
{
    public function __construct(Supplier $model)
    {
        parent::__construct($model);
    }

    /**
     * Paginated list for the current tenant, optionally filtered by search.
     */
    public function list(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->query()
            ->withCount('purchases')
            ->when($search, fn ($q) => $q->where(function ($w) use ($search) {
                $w->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            }))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }
}
