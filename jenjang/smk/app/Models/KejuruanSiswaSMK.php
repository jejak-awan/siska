<?php

namespace App\Jenjang\SMK\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KejuruanSiswaSMK extends Model
{
    use HasFactory;

    protected $connection = 'smk';
    protected $table = 'kejuruan_siswa_smk';

    protected $fillable = [
        'kejuruan_id',
        'siswa_id',
        'tanggal_daftar',
        'tanggal_keluar',
        'status',
        'nilai',
        'sertifikat',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'tanggal_keluar' => 'date',
        'nilai' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the kejuruan that owns the participation
     */
    public function kejuruan(): BelongsTo
    {
        return $this->belongsTo(KejuruanSMK::class, 'kejuruan_id');
    }

    /**
     * Get the student that owns the participation
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(SiswaSMK::class, 'siswa_id');
    }

    /**
     * Scope for active participations
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope for participations by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for participations by kejuruan
     */
    public function scopeByKejuruan($query, $kejuruanId)
    {
        return $query->where('kejuruan_id', $kejuruanId);
    }

    /**
     * Get status in Indonesian
     */
    public function getStatusIndonesiaAttribute(): string
    {
        return match($this->status) {
            'aktif' => 'Aktif',
            'selesai' => 'Selesai',
            'keluar' => 'Keluar',
            'diberhentikan' => 'Diberhentikan',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Check if participation is active
     */
    public function isActive(): bool
    {
        return $this->status === 'aktif';
    }

    /**
     * Check if participation is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'selesai';
    }

    /**
     * Check if participant has certificate
     */
    public function hasCertificate(): bool
    {
        return !empty($this->sertifikat);
    }

    /**
     * Get grade based on score
     */
    public function getGradeAttribute(): string
    {
        if ($this->nilai >= 90) return 'A';
        if ($this->nilai >= 80) return 'B';
        if ($this->nilai >= 70) return 'C';
        if ($this->nilai >= 60) return 'D';
        return 'E';
    }

    /**
     * Get participation duration in days
     */
    public function getDurasiHariAttribute(): int
    {
        if ($this->tanggal_daftar) {
            $endDate = $this->tanggal_keluar ?? now();
            return $this->tanggal_daftar->diffInDays($endDate);
        }
        return 0;
    }
}

