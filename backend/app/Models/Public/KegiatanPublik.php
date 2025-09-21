<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk kegiatan publik
 * 
 * @package App\Models\Public
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class KegiatanPublik extends Model
{
    use HasFactory;

    protected $connection = 'public';
    protected $table = 'kegiatan_publik';

    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'tempat',
        'penanggung_jawab',
        'target_peserta',
        'status',
        'gambar_utama',
        'galeri_gambar',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'target_peserta' => 'array',
        'galeri_gambar' => 'array',
    ];

    /**
     * Scope untuk kegiatan yang akan datang
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming')
                    ->where('tanggal_mulai', '>=', now());
    }

    /**
     * Scope untuk kegiatan yang sedang berjalan
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing')
                    ->where('tanggal_mulai', '<=', now())
                    ->where('tanggal_selesai', '>=', now());
    }

    /**
     * Scope untuk kegiatan yang sudah selesai
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed')
                    ->where('tanggal_selesai', '<', now());
    }

    /**
     * Scope untuk kegiatan berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get durasi kegiatan dalam hari
     */
    public function getDurationAttribute()
    {
        return $this->tanggal_mulai->diffInDays($this->tanggal_selesai);
    }

    /**
     * Cek apakah kegiatan sedang berjalan
     */
    public function isOngoing()
    {
        return $this->status === 'ongoing' && 
               $this->tanggal_mulai <= now() && 
               $this->tanggal_selesai >= now();
    }

    /**
     * Cek apakah kegiatan sudah selesai
     */
    public function isCompleted()
    {
        return $this->status === 'completed' || $this->tanggal_selesai < now();
    }

    /**
     * Cek apakah kegiatan belum dimulai
     */
    public function isUpcoming()
    {
        return $this->status === 'upcoming' && $this->tanggal_mulai > now();
    }

    /**
     * Get gambar utama URL
     */
    public function getGambarUtamaUrlAttribute()
    {
        if ($this->gambar_utama) {
            return asset('storage/' . $this->gambar_utama);
        }
        return asset('images/default-activity.jpg');
    }

    /**
     * Get galeri gambar URLs
     */
    public function getGaleriGambarUrlsAttribute()
    {
        if (!$this->galeri_gambar) {
            return [];
        }

        return array_map(function($file) {
            return asset('storage/' . $file);
        }, $this->galeri_gambar);
    }

    /**
     * Get formatted target peserta
     */
    public function getFormattedTargetPesertaAttribute()
    {
        return $this->target_peserta ? implode(', ', $this->target_peserta) : '';
    }
}
