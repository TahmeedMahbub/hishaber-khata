<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_returns', function (Blueprint $table) {
            $table->id();
            $table->char('public_id', 8)->nullable()->unique();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('sale_id')->constrained('sales')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('return_no', 50)->nullable();
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('refunded', 12, 2)->default(0);
            $table->decimal('adjusted_due', 12, 2)->default(0);
            $table->string('reason', 255)->nullable();
            $table->date('return_date');
            $table->timestamps();

            $table->index('tenant_id', 'sale_returns_tenant_id_index');
            $table->index('sale_id', 'sale_returns_sale_id_index');
            $table->index(['tenant_id', 'return_date'], 'sale_returns_tenant_date_index');
        });

        Schema::create('sale_return_items', function (Blueprint $table) {
            $table->id();
            $table->char('public_id', 8)->nullable()->unique();
            $table->foreignId('sale_return_id')->constrained('sale_returns')->cascadeOnDelete();
            $table->foreignId('sale_item_id')->constrained('sale_items')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('qty', 12, 2)->default(0);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('cost_price', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            $table->index('sale_return_id', 'sale_return_items_return_id_index');
            $table->index('sale_item_id', 'sale_return_items_sale_item_id_index');
            $table->index('product_id', 'sale_return_items_product_id_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_return_items');
        Schema::dropIfExists('sale_returns');
    }
};
