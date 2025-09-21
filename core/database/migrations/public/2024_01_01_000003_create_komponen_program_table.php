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
        Schema::connection('public')->create('komponen_program', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('program')->onDelete('cascade')->comment('Foreign key ke tabel program');
            $table->string('nama')->comment('Nama komponen program');
            $table->text('deskripsi')->nullable()->comment('Deskripsi komponen program');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending')->comment('Status komponen');
            $table->date('tanggal_mulai')->nullable()->comment('Tanggal mulai komponen');
            $table->date('tanggal_selesai')->nullable()->comment('Tanggal selesai komponen');
            $table->boolean('is_required')->default(true)->comment('Apakah komponen wajib');
            $table->boolean('is_completed')->default(false)->comment('Apakah komponen sudah selesai');
            $table->integer('persentase_penyelesaian')->default(0)->comment('Persentase penyelesaian komponen');
            $table->timestamps();

            $table->index(['program_id', 'status']);
            $table->index('is_required');
            $table->index('is_completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('public')->dropIfExists('komponen_program');
    }
};
