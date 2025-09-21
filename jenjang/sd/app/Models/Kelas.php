<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk kelas SD
 * 
 * @package App\Models
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class Kelas extends Model
{
    use HasFactory;

    protected $connection = 'sd';
    protected $table = 'kelas_sd';

    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'kapasitas',
        'wali_kelas_id',
        'tahun_akademik_id',
        'semester_id',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'kapasitas' => 'integer',
    ];

    /**
     * Scope untuk kelas aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope untuk kelas berdasarkan tingkat
     */
    public function scopeByTingkat($query, $tingkat)
    {
        return $query->where('tingkat', $tingkat);
    }

    /**
     * Scope untuk kelas berdasarkan tahun akademik
     */
    public function scopeByTahunAkademik($query, $tahunAkademikId)
    {
        return $query->where('tahun_akademik_id', $tahunAkademikId);
    }

    /**
     * Get jumlah siswa
     */
    public function getJumlahSiswaAttribute()
    {
        return $this->siswa()->count();
    }

    /**
     * Get persentase kapasitas
     */
    public function getPersentaseKapasitasAttribute()
    {
        if ($this->kapasitas > 0) {
            return round(($this->getJumlahSiswaAttribute() / $this->kapasitas) * 100, 2);
        }
        return 0;
    }

    /**
     * Cek apakah kelas penuh
     */
    public function isFull()
    {
        return $this->getJumlahSiswaAttribute() >= $this->kapasitas;
    }

    /**
     * Cek apakah kelas kosong
     */
    public function isEmpty()
    {
        return $this->getJumlahSiswaAttribute() == 0;
    }

    /**
     * Relasi ke Siswa
     */
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    /**
     * Relasi ke Guru (Wali Kelas)
     */
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    /**
     * Relasi ke Tahun Akademik
     */
    public function tahunAkademik()
    {
        return $this->belongsTo(\App\Models\Core\TahunAkademik::class, 'tahun_akademik_id');
    }

    /**
     * Relasi ke Semester
     */
    public function semester()
    {
        return $this->belongsTo(\App\Models\Core\Semester::class, 'semester_id');
    }
}
