<?php

namespace App\Domains\Product\Controllers;

use App\Domains\Category\Models\Category;
use App\Domains\Product\Models\Product;
use App\Domains\Product\Requests\ProductRequest;
use App\Domains\Product\Services\ProductImportException;
use App\Domains\Product\Services\ProductImportService;
use App\Domains\Product\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

        if ($request->input('_add_another') === '1') {
            return redirect()->route('products.create')
                ->with('success', t('msg.product_created'));
        }

        return redirect()->route('products.index')
            ->with('success', t('msg.product_created'));
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
            ->with('success', t('msg.product_updated'));
    }

    public function destroy(Product $product): RedirectResponse
    {
        try {
            $this->service->delete($product);
        } catch (QueryException $e) {
            // Foreign key constraint violation (SQLSTATE 23000)
            if ($e->getCode() === '23000') {
                return redirect()->route('products.index')
                    ->with('product_in_use', [
                        'id'           => $product->id,
                        'public_id'    => $product->public_id,
                        'name'         => $product->name,
                    ]);
            }
            throw $e;
        }

        return redirect()->route('products.index')
            ->with('success', t('msg.product_deleted'));
    }

    public function deactivate(Product $product): RedirectResponse
    {
        $product->update(['status' => 'inactive']);

        return redirect()->route('products.index')
            ->with('success', t('msg.product_deactivated'));
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
            'name.required' => t('valid.product_name_required'),
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

    /**
     * Bulk-import products from an uploaded Excel/CSV file.
     */
    public function import(Request $request, ProductImportService $importer): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv,txt', 'max:5120'],
        ], [
            'file.required' => t('valid.file_required'),
            'file.mimes'    => t('valid.file_mimes'),
            'file.max'      => t('valid.file_max'),
        ]);

        try {
            $result = $importer->import($request->file('file'));
        } catch (ProductImportException $e) {
            return redirect()->route('products.index')->with('error', $e->getMessage());
        }

        $message = "{$result['imported']} " . t('msg.product_import_done');

        if (! empty($result['errors'])) {
            return redirect()->route('products.index')
                ->with('success', $message)
                ->with('import_errors', $result['errors']);
        }

        return redirect()->route('products.index')->with('success', $message);
    }

    /**
     * Download a blank Excel template with the required column headers.
     */
    public function template(): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Products');

        $headers = ProductImportService::HEADERS;
        $sheet->fromArray($headers, null, 'A1');

        // Sample row to guide the user.
        $sheet->fromArray(
            ['চাল (মিনিকেট)', 'মুদি', '8901234567890', 60, 72, 'kg', 100, 10],
            null,
            'A2'
        );

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setWidth(18);
            $sheet->getStyle("{$col}1")->getFont()->setBold(true);
        }

        $fileName = 'product-import-template.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            (new Xlsx($spreadsheet))->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
