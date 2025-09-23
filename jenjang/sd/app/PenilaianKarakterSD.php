<?php

namespace App\Jenjang\SMA\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenilaianKarakterSMA extends Model
{
    protected $connection = 'sd';
    protected $table = 'penilaian_karakter_sd';

    protected $fillable = [
        'id_siswa',
        'id_program_kesiswaan',
        'aspek_karakter',
        'nilai_karakter',
        'deskripsi',
        'tanggal_penilaian',
        'penilai_id',
        'semester',
        'tahun_akademik',
    ];

    protected $casts = [
        'tanggal_penilaian' => 'date',
    ];

    // Relationships
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(SiswaSMA::class, 'id_siswa');
    }

    public function programKesiswaan(): BelongsTo
    {
        return $this->belongsTo(ProgramKesiswaanSMA::class, 'id_program_kesiswaan');
    }

    public function penilai(): BelongsTo
    {
        return $this->belongsTo(UserSMA::class, 'penilai_id');
    }

    // Scopes
    public function scopeByAspekKarakter($query, $aspekKarakter)
    {
        return $query->where('aspek_karakter', $aspekKarakter);
    }

    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    public function scopeByTahunAkademik($query, $tahunAkademik)
    {
        return $query->where('tahun_akademik', $tahunAkademik);
    }

    public function scopeByNilai($query, $nilai)
    {
        return $query->where('nilai_karakter', $nilai);
    }

    // Accessors
    public function getAspekKarakterTextAttribute()
    {
        $aspekMap = [
            'jujur' => 'Kejujuran',
            'disiplin' => 'Kedisiplinan',
            'tanggung_jawab' => 'Tanggung Jawab',
            'santun' => 'Kesantunan',
        ];

        return $aspekMap[$this->aspek_karakter] ?? $this->aspek_karakter;
    }

    public function getNilaiKarakterTextAttribute()
    {
        $nilaiMap = [
            '1' => 'Sangat Baik',
            '2' => 'Baik',
            '3' => 'Cukup',
            '4' => 'Kurang',
        ];

        return $nilaiMap[$this->nilai_karakter] ?? $this->nilai_karakter;
    }
}
