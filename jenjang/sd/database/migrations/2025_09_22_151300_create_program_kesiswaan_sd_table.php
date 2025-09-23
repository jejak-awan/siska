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
        Schema::connection('sd')->create('program_kesiswaan_sd', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->text('deskripsi')->nullable();
            $table->enum('kategori', ['karakter_dasar', 'kebersihan', 'kedisiplinan']);
            $table->json('target_siswa')->nullable();
            $table->integer('durasi')->nullable();
            $table->foreignId('penanggung_jawab_id')->nullable()->constrained('users_sd')->onDelete('set null');
            $table->enum('status', ['active', 'inactive', 'completed'])->default('active');
            $table->timestamps();
            
            $table->index('kategori');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sd')->dropIfExists('program_kesiswaan_sd');
    }
};