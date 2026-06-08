<?php

namespace App\Domains\Purchase\Repositories;

use App\Domains\Common\Repositories\BaseRepository;
use App\Domains\Purchase\Models\Purchase;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PurchaseRepository extends BaseRepository
{
    public function __construct(Purchase $model)
    {
        parent::__construct($model);
    }

    /**
     * Paginated list for the current tenant, optionally filtered.
     */
    public function list(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->query()
            ->with('supplier')
            ->withCount('items')
            ->when($search, fn ($q) => $q->where(function ($w) use ($search) {
                $w->where('invoice_no', 'like', "%{$search}%")
                    ->orWhereHas('supplier', fn ($s) => $s->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%"));
            }))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }
}
