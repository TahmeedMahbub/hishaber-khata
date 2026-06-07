<?php

namespace App\Domains\Customer\Services;

use App\Domains\Common\Services\BaseService;
use App\Domains\Customer\Models\Customer;
use App\Domains\Customer\Repositories\CustomerRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerService extends BaseService
{
    public function __construct(protected CustomerRepository $customers)
    {
    }

    public function paginate(?string $search = null): LengthAwarePaginator
    {
        return $this->customers->list($search);
    }

    public function create(array $data): Customer
    {
        return $this->customers->create($this->prepare($data));
    }

    public function update(Customer $customer, array $data): Customer
    {
        // due_balance is managed via due payments, never edited directly here.
        $payload = $this->prepare($data);
        unset($payload['due_balance']);

        return $this->customers->update($customer, $payload);
    }

    public function delete(Customer $customer): bool
    {
        return $this->customers->delete($customer);
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
