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
        Schema::connection('sma')->create('program_kesiswaan_sma', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->string('penanggung_jawab');
            $table->foreignId('organisasi_id')->nullable()->constrained('organisasi_sma')->onDelete('set null');
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
        Schema::connection('sma')->dropIfExists('program_kesiswaan_sma');
    }
};

