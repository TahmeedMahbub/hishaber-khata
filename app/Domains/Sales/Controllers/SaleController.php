<?php

namespace App\Domains\Sales\Controllers;

use App\Domains\Customer\Models\Customer;
use App\Domains\Product\Models\Product;
use App\Domains\Sales\Models\Sale;
use App\Domains\Sales\Requests\SaleRequest;
use App\Domains\Sales\Services\SaleService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function __construct(protected SaleService $service)
    {
    }

    public function index(Request $request): View
    {
        return view('contents.sales.index', [
            'sales'  => $this->service->paginate($request->query('search')),
            'search' => $request->query('search'),
        ]);
    }

    public function create(): View
    {
        $user = auth()->user();

        return view('contents.sales.pos', [
            'products'  => Product::where('status', 'active')->orderBy('name')->get(),
            'customers' => Customer::orderBy('name')->get(),
            'employees' => $user->tenant
                ? $user->tenant->users()->where('status', 'active')->orderBy('name')->get()
                : collect(),
        ]);
    }

    public function store(SaleRequest $request): RedirectResponse
    {
        $sale = $this->service->create($request->validated());

        return redirect()->route('sales.show', $sale)
            ->with('success', 'বিক্রয় সম্পন্ন হয়েছে।');
    }

    public function show(Sale $sale): View
    {
        $sale->load(['items.product', 'customer', 'user']);

        return view('contents.sales.show', ['sale' => $sale]);
    }

    public function destroy(Sale $sale): RedirectResponse
    {
        $this->service->delete($sale);

        return redirect()->route('sales.index')
            ->with('success', 'বিক্রয় মুছে ফেলা হয়েছে।');
    }
}
