<?php

namespace App\Domains\Sales\Controllers;

use App\Domains\Sales\Models\Sale;
use App\Domains\Sales\Models\SaleReturn;
use App\Domains\Sales\Requests\SaleReturnRequest;
use App\Domains\Sales\Services\SaleReturnService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SaleReturnController extends Controller
{
    public function __construct(protected SaleReturnService $service)
    {
    }

    /**
     * List all sale returns.
     */
    public function index(Request $request): View
    {
        $returns = SaleReturn::with(['sale', 'customer'])
            ->when($request->query('search'), function ($q, $search) {
                $q->where('return_no', 'like', "%{$search}%")
                    ->orWhereHas('sale', fn ($s) => $s->where('invoice_no', 'like', "%{$search}%"))
                    ->orWhereHas('customer', fn ($c) => $c->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('contents.sales.return-index', [
            'returns' => $returns,
            'search'  => $request->query('search'),
        ]);
    }

    /**
     * Show the return form for a given sale.
     */
    public function create(Sale $sale): View
    {
        $sale->load(['items.product', 'customer']);

        // Calculate returnable qty for each item
        $items = $sale->items->map(function ($item) {
            $item->returnable_qty = $item->returnableQty();
            return $item;
        });

        return view('contents.sales.return', [
            'sale'  => $sale,
            'items' => $items,
        ]);
    }

    /**
     * Store the return.
     */
    public function store(SaleReturnRequest $request, Sale $sale): RedirectResponse
    {
        abort_if($sale->status !== 'completed', 403, __('Only completed sales can be returned.'));

        $return = $this->service->create($sale, $request->validated());

        return redirect()->route('sale-returns.show', $return)
            ->with('success', t('msg.sale_return_created'));
    }

    /**
     * Show return receipt.
     */
    public function show(SaleReturn $saleReturn): View
    {
        $saleReturn->load(['items.product', 'sale', 'customer', 'user']);

        return view('contents.sales.return-show', [
            'return' => $saleReturn,
        ]);
    }

    /**
     * Delete a return (owner only) — reverses all side effects.
     */
    public function destroy(SaleReturn $saleReturn): RedirectResponse
    {
        $saleId = $saleReturn->sale_id;
        $this->service->delete($saleReturn);

        return redirect()->route('sales.show', $saleId)
            ->with('success', t('msg.sale_return_deleted'));
    }
}
