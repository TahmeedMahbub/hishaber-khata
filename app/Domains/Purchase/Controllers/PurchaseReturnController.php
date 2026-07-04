<?php

namespace App\Domains\Purchase\Controllers;

use App\Domains\Purchase\Models\Purchase;
use App\Domains\Purchase\Models\PurchaseReturn;
use App\Domains\Purchase\Requests\PurchaseReturnRequest;
use App\Domains\Purchase\Services\PurchaseReturnService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseReturnController extends Controller
{
    public function __construct(protected PurchaseReturnService $service)
    {
    }

    /**
     * List all purchase returns.
     */
    public function index(Request $request): View
    {
        $returns = PurchaseReturn::with(['purchase', 'supplier'])
            ->when($request->query('search'), function ($q, $search) {
                $q->where('return_no', 'like', "%{$search}%")
                    ->orWhereHas('purchase', fn ($p) => $p->where('invoice_no', 'like', "%{$search}%"))
                    ->orWhereHas('supplier', fn ($s) => $s->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('contents.purchases.return-index', [
            'returns' => $returns,
            'search'  => $request->query('search'),
        ]);
    }

    /**
     * Show the return form for a given purchase.
     */
    public function create(Purchase $purchase): View
    {
        $purchase->load(['items.product', 'supplier']);

        $items = $purchase->items->map(function ($item) {
            $item->returnable_qty = $item->returnableQty();
            return $item;
        });

        return view('contents.purchases.return', [
            'purchase' => $purchase,
            'items'    => $items,
        ]);
    }

    /**
     * Store the return.
     */
    public function store(PurchaseReturnRequest $request, Purchase $purchase): RedirectResponse
    {
        abort_if($purchase->status !== 'completed', 403, __('Only completed purchases can be returned.'));

        $return = $this->service->create($purchase, $request->validated());

        return redirect()->route('purchase-returns.show', $return)
            ->with('success', t('msg.purchase_return_created'));
    }

    /**
     * Show return receipt.
     */
    public function show(PurchaseReturn $purchaseReturn): View
    {
        $purchaseReturn->load(['items.product', 'purchase', 'supplier', 'user']);

        return view('contents.purchases.return-show', [
            'return' => $purchaseReturn,
        ]);
    }

    /**
     * Delete a return — reverses all side effects.
     */
    public function destroy(PurchaseReturn $purchaseReturn): RedirectResponse
    {
        $purchaseId = $purchaseReturn->purchase_id;
        $this->service->delete($purchaseReturn);

        return redirect()->route('purchases.show', $purchaseId)
            ->with('success', t('msg.purchase_return_deleted'));
    }
}
