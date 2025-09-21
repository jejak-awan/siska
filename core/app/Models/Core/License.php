<?php

namespace App\Models\Core;

use App\Models\BaseModel;

/**
 * Model untuk manajemen lisensi SISKA
 * 
 * @package App\Models\Core
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class License extends BaseModel
{

    protected $connection = 'core';
    protected $table = 'license_management';

    protected $fillable = [
        'license_key',
        'installation_id',
        'sekolah_id',
        'license_type',
        'jenjang_access',
        'features',
        'max_users',
        'expires_at',
        'is_active',
        'activated_at',
        'last_check',
    ];

    protected $casts = [
        'jenjang_access' => 'array',
        'features' => 'array',
        'expires_at' => 'datetime',
        'activated_at' => 'datetime',
        'last_check' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Scope untuk lisensi aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('expires_at', '>', now());
    }

    /**
     * Scope untuk lisensi berdasarkan jenis
     */
    public function scopeByType($query, $type)
    {
        return $query->where('license_type', $type);
    }

    /**
     * Cek apakah lisensi memiliki akses ke jenjang tertentu
     */
    public function hasJenjangAccess($jenjang)
    {
        return in_array($jenjang, $this->jenjang_access ?? []);
    }

    /**
     * Cek apakah lisensi memiliki fitur tertentu
     */
    public function hasFeature($feature)
    {
        return in_array($feature, $this->features ?? []);
    }

    /**
     * Cek apakah lisensi masih berlaku
     */
    public function isValid()
    {
        return $this->is_active && $this->expires_at > now();
    }

    /**
     * Update last check timestamp
     */
    public function updateLastCheck()
    {
        $this->update(['last_check' => now()]);
    }

    /**
     * Relasi ke Profil Sekolah
     */
    public function sekolah()
    {
        return $this->belongsTo(ProfilSekolah::class, 'sekolah_id');
    }
}
