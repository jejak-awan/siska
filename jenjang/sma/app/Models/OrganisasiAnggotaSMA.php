<?php

namespace App\Jenjang\SMA\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganisasiAnggotaSMA extends Model
{
    use HasFactory;

    protected $connection = 'sma';
    protected $table = 'organisasi_anggota_sma';

    protected $fillable = [
        'organisasi_id',
        'siswa_id',
        'jabatan',
        'tanggal_bergabung',
        'tanggal_keluar',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
        'tanggal_keluar' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the organization that owns the member
     */
    public function organisasi(): BelongsTo
    {
        return $this->belongsTo(OrganisasiSMA::class, 'organisasi_id');
    }

    /**
     * Get the student that owns the membership
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(SiswaSMA::class, 'siswa_id');
    }

    /**
     * Scope for active members
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope for members by position
     */
    public function scopeByJabatan($query, $jabatan)
    {
        return $query->where('jabatan', $jabatan);
    }

    /**
     * Get status in Indonesian
     */
    public function getStatusIndonesiaAttribute(): string
    {
        return match($this->status) {
            'aktif' => 'Aktif',
            'keluar' => 'Keluar',
            'diberhentikan' => 'Diberhentikan',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get position in Indonesian
     */
    public function getJabatanIndonesiaAttribute(): string
    {
        return match($this->jabatan) {
            'ketua' => 'Ketua',
            'wakil_ketua' => 'Wakil Ketua',
            'sekretaris' => 'Sekretaris',
            'bendahara' => 'Bendahara',
            'anggota' => 'Anggota',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Check if member is active
     */
    public function isActive(): bool
    {
        return $this->status === 'aktif';
    }

    /**
     * Check if member is leader
     */
    public function isLeader(): bool
    {
        return in_array($this->jabatan, ['ketua', 'wakil_ketua']);
    }
}
