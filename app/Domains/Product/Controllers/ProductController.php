<?php

namespace App\Domains\Product\Controllers;

use App\Domains\Category\Models\Category;
use App\Domains\Product\Models\Product;
use App\Domains\Product\Requests\ProductRequest;
use App\Domains\Product\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(protected ProductService $service)
    {
    }

    public function index(Request $request): View
    {
        $products = $this->service->paginate(
            $request->query('search'),
            $request->query('category_id') ? (int) $request->query('category_id') : null,
        );

        return view('contents.products.index', [
            'products'   => $products,
            'categories' => $this->categories(),
            'search'     => $request->query('search'),
            'categoryId' => $request->query('category_id'),
        ]);
    }

    public function create(): View
    {
        return view('contents.products.create', [
            'categories' => $this->categories(),
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'পণ্য যোগ করা হয়েছে।');
    }

    public function edit(Product $product): View
    {
        return view('contents.products.edit', [
            'product'    => $product,
            'categories' => $this->categories(),
        ]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->service->update($product, $request->validated());

        return redirect()->route('products.index')
            ->with('success', 'পণ্য আপডেট করা হয়েছে।');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->service->delete($product);

        return redirect()->route('products.index')
            ->with('success', 'পণ্য মুছে ফেলা হয়েছে।');
    }

    /**
     * Quick-create a product from another screen (e.g. POS / Purchase). Returns JSON.
     */
    public function quickStore(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:150'],
            'barcode'        => ['nullable', 'string', 'max:100'],
            'unit'           => ['nullable', 'string', 'max:20'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'sale_price'     => ['nullable', 'numeric', 'min:0'],
        ], [
            'name.required' => 'পণ্যের নাম দিন।',
        ]);

        $product = $this->service->create($data);

        return response()->json([
            'id'             => $product->id,
            'name'           => $product->name,
            'barcode'        => (string) $product->barcode,
            'unit'           => $product->unit,
            'purchase_price' => (float) $product->purchase_price,
            'sale_price'     => (float) $product->sale_price,
            'stock'          => (float) $product->stock_qty,
        ]);
    }

    /**
     * Active categories for the current tenant (for dropdowns).
     */
    protected function categories()
    {
        return Category::where('status', 'active')->orderBy('name')->get();
    }
}
