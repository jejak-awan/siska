<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk presensi SMP
 * 
 * @package App\Models
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class Presensi extends Model
{
    use HasFactory;

    protected $connection = 'sd';
    protected $table = 'presensi_sd';

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan',
        'latitude',
        'longitude',
        'qr_code',
        'foto',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_keluar' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Scope untuk presensi berdasarkan tanggal
     */
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('tanggal', $date);
    }

    /**
     * Scope untuk presensi berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk presensi berdasarkan siswa
     */
    public function scopeBySiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    /**
     * Scope untuk presensi dalam rentang tanggal
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }

    /**
     * Scope untuk presensi bulan ini
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year);
    }

    /**
     * Get durasi kehadiran dalam menit
     */
    public function getDurasiKehadiranAttribute()
    {
        if ($this->jam_masuk && $this->jam_keluar) {
            return $this->jam_masuk->diffInMinutes($this->jam_keluar);
        }
        return 0;
    }

    /**
     * Get status description
     */
    public function getStatusDescriptionAttribute()
    {
        $descriptions = [
            'hadir' => 'Hadir',
            'terlambat' => 'Terlambat',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpa' => 'Alpa',
        ];

        return $descriptions[$this->status] ?? $this->status;
    }

    /**
     * Cek apakah terlambat
     */
    public function isLate()
    {
        if (!$this->jam_masuk) {
            return false;
        }

        // Jam masuk normal adalah 07:00
        $jamNormal = $this->tanggal->setTime(7, 0, 0);
        
        return $this->jam_masuk > $jamNormal;
    }

    /**
     * Get keterangan terlambat
     */
    public function getKeteranganTerlambatAttribute()
    {
        if ($this->isLate()) {
            $jamNormal = $this->tanggal->setTime(7, 0, 0);
            $menitTerlambat = $jamNormal->diffInMinutes($this->jam_masuk);
            
            return "Terlambat {$menitTerlambat} menit";
        }
        
        return null;
    }

    /**
     * Relasi ke Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Relasi ke User (created_by)
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
