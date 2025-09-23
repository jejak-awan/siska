<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk siswa SMA
 * 
 * @package App\Models
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class Siswa extends Model
{
    use HasFactory;

    protected $connection = 'sd';
    protected $table = 'siswa_sd';

    protected $fillable = [
        'nis',
        'nisn',
        'nama_lengkap',
        'nama_panggilan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'telepon',
        'email',
        'kelas_id',
        'tahun_masuk',
        'status',
        'nama_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'telepon_ortu',
        'alamat_ortu',
        'foto',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tahun_masuk' => 'integer',
    ];

    /**
     * Scope untuk siswa aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope untuk siswa berdasarkan kelas
     */
    public function scopeByKelas($query, $kelasId)
    {
        return $query->where('kelas_id', $kelasId);
    }

    /**
     * Scope untuk siswa berdasarkan jenis kelamin
     */
    public function scopeByGender($query, $gender)
    {
        return $query->where('jenis_kelamin', $gender);
    }

    /**
     * Scope untuk siswa berdasarkan tahun masuk
     */
    public function scopeByTahunMasuk($query, $tahun)
    {
        return $query->where('tahun_masuk', $tahun);
    }

    /**
     * Get usia siswa
     */
    public function getUsiaAttribute()
    {
        return $this->tanggal_lahir->age;
    }

    /**
     * Get nama lengkap dengan kelas
     */
    public function getNamaLengkapKelasAttribute()
    {
        return $this->nama_lengkap . ' (' . $this->kelas->nama_kelas . ')';
    }

    /**
     * Get foto URL
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/default-student.png');
    }

    /**
     * Get alamat lengkap
     */
    public function getAlamatLengkapAttribute()
    {
        $alamat = $this->alamat;
        if ($this->rt) $alamat .= ', RT ' . $this->rt;
        if ($this->rw) $alamat .= '/RW ' . $this->rw;
        if ($this->kelurahan) $alamat .= ', ' . $this->kelurahan;
        if ($this->kecamatan) $alamat .= ', ' . $this->kecamatan;
        if ($this->kota) $alamat .= ', ' . $this->kota;
        if ($this->provinsi) $alamat .= ', ' . $this->provinsi;
        if ($this->kode_pos) $alamat .= ' ' . $this->kode_pos;
        
        return $alamat;
    }

    /**
     * Relasi ke Kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relasi ke Presensi
     */
    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'siswa_id');
    }

    /**
     * Relasi ke Kredit Poin
     */
    public function kreditPoin()
    {
        return $this->hasMany(KreditPoin::class, 'siswa_id');
    }

    /**
     * Relasi ke Penilaian Karakter
     */
    public function penilaianKarakter()
    {
        return $this->hasMany(PenilaianKarakter::class, 'siswa_id');
    }

    /**
     * Get total kredit poin
     */
    public function getTotalKreditPoinAttribute()
    {
        return $this->kreditPoin()->sum('poin');
    }

    /**
     * Get rata-rata kredit poin
     */
    public function getRataRataKreditPoinAttribute()
    {
        $total = $this->kreditPoin()->count();
        if ($total > 0) {
            return round($this->getTotalKreditPoinAttribute() / $total, 2);
        }
        return 0;
    }

    /**
     * Get presensi bulan ini
     */
    public function getPresensiBulanIniAttribute()
    {
        return $this->presensi()
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->get();
    }

    /**
     * Get persentase kehadiran bulan ini
     */
    public function getPersentaseKehadiranBulanIniAttribute()
    {
        $presensi = $this->getPresensiBulanIniAttribute();
        $total = $presensi->count();
        
        if ($total > 0) {
            $hadir = $presensi->where('status', 'hadir')->count();
            return round(($hadir / $total) * 100, 2);
        }
        
        return 0;
    }
}
