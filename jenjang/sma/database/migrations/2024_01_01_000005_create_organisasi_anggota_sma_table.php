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
        Schema::connection('sma')->create('organisasi_anggota_sma', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisasi_id')->constrained('organisasi_sma')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa_sma')->onDelete('cascade');
            $table->string('jabatan')->nullable();
            $table->date('tanggal_bergabung');
            $table->date('tanggal_keluar')->nullable();
            $table->enum('status', ['aktif', 'keluar', 'diberhentikan'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sma')->dropIfExists('organisasi_anggota_sma');
    }
};

