<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Model User untuk SISKA Core System
 * 
 * @package App\Models
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'core';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role_type',
        'status',
        'last_login_at',
        'profile_data',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'profile_data' => 'array',
        'password' => 'hashed',
    ];

    /**
     * Scope untuk user aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk user berdasarkan role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role_type', $role);
    }

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role_type === 'admin';
    }

    /**
     * Cek apakah user adalah guru
     */
    public function isGuru()
    {
        return $this->role_type === 'guru';
    }

    /**
     * Cek apakah user adalah siswa
     */
    public function isSiswa()
    {
        return $this->role_type === 'siswa';
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin()
    {
        $this->update(['last_login_at' => now()]);
    }
}
