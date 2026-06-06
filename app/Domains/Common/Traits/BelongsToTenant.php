<?php

namespace App\Domains\Common\Traits;

use App\Domains\Tenant\Scopes\TenantScope;
use App\Domains\Tenant\Services\TenantManager;
use Illuminate\Database\Eloquent\Builder;

/**
 * Adds multi-tenant behaviour to an Eloquent model.
 *
 * - Registers a global scope so every query is automatically filtered
 *   by the current tenant (Product::all() => WHERE tenant_id = current).
 * - Auto-fills `tenant_id` from the current tenant context on create.
 *
 * The owning model must have a `tenant_id` column.
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait BelongsToTenant
{
    /**
     * Boot the trait: apply the global scope and auto-assign tenant_id.
     */
    public static function bootBelongsToTenant(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function ($model): void {
            if (empty($model->tenant_id) && ($tenantId = static::currentTenantId()) !== null) {
                $model->tenant_id = $tenantId;
            }
        });
    }

    /**
     * Resolve the current tenant id from the TenantManager.
     */
    protected static function currentTenantId(): ?int
    {
        return app(TenantManager::class)->getTenantId();
    }

    /**
     * Scope a query to a specific tenant (bypasses the implicit current tenant).
     */
    public function scopeForTenant(Builder $query, int $tenantId): Builder
    {
        return $query->withoutGlobalScope(TenantScope::class)
            ->where($this->getTable() . '.tenant_id', $tenantId);
    }

    /**
     * Scope a query to ignore tenant filtering entirely (admin/maintenance use).
     */
    public function scopeAllTenants(Builder $query): Builder
    {
        return $query->withoutGlobalScope(TenantScope::class);
    }
}
