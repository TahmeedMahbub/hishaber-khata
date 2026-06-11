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
        $type = $this->normalizeType($request->query('type'));

        $customers = collect();
        $suppliers = collect();

        if ($type !== 'supplier') {
            $customers = Customer::where('due_balance', '>', 0)
                ->orderByDesc('due_balance')
                ->get(['id', 'name', 'phone', 'due_balance']);
        }

        if ($type !== 'customer') {
            $suppliers = Supplier::where('due_balance', '>', 0)
                ->orderByDesc('due_balance')
                ->get(['id', 'name', 'phone', 'due_balance']);
        }

        return view('contents.due-payments.index', [
            'type'             => $request->query('type'),
            'customers'        => $customers,
            'suppliers'        => $suppliers,
            'customerDueTotal' => $customers->sum('due_balance'),
            'supplierDueTotal' => $suppliers->sum('due_balance'),
        ]);
    }

    public function create(Request $request): View
    {
        return view('contents.due-payments.create', [
            'partyType' => $request->query('party_type') === 'supplier' ? 'supplier' : 'customer',
            'partyId'   => $request->query('party_id'),
            'customers' => Customer::where('due_balance', '>', 0)
                ->orderBy('name')->get(['id', 'name', 'phone', 'due_balance']),
            'suppliers' => Supplier::where('due_balance', '>', 0)
                ->orderBy('name')->get(['id', 'name', 'phone', 'due_balance']),
        ]);
    }

    public function history(Request $request): View
    {
        $type = $this->normalizeType($request->query('type'));

        return view('contents.due-payments.history', [
            'payments'      => $this->service->paginate($type),
            'type'          => $request->query('type'),
            'customerNames' => Customer::pluck('name', 'id'),
            'supplierNames' => Supplier::pluck('name', 'id'),
        ]);
    }

    public function store(DuePaymentRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        $message = $request->input('party_type') === 'supplier'
            ? t('msg.duepay_paid')
            : t('msg.duepay_collect');

        return redirect()->route('due-payments.index')
            ->with('success', $message);
    }

    public function destroy(DuePayment $duePayment): RedirectResponse
    {
        $this->service->delete($duePayment);

        return redirect()->route('due-payments.history')
            ->with('success', t('msg.duepay_deleted'));
    }

    private function normalizeType(?string $type): ?string
    {
        return in_array($type, ['customer', 'supplier'], true) ? $type : null;
    }
}
