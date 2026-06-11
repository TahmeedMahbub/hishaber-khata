<?php

namespace App\Domains\Expense\Models;

use App\Domains\Common\Traits\BelongsToTenant;
use App\Domains\Common\Traits\HasPublicId;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use BelongsToTenant, HasPublicId;

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'expense_category_id',
        'title',
        'amount',
        'expense_date',
        'note',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'expense_date' => 'date',
    ];
}
