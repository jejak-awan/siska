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
            $table->foreignId('program_id')->constrained('program')->onDelete('cascade');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->boolean('is_required')->default(true);
            $table->boolean('is_completed')->default(false);
            $table->integer('persentase_penyelesaian')->default(0);
            $table->timestamps();
            
            $table->index('program_id');
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