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
        Schema::connection('public')->create('kegiatan_publik', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('tempat');
            $table->string('penanggung_jawab');
            $table->json('target_peserta')->nullable();
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->string('gambar_utama')->nullable();
            $table->json('galeri_gambar')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('tanggal_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('public')->dropIfExists('kegiatan_publik');
    }
};