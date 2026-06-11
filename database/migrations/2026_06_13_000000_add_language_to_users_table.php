<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add a per-user `language` preference so each user can pick their
     * own interface language independently of the tenant-wide setting.
     */
    public function up(): void
    {
        if (Schema::hasTable('users') && ! Schema::hasColumn('users', 'language')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('language', ['bn', 'en'])->default('bn')->after('status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'language')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('language');
            });
        }
    }
};
