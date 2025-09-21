<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk profil sekolah
 * 
 * @package App\Models\Core
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class SchoolProfile extends Model
{
    use HasFactory;

    protected $connection = 'core';
    protected $table = 'school_profile';

    protected $fillable = [
        'nama_sekolah',
        'jenis_sekolah',
        'jenjang_aktif',
        'multi_jenjang',
        'alamat',
        'telepon',
        'email',
        'website',
        'logo',
        'struktur_organisasi',
        'sejarah',
        'visi',
        'misi',
        'tujuan',
        'status',
        'tahun_berdiri',
        'npsn',
        'akreditasi',
        'kepala_sekolah',
        'wakil_kepala_sekolah',
    ];

    protected $casts = [
        'multi_jenjang' => 'boolean',
        'struktur_organisasi' => 'array',
        'jenjang_aktif' => 'array',
        'status' => 'boolean',
    ];

    /**
     * Scope untuk sekolah aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope untuk sekolah berdasarkan jenis
     */
    public function scopeByType($query, $type)
    {
        return $query->where('jenis_sekolah', $type);
    }

    /**
     * Scope untuk sekolah berdasarkan jenjang
     */
    public function scopeByJenjang($query, $jenjang)
    {
        return $query->whereJsonContains('jenjang_aktif', $jenjang);
    }

    /**
     * Cek apakah sekolah multi jenjang
     */
    public function isMultiJenjang()
    {
        return $this->multi_jenjang;
    }

    /**
     * Cek apakah sekolah memiliki jenjang tertentu
     */
    public function hasJenjang($jenjang)
    {
        return in_array($jenjang, $this->jenjang_aktif ?? []);
    }

    /**
     * Get logo URL
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return asset('images/default-school-logo.png');
    }

    /**
     * Relasi ke License
     */
    public function license()
    {
        return $this->hasOne(License::class, 'school_id');
    }

    /**
     * Relasi ke Tahun Akademik
     */
    public function tahunAkademik()
    {
        return $this->hasMany(TahunAkademik::class, 'school_id');
    }
}
