<?php

namespace App\Jenjang\SMA\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserSMA extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $connection = 'sd';
    protected $table = 'users_sd';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'jenis_user',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function siswa()
    {
        return $this->hasOne(SiswaSMA::class, 'id_user');
    }

    public function kreditPoin()
    {
        return $this->hasMany(KreditPoinSMA::class, 'pemberi_poin_id');
    }

    public function programKesiswaan()
    {
        return $this->hasMany(ProgramKesiswaanSMA::class, 'penanggung_jawab_id');
    }

    public function penilaianKarakter()
    {
        return $this->hasMany(PenilaianKarakterSMA::class, 'penilai_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByJenisUser($query, $jenisUser)
    {
        return $query->where('jenis_user', $jenisUser);
    }
}
