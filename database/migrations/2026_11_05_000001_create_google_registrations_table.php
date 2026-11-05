<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('google_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('google_id', 64)->unique();
            $table->string('email');
            $table->string('name')->nullable();
            $table->timestamp('expires_at');
            $table->timestamps();
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('google_registrations');
    }
};
