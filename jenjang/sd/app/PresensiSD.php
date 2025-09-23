<?php

namespace App\Jenjang\SMA\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresensiSMA extends Model
{
    protected $connection = 'sd';
    protected $table = 'presensi_sd';

    protected $fillable = [
        'id_siswa',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan',
        'semester',
        'tahun_akademik',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i',
        'jam_keluar' => 'datetime:H:i',
    ];

    // Relationships
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(SiswaSMA::class, 'id_siswa');
    }

    // Scopes
    public function scopeByTanggal($query, $tanggal)
    {
        return $query->where('tanggal', $tanggal);
    }

    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    public function scopeByTahunAkademik($query, $tahunAkademik)
    {
        return $query->where('tahun_akademik', $tahunAkademik);
    }

    public function scopeHadir($query)
    {
        return $query->where('status', 'hadir');
    }

    public function scopeTidakHadir($query)
    {
        return $query->whereIn('status', ['izin', 'sakit', 'alpa']);
    }

    // Accessors
    public function getStatusTextAttribute()
    {
        $statusMap = [
            'hadir' => 'Hadir',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpa' => 'Alpa',
        ];

        return $statusMap[$this->status] ?? $this->status;
    }

    public function getDurasiAttribute()
    {
        if ($this->jam_masuk && $this->jam_keluar) {
            return $this->jam_masuk->diffInMinutes($this->jam_keluar);
        }
        return null;
    }
}
