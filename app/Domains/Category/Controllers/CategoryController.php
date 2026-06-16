<?php

namespace App\Domains\Category\Controllers;

use App\Domains\Category\Models\Category;
use App\Domains\Category\Requests\CategoryRequest;
use App\Domains\Category\Services\CategoryService;
use App\Domains\Tenant\Services\TenantManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service)
    {
    }

    public function index(Request $request): View
    {
        $categories = $this->service->paginate($request->query('search'));

        return view('contents.categories.index', [
            'categories' => $categories,
            'search'     => $request->query('search'),
        ]);
    }

    public function create(): View
    {
        return view('contents.categories.create');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->route('categories.index')
            ->with('success', t('msg.category_created'));
    }

    /**
     * Quickly create a category from a modal (AJAX) and return JSON.
     */
    public function quickStore(Request $request): JsonResponse
    {
        $tenantId = app(TenantManager::class)->getTenantId();

        $data = $request->validate([
            'name' => [
                'required', 'string', 'max:100',
                Rule::unique('categories', 'name')
                    ->where(fn ($q) => $q->where('tenant_id', $tenantId)),
            ],
        ], [
            'name.unique' => t('valid.category_name_unique'),
        ]);

        $category = $this->service->create($data);

        return response()->json([
            'id'   => $category->id,
            'name' => $category->name,
        ]);
    }

    public function edit(Category $category): View
    {
        return view('contents.categories.edit', ['category' => $category]);
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $this->service->update($category, $request->validated());

        return redirect()->route('categories.index')
            ->with('success', t('msg.category_updated'));
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->service->delete($category);

        return redirect()->route('categories.index')
            ->with('success', t('msg.category_deleted'));
    }
}
