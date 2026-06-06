<?php

namespace App\Domains\Supplier\Requests;

use App\Domains\Tenant\Services\TenantManager;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
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
                Rule::unique('suppliers', 'phone')
                    ->where(fn ($q) => $q->where('tenant_id', $tenantId))
                    ->ignore($this->route('supplier')),
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
            'name.required' => 'সরবরাহকারীর নাম দিন।',
            'phone.unique'  => 'এই মোবাইল নম্বরে আগে থেকেই একজন সরবরাহকারী আছে।',
        ];
    }
}
