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
        Schema::connection('sd')->create('kredit_poin_sd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->constrained('siswa_sd')->onDelete('cascade');
            $table->enum('kategori', ['positif', 'negatif']);
            $table->integer('poin');
            $table->text('deskripsi');
            $table->date('tanggal');
            $table->foreignId('pemberi_poin_id')->constrained('users_sd')->onDelete('cascade');
            $table->enum('semester', ['1', '2']);
            $table->string('tahun_akademik', 9);
            $table->timestamps();
            
            $table->index(['id_siswa', 'tanggal']);
            $table->index('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sd')->dropIfExists('kredit_poin_sd');
    }
};