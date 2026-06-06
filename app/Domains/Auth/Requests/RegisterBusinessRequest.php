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
            'email'         => ['nullable', 'email', 'max:150', 'unique:users,email'],
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
            'phone.unique' => 'This mobile number is already registered.',
            'email.unique' => 'This email is already registered.',
        ];
    }
}
