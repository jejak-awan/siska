<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('license_key')->unique();
            $table->enum('license_type', ['basic', 'premium', 'enterprise']);
            $table->string('school_name');
            $table->text('school_address');
            $table->string('contact_person');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->integer('max_users');
            $table->integer('max_students');
            $table->json('features');
            $table->timestamp('expires_at');
            $table->enum('status', ['active', 'inactive', 'expired'])->default('inactive');
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('deactivated_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};

