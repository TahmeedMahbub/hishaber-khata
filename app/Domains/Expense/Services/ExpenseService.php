<?php

namespace App\Domains\Expense\Services;

use App\Domains\Common\Services\BaseService;
use App\Domains\Expense\Models\Expense;
use App\Domains\Expense\Repositories\ExpenseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ExpenseService extends BaseService
{
    public function __construct(protected ExpenseRepository $expenses)
    {
    }

    public function paginate(?string $search = null): LengthAwarePaginator
    {
        return $this->expenses->list($search);
    }

    public function create(array $data): Expense
    {
        return $this->expenses->create($this->prepare($data));
    }

    public function update(Expense $expense, array $data): Expense
    {
        return $this->expenses->update($expense, $this->prepare($data));
    }

    public function delete(Expense $expense): bool
    {
        return $this->expenses->delete($expense);
    }

    /**
     * @return array<string, mixed>
     */
    protected function prepare(array $data): array
    {
        return [
            'title'        => $data['title'],
            'amount'       => $data['amount'] ?? 0,
            'expense_date' => $data['expense_date'] ?? now()->toDateString(),
            'note'         => $data['note'] ?? null,
        ];
    }
}
