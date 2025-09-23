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
        Schema::connection('sma')->create('program_peserta_sma', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('program_kesiswaan_sma')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa_sma')->onDelete('cascade');
            $table->date('tanggal_daftar');
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
        Schema::connection('sma')->dropIfExists('program_peserta_sma');
    }
};

