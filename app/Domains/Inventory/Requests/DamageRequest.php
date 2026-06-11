<?php

namespace App\Domains\Inventory\Requests;

use App\Domains\Tenant\Services\TenantManager;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DamageRequest extends FormRequest
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
            'product_id' => [
                'required',
                Rule::exists('products', 'id')->where(fn ($q) => $q->where('tenant_id', $tenantId)),
            ],
            'type'        => ['required', Rule::in(['damage', 'lost'])],
            'qty'         => ['required', 'numeric', 'min:0.01'],
            'reason'      => ['nullable', 'string', 'max:255'],
            'damage_date' => ['nullable', 'date'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'product_id.required' => t('valid.damage_product_required'),
            'qty.required'        => t('valid.qty_required'),
        ];
    }
}
