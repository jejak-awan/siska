<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk penilaian karakter SMK
 * 
 * @package App\Models
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class PenilaianKarakter extends Model
{
    use HasFactory;

    protected $connection = 'sd';
    protected $table = 'penilaian_karakter_sd';

    protected $fillable = [
        'siswa_id',
        'aspek_karakter',
        'nilai',
        'deskripsi',
        'tanggal_penilaian',
        'semester_id',
        'tahun_akademik_id',
        'created_by',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_penilaian' => 'date',
        'nilai' => 'integer',
    ];

    /**
     * Scope untuk penilaian berdasarkan aspek
     */
    public function scopeByAspek($query, $aspek)
    {
        return $query->where('aspek_karakter', $aspek);
    }

    /**
     * Scope untuk penilaian berdasarkan siswa
     */
    public function scopeBySiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    /**
     * Scope untuk penilaian berdasarkan semester
     */
    public function scopeBySemester($query, $semesterId)
    {
        return $query->where('semester_id', $semesterId);
    }

    /**
     * Scope untuk penilaian berdasarkan tahun akademik
     */
    public function scopeByTahunAkademik($query, $tahunAkademikId)
    {
        return $query->where('tahun_akademik_id', $tahunAkademikId);
    }

    /**
     * Scope untuk penilaian dalam rentang tanggal
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_penilaian', [$startDate, $endDate]);
    }

    /**
     * Get aspek description
     */
    public function getAspekDescriptionAttribute()
    {
        $descriptions = [
            'jujur' => 'Jujur',
            'disiplin' => 'Disiplin',
            'tanggung_jawab' => 'Tanggung Jawab',
            'santun' => 'Santun',
            'peduli' => 'Peduli',
            'percaya_diri' => 'Percaya Diri',
        ];

        return $descriptions[$this->aspek_karakter] ?? $this->aspek_karakter;
    }

    /**
     * Get nilai description
     */
    public function getNilaiDescriptionAttribute()
    {
        $descriptions = [
            4 => 'Sangat Baik',
            3 => 'Baik',
            2 => 'Cukup',
            1 => 'Kurang',
        ];

        return $descriptions[$this->nilai] ?? 'Tidak Diketahui';
    }

    /**
     * Get nilai color class
     */
    public function getNilaiColorClassAttribute()
    {
        $colors = [
            4 => 'text-green-600',
            3 => 'text-blue-600',
            2 => 'text-yellow-600',
            1 => 'text-red-600',
        ];

        return $colors[$this->nilai] ?? 'text-gray-600';
    }

    /**
     * Get nilai background color class
     */
    public function getNilaiBgColorClassAttribute()
    {
        $colors = [
            4 => 'bg-green-100',
            3 => 'bg-blue-100',
            2 => 'bg-yellow-100',
            1 => 'bg-red-100',
        ];

        return $colors[$this->nilai] ?? 'bg-gray-100';
    }

    /**
     * Cek apakah nilai baik
     */
    public function isGood()
    {
        return $this->nilai >= 3;
    }

    /**
     * Cek apakah nilai sangat baik
     */
    public function isVeryGood()
    {
        return $this->nilai == 4;
    }

    /**
     * Cek apakah nilai kurang
     */
    public function isPoor()
    {
        return $this->nilai <= 2;
    }

    /**
     * Relasi ke Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Relasi ke Semester
     */
    public function semester()
    {
        return $this->belongsTo(\App\Models\Core\Semester::class, 'semester_id');
    }

    /**
     * Relasi ke Tahun Akademik
     */
    public function tahunAkademik()
    {
        return $this->belongsTo(\App\Models\Core\TahunAkademik::class, 'tahun_akademik_id');
    }

    /**
     * Relasi ke User (created_by)
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
