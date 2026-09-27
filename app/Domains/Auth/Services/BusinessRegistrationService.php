<?php

namespace App\Domains\Auth\Services;

use App\Domains\Common\Services\BaseService;
use App\Domains\Tenant\Models\Branch;
use App\Domains\Tenant\Models\Plan;
use App\Domains\Tenant\Models\Subscription;
use App\Domains\Tenant\Models\Tenant;
use App\Models\User;
use RuntimeException;

/**
 * Orchestrates the full business registration flow:
 * tenant -> main branch -> owner user -> free plan subscription,
 * all inside a single database transaction.
 */
class BusinessRegistrationService extends BaseService
{
    /**
     * Register a new business and return the created owner user.
     *
     * @param  array{business_name:string,owner_name:string,phone:string,email:?string,password:string,business_type:string}  $data
     */
    public function register(array $data): User
    {
        return $this->transaction(function () use ($data): User {
            $tenant = $this->createTenant($data);
            $branch = $this->createMainBranch($tenant, $data);
            $user = $this->createOwner($tenant, $branch, $data);
            $this->assignFreePlan($tenant);

            return $user;
        });
    }

    protected function createTenant(array $data): Tenant
    {
        return Tenant::create([
            'name'          => $data['business_name'],
            'owner_name'    => $data['owner_name'],
            'phone'         => $data['phone'],
            'email'         => $data['email'] ?? null,
            'business_type' => $data['business_type'],
            'status'        => 'active',
        ]);
    }

    protected function createMainBranch(Tenant $tenant, array $data): Branch
    {
        return Branch::create([
            'tenant_id' => $tenant->id,
            'name'      => 'Main Branch',
            'phone'     => $data['phone'],
            'is_main'   => true,
        ]);
    }

    protected function createOwner(Tenant $tenant, Branch $branch, array $data): User
    {
        return User::create([
            'tenant_id' => $tenant->id,
            'branch_id' => $branch->id,
            'name'      => $data['owner_name'],
            'phone'     => $data['phone'],
            'email'     => $data['email'] ?? null,
            'password'  => $data['password'],
            'role'      => 'owner',
            'status'    => 'active',
        ]);
    }

    protected function assignFreePlan(Tenant $tenant): Subscription
    {
        $plan = Plan::where('slug', 'free')->first();

        if ($plan === null) {
            throw new RuntimeException('Free plan is not configured. Seed the plans table first.');
        }

        return Subscription::create([
            'tenant_id' => $tenant->id,
            'plan_id'   => $plan->id,
            'status'    => 'active',
            'starts_at' => now()->toDateString(),
            'ends_at'   => null,
        ]);
    }
}
