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
        Schema::connection('public')->create('audit_konten', function (Blueprint $table) {
            $table->id();
            $table->string('model_type')->comment('Tipe model yang diaudit (e.g., App\\Models\\Public\\PostinganUmum)');
            $table->unsignedBigInteger('model_id')->comment('ID model yang diaudit');
            $table->string('event')->comment('Jenis event: created, updated, deleted, reviewed, published');
            $table->unsignedBigInteger('user_id')->nullable()->comment('ID User yang melakukan audit (reference ke backend.users)');
            $table->text('old_values')->nullable()->comment('Nilai lama (JSON)');
            $table->text('new_values')->nullable()->comment('Nilai baru (JSON)');
            $table->text('catatan')->nullable()->comment('Catatan audit');
            $table->ipAddress('ip_address')->nullable()->comment('Alamat IP user');
            $table->string('user_agent')->nullable()->comment('User agent browser');
            $table->timestamps();

            $table->index(['model_type', 'model_id']);
            $table->index('event');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('public')->dropIfExists('audit_konten');
    }
};
