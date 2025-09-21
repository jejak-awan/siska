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
            $table->string('judul')->comment('Judul postingan');
            $table->longText('konten')->comment('Konten postingan');
            $table->enum('kategori', ['berita', 'pengumuman', 'artikel', 'agenda'])->comment('Kategori postingan');
            $table->string('subkategori')->nullable()->comment('Subkategori postingan');
            $table->json('tag')->nullable()->comment('Tag postingan');
            $table->json('lampiran')->nullable()->comment('File lampiran');
            $table->string('peran_penulis')->comment('Peran penulis (admin, guru, dll)');
            $table->unsignedBigInteger('id_penulis')->comment('ID penulis');
            $table->timestamp('tanggal_publikasi')->nullable()->comment('Tanggal publikasi');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->comment('Status postingan');
            $table->integer('views')->default(0)->comment('Jumlah views');
            $table->boolean('is_featured')->default(false)->comment('Apakah featured');
            $table->boolean('is_pinned')->default(false)->comment('Apakah pinned');
            $table->timestamps();

            $table->index(['kategori', 'status']);
            $table->index(['tanggal_publikasi', 'status']);
            $table->index(['peran_penulis', 'id_penulis']);
            $table->index('is_featured');
            $table->index('is_pinned');
            $table->index('views');
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
