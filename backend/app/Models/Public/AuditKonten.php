<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk audit konten
 * 
 * @package App\Models\Public
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class AuditKonten extends Model
{
    use HasFactory;

    protected $connection = 'public';
    protected $table = 'audit_konten';

    protected $fillable = [
        'model_type',
        'model_id',
        'event',
        'user_id',
        'old_values',
        'new_values',
        'catatan',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * Scope untuk audit berdasarkan event
     */
    public function scopeByEvent($query, $event)
    {
        return $query->where('event', $event);
    }

    /**
     * Scope untuk audit berdasarkan user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk audit berdasarkan model
     */
    public function scopeByModel($query, $modelType, $modelId = null)
    {
        $query = $query->where('model_type', $modelType);
        
        if ($modelId) {
            $query->where('model_id', $modelId);
        }
        
        return $query;
    }

    /**
     * Scope untuk audit dalam rentang waktu
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Relasi polymorphic ke model yang diaudit
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * Get formatted old values
     */
    public function getFormattedOldValuesAttribute()
    {
        if (!$this->old_values) {
            return 'Tidak ada data lama';
        }

        return json_encode($this->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Get formatted new values
     */
    public function getFormattedNewValuesAttribute()
    {
        if (!$this->new_values) {
            return 'Tidak ada data baru';
        }

        return json_encode($this->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Get event description
     */
    public function getEventDescriptionAttribute()
    {
        $descriptions = [
            'created' => 'Dibuat',
            'updated' => 'Diperbarui',
            'deleted' => 'Dihapus',
            'reviewed' => 'Direview',
            'published' => 'Dipublikasi',
        ];

        return $descriptions[$this->event] ?? $this->event;
    }

    /**
     * Get user name
     */
    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : 'System';
    }

    /**
     * Get model name
     */
    public function getModelNameAttribute()
    {
        $modelNames = [
            'App\\Models\\Public\\PostinganUmum' => 'Postingan Umum',
            'App\\Models\\Public\\Program' => 'Program',
            'App\\Models\\Public\\KegiatanPublik' => 'Kegiatan Publik',
            'App\\Models\\Public\\KomponenProgram' => 'Komponen Program',
        ];

        return $modelNames[$this->model_type] ?? class_basename($this->model_type);
    }
}
