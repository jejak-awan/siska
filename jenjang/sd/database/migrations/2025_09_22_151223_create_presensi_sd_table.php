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
        Schema::connection('sd')->create('presensi_sd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->constrained('siswa_sd')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa'])->default('hadir');
            $table->text('keterangan')->nullable();
            $table->enum('semester', ['1', '2']);
            $table->string('tahun_akademik', 9);
            $table->timestamps();
            
            $table->index(['id_siswa', 'tanggal']);
            $table->index('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sd')->dropIfExists('presensi_sd');
    }
};