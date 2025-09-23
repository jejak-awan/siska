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
        Schema::connection('sma')->create('siswa_sma', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users_sma')->onDelete('cascade');
            $table->string('nis')->unique();
            $table->string('nisn')->unique();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->string('agama');
            $table->text('alamat');
            $table->string('nomor_telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('kelas');
            $table->integer('tahun_masuk');
            $table->enum('status', ['aktif', 'nonaktif', 'lulus', 'pindah'])->default('aktif');
            $table->string('nama_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->text('alamat_ortu')->nullable();
            $table->string('nomor_telepon_ortu')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sma')->dropIfExists('siswa_sma');
    }
};

