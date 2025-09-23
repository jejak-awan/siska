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
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('npsn')->unique();
            $table->string('nama_sekolah');
            $table->enum('jenjang', ['SD', 'SMP', 'SMA', 'SMK']);
            $table->text('alamat');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kabupaten_kota');
            $table->string('provinsi');
            $table->string('kode_pos');
            $table->string('nomor_telepon');
            $table->string('email');
            $table->string('website')->nullable();
            $table->string('logo_url')->nullable();
            $table->json('jenjang_aktif');
            $table->integer('tahun_berdiri');
            $table->enum('status_sekolah', ['negeri', 'swasta']);
            $table->enum('akreditasi', ['A', 'B', 'C', 'D'])->nullable();
            $table->string('kepala_sekolah');
            $table->string('nip_kepala_sekolah')->nullable();
            $table->string('bendahara')->nullable();
            $table->string('nip_bendahara')->nullable();
            $table->string('operator')->nullable();
            $table->string('nip_operator')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};

