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
        Schema::connection('smk')->create('kejuruan_siswa_smk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kejuruan_id')->constrained('kejuruan_smk')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa_smk')->onDelete('cascade');
            $table->date('tanggal_daftar');
            $table->date('tanggal_keluar')->nullable();
            $table->enum('status', ['aktif', 'selesai', 'keluar', 'diberhentikan'])->default('aktif');
            $table->decimal('nilai', 5, 2)->nullable();
            $table->string('sertifikat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('smk')->dropIfExists('kejuruan_siswa_smk');
    }
};

