<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk postingan umum (berita, pengumuman, dll)
 * 
 * @package App\Models\Public
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class PostinganUmum extends Model
{
    use HasFactory;

    protected $connection = 'public';
    protected $table = 'postingan_umum';

    protected $fillable = [
        'judul',
        'konten',
        'kategori',
        'subkategori',
        'tag',
        'lampiran',
        'peran_penulis',
        'id_penulis',
        'tanggal_publikasi',
        'status',
        'views',
        'is_featured',
        'is_pinned',
    ];

    protected $casts = [
        'tag' => 'array',
        'lampiran' => 'array',
        'tanggal_publikasi' => 'datetime',
        'is_featured' => 'boolean',
        'is_pinned' => 'boolean',
    ];

    /**
     * Scope untuk postingan yang dipublikasi
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('tanggal_publikasi', '<=', now());
    }

    /**
     * Scope untuk postingan berdasarkan kategori
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('kategori', $category);
    }

    /**
     * Scope untuk postingan featured
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope untuk postingan pinned
     */
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    /**
     * Scope untuk postingan berdasarkan penulis
     */
    public function scopeByAuthor($query, $role, $id)
    {
        return $query->where('peran_penulis', $role)
                    ->where('id_penulis', $id);
    }

    /**
     * Get excerpt dari konten
     */
    public function getExcerptAttribute()
    {
        return \Str::limit(strip_tags($this->konten), 150);
    }

    /**
     * Get formatted tags
     */
    public function getFormattedTagsAttribute()
    {
        return $this->tag ? implode(', ', $this->tag) : '';
    }

    /**
     * Cek apakah postingan sudah dipublikasi
     */
    public function isPublished()
    {
        return $this->status === 'published' && $this->tanggal_publikasi <= now();
    }

    /**
     * Cek apakah postingan bisa diedit oleh user tertentu
     */
    public function canBeEditedBy($role, $id)
    {
        return $this->peran_penulis === $role && $this->id_penulis === $id;
    }

    /**
     * Increment views
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Get attachment URLs
     */
    public function getAttachmentUrlsAttribute()
    {
        if (!$this->lampiran) {
            return [];
        }

        return array_map(function($file) {
            return asset('storage/' . $file);
        }, $this->lampiran);
    }
}
