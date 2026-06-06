<?php

namespace App\Domains\Product\Requests;

use App\Domains\Tenant\Services\TenantManager;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'category_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where(fn ($q) => $q->where('tenant_id', $tenantId)),
            ],
            'name'            => ['required', 'string', 'max:150'],
            'barcode'         => ['nullable', 'string', 'max:100'],
            'unit'            => ['required', 'string', 'max:20'],
            'purchase_price'  => ['required', 'numeric', 'min:0'],
            'sale_price'      => ['required', 'numeric', 'min:0'],
            'stock_qty'       => ['required', 'numeric', 'min:0'],
            'low_stock_alert' => ['nullable', 'numeric', 'min:0'],
            'status'          => ['nullable', Rule::in(['active', 'inactive'])],
        ];
    }
}
