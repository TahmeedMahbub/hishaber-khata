<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_sequences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('entity_type', 50);
            $table->unsignedBigInteger('last_number')->default(0);
            $table->timestamps();

            $table->unique(['tenant_id', 'entity_type'], 'tenant_entity_unique');
        });

        // Add composite index for tenant-scoped invoice and return numbers if not already present
        if (Schema::hasTable('sales') && ! Schema::hasIndex('sales', 'sales_tenant_invoice_index')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->index(['tenant_id', 'invoice_no'], 'sales_tenant_invoice_index');
            });
        }

        if (Schema::hasTable('purchases') && ! Schema::hasIndex('purchases', 'purchases_tenant_invoice_index')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->index(['tenant_id', 'invoice_no'], 'purchases_tenant_invoice_index');
            });
        }

        if (Schema::hasTable('sale_returns') && ! Schema::hasIndex('sale_returns', 'sale_returns_tenant_no_index')) {
            Schema::table('sale_returns', function (Blueprint $table) {
                $table->index(['tenant_id', 'return_no'], 'sale_returns_tenant_no_index');
            });
        }

        if (Schema::hasTable('purchase_returns') && ! Schema::hasIndex('purchase_returns', 'purchase_returns_tenant_no_index')) {
            Schema::table('purchase_returns', function (Blueprint $table) {
                $table->index(['tenant_id', 'return_no'], 'purchase_returns_tenant_no_index');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_sequences');
    }
};
