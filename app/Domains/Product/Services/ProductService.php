<?php

namespace App\Domains\Product\Services;

use App\Domains\Common\Services\BaseService;
use App\Domains\Product\Models\Product;
use App\Domains\Product\Repositories\ProductRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService extends BaseService
{
    public function __construct(protected ProductRepository $products)
    {
    }

    public function paginate(?string $search = null, ?int $categoryId = null): LengthAwarePaginator
    {
        return $this->products->list($search, $categoryId);
    }

    public function find(int $id): Product
    {
        return $this->products->findOrFail($id);
    }

    public function create(array $data): Product
    {
        return $this->products->create($this->prepare($data));
    }

    public function update(Product $product, array $data): Product
    {
        return $this->products->update($product, $this->prepare($data));
    }

    public function delete(Product $product): bool
    {
        return $this->products->delete($product);
    }

    /**
     * Normalise incoming form data.
     *
     * @return array<string, mixed>
     */
    protected function prepare(array $data): array
    {
        return [
            'category_id'     => $data['category_id'] ?? null,
            'name'            => $data['name'],
            'barcode'         => $data['barcode'] ?? null,
            'unit'            => $data['unit'] ?? 'pcs',
            'purchase_price'  => $data['purchase_price'] ?? 0,
            'sale_price'      => $data['sale_price'] ?? 0,
            'stock_qty'       => $data['stock_qty'] ?? 0,
            'low_stock_alert' => $data['low_stock_alert'] ?? 0,
            'status'          => $data['status'] ?? 'active',
        ];
    }
}
