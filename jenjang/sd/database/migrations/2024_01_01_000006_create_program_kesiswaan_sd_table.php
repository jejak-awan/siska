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
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->string('penanggung_jawab');
            $table->enum('status', ['aktif', 'selesai', 'ditunda', 'dibatalkan'])->default('aktif');
            $table->integer('target_peserta')->nullable();
            $table->decimal('biaya', 10, 2)->nullable();
            $table->string('lokasi')->nullable();
            $table->timestamps();
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

