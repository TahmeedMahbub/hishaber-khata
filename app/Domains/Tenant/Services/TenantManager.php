<?php

namespace App\Domains\Tenant\Services;

/**
 * Holds the current tenant context for the duration of a request.
 *
 * Registered as a singleton so any class (services, repositories,
 * global scopes) can resolve the active tenant without re-reading
 * the authenticated user everywhere.
 */
class TenantManager
{
    /**
     * The resolved current tenant id, if any.
     */
    protected ?int $tenantId = null;

    /**
     * Set the current tenant id.
     */
    public function setTenantId(?int $tenantId): void
    {
        $this->tenantId = $tenantId;
    }

    /**
     * Get the current tenant id.
     */
    public function getTenantId(): ?int
    {
        return $this->tenantId;
    }

    /**
     * Determine whether a tenant context is currently set.
     */
    public function hasTenant(): bool
    {
        return $this->tenantId !== null;
    }

    /**
     * Clear the current tenant context.
     */
    public function forget(): void
    {
        $this->tenantId = null;
    }
}
