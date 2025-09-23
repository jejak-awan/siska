<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'npsn',
        'nama_sekolah',
        'jenjang',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'kode_pos',
        'nomor_telepon',
        'email',
        'website',
        'logo_url',
        'jenjang_aktif',
        'tahun_berdiri',
        'status_sekolah',
        'akreditasi',
        'kepala_sekolah',
        'nip_kepala_sekolah',
        'bendahara',
        'nip_bendahara',
        'operator',
        'nip_operator',
        'latitude',
        'longitude',
        'is_active'
    ];

    protected $casts = [
        'jenjang_aktif' => 'array',
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'tahun_berdiri' => 'integer'
    ];

    /**
     * Check if school is active
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Check if school has specific jenjang
     */
    public function hasJenjang(string $jenjang): bool
    {
        return in_array($jenjang, $this->jenjang_aktif ?? []);
    }

    /**
     * Get active jenjang
     */
    public function getActiveJenjangAttribute(): array
    {
        return $this->jenjang_aktif ?? [];
    }

    /**
     * Get school full address
     */
    public function getFullAddressAttribute(): string
    {
        return implode(', ', array_filter([
            $this->alamat,
            $this->kelurahan,
            $this->kecamatan,
            $this->kabupaten_kota,
            $this->provinsi,
            $this->kode_pos
        ]));
    }

    /**
     * Get school coordinates
     */
    public function getCoordinatesAttribute(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];
    }

    /**
     * Scope for active schools
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for specific jenjang
     */
    public function scopeWithJenjang($query, string $jenjang)
    {
        return $query->whereJsonContains('jenjang_aktif', $jenjang);
    }

    /**
     * Scope for specific province
     */
    public function scopeInProvince($query, string $provinsi)
    {
        return $query->where('provinsi', $provinsi);
    }

    /**
     * Scope for specific city
     */
    public function scopeInCity($query, string $kabupaten_kota)
    {
        return $query->where('kabupaten_kota', $kabupaten_kota);
    }

    /**
     * Get school statistics
     */
    public function getStatistics(): array
    {
        return [
            'total_jenjang' => count($this->jenjang_aktif ?? []),
            'jenjang_list' => $this->jenjang_aktif ?? [],
            'is_active' => $this->is_active,
            'has_coordinates' => !is_null($this->latitude) && !is_null($this->longitude),
            'has_website' => !is_null($this->website),
            'has_logo' => !is_null($this->logo_url)
        ];
    }
}
