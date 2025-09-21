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
        Schema::connection('core')->create('license_management', function (Blueprint $table) {
            $table->id();
            $table->string('license_key')->unique()->comment('Kunci lisensi unik');
            $table->string('installation_id')->nullable()->comment('ID instalasi');
            $table->foreignId('sekolah_id')->nullable()->constrained('profil_sekolah')->onDelete('set null')->comment('ID sekolah');
            $table->enum('license_type', ['trial', 'single', 'multi', 'enterprise'])->default('trial')->comment('Jenis lisensi');
            $table->json('jenjang_access')->nullable()->comment('Akses jenjang yang diizinkan');
            $table->json('features')->nullable()->comment('Fitur yang diizinkan');
            $table->integer('max_users')->default(10)->comment('Maksimal pengguna');
            $table->timestamp('expires_at')->nullable()->comment('Tanggal kadaluarsa');
            $table->boolean('is_active')->default(false)->comment('Status aktif');
            $table->timestamp('activated_at')->nullable()->comment('Tanggal aktivasi');
            $table->timestamp('last_check')->nullable()->comment('Terakhir dicek');
            $table->timestamps();

            $table->index(['license_key', 'is_active']);
            $table->index('installation_id');
            $table->index('sekolah_id');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('core')->dropIfExists('license_management');
    }
};
