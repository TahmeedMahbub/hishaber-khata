<?php

namespace App\Domains\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterBusinessRequest extends FormRequest
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
            'business_name' => ['required', 'string', 'max:150'],
            'owner_name'    => ['required', 'string', 'max:150'],
            'phone'         => ['required', 'string', 'max:20', 'unique:tenants,phone', 'unique:users,phone'],
            'email'         => ['required', 'email', 'max:150', 'unique:users,email'],
            'password'      => ['required', 'string', 'min:6'],
            'business_type' => ['required', 'string', Rule::in(array_keys(config('business_types.types')))],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.unique' => t('valid.register_phone_unique'),
            'email.unique' => t('valid.register_email_unique'),
        ];
    }
}
