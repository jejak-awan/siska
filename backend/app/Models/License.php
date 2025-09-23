<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class License extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'license_key',
        'license_type',
        'school_name',
        'school_address',
        'contact_person',
        'contact_email',
        'contact_phone',
        'max_users',
        'max_students',
        'features',
        'expires_at',
        'status',
        'activated_at',
        'deactivated_at',
        'notes'
    ];

    protected $casts = [
        'features' => 'array',
        'expires_at' => 'datetime',
        'activated_at' => 'datetime',
        'deactivated_at' => 'datetime',
        'max_users' => 'integer',
        'max_students' => 'integer'
    ];

    /**
     * Check if license is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && 
               $this->expires_at > now() && 
               $this->activated_at !== null;
    }

    /**
     * Check if license is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at < now();
    }

    /**
     * Check if license has specific feature
     */
    public function hasFeature(string $feature): bool
    {
        return in_array($feature, $this->features ?? []);
    }

    /**
     * Get license status
     */
    public function getStatusAttribute($value): string
    {
        if ($this->isExpired()) {
            return 'expired';
        }
        
        if ($this->activated_at === null) {
            return 'inactive';
        }
        
        return $value;
    }

    /**
     * Get days until expiration
     */
    public function getDaysUntilExpirationAttribute(): int
    {
        return $this->expires_at->diffInDays(now());
    }

    /**
     * Activate license
     */
    public function activate(): bool
    {
        if ($this->isExpired()) {
            return false;
        }
        
        $this->update([
            'status' => 'active',
            'activated_at' => now()
        ]);
        
        return true;
    }

    /**
     * Deactivate license
     */
    public function deactivate(): bool
    {
        $this->update([
            'status' => 'inactive',
            'deactivated_at' => now()
        ]);
        
        return true;
    }

    /**
     * Scope for active licenses
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('expires_at', '>', now())
                    ->whereNotNull('activated_at');
    }

    /**
     * Scope for expired licenses
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    /**
     * Scope for inactive licenses
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive')
                    ->orWhereNull('activated_at');
    }
}

