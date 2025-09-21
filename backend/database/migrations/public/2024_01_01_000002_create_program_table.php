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
            $table->string('nama')->comment('Nama program');
            $table->text('deskripsi')->nullable()->comment('Deskripsi program');
            $table->enum('kategori', ['akademik', 'non_akademik', 'organisasi', 'kejuruan', 'karakter'])->comment('Kategori program');
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming')->comment('Status program');
            $table->date('tanggal_mulai')->comment('Tanggal mulai program');
            $table->date('tanggal_selesai')->comment('Tanggal selesai program');
            $table->json('tujuan')->nullable()->comment('Tujuan program');
            $table->json('target_audience')->nullable()->comment('Target audience');
            $table->string('peran_penanggung_jawab')->comment('Peran penanggung jawab');
            $table->unsignedBigInteger('id_penanggung_jawab')->comment('ID penanggung jawab');
            $table->json('komponen')->nullable()->comment('Komponen program');
            $table->json('status_penyelesaian')->nullable()->comment('Status penyelesaian komponen');
            $table->decimal('persentase_penyelesaian', 5, 2)->default(0)->comment('Persentase penyelesaian');
            $table->boolean('is_active')->default(true)->comment('Apakah program aktif');
            $table->boolean('is_featured')->default(false)->comment('Apakah featured');
            $table->timestamps();

            $table->index(['kategori', 'status']);
            $table->index(['tanggal_mulai', 'tanggal_selesai']);
            $table->index(['peran_penanggung_jawab', 'id_penanggung_jawab']);
            $table->index('is_active');
            $table->index('is_featured');
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
