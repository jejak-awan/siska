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
        Schema::connection('core')->create('tahun_akademik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('school_profile')->onDelete('cascade')->comment('ID sekolah');
            $table->string('tahun_akademik')->comment('Tahun akademik (e.g., 2024/2025)');
            $table->date('tanggal_mulai')->comment('Tanggal mulai tahun akademik');
            $table->date('tanggal_selesai')->comment('Tanggal selesai tahun akademik');
            $table->enum('status', ['upcoming', 'active', 'completed', 'cancelled'])->default('upcoming')->comment('Status tahun akademik');
            $table->boolean('is_active')->default(false)->comment('Apakah tahun akademik aktif');
            $table->text('keterangan')->nullable()->comment('Keterangan tambahan');
            $table->timestamps();

            $table->index(['school_id', 'is_active']);
            $table->index(['tahun_akademik', 'status']);
            $table->index('tanggal_mulai');
            $table->index('tanggal_selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('core')->dropIfExists('tahun_akademik');
    }
};
