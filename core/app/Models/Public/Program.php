<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk program sekolah
 * 
 * @package App\Models\Public
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class Program extends Model
{
    use HasFactory;

    protected $connection = 'public';
    protected $table = 'program';

    protected $fillable = [
        'nama',
        'deskripsi',
        'kategori',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'tujuan',
        'target_audience',
        'peran_penanggung_jawab',
        'id_penanggung_jawab',
        'komponen',
        'status_penyelesaian',
        'persentase_penyelesaian',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tujuan' => 'array',
        'target_audience' => 'array',
        'komponen' => 'array',
        'status_penyelesaian' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Scope untuk program aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk program berdasarkan kategori
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('kategori', $category);
    }

    /**
     * Scope untuk program berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk program berdasarkan penanggung jawab
     */
    public function scopeByResponsible($query, $role, $id)
    {
        return $query->where('peran_penanggung_jawab', $role)
                    ->where('id_penanggung_jawab', $id);
    }

    /**
     * Scope untuk program featured
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope untuk program yang sedang berjalan
     */
    public function scopeOngoing($query)
    {
        return $query->where('tanggal_mulai', '<=', now())
                    ->where('tanggal_selesai', '>=', now());
    }

    /**
     * Scope untuk program yang akan datang
     */
    public function scopeUpcoming($query)
    {
        return $query->where('tanggal_mulai', '>', now());
    }

    /**
     * Scope untuk program yang sudah selesai
     */
    public function scopeCompleted($query)
    {
        return $query->where('tanggal_selesai', '<', now());
    }

    /**
     * Get durasi program dalam hari
     */
    public function getDurationAttribute()
    {
        return $this->tanggal_mulai->diffInDays($this->tanggal_selesai);
    }

    /**
     * Cek apakah program sedang berjalan
     */
    public function getIsActiveAttribute()
    {
        return $this->tanggal_mulai <= now() && $this->tanggal_selesai >= now();
    }

    /**
     * Get formatted objectives
     */
    public function getFormattedObjectivesAttribute()
    {
        return $this->tujuan ? implode(', ', $this->tujuan) : '';
    }

    /**
     * Get formatted target audience
     */
    public function getFormattedTargetAttribute()
    {
        return $this->target_audience ? implode(', ', $this->target_audience) : '';
    }

    /**
     * Update completion status
     */
    public function updateCompletionStatus()
    {
        $totalComponents = count($this->komponen ?? []);
        $completedComponents = count(array_filter($this->status_penyelesaian ?? [], function($status) {
            return $status === 'completed';
        }));

        if ($totalComponents > 0) {
            $this->persentase_penyelesaian = round(($completedComponents / $totalComponents) * 100, 2);
        }

        $this->save();
    }

    /**
     * Cek apakah program bisa diedit oleh user tertentu
     */
    public function canBeEditedBy($role, $id)
    {
        return $this->peran_penanggung_jawab === $role && $this->id_penanggung_jawab === $id;
    }

    /**
     * Relasi ke Komponen Program
     */
    public function komponenProgram()
    {
        return $this->hasMany(KomponenProgram::class, 'program_id');
    }
}
