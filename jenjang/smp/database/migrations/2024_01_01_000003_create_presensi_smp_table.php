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
        Schema::connection('smp')->create('presensi_smp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa_smp')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha']);
            $table->text('keterangan')->nullable();
            $table->timestamp('jam_masuk')->nullable();
            $table->timestamp('jam_keluar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('smp')->dropIfExists('presensi_smp');
    }
};

