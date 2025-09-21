<?php

namespace App\Services\Core;

use App\Models\Core\TahunAkademik;
use App\Models\Core\ProfilSekolah;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Service untuk manajemen tahun akademik SISKA
 * 
 * @package App\Services\Core
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class TahunAkademikService
{
    /**
     * Create tahun akademik
     */
    public function createTahunAkademik(array $data)
    {
        try {
            // If this is set as active, deactivate other academic years for the same school
            if (isset($data['status']) && $data['status'] === 'aktif') {
                TahunAkademik::where('sekolah_id', $data['sekolah_id'])
                    ->where('status', 'aktif')
                    ->update(['status' => 'nonaktif']);
            }

            $tahunAkademik = TahunAkademik::create($data);

            // Clear cache
            $this->clearCache($data['sekolah_id']);

            return [
                'success' => true,
                'message' => 'Tahun akademik berhasil dibuat',
                'data' => $tahunAkademik
            ];

        } catch (\Exception $e) {
            Log::error('Create tahun akademik error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error membuat tahun akademik: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update tahun akademik
     */
    public function updateTahunAkademik(TahunAkademik $tahunAkademik, array $data)
    {
        try {
            // If this is set as active, deactivate other academic years for the same school
            if (isset($data['status']) && $data['status'] === 'aktif') {
                TahunAkademik::where('sekolah_id', $tahunAkademik->sekolah_id)
                    ->where('id', '!=', $tahunAkademik->id)
                    ->where('status', 'aktif')
                    ->update(['status' => 'nonaktif']);
            }

            $tahunAkademik->update($data);

            // Clear cache
            $this->clearCache($tahunAkademik->sekolah_id);

            return [
                'success' => true,
                'message' => 'Tahun akademik berhasil diperbarui',
                'data' => $tahunAkademik
            ];

        } catch (\Exception $e) {
            Log::error('Update tahun akademik error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error memperbarui tahun akademik: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete tahun akademik
     */
    public function deleteTahunAkademik(TahunAkademik $tahunAkademik)
    {
        try {
            // Check if there are semesters associated with this academic year
            if ($tahunAkademik->semester()->count() > 0) {
                return [
                    'success' => false,
                    'message' => 'Tidak dapat menghapus tahun akademik yang memiliki semester'
                ];
            }

            $sekolahId = $tahunAkademik->sekolah_id;
            $tahunAkademik->delete();

            // Clear cache
            $this->clearCache($sekolahId);

            return [
                'success' => true,
                'message' => 'Tahun akademik berhasil dihapus'
            ];

        } catch (\Exception $e) {
            Log::error('Delete tahun akademik error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error menghapus tahun akademik: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Activate tahun akademik
     */
    public function activateTahunAkademik(TahunAkademik $tahunAkademik)
    {
        try {
            // Deactivate other academic years for the same school
            TahunAkademik::where('sekolah_id', $tahunAkademik->sekolah_id)
                ->where('id', '!=', $tahunAkademik->id)
                ->where('status', 'aktif')
                ->update(['status' => 'nonaktif']);

            $tahunAkademik->update(['status' => 'aktif']);

            // Clear cache
            $this->clearCache($tahunAkademik->sekolah_id);

            return [
                'success' => true,
                'message' => 'Tahun akademik berhasil diaktifkan',
                'data' => $tahunAkademik
            ];

        } catch (\Exception $e) {
            Log::error('Activate tahun akademik error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error mengaktifkan tahun akademik: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get active tahun akademik for school
     */
    public function getActiveTahunAkademik(int $sekolahId)
    {
        return Cache::remember("tahun_akademik_active_{$sekolahId}", 1800, function () use ($sekolahId) {
            return TahunAkademik::where('sekolah_id', $sekolahId)
                ->where('status', 'aktif')
                ->with(['sekolah', 'semester'])
                ->first();
        });
    }

    /**
     * Get tahun akademik by school
     */
    public function getTahunAkademikBySchool(int $sekolahId)
    {
        return Cache::remember("tahun_akademik_school_{$sekolahId}", 1800, function () use ($sekolahId) {
            return TahunAkademik::where('sekolah_id', $sekolahId)
                ->with(['semester'])
                ->orderBy('tahun_ajaran', 'desc')
                ->get();
        });
    }

    /**
     * Get current academic year (system-wide)
     */
    public function getCurrentAcademicYear()
    {
        return Cache::remember('tahun_akademik_current', 1800, function () {
            return TahunAkademik::where('status', 'aktif')
                ->where('tanggal_mulai', '<=', now())
                ->where('tanggal_selesai', '>=', now())
                ->with(['sekolah'])
                ->get();
        });
    }

    /**
     * Get academic year statistics
     */
    public function getAcademicYearStatistics()
    {
        return Cache::remember('tahun_akademik_statistics', 3600, function () {
            $total = TahunAkademik::count();
            $active = TahunAkademik::where('status', 'aktif')->count();
            $inactive = TahunAkademik::where('status', 'nonaktif')->count();
            
            $current = TahunAkademik::where('status', 'aktif')
                ->where('tanggal_mulai', '<=', now())
                ->where('tanggal_selesai', '>=', now())
                ->count();

            $upcoming = TahunAkademik::where('tanggal_mulai', '>', now())->count();
            $completed = TahunAkademik::where('tanggal_selesai', '<', now())->count();

            return [
                'total' => $total,
                'active' => $active,
                'inactive' => $inactive,
                'current' => $current,
                'upcoming' => $upcoming,
                'completed' => $completed
            ];
        });
    }

    /**
     * Search academic years
     */
    public function searchAcademicYears(string $query, array $filters = [])
    {
        $searchQuery = TahunAkademik::query();

        // Search by academic year name
        $searchQuery->where('tahun_ajaran', 'like', "%{$query}%");

        // Apply filters
        if (isset($filters['sekolah_id'])) {
            $searchQuery->where('sekolah_id', $filters['sekolah_id']);
        }

        if (isset($filters['status'])) {
            $searchQuery->where('status', $filters['status']);
        }

        if (isset($filters['date_from'])) {
            $searchQuery->where('tanggal_mulai', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $searchQuery->where('tanggal_selesai', '<=', $filters['date_to']);
        }

        return $searchQuery->with(['sekolah'])
            ->orderBy('tahun_ajaran', 'desc')
            ->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Validate academic year data
     */
    public function validateAcademicYearData(array $data, $excludeId = null)
    {
        $rules = [
            'sekolah_id' => 'required|exists:profil_sekolah,id',
            'tahun_ajaran' => 'required|string|unique:tahun_akademik,tahun_ajaran' . ($excludeId ? ",{$excludeId}" : '') . ',id,sekolah_id,' . ($data['sekolah_id'] ?? 'NULL'),
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,nonaktif',
            'keterangan' => 'nullable|string',
        ];

        $messages = [
            'sekolah_id.required' => 'ID sekolah wajib diisi',
            'sekolah_id.exists' => 'Sekolah tidak ditemukan',
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi',
            'tahun_ajaran.unique' => 'Tahun ajaran sudah ada untuk sekolah ini',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
            'status.required' => 'Status wajib diisi',
            'status.in' => 'Status tidak valid',
        ];

        $validator = \Validator::make($data, $rules, $messages);

        return [
            'valid' => !$validator->fails(),
            'errors' => $validator->errors()
        ];
    }

    /**
     * Get academic year progress
     */
    public function getAcademicYearProgress(TahunAkademik $tahunAkademik)
    {
        if ($tahunAkademik->tanggal_mulai > now()) {
            return [
                'status' => 'upcoming',
                'progress' => 0,
                'days_remaining' => $tahunAkademik->tanggal_mulai->diffInDays(now()),
                'message' => 'Tahun akademik belum dimulai'
            ];
        }

        if ($tahunAkademik->tanggal_selesai < now()) {
            return [
                'status' => 'completed',
                'progress' => 100,
                'days_passed' => $tahunAkademik->tanggal_selesai->diffInDays($tahunAkademik->tanggal_mulai),
                'message' => 'Tahun akademik sudah selesai'
            ];
        }

        $totalDays = $tahunAkademik->tanggal_mulai->diffInDays($tahunAkademik->tanggal_selesai);
        $passedDays = $tahunAkademik->tanggal_mulai->diffInDays(now());
        $progress = min(100, round(($passedDays / $totalDays) * 100, 2));

        return [
            'status' => 'current',
            'progress' => $progress,
            'days_passed' => $passedDays,
            'days_remaining' => $tahunAkademik->tanggal_selesai->diffInDays(now()),
            'total_days' => $totalDays,
            'message' => 'Tahun akademik sedang berjalan'
        ];
    }

    /**
     * Clear cache for school
     */
    private function clearCache($sekolahId = null)
    {
        Cache::forget('tahun_akademik_current');
        Cache::forget('tahun_akademik_statistics');

        if ($sekolahId) {
            Cache::forget("tahun_akademik_active_{$sekolahId}");
            Cache::forget("tahun_akademik_school_{$sekolahId}");
        }
    }
}
