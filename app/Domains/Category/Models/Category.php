<?php

namespace App\Domains\Category\Models;

use App\Domains\Common\Traits\BelongsToTenant;
use App\Domains\Common\Traits\HasPublicId;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use BelongsToTenant, HasPublicId;

    protected $fillable = [
        'tenant_id',
        'name',
        'status',
    ];

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
