<?php

namespace App\Jenjang\SMA\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresensiSMA extends Model
{
    use HasFactory;

    protected $connection = 'sma';
    protected $table = 'presensi_sma';

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'status',
        'keterangan',
        'jam_masuk',
        'jam_keluar',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_keluar' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the student that owns the presensi
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(SiswaSMA::class, 'siswa_id');
    }

    /**
     * Scope for presensi by date range
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }

    /**
     * Scope for presensi by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for presensi by student
     */
    public function scopeByStudent($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    /**
     * Get status in Indonesian
     */
    public function getStatusIndonesiaAttribute(): string
    {
        return match($this->status) {
            'hadir' => 'Hadir',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpha' => 'Alpha',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Check if student is present
     */
    public function isPresent(): bool
    {
        return $this->status === 'hadir';
    }

    /**
     * Check if student is absent
     */
    public function isAbsent(): bool
    {
        return in_array($this->status, ['izin', 'sakit', 'alpha']);
    }
}
