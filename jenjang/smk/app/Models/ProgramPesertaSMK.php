<?php

namespace App\Jenjang\SMK\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramPesertaSMK extends Model
{
    use HasFactory;

    protected $connection = 'smk';
    protected $table = 'program_peserta_smk';

    protected $fillable = [
        'program_id',
        'siswa_id',
        'tanggal_daftar',
        'status',
        'nilai',
        'sertifikat',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'nilai' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the program that owns the participant
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(ProgramKesiswaanSMK::class, 'program_id');
    }

    /**
     * Get the student that owns the participation
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(SiswaSMK::class, 'siswa_id');
    }

    /**
     * Scope for active participants
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope for participants by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for participants by program
     */
    public function scopeByProgram($query, $programId)
    {
        return $query->where('program_id', $programId);
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
     * Check if participant is active
     */
    public function isActive(): bool
    {
        return $this->status === 'aktif';
    }

    /**
     * Check if participant completed the program
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
}

