<?php

namespace App\Domains\Payment\Requests;

use App\Domains\Tenant\Services\TenantManager;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DuePaymentRequest extends FormRequest
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
        $table = $this->input('party_type') === 'supplier' ? 'suppliers' : 'customers';

        return [
            'party_type'   => ['required', Rule::in(['customer', 'supplier'])],
            'party_id'     => [
                'required',
                Rule::exists($table, 'id')->where(fn ($q) => $q->where('tenant_id', $tenantId)),
            ],
            'amount'       => ['required', 'numeric', 'min:0.01'],
            'method'       => ['required', Rule::in(['cash', 'bkash', 'nagad', 'rocket', 'bank', 'other'])],
            'payment_date' => ['nullable', 'date'],
            'note'         => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'party_type.required' => 'কাস্টমার বা সরবরাহকারী নির্বাচন করুন।',
            'party_id.required'   => 'নাম নির্বাচন করুন।',
            'party_id.exists'     => 'নির্বাচিত ব্যক্তি খুঁজে পাওয়া যায়নি।',
            'amount.required'     => 'টাকার পরিমাণ দিন।',
            'amount.min'          => 'টাকার পরিমাণ ০ এর বেশি হতে হবে।',
        ];
    }
}
