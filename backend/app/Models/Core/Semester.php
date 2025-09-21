<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk semester
 * 
 * @package App\Models\Core
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class Semester extends Model
{
    use HasFactory;

    protected $connection = 'core';
    protected $table = 'semester';

    protected $fillable = [
        'tahun_akademik_id',
        'nama_semester',
        'semester_ke',
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
     * Scope untuk semester aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk semester berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk semester yang sedang berjalan
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_active', true)
                    ->where('tanggal_mulai', '<=', now())
                    ->where('tanggal_selesai', '>=', now());
    }

    /**
     * Scope untuk semester berdasarkan nomor
     */
    public function scopeByNumber($query, $number)
    {
        return $query->where('semester_ke', $number);
    }

    /**
     * Cek apakah semester sedang berjalan
     */
    public function isCurrent()
    {
        return $this->is_active && 
               $this->tanggal_mulai <= now() && 
               $this->tanggal_selesai >= now();
    }

    /**
     * Cek apakah semester sudah selesai
     */
    public function isCompleted()
    {
        return $this->tanggal_selesai < now();
    }

    /**
     * Cek apakah semester belum dimulai
     */
    public function isUpcoming()
    {
        return $this->tanggal_mulai > now();
    }

    /**
     * Get durasi semester dalam hari
     */
    public function getDurationAttribute()
    {
        return $this->tanggal_mulai->diffInDays($this->tanggal_selesai);
    }

    /**
     * Get progress semester dalam persen
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
     * Get nama semester lengkap
     */
    public function getFullNameAttribute()
    {
        return $this->tahunAkademik->tahun_akademik . ' - ' . $this->nama_semester;
    }

    /**
     * Relasi ke Tahun Akademik
     */
    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }
}
