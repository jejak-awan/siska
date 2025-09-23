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
        Schema::connection('smp')->create('ekstrakurikuler_smp', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ekstrakurikuler')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('pembina');
            $table->string('jadwal');
            $table->string('lokasi');
            $table->integer('kuota_maksimal')->default(50);
            $table->enum('status', ['aktif', 'nonaktif', 'ditutup'])->default('aktif');
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('smp')->dropIfExists('ekstrakurikuler_smp');
    }
};

