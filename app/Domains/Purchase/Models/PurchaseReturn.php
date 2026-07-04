<?php

namespace App\Domains\Purchase\Models;

use App\Domains\Common\Traits\BelongsToTenant;
use App\Domains\Common\Traits\HasPublicId;
use App\Domains\Supplier\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseReturn extends Model
{
    use BelongsToTenant, HasPublicId;

    protected $fillable = [
        'tenant_id', 'branch_id', 'purchase_id', 'supplier_id', 'user_id',
        'return_no', 'total', 'refunded', 'adjusted_due', 'reason', 'return_date',
    ];

    protected $casts = [
        'total'        => 'decimal:2',
        'refunded'     => 'decimal:2',
        'adjusted_due' => 'decimal:2',
        'return_date'  => 'date',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseReturnItem::class);
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
