<?php

namespace App\Domains\Sales\Models;

use App\Domains\Common\Traits\BelongsToTenant;
use App\Domains\Common\Traits\HasPublicId;
use App\Domains\Customer\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleReturn extends Model
{
    use BelongsToTenant, HasPublicId;

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'sale_id',
        'customer_id',
        'user_id',
        'return_no',
        'total',
        'refunded',
        'adjusted_due',
        'reason',
        'return_date',
    ];

    protected $casts = [
        'total'        => 'decimal:2',
        'refunded'     => 'decimal:2',
        'adjusted_due' => 'decimal:2',
        'return_date'  => 'date',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(SaleReturnItem::class);
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
