<?php

namespace App\Domains\Supplier\Services;

use App\Domains\Common\Services\BaseService;
use App\Domains\Supplier\Models\Supplier;
use App\Domains\Supplier\Repositories\SupplierRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SupplierService extends BaseService
{
    public function __construct(protected SupplierRepository $suppliers)
    {
    }

    public function paginate(?string $search = null): LengthAwarePaginator
    {
        return $this->suppliers->list($search);
    }

    public function create(array $data): Supplier
    {
        return $this->suppliers->create($this->prepare($data));
    }

    public function update(Supplier $supplier, array $data): Supplier
    {
        // due_balance is managed via due payments, never edited directly here.
        $payload = $this->prepare($data);
        unset($payload['due_balance']);

        return $this->suppliers->update($supplier, $payload);
    }

    public function delete(Supplier $supplier): bool
    {
        return $this->suppliers->delete($supplier);
    }

    /**
     * @return array<string, mixed>
     */
    protected function prepare(array $data): array
    {
        return [
            'name'        => $data['name'],
            'phone'       => $data['phone'] ?? null,
            'address'     => $data['address'] ?? null,
            'due_balance' => $data['due_balance'] ?? 0,
        ];
    }
}
