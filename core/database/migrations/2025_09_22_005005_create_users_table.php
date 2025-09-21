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
        Schema::connection('core')->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique()->comment('Username untuk login');
            $table->string('email')->unique()->comment('Alamat email');
            $table->timestamp('email_verified_at')->nullable()->comment('Tanggal verifikasi email');
            $table->string('password')->comment('Password terenkripsi');
            $table->enum('role_type', ['admin', 'guru', 'siswa', 'wali_kelas', 'bk', 'osis', 'ekstrakurikuler', 'orang_tua'])->comment('Tipe role user');
            $table->enum('status', ['aktif', 'nonaktif', 'suspended'])->default('aktif')->comment('Status user');
            $table->timestamp('last_login_at')->nullable()->comment('Terakhir login');
            $table->json('profile_data')->nullable()->comment('Data profil tambahan');
            $table->rememberToken();
            $table->timestamps();

            $table->index(['username', 'status']);
            $table->index(['email', 'status']);
            $table->index('role_type');
            $table->index('last_login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('core')->dropIfExists('users');
    }
};
