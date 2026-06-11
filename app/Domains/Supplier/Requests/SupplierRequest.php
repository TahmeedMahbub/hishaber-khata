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

        // Ignore the supplier currently being edited (works whether the route
        // param resolves to a model instance or a raw id).
        $supplier = $this->route('supplier');
        $supplierId = $supplier instanceof \App\Domains\Supplier\Models\Supplier
            ? $supplier->getKey()
            : $supplier;

        return [
            'name'  => ['required', 'string', 'max:150'],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('suppliers', 'phone')
                    ->where(fn ($q) => $q->where('tenant_id', $tenantId))
                    ->ignore($supplierId, 'id'),
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
            'name.required' => t('valid.supplier_name_required'),
            'phone.unique'  => t('valid.supplier_phone_unique'),
        ];
    }
}
