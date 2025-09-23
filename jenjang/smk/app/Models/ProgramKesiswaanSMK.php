<?php

namespace App\Jenjang\SMK\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramKesiswaanSMK extends Model
{
    use HasFactory;

    protected $connection = 'smk';
    protected $table = 'program_kesiswaan_smk';

    protected $fillable = [
        'nama_program',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'penanggung_jawab',
        'status',
        'target_peserta',
        'biaya',
        'lokasi',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'biaya' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the participants of this program
     */
    public function peserta(): HasMany
    {
        return $this->hasMany(ProgramPesertaSMK::class, 'program_id');
    }

    /**
     * Scope for active programs
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope for programs by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for programs by date range
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_mulai', [$startDate, $endDate]);
    }

    /**
     * Get status in Indonesian
     */
    public function getStatusIndonesiaAttribute(): string
    {
        return match($this->status) {
            'aktif' => 'Aktif',
            'selesai' => 'Selesai',
            'ditunda' => 'Ditunda',
            'dibatalkan' => 'Dibatalkan',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Check if program is active
     */
    public function isActive(): bool
    {
        return $this->status === 'aktif';
    }

    /**
     * Check if program is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'selesai';
    }

    /**
     * Get total participants count
     */
    public function getTotalPesertaAttribute(): int
    {
        return $this->peserta()->count();
    }

    /**
     * Get program duration in days
     */
    public function getDurasiHariAttribute(): int
    {
        if ($this->tanggal_mulai && $this->tanggal_selesai) {
            return $this->tanggal_mulai->diffInDays($this->tanggal_selesai);
        }
        return 0;
    }

    /**
     * Check if program is ongoing
     */
    public function isOngoing(): bool
    {
        $now = now();
        return $this->tanggal_mulai <= $now && 
               ($this->tanggal_selesai === null || $this->tanggal_selesai >= $now);
    }

    /**
     * Check if program is upcoming
     */
    public function isUpcoming(): bool
    {
        return $this->tanggal_mulai > now();
    }

    /**
     * Check if program is past
     */
    public function isPast(): bool
    {
        return $this->tanggal_selesai && $this->tanggal_selesai < now();
    }
}

