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
        Schema::connection('sd')->create('penilaian_karakter_sd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->constrained('siswa_sd')->onDelete('cascade');
            $table->foreignId('id_program_kesiswaan')->nullable()->constrained('program_kesiswaan_sd')->onDelete('set null');
            $table->enum('aspek_karakter', ['jujur', 'disiplin', 'tanggung_jawab', 'santun']);
            $table->enum('nilai_karakter', ['1', '2', '3', '4']);
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_penilaian');
            $table->foreignId('penilai_id')->constrained('users_sd')->onDelete('cascade');
            $table->enum('semester', ['1', '2']);
            $table->string('tahun_akademik', 9);
            $table->timestamps();
            
            $table->index(['id_siswa', 'semester', 'tahun_akademik']);
            $table->index('aspek_karakter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sd')->dropIfExists('penilaian_karakter_sd');
    }
};