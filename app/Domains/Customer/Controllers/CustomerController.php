<?php

namespace App\Domains\Customer\Controllers;

use App\Domains\Customer\Models\Customer;
use App\Domains\Tenant\Services\TenantManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $tenantId = app(TenantManager::class)->getTenantId();

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:150'],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('customers', 'phone')->where(fn ($q) => $q->where('tenant_id', $tenantId)),
            ],
        ], [
            'name.required'  => 'কাস্টমারের নাম দিন।',
            'phone.unique'   => 'এই মোবাইল নম্বরে আগে থেকেই একজন কাস্টমার আছে।',
        ]);

        $customer = Customer::create($data);

        return response()->json([
            'id'    => $customer->id,
            'name'  => $customer->name,
            'phone' => $customer->phone,
        ]);
    }
}
