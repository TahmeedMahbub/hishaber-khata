<?php

namespace App\Domains\Supplier\Controllers;

use App\Domains\Supplier\Models\Supplier;
use App\Domains\Supplier\Requests\SupplierRequest;
use App\Domains\Supplier\Services\SupplierService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function __construct(protected SupplierService $service)
    {
    }

    public function index(Request $request): View
    {
        return view('contents.suppliers.index', [
            'suppliers' => $this->service->paginate($request->query('search')),
            'search'    => $request->query('search'),
        ]);
    }

    public function create(): View
    {
        return view('contents.suppliers.create');
    }

    public function store(SupplierRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->route('suppliers.index')
            ->with('success', t('msg.supplier_created'));
    }

    public function edit(Supplier $supplier): View
    {
        return view('contents.suppliers.edit', ['supplier' => $supplier]);
    }

    public function update(SupplierRequest $request, Supplier $supplier): RedirectResponse
    {
        $this->service->update($supplier, $request->validated());

        return redirect()->route('suppliers.index')
            ->with('success', t('msg.supplier_updated'));
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        $this->service->delete($supplier);

        return redirect()->route('suppliers.index')
            ->with('success', t('msg.supplier_deleted'));
    }

    /**
     * Quick-create a supplier from another screen (e.g. Purchase). Returns JSON.
     */
    public function quickStore(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:150'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => t('valid.supplier_name_required'),
        ]);

        $supplier = $this->service->create($data);

        return response()->json([
            'id'    => $supplier->id,
            'name'  => $supplier->name,
            'phone' => (string) $supplier->phone,
        ]);
    }
}
