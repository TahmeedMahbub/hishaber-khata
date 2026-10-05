<?php

namespace App\Domains\Tenant\Services;

use App\Domains\Common\Services\BaseService;
use App\Domains\Product\Models\Product;
use App\Domains\Purchase\Models\Purchase;
use App\Domains\Sales\Models\Sale;
use App\Domains\Tenant\Exceptions\FeatureRestrictedException;
use App\Domains\Tenant\Exceptions\SubscriptionLimitException;
use App\Domains\Tenant\Models\Branch;
use App\Domains\Tenant\Models\Plan;
use App\Domains\Tenant\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Carbon;

class SubscriptionService extends BaseService
{
    /**
     * Resolve the target tenant.
     */
    public function resolveTenant(?Tenant $tenant = null): ?Tenant
    {
        if ($tenant !== null) {
            return $tenant;
        }

        $user = auth()->user();
        if ($user && $user->tenant) {
            return $user->tenant;
        }

        $tenantId = app(TenantManager::class)->getTenantId();
        if ($tenantId) {
            return Tenant::find($tenantId);
        }

        return null;
    }

    /**
     * Check if launch trial is active for the tenant.
     * Trial end = MAX(trial_started_at + 3 months, 2026-12-31).
     */
    public function isTrialActive(?Tenant $tenant = null): bool
    {
        $tenant = $this->resolveTenant($tenant);
        if (! $tenant || ! $tenant->created_at) {
            return false;
        }

        $threeMonthsEnd = $tenant->created_at->copy()->addMonths(3)->endOfDay();
        $cutoffEnd = Carbon::parse('2026-12-31 23:59:59');

        $trialEndAt = $threeMonthsEnd->greaterThan($cutoffEnd) ? $threeMonthsEnd : $cutoffEnd;

        return now()->lte($trialEndAt);
    }

    /**
     * Get the launch trial end date.
     */
    public function getTrialEndDate(?Tenant $tenant = null): ?Carbon
    {
        $tenant = $this->resolveTenant($tenant);
        if (! $tenant || ! $tenant->created_at) {
            return null;
        }

        $threeMonthsEnd = $tenant->created_at->copy()->addMonths(3)->endOfDay();
        $cutoffEnd = Carbon::parse('2026-12-31 23:59:59');

        return $threeMonthsEnd->greaterThan($cutoffEnd) ? $threeMonthsEnd : $cutoffEnd;
    }

    /**
     * Resolve the effective Plan for the tenant.
     * Note: Returns null if in trial (unlimited access) or the active Plan model instance.
     */
    public function getEffectivePlan(?Tenant $tenant = null): ?Plan
    {
        if ($this->isTrialActive($tenant)) {
            return null; // Trial override = full unlimited
        }

        $tenant = $this->resolveTenant($tenant);
        if (! $tenant) {
            return Plan::where('slug', 'free')->first();
        }

        $subscription = $tenant->subscription;

        if ($subscription && $subscription->isActive() && $subscription->plan) {
            return $subscription->plan;
        }

        return Plan::where('slug', 'free')->first();
    }

    /**
     * Determine if a feature is allowed for the tenant.
     */
    public function allowsFeature(string $featureKey, ?Tenant $tenant = null): bool
    {
        if ($this->isTrialActive($tenant)) {
            return true;
        }

        $plan = $this->getEffectivePlan($tenant);

        return $plan ? $plan->allows($featureKey) : false;
    }

    /**
     * Check feature flag or throw FeatureRestrictedException.
     */
    public function checkFeatureOrFail(string $featureKey, ?Tenant $tenant = null, string $featureLabelBn = 'এই ফিচারের'): void
    {
        if (! $this->allowsFeature($featureKey, $tenant)) {
            throw new FeatureRestrictedException(
                "{$featureLabelBn} ব্যবহারের সুবিধা আপনার বর্তমান প্ল্যানে অন্তর্ভুক্ত নয়। এই ফিচারটি ব্যবহার করতে আপনার প্ল্যান আপগ্রেড করুন।",
                $featureKey
            );
        }
    }

    // ── Dynamic Limits Resolvers (NULL = Unlimited) ─────────────────────

    public function getProductLimit(?Tenant $tenant = null): ?int
    {
        if ($this->isTrialActive($tenant)) {
            return null;
        }
        $plan = $this->getEffectivePlan($tenant);

        return $plan?->product_limit !== null ? (int) $plan->product_limit : null;
    }

    public function getMonthlySalesLimit(?Tenant $tenant = null): ?int
    {
        if ($this->isTrialActive($tenant)) {
            return null;
        }
        $plan = $this->getEffectivePlan($tenant);

        return $plan?->monthly_sales_limit !== null ? (int) $plan->monthly_sales_limit : null;
    }

    public function getMonthlyPurchaseLimit(?Tenant $tenant = null): ?int
    {
        if ($this->isTrialActive($tenant)) {
            return null;
        }
        $plan = $this->getEffectivePlan($tenant);

        return $plan?->monthly_purchase_limit !== null ? (int) $plan->monthly_purchase_limit : null;
    }

    public function getEmployeeLimit(?Tenant $tenant = null): ?int
    {
        if ($this->isTrialActive($tenant)) {
            return null;
        }
        $plan = $this->getEffectivePlan($tenant);

        return $plan?->employee_limit !== null ? (int) $plan->employee_limit : null;
    }

    public function getBranchLimit(?Tenant $tenant = null): ?int
    {
        if ($this->isTrialActive($tenant)) {
            return null;
        }
        $plan = $this->getEffectivePlan($tenant);

        return $plan?->branch_limit !== null ? (int) $plan->branch_limit : null;
    }

    // ── Per-Tenant Counts ───────────────────────────────────────────────

    public function getCurrentProductCount(?Tenant $tenant = null): int
    {
        $tenant = $this->resolveTenant($tenant);
        if (! $tenant) {
            return 0;
        }

        return Product::where('tenant_id', $tenant->id)->count();
    }

    public function getCurrentMonthlySalesCount(?Tenant $tenant = null): int
    {
        $tenant = $this->resolveTenant($tenant);
        if (! $tenant) {
            return 0;
        }

        return Sale::where('tenant_id', $tenant->id)
            ->whereYear('sale_date', now()->year)
            ->whereMonth('sale_date', now()->month)
            ->count();
    }

    public function getCurrentMonthlyPurchaseCount(?Tenant $tenant = null): int
    {
        $tenant = $this->resolveTenant($tenant);
        if (! $tenant) {
            return 0;
        }

        return Purchase::where('tenant_id', $tenant->id)
            ->whereYear('purchase_date', now()->year)
            ->whereMonth('purchase_date', now()->month)
            ->count();
    }

    public function getCurrentEmployeeCount(?Tenant $tenant = null): int
    {
        $tenant = $this->resolveTenant($tenant);
        if (! $tenant) {
            return 0;
        }

        return User::where('tenant_id', $tenant->id)->count();
    }

    public function getCurrentBranchCount(?Tenant $tenant = null): int
    {
        $tenant = $this->resolveTenant($tenant);
        if (! $tenant) {
            return 0;
        }

        return Branch::where('tenant_id', $tenant->id)->count();
    }

    // ── Enforcement Guard Methods ───────────────────────────────────────

    public function checkProductLimitOrFail(?Tenant $tenant = null): void
    {
        $limit = $this->getProductLimit($tenant);
        if ($limit === null) {
            return; // Unlimited
        }

        $current = $this->getCurrentProductCount($tenant);
        if ($current >= $limit) {
            throw new SubscriptionLimitException(
                "আপনার বর্তমান প্ল্যানে সর্বোচ্চ {$limit}টি পণ্য রাখা যাবে। আরও পণ্য যোগ করতে আপনার প্ল্যান আপগ্রেড করুন।",
                'product',
                $limit
            );
        }
    }

    public function checkSalesLimitOrFail(?Tenant $tenant = null): void
    {
        $limit = $this->getMonthlySalesLimit($tenant);
        if ($limit === null) {
            return; // Unlimited
        }

        $current = $this->getCurrentMonthlySalesCount($tenant);
        if ($current >= $limit) {
            throw new SubscriptionLimitException(
                'এই মাসের বিক্রয়ের সীমা পূর্ণ হয়েছে। আরও বিক্রয় করতে আপনার প্ল্যান আপগ্রেড করুন।',
                'sales',
                $limit
            );
        }
    }

    public function checkPurchaseLimitOrFail(?Tenant $tenant = null): void
    {
        $limit = $this->getMonthlyPurchaseLimit($tenant);
        if ($limit === null) {
            return; // Unlimited
        }

        $current = $this->getCurrentMonthlyPurchaseCount($tenant);
        if ($current >= $limit) {
            throw new SubscriptionLimitException(
                'এই মাসের ক্রয়ের সীমা পূর্ণ হয়েছে। আরও ক্রয় যোগ করতে আপনার প্ল্যান আপগ্রেড করুন।',
                'purchase',
                $limit
            );
        }
    }

    public function checkEmployeeLimitOrFail(?Tenant $tenant = null): void
    {
        $limit = $this->getEmployeeLimit($tenant);
        if ($limit === null) {
            return; // Unlimited
        }

        $current = $this->getCurrentEmployeeCount($tenant);
        if ($current >= $limit) {
            throw new SubscriptionLimitException(
                "আপনার বর্তমান প্ল্যানে সর্বোচ্চ {$limit} জন ব্যবহারকারী রাখা যাবে। আরও ব্যবহারকারী যোগ করতে আপনার প্ল্যান আপগ্রেড করুন।",
                'employee',
                $limit
            );
        }
    }

    public function checkBranchLimitOrFail(?Tenant $tenant = null): void
    {
        $limit = $this->getBranchLimit($tenant);
        if ($limit === null) {
            return; // Unlimited
        }

        $current = $this->getCurrentBranchCount($tenant);
        if ($current >= $limit) {
            throw new SubscriptionLimitException(
                "আপনার বর্তমান প্ল্যানে সর্বোচ্চ {$limit}টি শাখা তৈরি করা যাবে। আরও শাখা যোগ করতে আপনার প্ল্যান আপগ্রেড করুন।",
                'branch',
                $limit
            );
        }
    }
}
