<?php

namespace App\Domains\Sales\Models;

use App\Domains\Common\Traits\BelongsToTenant;
use App\Domains\Common\Traits\HasPublicId;
use App\Domains\Customer\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use BelongsToTenant, HasPublicId;

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'customer_id',
        'user_id',
        'invoice_no',
        'status',
        'total',
        'discount',
        'paid',
        'due',
        'sale_date',
        'note',
    ];

    protected $casts = [
        'total'     => 'decimal:2',
        'discount'  => 'decimal:2',
        'paid'      => 'decimal:2',
        'due'       => 'decimal:2',
        'sale_date' => 'date',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPaid(): bool
    {
        return $this->due <= 0;
    }
}
