<?php

namespace App\Jenjang\SMA\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganisasiSMA extends Model
{
    use HasFactory;

    protected $connection = 'sma';
    protected $table = 'organisasi_sma';

    protected $fillable = [
        'nama_organisasi',
        'deskripsi',
        'pembina',
        'ketua',
        'wakil_ketua',
        'sekretaris',
        'bendahara',
        'tanggal_berdiri',
        'status',
        'logo',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tanggal_berdiri' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the members of this organization
     */
    public function anggota(): HasMany
    {
        return $this->hasMany(OrganisasiAnggotaSMA::class, 'organisasi_id');
    }

    /**
     * Get the programs of this organization
     */
    public function program(): HasMany
    {
        return $this->hasMany(ProgramKesiswaanSMA::class, 'organisasi_id');
    }

    /**
     * Scope for active organizations
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope for organizations by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get status in Indonesian
     */
    public function getStatusIndonesiaAttribute(): string
    {
        return match($this->status) {
            'aktif' => 'Aktif',
            'nonaktif' => 'Nonaktif',
            'dibubarkan' => 'Dibubarkan',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Check if organization is active
     */
    public function isActive(): bool
    {
        return $this->status === 'aktif';
    }

    /**
     * Get total members count
     */
    public function getTotalAnggotaAttribute(): int
    {
        return $this->anggota()->count();
    }
}
