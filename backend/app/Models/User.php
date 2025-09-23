<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'last_login_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === 'aktif';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is teacher
     */
    public function isTeacher(): bool
    {
        return $this->role === 'guru';
    }

    /**
     * Check if user is student
     */
    public function isStudent(): bool
    {
        return $this->role === 'siswa';
    }

    /**
     * Get user role display name
     */
    public function getRoleDisplayNameAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'guru' => 'Guru',
            'siswa' => 'Siswa',
            default => 'Unknown'
        };
    }

    /**
     * Get user status display name
     */
    public function getStatusDisplayNameAttribute(): string
    {
        return match($this->status) {
            'aktif' => 'Aktif',
            'nonaktif' => 'Nonaktif',
            default => 'Unknown'
        };
    }

    /**
     * Update last login time
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope for specific role
     */
    public function scopeWithRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope for admins
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope for teachers
     */
    public function scopeTeachers($query)
    {
        return $query->where('role', 'guru');
    }

    /**
     * Scope for students
     */
    public function scopeStudents($query)
    {
        return $query->where('role', 'siswa');
    }

    /**
     * Get user statistics
     */
    public function getStatistics(): array
    {
        return [
            'is_active' => $this->isActive(),
            'role' => $this->role,
            'role_display' => $this->role_display_name,
            'status' => $this->status,
            'status_display' => $this->status_display_name,
            'last_login' => $this->last_login_at,
            'days_since_last_login' => $this->last_login_at ? $this->last_login_at->diffInDays(now()) : null
        ];
    }
}