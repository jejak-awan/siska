<?php

namespace App\Services\Public;

use App\Models\Public\PostinganUmum;
use App\Models\Public\Program;
use App\Models\Public\KegiatanPublik;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * Service untuk manajemen konten publik
 * 
 * @package App\Services\Public
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class PublicContentService
{
    /**
     * Get berita terbaru
     */
    public function getLatestNews($limit = 10)
    {
        return Cache::remember("latest_news_{$limit}", 300, function () use ($limit) {
            return PostinganUmum::published()
                ->byCategory('berita')
                ->orderBy('tanggal_publikasi', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get pengumuman terbaru
     */
    public function getLatestAnnouncements($limit = 10)
    {
        return Cache::remember("latest_announcements_{$limit}", 300, function () use ($limit) {
            return PostinganUmum::published()
                ->byCategory('pengumuman')
                ->orderBy('tanggal_publikasi', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get program aktif
     */
    public function getActivePrograms($limit = 10)
    {
        return Cache::remember("active_programs_{$limit}", 600, function () use ($limit) {
            return Program::active()
                ->ongoing()
                ->orderBy('tanggal_mulai', 'asc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get program featured
     */
    public function getFeaturedPrograms($limit = 5)
    {
        return Cache::remember("featured_programs_{$limit}", 600, function () use ($limit) {
            return Program::active()
                ->featured()
                ->orderBy('tanggal_mulai', 'asc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get kegiatan publik
     */
    public function getPublicActivities($limit = 10)
    {
        return Cache::remember("public_activities_{$limit}", 300, function () use ($limit) {
            return KegiatanPublik::orderBy('tanggal_mulai', 'asc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get konten berdasarkan kategori
     */
    public function getContentByCategory($category, $limit = 10)
    {
        return Cache::remember("content_category_{$category}_{$limit}", 300, function () use ($category, $limit) {
            return PostinganUmum::published()
                ->byCategory($category)
                ->orderBy('tanggal_publikasi', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Search konten
     */
    public function searchContent($query, $category = null, $limit = 20)
    {
        $searchQuery = PostinganUmum::published()
            ->where(function ($q) use ($query) {
                $q->where('judul', 'like', "%{$query}%")
                  ->orWhere('konten', 'like', "%{$query}%")
                  ->orWhereJsonContains('tag', $query);
            });

        if ($category) {
            $searchQuery->byCategory($category);
        }

        return $searchQuery->orderBy('tanggal_publikasi', 'desc')
                          ->limit($limit)
                          ->get();
    }

    /**
     * Get konten populer
     */
    public function getPopularContent($limit = 10)
    {
        return Cache::remember("popular_content_{$limit}", 600, function () use ($limit) {
            return PostinganUmum::published()
                ->orderBy('views', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get konten featured
     */
    public function getFeaturedContent($limit = 5)
    {
        return Cache::remember("featured_content_{$limit}", 600, function () use ($limit) {
            return PostinganUmum::published()
                ->featured()
                ->orderBy('tanggal_publikasi', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get konten pinned
     */
    public function getPinnedContent($limit = 5)
    {
        return Cache::remember("pinned_content_{$limit}", 600, function () use ($limit) {
            return PostinganUmum::published()
                ->pinned()
                ->orderBy('tanggal_publikasi', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Create konten baru
     */
    public function createContent($data, $authorRole, $authorId)
    {
        try {
            $content = PostinganUmum::create([
                'judul' => $data['judul'],
                'konten' => $data['konten'],
                'kategori' => $data['kategori'],
                'subkategori' => $data['subkategori'] ?? null,
                'tag' => $data['tag'] ?? [],
                'lampiran' => $data['lampiran'] ?? [],
                'peran_penulis' => $authorRole,
                'id_penulis' => $authorId,
                'tanggal_publikasi' => $data['tanggal_publikasi'] ?? now(),
                'status' => $data['status'] ?? 'draft',
                'is_featured' => $data['is_featured'] ?? false,
                'is_pinned' => $data['is_pinned'] ?? false,
            ]);

            // Clear cache
            $this->clearContentCache();

            return [
                'success' => true,
                'message' => 'Konten berhasil dibuat',
                'content' => $content,
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error membuat konten: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update konten
     */
    public function updateContent($id, $data, $authorRole, $authorId)
    {
        try {
            $content = PostinganUmum::findOrFail($id);

            if (!$content->canBeEditedBy($authorRole, $authorId)) {
                return [
                    'success' => false,
                    'message' => 'Tidak memiliki akses untuk mengedit konten ini'
                ];
            }

            $content->update($data);

            // Clear cache
            $this->clearContentCache();

            return [
                'success' => true,
                'message' => 'Konten berhasil diupdate',
                'content' => $content,
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error update konten: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete konten
     */
    public function deleteContent($id, $authorRole, $authorId)
    {
        try {
            $content = PostinganUmum::findOrFail($id);

            if (!$content->canBeEditedBy($authorRole, $authorId)) {
                return [
                    'success' => false,
                    'message' => 'Tidak memiliki akses untuk menghapus konten ini'
                ];
            }

            // Delete attachments
            if ($content->lampiran) {
                foreach ($content->lampiran as $file) {
                    Storage::delete($file);
                }
            }

            $content->delete();

            // Clear cache
            $this->clearContentCache();

            return [
                'success' => true,
                'message' => 'Konten berhasil dihapus'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error hapus konten: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Clear content cache
     */
    private function clearContentCache()
    {
        $cacheKeys = [
            'latest_news_*',
            'latest_announcements_*',
            'active_programs_*',
            'featured_programs_*',
            'public_activities_*',
            'content_category_*',
            'popular_content_*',
            'featured_content_*',
            'pinned_content_*',
        ];

        foreach ($cacheKeys as $pattern) {
            Cache::forget($pattern);
        }
    }
}
