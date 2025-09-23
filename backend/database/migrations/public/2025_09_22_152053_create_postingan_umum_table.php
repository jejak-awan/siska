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
        Schema::connection('public')->create('postingan_umum', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->longText('konten');
            $table->enum('kategori', ['admin', 'guru', 'siswa', 'umum']);
            $table->string('subkategori', 100)->nullable();
            $table->json('tag')->nullable();
            $table->json('lampiran')->nullable();
            $table->enum('peran_penulis', ['admin', 'guru', 'siswa']);
            $table->unsignedBigInteger('id_penulis');
            $table->timestamp('tanggal_publikasi')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamps();
            
            $table->index('status');
            $table->index('kategori');
            $table->index('tanggal_publikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('public')->dropIfExists('postingan_umum');
    }
};