<?php

namespace App\Domains\Customer\Controllers;

use App\Domains\Customer\Models\Customer;
use App\Domains\Customer\Requests\CustomerRequest;
use App\Domains\Customer\Services\CustomerService;
use App\Domains\Tenant\Services\TenantManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(protected CustomerService $service)
    {
    }

    public function index(Request $request): View
    {
        return view('contents.customers.index', [
            'customers' => $this->service->paginate($request->query('search')),
            'search'    => $request->query('search'),
        ]);
    }

    public function create(): View
    {
        return view('contents.customers.create');
    }

    public function store(CustomerRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->route('customers.index')
            ->with('success', t('msg.customer_created'));
    }

    public function edit(Customer $customer): View
    {
        return view('contents.customers.edit', ['customer' => $customer]);
    }

    public function update(CustomerRequest $request, Customer $customer): RedirectResponse
    {
        $this->service->update($customer, $request->validated());

        return redirect()->route('customers.index')
            ->with('success', t('msg.customer_updated'));
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $this->service->delete($customer);

        return redirect()->route('customers.index')
            ->with('success', t('msg.customer_deleted'));
    }

    /**
     * Quick-create a customer from the POS screen (returns JSON).
     */
    public function quickStore(Request $request): JsonResponse
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
            'name.required'  => t('valid.customer_name_required'),
            'phone.unique'   => t('valid.customer_phone_unique'),
        ]);

        $customer = Customer::create($data);

        return response()->json([
            'id'    => $customer->id,
            'name'  => $customer->name,
            'phone' => $customer->phone,
        ]);
    }
}
