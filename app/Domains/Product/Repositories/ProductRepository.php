<?php

namespace App\Domains\Product\Repositories;

use App\Domains\Common\Repositories\BaseRepository;
use App\Domains\Product\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * Paginated list for the current tenant, optionally filtered.
     */
    public function list(?string $search = null, ?int $categoryId = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->query()
            ->with('category')
            ->when($search, fn ($q) => $q->where(function ($w) use ($search) {
                $w->where('name', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            }))
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }
}
