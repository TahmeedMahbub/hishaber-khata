<?php

namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A verified Google identity that has not finished business registration yet.
 * Lets a visitor resume onboarding later without creating a half-made user/tenant.
 */
class GoogleRegistration extends Model
{
    public const TTL_DAYS = 14;

    protected $fillable = ['google_id', 'email', 'name', 'expires_at'];

    protected $casts = ['expires_at' => 'datetime'];

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}
