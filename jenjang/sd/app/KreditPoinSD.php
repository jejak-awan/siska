<?php

namespace App\Jenjang\SMA\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KreditPoinSMA extends Model
{
    protected $connection = 'sd';
    protected $table = 'kredit_poin_sd';

    protected $fillable = [
        'id_siswa',
        'kategori',
        'poin',
        'deskripsi',
        'tanggal',
        'pemberi_poin_id',
        'semester',
        'tahun_akademik',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relationships
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(SiswaSMA::class, 'id_siswa');
    }

    public function pemberiPoin(): BelongsTo
    {
        return $this->belongsTo(UserSMA::class, 'pemberi_poin_id');
    }

    // Scopes
    public function scopePositif($query)
    {
        return $query->where('kategori', 'positif');
    }

    public function scopeNegatif($query)
    {
        return $query->where('kategori', 'negatif');
    }

    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    public function scopeByTahunAkademik($query, $tahunAkademik)
    {
        return $query->where('tahun_akademik', $tahunAkademik);
    }

    public function scopeByTanggal($query, $tanggal)
    {
        return $query->where('tanggal', $tanggal);
    }

    // Accessors
    public function getKategoriTextAttribute()
    {
        return $this->kategori === 'positif' ? 'Poin Positif' : 'Poin Negatif';
    }

    public function getPoinFormattedAttribute()
    {
        return $this->kategori === 'positif' ? "+{$this->poin}" : "-{$this->poin}";
    }
}
