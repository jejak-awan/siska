<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    use HasFactory;
    
    protected $table = 'tahun_akademik';

    protected $fillable = [
        'sekolah_id',
        'tahun_akademik',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'is_active',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_active' => 'boolean'
    ];

    /**
     * Check if academic year is active
     */
    public function isActive(): bool
    {
        return $this->is_active && $this->status === 'aktif';
    }

    /**
     * Check if academic year is current
     */
    public function isCurrent(): bool
    {
        $now = now();
        return $this->tanggal_mulai <= $now && $this->tanggal_selesai >= $now;
    }

    /**
     * Check if academic year is past
     */
    public function isPast(): bool
    {
        return $this->tanggal_selesai < now();
    }

    /**
     * Check if academic year is future
     */
    public function isFuture(): bool
    {
        return $this->tanggal_mulai > now();
    }

    /**
     * Get academic year display name
     */
    public function getDisplayNameAttribute(): string
    {
        return "{$this->tahun_akademik} - Semester {$this->semester}";
    }

    /**
     * Get academic year status
     */
    public function getStatusAttribute($value): string
    {
        if ($this->isPast()) {
            return 'selesai';
        }
        
        if ($this->isFuture()) {
            return 'akan_datang';
        }
        
        if ($this->isCurrent()) {
            return 'berjalan';
        }
        
        return $value;
    }

    /**
     * Get days until start
     */
    public function getDaysUntilStartAttribute(): int
    {
        return $this->tanggal_mulai->diffInDays(now());
    }

    /**
     * Get days until end
     */
    public function getDaysUntilEndAttribute(): int
    {
        return $this->tanggal_selesai->diffInDays(now());
    }

    /**
     * Get progress percentage
     */
    public function getProgressPercentageAttribute(): float
    {
        if ($this->isPast()) {
            return 100.0;
        }
        
        if ($this->isFuture()) {
            return 0.0;
        }
        
        $totalDays = $this->tanggal_mulai->diffInDays($this->tanggal_selesai);
        $passedDays = $this->tanggal_mulai->diffInDays(now());
        
        return $totalDays > 0 ? round(($passedDays / $totalDays) * 100, 2) : 0;
    }

    /**
     * Activate academic year
     */
    public function activate(): bool
    {
        // Deactivate all other academic years
        static::where('id', '!=', $this->id)->update(['is_active' => false]);
        
        $this->update([
            'is_active' => true,
            'status' => 'aktif'
        ]);
        
        return true;
    }

    /**
     * Deactivate academic year
     */
    public function deactivate(): bool
    {
        $this->update([
            'is_active' => false,
            'status' => 'nonaktif'
        ]);
        
        return true;
    }

    /**
     * Scope for active academic years
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for current academic years
     */
    public function scopeCurrent($query)
    {
        $now = now();
        return $query->where('tanggal_mulai', '<=', $now)
                    ->where('tanggal_selesai', '>=', $now);
    }

    /**
     * Scope for past academic years
     */
    public function scopePast($query)
    {
        return $query->where('tanggal_selesai', '<', now());
    }

    /**
     * Scope for future academic years
     */
    public function scopeFuture($query)
    {
        return $query->where('tanggal_mulai', '>', now());
    }

    /**
     * Scope for specific year
     */
    public function scopeForYear($query, string $tahun)
    {
        return $query->where('tahun_akademik', $tahun);
    }

    /**
     * Scope for specific semester
     */
    public function scopeForSemester($query, int $semester)
    {
        return $query->where('semester', $semester);
    }

    /**
     * Get academic year statistics
     */
    public function getStatistics(): array
    {
        return [
            'is_active' => $this->is_active,
            'is_current' => $this->isCurrent(),
            'is_past' => $this->isPast(),
            'is_future' => $this->isFuture(),
            'progress_percentage' => $this->progress_percentage,
            'days_until_start' => $this->days_until_start,
            'days_until_end' => $this->days_until_end,
            'total_days' => $this->tanggal_mulai->diffInDays($this->tanggal_selesai)
        ];
    }
}
