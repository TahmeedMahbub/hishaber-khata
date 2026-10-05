<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            if (! Schema::hasColumn('plans', 'product_limit')) {
                $table->unsignedInteger('product_limit')->nullable()->after('price');
            }
            if (! Schema::hasColumn('plans', 'monthly_sales_limit')) {
                $table->unsignedInteger('monthly_sales_limit')->nullable()->after('product_limit');
            }
            if (! Schema::hasColumn('plans', 'monthly_purchase_limit')) {
                $table->unsignedInteger('monthly_purchase_limit')->nullable()->after('monthly_sales_limit');
            }
            $table->unsignedSmallInteger('employee_limit')->nullable()->default(1)->change();
            $table->unsignedSmallInteger('branch_limit')->nullable()->default(1)->change();
        });

        // Seed / Update plans table default records
        $now = now();
        $plans = [
            [
                'name'                   => 'Free',
                'slug'                   => 'free',
                'price'                  => 0.00,
                'product_limit'          => 30,
                'monthly_sales_limit'    => 100,
                'monthly_purchase_limit' => 10,
                'employee_limit'         => 1,
                'branch_limit'           => 1,
                'features_json'          => json_encode([
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
                'is_active'              => true,
            ],
            [
                'name'                   => 'Basic',
                'slug'                   => 'basic',
                'price'                  => 299.00,
                'product_limit'          => 150,
                'monthly_sales_limit'    => null,
                'monthly_purchase_limit' => 100,
                'employee_limit'         => 1,
                'branch_limit'           => 1,
                'features_json'          => json_encode([
                    'sales'                      => true,
                    'basic_reports'              => true,
                    'invoice'                    => true,
                    'customer_management'        => true,
                    'due_management'             => true,
                    'cloud_backup'               => true,
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
                'is_active'              => true,
            ],
            [
                'name'                   => 'Professional',
                'slug'                   => 'professional',
                'price'                  => 599.00,
                'product_limit'          => 500,
                'monthly_sales_limit'    => null,
                'monthly_purchase_limit' => null,
                'employee_limit'         => 3,
                'branch_limit'           => 1,
                'features_json'          => json_encode([
                    'sales'                      => true,
                    'basic_reports'              => true,
                    'invoice'                    => true,
                    'customer_management'        => true,
                    'due_management'             => true,
                    'cloud_backup'               => true,
                    'whatsapp_invoice'           => true,
                    'stock_management'           => true,
                    'expense_tracking'           => true,
                    'premium_reports'            => true,
                    'priority_support'           => true,
                    'advanced_reports'           => false,
                    'custom_reports'             => false,
                    'role_permission_management' => false,
                    'multi_branch'               => false,
                    'dedicated_support'          => false,
                ]),
                'is_active'              => true,
            ],
            [
                'name'                   => 'Business',
                'slug'                   => 'business',
                'price'                  => 1299.00,
                'product_limit'          => null,
                'monthly_sales_limit'    => null,
                'monthly_purchase_limit' => null,
                'employee_limit'         => 10,
                'branch_limit'           => null,
                'features_json'          => json_encode([
                    'sales'                      => true,
                    'basic_reports'              => true,
                    'invoice'                    => true,
                    'customer_management'        => true,
                    'due_management'             => true,
                    'cloud_backup'               => true,
                    'whatsapp_invoice'           => true,
                    'stock_management'           => true,
                    'expense_tracking'           => true,
                    'premium_reports'            => true,
                    'priority_support'           => true,
                    'multi_branch'               => true,
                    'advanced_reports'           => true,
                    'custom_reports'             => true,
                    'role_permission_management' => true,
                    'dedicated_support'          => true,
                ]),
                'is_active'              => true,
            ],
        ];

        foreach ($plans as $planData) {
            DB::table('plans')->updateOrInsert(
                ['slug' => $planData['slug']],
                array_merge($planData, ['created_at' => $now, 'updated_at' => $now])
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['product_limit', 'monthly_sales_limit', 'monthly_purchase_limit']);
        });
    }
};
