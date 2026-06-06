<?php

namespace App\Domains\Tenant\Scopes;

use App\Domains\Tenant\Services\TenantManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Global scope that automatically constrains every query on a tenant
 * model to the current tenant resolved from the TenantManager.
 *
 * When no tenant context is set (e.g. console commands, guest requests)
 * the scope is a no-op so seeding and cross-tenant maintenance still work.
 */
class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $tenantId = app(TenantManager::class)->getTenantId();

        if ($tenantId !== null) {
            $builder->where($model->getTable() . '.tenant_id', $tenantId);
        }
    }
}
