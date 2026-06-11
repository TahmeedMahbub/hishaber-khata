<?php

namespace App\Domains\Product\Models;

use App\Domains\Category\Models\Category;
use App\Domains\Common\Traits\BelongsToTenant;
use App\Domains\Common\Traits\HasPublicId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use BelongsToTenant, HasPublicId;

    protected $fillable = [
        'tenant_id',
        'category_id',
        'name',
        'barcode',
        'unit',
        'purchase_price',
        'sale_price',
        'stock_qty',
        'low_stock_alert',
        'status',
    ];

    protected $casts = [
        'purchase_price'  => 'decimal:2',
        'sale_price'      => 'decimal:2',
        'stock_qty'       => 'decimal:2',
        'low_stock_alert' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isLowStock(): bool
    {
        return $this->low_stock_alert > 0 && $this->stock_qty <= $this->low_stock_alert;
    }
}
