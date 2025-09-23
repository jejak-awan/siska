<?php

namespace App\Jenjang\SD\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiswaSD extends Model
{
    protected $connection = 'sd';
    protected $table = 'siswa_sd';

    protected $fillable = [
        'id_user',
        'nis',
        'nisn',
        'nama',
        'kelas',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'telepon',
        'nama_orang_tua',
        'telepon_orang_tua',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserSD::class, 'id_user');
    }

    public function presensi(): HasMany
    {
        return $this->hasMany(PresensiSD::class, 'id_siswa');
    }

    public function kreditPoin(): HasMany
    {
        return $this->hasMany(KreditPoinSD::class, 'id_siswa');
    }

    public function penilaianKarakter(): HasMany
    {
        return $this->hasMany(PenilaianKarakterSD::class, 'id_siswa');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }

    public function scopeByJenisKelamin($query, $jenisKelamin)
    {
        return $query->where('jenis_kelamin', $jenisKelamin);
    }

    // Accessors & Mutators
    public function getJenisKelaminTextAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getUmurAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }
}
