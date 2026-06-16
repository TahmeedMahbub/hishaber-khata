<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Marks all pre-existing users as email-verified so the newly introduced
 * owner email-verification requirement does not lock out current accounts.
 * Only newly registered owners will need to verify going forward.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->whereNull('email_verified_at')
            ->update(['email_verified_at' => now()]);
    }

    public function down(): void
    {
        // Irreversible: we cannot know which users were unverified before.
    }
};
