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

        return [
            'name'  => ['required', 'string', 'max:150'],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('customers', 'phone')
                    ->where(fn ($q) => $q->where('tenant_id', $tenantId))
                    ->ignore($this->route('customer')),
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
            'name.required' => 'কাস্টমারের নাম দিন।',
            'phone.unique'  => 'এই মোবাইল নম্বরে আগে থেকেই একজন কাস্টমার আছে।',
        ];
    }
}
