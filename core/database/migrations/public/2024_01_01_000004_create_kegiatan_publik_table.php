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
            $table->string('nama_kegiatan')->comment('Nama kegiatan publik');
            $table->text('deskripsi')->nullable()->comment('Deskripsi kegiatan');
            $table->date('tanggal_mulai')->comment('Tanggal mulai kegiatan');
            $table->date('tanggal_selesai')->comment('Tanggal selesai kegiatan');
            $table->string('tempat')->comment('Tempat kegiatan');
            $table->string('penanggung_jawab')->comment('Penanggung jawab kegiatan');
            $table->json('target_peserta')->nullable()->comment('Target peserta kegiatan');
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming')->comment('Status kegiatan');
            $table->string('gambar_utama')->nullable()->comment('Path gambar utama kegiatan');
            $table->json('galeri_gambar')->nullable()->comment('Array path galeri gambar');
            $table->timestamps();

            $table->index('tanggal_mulai');
            $table->index('status');
            $table->index('penanggung_jawab');
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
