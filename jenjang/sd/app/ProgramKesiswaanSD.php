<?php

namespace App\Jenjang\SMA\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramKesiswaanSMA extends Model
{
    protected $connection = 'sd';
    protected $table = 'program_kesiswaan_sd';

    protected $fillable = [
        'nama_program',
        'deskripsi',
        'kategori',
        'target_siswa',
        'durasi',
        'penanggung_jawab_id',
        'status',
    ];

    protected $casts = [
        'target_siswa' => 'array',
    ];

    // Relationships
    public function penanggungJawab(): BelongsTo
    {
        return $this->belongsTo(UserSMA::class, 'penanggung_jawab_id');
    }

    public function penilaianKarakter(): HasMany
    {
        return $this->hasMany(PenilaianKarakterSMA::class, 'id_program_kesiswaan');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Accessors
    public function getKategoriTextAttribute()
    {
        $kategoriMap = [
            'karakter_dasar' => 'Karakter Dasar',
            'kebersihan' => 'Kebersihan',
            'kedisiplinan' => 'Kedisiplinan',
        ];

        return $kategoriMap[$this->kategori] ?? $this->kategori;
    }

    public function getStatusTextAttribute()
    {
        $statusMap = [
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'completed' => 'Selesai',
        ];

        return $statusMap[$this->status] ?? $this->status;
    }
}
