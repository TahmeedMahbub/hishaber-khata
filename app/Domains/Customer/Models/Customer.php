<?php

namespace App\Domains\Customer\Models;

use App\Domains\Common\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'phone',
        'address',
        'due_balance',
    ];

    protected $casts = [
        'due_balance' => 'decimal:2',
    ];
}
