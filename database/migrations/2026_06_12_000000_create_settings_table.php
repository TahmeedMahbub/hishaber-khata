<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create a dedicated `settings` table holding one row of business
     * preferences per tenant (language, stock tracking, alerts, etc.).
     * Each option is stored in its own column.
     */
    public function up(): void
    {
        // Remove the old JSON column on tenants if a previous version added it.
        if (Schema::hasTable('tenants') && Schema::hasColumn('tenants', 'settings')) {
            Schema::table('tenants', function (Blueprint $table) {
                $table->dropColumn('settings');
            });
        }

        if (Schema::hasTable('settings')) {
            return;
        }

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->char('public_id', 8)->nullable()->unique();
            $table->foreignId('tenant_id')->unique()->constrained('tenants')->cascadeOnDelete();

            // Localization
            $table->enum('language', ['bn', 'en'])->default('bn');
            $table->string('currency', 10)->default('BDT');
            $table->string('currency_symbol', 10)->default('৳');
            $table->string('date_format', 20)->default('d/m/Y');
            $table->string('timezone', 50)->default('Asia/Dhaka');

            // Stock / inventory
            $table->boolean('track_stock')->default(true);
            $table->boolean('low_stock_alert')->default(true);
            $table->boolean('allow_negative_stock')->default(false);
            $table->boolean('enable_barcode')->default(false);

            // Sales / reporting
            $table->boolean('show_profit')->default(true);
            $table->boolean('enable_due')->default(true);
            $table->string('invoice_prefix', 20)->default('INV-');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
