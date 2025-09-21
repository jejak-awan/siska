<?php

namespace App\Services\Core;

use App\Models\Core\ProfilSekolah;
use App\Models\Core\TahunAkademik;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Service untuk manajemen profil sekolah SISKA
 * 
 * @package App\Services\Core
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class ProfilSekolahService
{
    /**
     * Create profil sekolah
     */
    public function createProfilSekolah(array $data)
    {
        try {
            // Handle logo upload
            if (isset($data['logo']) && $data['logo']->isValid()) {
                $logoPath = $data['logo']->store('logos', 'public');
                $data['logo'] = $logoPath;
            }

            $profilSekolah = ProfilSekolah::create($data);

            // Clear cache
            $this->clearCache($profilSekolah->id);

            return [
                'success' => true,
                'message' => 'Profil sekolah berhasil dibuat',
                'data' => $profilSekolah
            ];

        } catch (\Exception $e) {
            Log::error('Create profil sekolah error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error membuat profil sekolah: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update profil sekolah
     */
    public function updateProfilSekolah(ProfilSekolah $profilSekolah, array $data)
    {
        try {
            // Handle logo upload
            if (isset($data['logo']) && $data['logo']->isValid()) {
                // Delete old logo if exists
                if ($profilSekolah->logo && Storage::disk('public')->exists($profilSekolah->logo)) {
                    Storage::disk('public')->delete($profilSekolah->logo);
                }
                
                $logoPath = $data['logo']->store('logos', 'public');
                $data['logo'] = $logoPath;
            }

            $profilSekolah->update($data);

            // Clear cache
            $this->clearCache($profilSekolah->id);

            return [
                'success' => true,
                'message' => 'Profil sekolah berhasil diperbarui',
                'data' => $profilSekolah
            ];

        } catch (\Exception $e) {
            Log::error('Update profil sekolah error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error memperbarui profil sekolah: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete profil sekolah
     */
    public function deleteProfilSekolah(ProfilSekolah $profilSekolah)
    {
        try {
            // Check if school has active academic years
            $activeTahunAkademik = TahunAkademik::where('sekolah_id', $profilSekolah->id)
                ->where('status', 'aktif')
                ->count();

            if ($activeTahunAkademik > 0) {
                return [
                    'success' => false,
                    'message' => 'Tidak dapat menghapus sekolah yang memiliki tahun akademik aktif'
                ];
            }

            // Delete logo if exists
            if ($profilSekolah->logo && Storage::disk('public')->exists($profilSekolah->logo)) {
                Storage::disk('public')->delete($profilSekolah->logo);
            }

            $profilSekolah->delete();

            // Clear cache
            $this->clearCache($profilSekolah->id);

            return [
                'success' => true,
                'message' => 'Profil sekolah berhasil dihapus'
            ];

        } catch (\Exception $e) {
            Log::error('Delete profil sekolah error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error menghapus profil sekolah: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get profil sekolah by NPSN
     */
    public function getByNpsn(string $npsn)
    {
        return Cache::remember("profil_sekolah_npsn_{$npsn}", 3600, function () use ($npsn) {
            return ProfilSekolah::where('npsn', $npsn)
                ->with(['license', 'tahunAkademik'])
                ->first();
        });
    }

    /**
     * Get schools by jenjang
     */
    public function getByJenjang(string $jenjang)
    {
        return Cache::remember("profil_sekolah_jenjang_{$jenjang}", 1800, function () use ($jenjang) {
            return ProfilSekolah::where('jenjang', $jenjang)
                ->where('status', 'aktif')
                ->with(['license'])
                ->orderBy('nama_sekolah')
                ->get();
        });
    }

    /**
     * Get active schools
     */
    public function getActiveSchools()
    {
        return Cache::remember('profil_sekolah_active', 1800, function () {
            return ProfilSekolah::where('status', 'aktif')
                ->with(['license'])
                ->orderBy('nama_sekolah')
                ->get();
        });
    }

    /**
     * Get school statistics
     */
    public function getSchoolStatistics()
    {
        return Cache::remember('profil_sekolah_statistics', 3600, function () {
            $total = ProfilSekolah::count();
            $active = ProfilSekolah::where('status', 'aktif')->count();
            $inactive = ProfilSekolah::where('status', 'nonaktif')->count();
            
            $byJenjang = ProfilSekolah::selectRaw('jenjang, COUNT(*) as count')
                ->groupBy('jenjang')
                ->pluck('count', 'jenjang')
                ->toArray();

            return [
                'total' => $total,
                'active' => $active,
                'inactive' => $inactive,
                'by_jenjang' => $byJenjang
            ];
        });
    }

    /**
     * Search schools
     */
    public function searchSchools(string $query, array $filters = [])
    {
        $searchQuery = ProfilSekolah::query();

        // Search by name, NPSN, or address
        $searchQuery->where(function ($q) use ($query) {
            $q->where('nama_sekolah', 'like', "%{$query}%")
              ->orWhere('npsn', 'like', "%{$query}%")
              ->orWhere('alamat', 'like', "%{$query}%");
        });

        // Apply filters
        if (isset($filters['jenjang'])) {
            $searchQuery->where('jenjang', $filters['jenjang']);
        }

        if (isset($filters['status'])) {
            $searchQuery->where('status', $filters['status']);
        }

        if (isset($filters['kabupaten_kota'])) {
            $searchQuery->where('kabupaten_kota', 'like', "%{$filters['kabupaten_kota']}%");
        }

        if (isset($filters['provinsi'])) {
            $searchQuery->where('provinsi', 'like', "%{$filters['provinsi']}%");
        }

        return $searchQuery->with(['license'])
            ->orderBy('nama_sekolah')
            ->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Validate school data
     */
    public function validateSchoolData(array $data, $excludeId = null)
    {
        $rules = [
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'required|string|unique:profil_sekolah,npsn' . ($excludeId ? ",{$excludeId}" : ''),
            'jenjang' => 'required|in:SD,SMP,SMA,SMK',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'provinsi' => 'required|string',
            'kode_pos' => 'nullable|string',
            'telepon' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kepala_sekolah' => 'required|string',
            'nip_kepala_sekolah' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ];

        $messages = [
            'nama_sekolah.required' => 'Nama sekolah wajib diisi',
            'npsn.required' => 'NPSN wajib diisi',
            'npsn.unique' => 'NPSN sudah digunakan',
            'jenjang.required' => 'Jenjang wajib diisi',
            'jenjang.in' => 'Jenjang tidak valid',
            'alamat.required' => 'Alamat wajib diisi',
            'kecamatan.required' => 'Kecamatan wajib diisi',
            'kabupaten_kota.required' => 'Kabupaten/Kota wajib diisi',
            'provinsi.required' => 'Provinsi wajib diisi',
            'email.email' => 'Format email tidak valid',
            'website.url' => 'Format website tidak valid',
            'logo.image' => 'File logo harus berupa gambar',
            'logo.mimes' => 'Format logo harus jpeg, png, jpg, atau gif',
            'logo.max' => 'Ukuran logo maksimal 2MB',
            'kepala_sekolah.required' => 'Nama kepala sekolah wajib diisi',
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
     * Clear cache for school
     */
    private function clearCache($sekolahId = null)
    {
        Cache::forget('profil_sekolah_active');
        Cache::forget('profil_sekolah_statistics');
        
        // Clear jenjang cache
        $jenjangs = ['SD', 'SMP', 'SMA', 'SMK'];
        foreach ($jenjangs as $jenjang) {
            Cache::forget("profil_sekolah_jenjang_{$jenjang}");
        }

        if ($sekolahId) {
            $sekolah = ProfilSekolah::find($sekolahId);
            if ($sekolah && $sekolah->npsn) {
                Cache::forget("profil_sekolah_npsn_{$sekolah->npsn}");
            }
        }
    }
}
