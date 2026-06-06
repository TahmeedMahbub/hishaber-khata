<?php

namespace App\Domains\Expense\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
        return [
            'title'        => ['required', 'string', 'max:150'],
            'amount'       => ['required', 'numeric', 'min:0'],
            'expense_date' => ['nullable', 'date'],
            'note'         => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required'  => 'খরচের বিবরণ দিন।',
            'amount.required' => 'টাকার পরিমাণ দিন।',
        ];
    }
}
