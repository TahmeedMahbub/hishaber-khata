<?php

namespace App\Domains\Tenant\Models;

use App\Domains\Common\Traits\HasPublicId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tenant extends Model
{
    use HasPublicId;

    protected $fillable = [
        'name',
        'owner_name',
        'phone',
        'email',
        'business_type',
        'status',
    ];

    /**
     * The per-tenant business preferences (one row in the settings table).
     */
    public function settings(): HasOne
    {
        return $this->hasOne(Setting::class);
    }

    /**
     * Return the tenant's settings row, creating it with defaults if missing.
     */
    public function settingsOrCreate(): Setting
    {
        return $this->settings()->firstOrCreate(['tenant_id' => $this->id]);
    }

    /**
     * Get a single preference value, falling back to its default.
     */
    public function setting(string $key, mixed $default = null): mixed
    {
        $value = $this->settings?->getAttribute($key);

        if ($value !== null) {
            return $value;
        }

        return $default ?? Setting::DEFAULTS[$key] ?? null;
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(\App\Models\User::class);
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class)->latestOfMany();
    }

    public function mainBranch(): HasOne
    {
        return $this->hasOne(Branch::class)->where('is_main', true);
    }
}
