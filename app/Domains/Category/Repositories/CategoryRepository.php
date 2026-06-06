<?php

namespace App\Domains\Category\Repositories;

use App\Domains\Category\Models\Category;
use App\Domains\Common\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    /**
     * Paginated list for the current tenant, optionally filtered by search.
     */
    public function list(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->query()
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }
}
