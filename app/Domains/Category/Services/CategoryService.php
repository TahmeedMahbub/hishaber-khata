<?php

namespace App\Domains\Category\Services;

use App\Domains\Category\Models\Category;
use App\Domains\Category\Repositories\CategoryRepository;
use App\Domains\Common\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryService extends BaseService
{
    public function __construct(protected CategoryRepository $categories)
    {
    }

    public function paginate(?string $search = null): LengthAwarePaginator
    {
        return $this->categories->list($search);
    }

    public function find(int $id): Category
    {
        return $this->categories->findOrFail($id);
    }

    public function create(array $data): Category
    {
        return $this->categories->create([
            'name'   => $data['name'],
            'status' => $data['status'] ?? 'active',
        ]);
    }

    public function update(Category $category, array $data): Category
    {
        return $this->categories->update($category, [
            'name'   => $data['name'],
            'status' => $data['status'] ?? $category->status,
        ]);
    }

    public function delete(Category $category): bool
    {
        return $this->categories->delete($category);
    }
}
