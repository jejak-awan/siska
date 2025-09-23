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
        Schema::connection('sd')->create('ekstrakurikuler_siswa_sd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ekstrakurikuler_id')->constrained('ekstrakurikuler_sd')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa_sd')->onDelete('cascade');
            $table->date('tanggal_daftar');
            $table->date('tanggal_keluar')->nullable();
            $table->enum('status', ['aktif', 'selesai', 'keluar', 'diberhentikan'])->default('aktif');
            $table->decimal('nilai', 5, 2)->nullable();
            $table->string('sertifikat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sd')->dropIfExists('ekstrakurikuler_siswa_sd');
    }
};

