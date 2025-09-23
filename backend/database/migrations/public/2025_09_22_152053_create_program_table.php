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
        Schema::connection('public')->create('program', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->enum('kategori', ['akademik', 'non_akademik', 'organisasi', 'kejuruan']);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->json('tujuan')->nullable();
            $table->enum('peran_penanggung_jawab', ['admin', 'guru', 'siswa']);
            $table->unsignedBigInteger('id_penanggung_jawab');
            $table->json('komponen')->nullable();
            $table->enum('status_penyelesaian', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->integer('persentase_penyelesaian')->default(0);
            $table->timestamps();
            
            $table->index('status_penyelesaian');
            $table->index('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('public')->dropIfExists('program');
    }
};