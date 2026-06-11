<?php

namespace App\Domains\Common\Models;

use App\Domains\Common\Traits\HasPublicId;
use App\Domains\Tenant\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Feedback may be submitted by an authenticated tenant user OR by a guest
 * from the public landing page, so tenant_id and user_id are both nullable.
 * This model intentionally does NOT use the tenant global scope.
 */
class Feedback extends Model
{
    use HasPublicId;

    protected $table = 'feedbacks';

    protected $fillable = [
        'tenant_id',
        'user_id',
        'name',
        'phone',
        'email',
        'type',
        'rating',
        'message',
        'source',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
