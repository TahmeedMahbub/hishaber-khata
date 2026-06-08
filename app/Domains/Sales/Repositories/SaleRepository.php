<?php

namespace App\Domains\Sales\Repositories;

use App\Domains\Common\Repositories\BaseRepository;
use App\Domains\Sales\Models\Sale;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SaleRepository extends BaseRepository
{
    public function __construct(Sale $model)
    {
        parent::__construct($model);
    }

    /**
     * Paginated list for the current tenant, optionally filtered.
     */
    public function list(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->query()
            ->with('customer')
            ->withCount('items')
            ->when($search, fn ($q) => $q->where(function ($w) use ($search) {
                $w->where('invoice_no', 'like', "%{$search}%")
                    ->orWhereHas('customer', fn ($c) => $c->where('name', 'like', "%{$search}%"));
            }))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }
}
