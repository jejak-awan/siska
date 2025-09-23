<?php

namespace App\Jenjang\SMK\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiswaSMK extends Model
{
    use HasFactory;

    protected $connection = 'smk';
    protected $table = 'siswa_smk';

    protected $fillable = [
        'user_id',
        'nis',
        'nisn',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'agama',
        'alamat',
        'nomor_telepon',
        'email',
        'kelas',
        'jurusan',
        'tahun_masuk',
        'status',
        'nama_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'alamat_ortu',
        'nomor_telepon_ortu',
        'foto',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tahun_masuk' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the user that owns the student
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserSMK::class, 'user_id');
    }

    /**
     * Get the presensi records for the student
     */
    public function presensi(): HasMany
    {
        return $this->hasMany(PresensiSMK::class, 'siswa_id');
    }

    /**
     * Get the kejuruan participations for the student
     */
    public function kejuruan(): HasMany
    {
        return $this->hasMany(KejuruanSiswaSMK::class, 'siswa_id');
    }

    /**
     * Get the program kesiswaan participations for the student
     */
    public function programKesiswaan(): HasMany
    {
        return $this->hasMany(ProgramKesiswaanSMK::class, 'siswa_id');
    }

    /**
     * Scope for active students
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope for students by class
     */
    public function scopeByKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }

    /**
     * Scope for students by jurusan
     */
    public function scopeByJurusan($query, $jurusan)
    {
        return $query->where('jurusan', $jurusan);
    }

    /**
     * Scope for students by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get student's full name with NIS
     */
    public function getNamaLengkapWithNisAttribute(): string
    {
        return "{$this->nama_lengkap} ({$this->nis})";
    }

    /**
     * Get student's age
     */
    public function getUmurAttribute(): int
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : 0;
    }

    /**
     * Get student's status in Indonesian
     */
    public function getStatusIndonesiaAttribute(): string
    {
        return match($this->status) {
            'aktif' => 'Aktif',
            'lulus' => 'Lulus',
            'pindah' => 'Pindah',
            'nonaktif' => 'Nonaktif',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get jurusan display name
     */
    public function getJurusanDisplayAttribute(): string
    {
        return match($this->jurusan) {
            'tkj' => 'Teknik Komputer dan Jaringan',
            'rpl' => 'Rekayasa Perangkat Lunak',
            'mm' => 'Multimedia',
            'ak' => 'Akuntansi',
            'pm' => 'Pemasaran',
            'otkp' => 'Otomatisasi dan Tata Kelola Perkantoran',
            'tkr' => 'Teknik Kendaraan Ringan',
            'tsm' => 'Teknik Sepeda Motor',
            'tbsm' => 'Teknik dan Bisnis Sepeda Motor',
            'tav' => 'Teknik Audio Video',
            'tptu' => 'Teknik Pendingin dan Tata Udara',
            'tpl' => 'Teknik Pemesinan',
            'tpm' => 'Teknik Pengelasan',
            'tkr' => 'Teknik Kendaraan Ringan',
            default => $this->jurusan
        };
    }
}

