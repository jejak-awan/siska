<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk kredit poin SMP
 * 
 * @package App\Models
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class KreditPoin extends Model
{
    use HasFactory;

    protected $connection = 'sd';
    protected $table = 'kredit_poin_sd';

    protected $fillable = [
        'siswa_id',
        'kategori',
        'aspek',
        'poin',
        'deskripsi',
        'tanggal',
        'created_by',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'poin' => 'integer',
    ];

    /**
     * Scope untuk kredit poin berdasarkan kategori
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope untuk kredit poin berdasarkan aspek
     */
    public function scopeByAspek($query, $aspek)
    {
        return $query->where('aspek', $aspek);
    }

    /**
     * Scope untuk kredit poin berdasarkan siswa
     */
    public function scopeBySiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    /**
     * Scope untuk kredit poin positif
     */
    public function scopePositive($query)
    {
        return $query->where('poin', '>', 0);
    }

    /**
     * Scope untuk kredit poin negatif
     */
    public function scopeNegative($query)
    {
        return $query->where('poin', '<', 0);
    }

    /**
     * Scope untuk kredit poin dalam rentang tanggal
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }

    /**
     * Scope untuk kredit poin bulan ini
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year);
    }

    /**
     * Get kategori description
     */
    public function getKategoriDescriptionAttribute()
    {
        $descriptions = [
            'disiplin' => 'Disiplin',
            'kerapihan' => 'Kerapihan',
            'kerjasama' => 'Kerjasama',
            'tanggung_jawab' => 'Tanggung Jawab',
            'kepemimpinan' => 'Kepemimpinan',
            'kreativitas' => 'Kreativitas',
        ];

        return $descriptions[$this->kategori] ?? $this->kategori;
    }

    /**
     * Get aspek description
     */
    public function getAspekDescriptionAttribute()
    {
        $descriptions = [
            'jujur' => 'Jujur',
            'disiplin' => 'Disiplin',
            'tanggung_jawab' => 'Tanggung Jawab',
            'santun' => 'Santun',
            'peduli' => 'Peduli',
            'percaya_diri' => 'Percaya Diri',
        ];

        return $descriptions[$this->aspek] ?? $this->aspek;
    }

    /**
     * Get poin description
     */
    public function getPoinDescriptionAttribute()
    {
        if ($this->poin > 0) {
            return "+{$this->poin}";
        }
        
        return (string) $this->poin;
    }

    /**
     * Get poin color class
     */
    public function getPoinColorClassAttribute()
    {
        if ($this->poin > 0) {
            return 'text-green-600';
        } elseif ($this->poin < 0) {
            return 'text-red-600';
        }
        
        return 'text-gray-600';
    }

    /**
     * Cek apakah poin positif
     */
    public function isPositive()
    {
        return $this->poin > 0;
    }

    /**
     * Cek apakah poin negatif
     */
    public function isNegative()
    {
        return $this->poin < 0;
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
