<?php

namespace App\Domains\Supplier\Models;

use App\Domains\Common\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
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
