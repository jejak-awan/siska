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
        Schema::connection('sma')->create('organisasi_sma', function (Blueprint $table) {
            $table->id();
            $table->string('nama_organisasi')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('pembina');
            $table->string('ketua')->nullable();
            $table->string('wakil_ketua')->nullable();
            $table->string('sekretaris')->nullable();
            $table->string('bendahara')->nullable();
            $table->date('tanggal_berdiri');
            $table->enum('status', ['aktif', 'nonaktif', 'dibubarkan'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sma')->dropIfExists('organisasi_sma');
    }
};

