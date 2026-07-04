<?php

namespace App\Domains\Purchase\Models;

use App\Domains\Common\Traits\HasPublicId;
use App\Domains\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseItem extends Model
{
    use HasPublicId;

    public $timestamps = false;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'qty',
        'unit_price',
        'total',
    ];

    protected $casts = [
        'qty'        => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total'      => 'decimal:2',
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function returnedQty(): float
    {
        return (float) PurchaseReturnItem::where('purchase_item_id', $this->id)->sum('qty');
    }

    public function returnableQty(): float
    {
        return max(0, (float) $this->qty - $this->returnedQty());
    }
}
