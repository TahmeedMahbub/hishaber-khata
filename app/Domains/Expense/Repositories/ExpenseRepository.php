<?php

namespace App\Domains\Expense\Repositories;

use App\Domains\Common\Repositories\BaseRepository;
use App\Domains\Expense\Models\Expense;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ExpenseRepository extends BaseRepository
{
    public function __construct(Expense $model)
    {
        parent::__construct($model);
    }

    /**
     * Paginated list for the current tenant, optionally filtered by search.
     */
    public function list(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->query()
            ->when($search, fn ($q) => $q->where('title', 'like', "%{$search}%"))
            ->orderByDesc('expense_date')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }
}
