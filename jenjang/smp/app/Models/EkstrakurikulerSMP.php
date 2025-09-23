<?php

namespace App\Jenjang\SMP\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EkstrakurikulerSMP extends Model
{
    use HasFactory;

    protected $connection = 'smp';
    protected $table = 'ekstrakurikuler_smp';

    protected $fillable = [
        'nama_ekstrakurikuler',
        'deskripsi',
        'pembina',
        'jadwal',
        'lokasi',
        'kuota_maksimal',
        'status',
        'logo',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'kuota_maksimal' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the students participating in this ekstrakurikuler
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(EkstrakurikulerSiswaSMP::class, 'ekstrakurikuler_id');
    }

    /**
     * Scope for active ekstrakurikuler
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope for ekstrakurikuler by status
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
            'ditutup' => 'Ditutup',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Check if ekstrakurikuler is active
     */
    public function isActive(): bool
    {
        return $this->status === 'aktif';
    }

    /**
     * Get total participants count
     */
    public function getTotalPesertaAttribute(): int
    {
        return $this->siswa()->where('status', 'aktif')->count();
    }

    /**
     * Check if ekstrakurikuler is full
     */
    public function isFull(): bool
    {
        return $this->total_peserta >= $this->kuota_maksimal;
    }

    /**
     * Get available slots
     */
    public function getSisaKuotaAttribute(): int
    {
        return max(0, $this->kuota_maksimal - $this->total_peserta);
    }

    /**
     * Get participation rate
     */
    public function getTingkatPartisipasiAttribute(): float
    {
        return $this->kuota_maksimal > 0 ? round(($this->total_peserta / $this->kuota_maksimal) * 100, 2) : 0;
    }
}

