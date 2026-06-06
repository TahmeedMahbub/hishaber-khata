<?php

namespace App\Http\Middleware;

use App\Domains\Tenant\Services\TenantManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolves the current tenant from the authenticated user and stores
 * it in the TenantManager so the rest of the request can scope queries
 * to that tenant.
 *
 * Should run after authentication middleware.
 */
class TenantMiddleware
{
    public function __construct(protected TenantManager $tenants)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // No authenticated user => no tenant context to resolve.
        if ($user === null) {
            return $next($request);
        }

        // Block users that are not attached to a tenant.
        if (empty($user->tenant_id)) {
            abort(403, 'No active business is associated with this account.');
        }

        $this->tenants->setTenantId((int) $user->tenant_id);

        return $next($request);
    }
}
