<?php

namespace App\Domains\Category\Controllers;

use App\Domains\Category\Models\Category;
use App\Domains\Category\Requests\CategoryRequest;
use App\Domains\Category\Services\CategoryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
