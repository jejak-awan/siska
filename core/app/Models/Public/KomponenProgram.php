<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk komponen program
 * 
 * @package App\Models\Public
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class KomponenProgram extends Model
{
    use HasFactory;

    protected $connection = 'public';
    protected $table = 'komponen_program';

    protected $fillable = [
        'program_id',
        'nama',
        'deskripsi',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_required',
        'is_completed',
        'persentase_penyelesaian',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_required' => 'boolean',
        'is_completed' => 'boolean',
    ];

    /**
     * Scope untuk komponen yang sudah selesai
     */
    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    /**
     * Scope untuk komponen yang wajib
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    /**
     * Scope untuk komponen berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk komponen yang sedang berjalan
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope untuk komponen yang pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Get durasi komponen dalam hari
     */
    public function getDurationAttribute()
    {
        if ($this->tanggal_mulai && $this->tanggal_selesai) {
            return $this->tanggal_mulai->diffInDays($this->tanggal_selesai);
        }
        return 0;
    }

    /**
     * Cek apakah komponen sedang berjalan
     */
    public function isOngoing()
    {
        return $this->status === 'in_progress' && 
               $this->tanggal_mulai <= now() && 
               $this->tanggal_selesai >= now();
    }

    /**
     * Cek apakah komponen sudah selesai
     */
    public function isCompleted()
    {
        return $this->is_completed || $this->status === 'completed';
    }

    /**
     * Cek apakah komponen belum dimulai
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Mark komponen sebagai selesai
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'is_completed' => true,
            'persentase_penyelesaian' => 100,
        ]);

        // Update program completion status
        $this->program->updateCompletionStatus();
    }

    /**
     * Mark komponen sebagai dibatalkan
     */
    public function markAsCancelled()
    {
        $this->update([
            'status' => 'cancelled',
            'is_completed' => false,
        ]);

        // Update program completion status
        $this->program->updateCompletionStatus();
    }

    /**
     * Update progress komponen
     */
    public function updateProgress($percentage)
    {
        $this->update([
            'persentase_penyelesaian' => min(100, max(0, $percentage)),
            'is_completed' => $percentage >= 100,
            'status' => $percentage >= 100 ? 'completed' : 'in_progress',
        ]);

        // Update program completion status
        $this->program->updateCompletionStatus();
    }

    /**
     * Relasi ke Program
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}
