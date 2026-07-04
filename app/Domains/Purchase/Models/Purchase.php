<?php

namespace App\Domains\Purchase\Models;

use App\Domains\Common\Traits\BelongsToTenant;
use App\Domains\Common\Traits\HasPublicId;
use App\Domains\Supplier\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use BelongsToTenant, HasPublicId;

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'supplier_id',
        'user_id',
        'invoice_no',
        'status',
        'total',
        'paid',
        'due',
        'purchase_date',
        'note',
    ];

    protected $casts = [
        'total'         => 'decimal:2',
        'paid'          => 'decimal:2',
        'due'           => 'decimal:2',
        'purchase_date' => 'date',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPaid(): bool
    {
        return $this->due <= 0;
    }

    public function returns(): HasMany
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function totalReturned(): float
    {
        return (float) $this->returns()->sum('total');
    }
}
