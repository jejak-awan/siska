<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk guru SD
 * 
 * @package App\Models
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class Guru extends Model
{
    use HasFactory;

    protected $connection = 'sd';
    protected $table = 'guru_sd';

    protected $fillable = [
        'nip',
        'nama_lengkap',
        'nama_panggilan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'telepon',
        'email',
        'jabatan',
        'status',
        'tanggal_masuk',
        'foto',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
    ];

    /**
     * Scope untuk guru aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope untuk guru berdasarkan jabatan
     */
    public function scopeByJabatan($query, $jabatan)
    {
        return $query->where('jabatan', $jabatan);
    }

    /**
     * Scope untuk guru berdasarkan jenis kelamin
     */
    public function scopeByGender($query, $gender)
    {
        return $query->where('jenis_kelamin', $gender);
    }

    /**
     * Get usia guru
     */
    public function getUsiaAttribute()
    {
        return $this->tanggal_lahir->age;
    }

    /**
     * Get masa kerja dalam tahun
     */
    public function getMasaKerjaAttribute()
    {
        return $this->tanggal_masuk->diffInYears(now());
    }

    /**
     * Get foto URL
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/default-teacher.png');
    }

    /**
     * Cek apakah guru adalah wali kelas
     */
    public function isWaliKelas()
    {
        return $this->kelas()->exists();
    }

    /**
     * Relasi ke Kelas (sebagai wali kelas)
     */
    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'wali_kelas_id');
    }

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
