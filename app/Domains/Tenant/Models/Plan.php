<?php

namespace App\Domains\Tenant\Models;

use App\Domains\Common\Traits\HasPublicId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasPublicId;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'product_limit',
        'monthly_sales_limit',
        'monthly_purchase_limit',
        'branch_limit',
        'employee_limit',
        'features_json',
        'is_active',
    ];

    protected $casts = [
        'price'                  => 'decimal:2',
        'product_limit'          => 'integer',
        'monthly_sales_limit'    => 'integer',
        'monthly_purchase_limit' => 'integer',
        'branch_limit'           => 'integer',
        'employee_limit'         => 'integer',
        'features_json'          => 'array',
        'is_active'              => 'boolean',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Determine whether the plan grants a given feature flag.
     */
    public function allows(string $feature): bool
    {
        return (bool) ($this->features_json[$feature] ?? false);
    }
}
