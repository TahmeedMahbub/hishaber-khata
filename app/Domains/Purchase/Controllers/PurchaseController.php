<?php

namespace App\Domains\Purchase\Controllers;

use App\Domains\Product\Models\Product;
use App\Domains\Purchase\Models\Purchase;
use App\Domains\Purchase\Requests\PurchaseRequest;
use App\Domains\Purchase\Services\PurchaseService;
use App\Domains\Supplier\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    public function __construct(protected PurchaseService $service)
    {
    }

    public function index(Request $request): View
    {
        return view('contents.purchases.index', [
            'purchases' => $this->service->paginate($request->query('search')),
            'search'    => $request->query('search'),
        ]);
    }

    public function create(): View
    {
        return view('contents.purchases.create', [
            'products'  => Product::where('status', 'active')->orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
        ]);
    }

    public function store(PurchaseRequest $request): RedirectResponse
    {
        $purchase = $this->service->create($request->validated());

        return redirect()->route('purchases.show', $purchase)
            ->with('success', 'ক্রয় সম্পন্ন হয়েছে।');
    }

    public function show(Purchase $purchase): View
    {
        $purchase->load(['items.product', 'supplier', 'user']);

        return view('contents.purchases.show', ['purchase' => $purchase]);
    }

    public function destroy(Purchase $purchase): RedirectResponse
    {
        $this->service->delete($purchase);

        return redirect()->route('purchases.index')
            ->with('success', 'ক্রয় মুছে ফেলা হয়েছে।');
    }
}
