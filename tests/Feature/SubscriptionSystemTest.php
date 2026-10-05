<?php

namespace Tests\Feature;

use App\Domains\Tenant\Models\Plan;
use App\Domains\Tenant\Models\Tenant;
use App\Domains\Tenant\Services\SubscriptionService;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SubscriptionSystemTest extends TestCase
{
    public function test_launch_trial_grants_unlimited_access(): void
    {
        Carbon::setTestNow('2026-10-03 12:00:00');

        $tenant = Tenant::create([
            'name'          => 'Trial Shop',
            'owner_name'    => 'Trial Owner',
            'phone'         => '017' . rand(10000000, 99999999),
            'business_type' => 'grocery',
            'status'        => 'active',
        ]);

        $service = app(SubscriptionService::class);

        $this->assertTrue($service->isTrialActive($tenant));
        $this->assertNull($service->getProductLimit($tenant));
        $this->assertNull($service->getMonthlySalesLimit($tenant));
        $this->assertNull($service->getMonthlyPurchaseLimit($tenant));
        $this->assertTrue($service->allowsFeature('invoice', $tenant));
        $this->assertTrue($service->allowsFeature('custom_reports', $tenant));

        Carbon::setTestNow(); // reset
    }

    public function test_free_plan_enforces_database_limits(): void
    {
        Carbon::setTestNow('2027-01-15 12:00:00');

        $tenant = Tenant::create([
            'name'          => 'Free Shop',
            'owner_name'    => 'Free Owner',
            'phone'         => '018' . rand(10000000, 99999999),
            'business_type' => 'grocery',
            'status'        => 'active',
        ]);
        $tenant->created_at = Carbon::parse('2025-01-01 00:00:00');
        $tenant->save(['timestamps' => false]);

        $service = app(SubscriptionService::class);

        $this->assertFalse($service->isTrialActive($tenant));
        $this->assertEquals(30, $service->getProductLimit($tenant));
        $this->assertEquals(100, $service->getMonthlySalesLimit($tenant));
        $this->assertEquals(10, $service->getMonthlyPurchaseLimit($tenant));
        $this->assertFalse($service->allowsFeature('invoice', $tenant));

        Carbon::setTestNow(); // reset
    }

    public function test_dynamic_plan_database_update_reflects_immediately_without_code_changes(): void
    {
        Carbon::setTestNow('2027-01-15 12:00:00');

        $tenant = Tenant::create([
            'name'          => 'Dynamic Shop',
            'owner_name'    => 'Dynamic Owner',
            'phone'         => '019' . rand(10000000, 99999999),
            'business_type' => 'grocery',
            'status'        => 'active',
        ]);
        $tenant->created_at = Carbon::parse('2025-01-01 00:00:00');
        $tenant->save(['timestamps' => false]);

        $service = app(SubscriptionService::class);

        // Verify initial DB limit
        $this->assertEquals(30, $service->getProductLimit($tenant));

        // Simulate Future Admin Panel modifying Free plan in database (30 -> 45)
        Plan::where('slug', 'free')->update([
            'product_limit' => 45,
            'features_json' => json_encode(['sales' => true, 'basic_reports' => true, 'invoice' => true]),
        ]);

        // Verify application immediately uses updated values dynamically!
        $this->assertEquals(45, $service->getProductLimit($tenant));
        $this->assertTrue($service->allowsFeature('invoice', $tenant));

        // Revert test DB change back to 30
        Plan::where('slug', 'free')->update([
            'product_limit' => 30,
            'features_json' => json_encode([
                'sales'                      => true,
                'basic_reports'              => true,
                'invoice'                    => false,
                'customer_management'        => false,
                'due_management'             => false,
                'cloud_backup'               => false,
                'whatsapp_invoice'           => false,
                'stock_management'           => false,
                'expense_tracking'           => false,
                'premium_reports'            => false,
                'advanced_reports'           => false,
                'custom_reports'             => false,
                'role_permission_management' => false,
                'multi_branch'               => false,
                'priority_support'           => false,
                'dedicated_support'          => false,
            ]),
        ]);

        Carbon::setTestNow(); // reset
    }
}
