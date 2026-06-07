<?php

namespace App\Domains\Payment\Controllers;

use App\Domains\Customer\Models\Customer;
use App\Domains\Payment\Models\DuePayment;
use App\Domains\Payment\Requests\DuePaymentRequest;
use App\Domains\Payment\Services\DuePaymentService;
use App\Domains\Supplier\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DuePaymentController extends Controller
{
    public function __construct(protected DuePaymentService $service)
    {
    }

    public function index(Request $request): View
    {
        $type = $request->query('type') === 'supplier' ? 'supplier' : null;

        $payments = $this->service->paginate($type);

        // Eager-load party names for the listing.
        $customerNames = Customer::pluck('name', 'id');
        $supplierNames = Supplier::pluck('name', 'id');

        return view('contents.due-payments.index', [
            'payments'      => $payments,
            'type'          => $request->query('type'),
            'customers'     => Customer::orderBy('name')->get(['id', 'name', 'phone', 'due_balance']),
            'suppliers'     => Supplier::orderBy('name')->get(['id', 'name', 'phone', 'due_balance']),
            'customerNames' => $customerNames,
            'supplierNames' => $supplierNames,
        ]);
    }

    public function store(DuePaymentRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        $label = $request->input('party_type') === 'supplier' ? 'বাকি পরিশোধ' : 'বাকি আদায়';

        return redirect()->route('due-payments.index')
            ->with('success', $label . ' সফলভাবে রেকর্ড করা হয়েছে।');
    }

    public function destroy(DuePayment $duePayment): RedirectResponse
    {
        $this->service->delete($duePayment);

        return redirect()->route('due-payments.index')
            ->with('success', 'লেনদেন মুছে ফেলা হয়েছে এবং বাকি পুনরায় যোগ হয়েছে।');
    }
}
