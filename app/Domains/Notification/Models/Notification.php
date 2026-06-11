<?php

namespace App\Domains\Notification\Models;

use App\Domains\Common\Traits\HasPublicId;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A notification is either tenant-wide or personal:
 *
 * - tenant_id set   => shown to every user of that tenant.
 * - tenant_id null  => user_id is required and it is shown only to that user.
 *
 * `read_at` is null while the notification is unread.
 *
 * NOTE: this model intentionally does NOT use the BelongsToTenant global
 * scope, because its visibility rule is custom (tenant-wide OR personal).
 */
class Notification extends Model
{
    use HasPublicId;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'type',
        'title',
        'message',
        'url',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(\App\Domains\Tenant\Models\Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Constrain the query to notifications visible to the given user:
     * every tenant-wide notification of their tenant, plus their own
     * personal (tenant-less) notifications.
     */
    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return $query->where(function (Builder $q) use ($user): void {
            if ($user->tenant_id !== null) {
                $q->where('tenant_id', $user->tenant_id);
            }

            $q->orWhere(function (Builder $inner) use ($user): void {
                $inner->whereNull('tenant_id')->where('user_id', $user->id);
            });
        });
    }

    /**
     * Only unread notifications.
     */
    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    public function isUnread(): bool
    {
        return $this->read_at === null;
    }
}
