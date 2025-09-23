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
        Schema::connection('sd')->create('siswa_sd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users_sd')->onDelete('cascade');
            $table->string('nis')->unique();
            $table->string('nisn')->unique();
            $table->string('nama');
            $table->enum('kelas', ['1', '2', '3', '4', '5', '6']);
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('nama_orang_tua')->nullable();
            $table->string('telepon_orang_tua', 20)->nullable();
            $table->enum('status', ['active', 'inactive', 'lulus', 'pindah'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sd')->dropIfExists('siswa_sd');
    }
};