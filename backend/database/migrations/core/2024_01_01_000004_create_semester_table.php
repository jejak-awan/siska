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
        Schema::connection('backend')->create('semester', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademik')->onDelete('cascade')->comment('ID tahun akademik');
            $table->string('nama_semester')->comment('Nama semester (e.g., Ganjil, Genap)');
            $table->integer('semester_ke')->comment('Nomor semester (1 atau 2)');
            $table->date('tanggal_mulai')->comment('Tanggal mulai semester');
            $table->date('tanggal_selesai')->comment('Tanggal selesai semester');
            $table->enum('status', ['upcoming', 'active', 'completed', 'cancelled'])->default('upcoming')->comment('Status semester');
            $table->boolean('is_active')->default(false)->comment('Apakah semester aktif');
            $table->text('keterangan')->nullable()->comment('Keterangan tambahan');
            $table->timestamps();

            $table->index(['tahun_akademik_id', 'is_active']);
            $table->index(['semester_ke', 'status']);
            $table->index('tanggal_mulai');
            $table->index('tanggal_selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('backend')->dropIfExists('semester');
    }
};
