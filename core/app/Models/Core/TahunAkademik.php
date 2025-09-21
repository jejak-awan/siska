<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk tahun akademik
 * 
 * @package App\Models\Core
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class TahunAkademik extends Model
{
    use HasFactory;

    protected $connection = 'core';
    protected $table = 'tahun_akademik';

    protected $fillable = [
        'school_id',
        'tahun_akademik',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'is_active',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Scope untuk tahun akademik aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk tahun akademik berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk tahun akademik yang sedang berjalan
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_active', true)
                    ->where('tanggal_mulai', '<=', now())
                    ->where('tanggal_selesai', '>=', now());
    }

    /**
     * Cek apakah tahun akademik sedang berjalan
     */
    public function isCurrent()
    {
        return $this->is_active && 
               $this->tanggal_mulai <= now() && 
               $this->tanggal_selesai >= now();
    }

    /**
     * Cek apakah tahun akademik sudah selesai
     */
    public function isCompleted()
    {
        return $this->tanggal_selesai < now();
    }

    /**
     * Cek apakah tahun akademik belum dimulai
     */
    public function isUpcoming()
    {
        return $this->tanggal_mulai > now();
    }

    /**
     * Get durasi tahun akademik dalam hari
     */
    public function getDurationAttribute()
    {
        return $this->tanggal_mulai->diffInDays($this->tanggal_selesai);
    }

    /**
     * Get progress tahun akademik dalam persen
     */
    public function getProgressAttribute()
    {
        if ($this->isUpcoming()) {
            return 0;
        }
        
        if ($this->isCompleted()) {
            return 100;
        }

        $totalDays = $this->getDurationAttribute();
        $passedDays = $this->tanggal_mulai->diffInDays(now());
        
        return min(100, round(($passedDays / $totalDays) * 100, 2));
    }

    /**
     * Relasi ke School Profile
     */
    public function school()
    {
        return $this->belongsTo(SchoolProfile::class, 'school_id');
    }

    /**
     * Relasi ke Semester
     */
    public function semester()
    {
        return $this->hasMany(Semester::class, 'tahun_akademik_id');
    }
}
