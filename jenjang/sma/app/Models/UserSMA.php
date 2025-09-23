<?php

namespace App\Jenjang\SMA\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserSMA extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'sma';
    protected $table = 'users_sma';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
    ];

    /**
     * Get the student profile for this user
     */
    public function siswa(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(SiswaSMA::class, 'user_id');
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
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === 'aktif';
    }
}
