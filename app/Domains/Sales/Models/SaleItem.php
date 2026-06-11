<?php

namespace App\Domains\Sales\Models;

use App\Domains\Common\Traits\HasPublicId;
use App\Domains\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    use HasPublicId;

    public $timestamps = false;

    protected $fillable = [
        'sale_id',
        'product_id',
        'qty',
        'unit_price',
        'cost_price',
        'total',
    ];

    protected $casts = [
        'qty'        => 'decimal:2',
        'unit_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'total'      => 'decimal:2',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
