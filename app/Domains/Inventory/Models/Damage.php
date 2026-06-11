<?php

namespace App\Domains\Inventory\Models;

use App\Domains\Common\Traits\BelongsToTenant;
use App\Domains\Common\Traits\HasPublicId;
use App\Domains\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Damage extends Model
{
    use BelongsToTenant, HasPublicId;

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'product_id',
        'type',
        'qty',
        'unit_cost',
        'reason',
        'damage_date',
    ];

    protected $casts = [
        'qty'         => 'decimal:2',
        'unit_cost'   => 'decimal:2',
        'damage_date' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
