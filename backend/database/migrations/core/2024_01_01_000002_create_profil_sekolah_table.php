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
        Schema::connection('backend')->create('profil_sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah')->comment('Nama sekolah');
            $table->enum('jenis_sekolah', ['negeri', 'swasta', 'yayasan'])->default('negeri')->comment('Jenis sekolah');
            $table->json('jenjang_aktif')->nullable()->comment('Jenjang yang aktif');
            $table->boolean('multi_jenjang')->default(false)->comment('Apakah multi jenjang');
            $table->text('alamat')->nullable()->comment('Alamat sekolah');
            $table->string('telepon')->nullable()->comment('Nomor telepon');
            $table->string('email')->nullable()->comment('Email sekolah');
            $table->string('website')->nullable()->comment('Website sekolah');
            $table->string('logo')->nullable()->comment('Path logo sekolah');
            $table->json('struktur_organisasi')->nullable()->comment('Struktur organisasi');
            $table->text('sejarah')->nullable()->comment('Sejarah sekolah');
            $table->text('visi')->nullable()->comment('Visi sekolah');
            $table->text('misi')->nullable()->comment('Misi sekolah');
            $table->text('tujuan')->nullable()->comment('Tujuan sekolah');
            $table->boolean('status')->default(true)->comment('Status aktif');
            $table->year('tahun_berdiri')->nullable()->comment('Tahun berdiri');
            $table->string('npsn')->nullable()->comment('Nomor Pokok Sekolah Nasional');
            $table->string('akreditasi')->nullable()->comment('Status akreditasi');
            $table->string('kepala_sekolah')->nullable()->comment('Nama kepala sekolah');
            $table->string('wakil_kepala_sekolah')->nullable()->comment('Nama wakil kepala sekolah');
            $table->timestamps();

            $table->index(['nama_sekolah', 'status']);
            $table->index('jenis_sekolah');
            $table->index('multi_jenjang');
            $table->index('npsn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('backend')->dropIfExists('profil_sekolah');
    }
};
