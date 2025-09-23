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
        Schema::create('tahun_akademik', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            $table->integer('semester');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['aktif', 'nonaktif', 'selesai'])->default('nonaktif');
            $table->boolean('is_active')->default(false);
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_akademik');
    }
};

