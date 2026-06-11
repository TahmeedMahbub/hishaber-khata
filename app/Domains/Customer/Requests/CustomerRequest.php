<?php

namespace App\Domains\Customer\Requests;

use App\Domains\Tenant\Services\TenantManager;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $tenantId = app(TenantManager::class)->getTenantId();

        // Ignore the customer currently being edited (works whether the route
        // param resolves to a model instance or a raw id).
        $customer = $this->route('customer');
        $customerId = $customer instanceof \App\Domains\Customer\Models\Customer
            ? $customer->getKey()
            : $customer;

        return [
            'name'  => ['required', 'string', 'max:150'],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('customers', 'phone')
                    ->where(fn ($q) => $q->where('tenant_id', $tenantId))
                    ->ignore($customerId, 'id'),
            ],
            'address'     => ['nullable', 'string', 'max:255'],
            'due_balance' => ['nullable', 'numeric'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => t('valid.customer_name_required'),
            'phone.unique'  => t('valid.customer_phone_unique'),
        ];
    }
}
