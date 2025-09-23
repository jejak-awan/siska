<?php

namespace App\Services;

use App\Models\SchoolProfile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SchoolProfileService
{
    protected $schoolProfileModel;

    public function __construct(SchoolProfile $schoolProfileModel)
    {
        $this->schoolProfileModel = $schoolProfileModel;
    }

    /**
     * Get all school profiles with pagination and filters
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = $this->schoolProfileModel->newQuery();

        // Apply filters
        if (isset($filters['jenjang']) && $filters['jenjang']) {
            $query->withJenjang($filters['jenjang']);
        }

        if (isset($filters['provinsi']) && $filters['provinsi']) {
            $query->inProvince($filters['provinsi']);
        }

        if (isset($filters['kabupaten_kota']) && $filters['kabupaten_kota']) {
            $query->inCity($filters['kabupaten_kota']);
        }

        if (isset($filters['status_sekolah']) && $filters['status_sekolah']) {
            $query->where('status_sekolah', $filters['status_sekolah']);
        }

        if (isset($filters['akreditasi']) && $filters['akreditasi']) {
            $query->where('akreditasi', $filters['akreditasi']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                  ->orWhere('npsn', 'like', "%{$search}%")
                  ->orWhere('kepala_sekolah', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('nama_sekolah')
                    ->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get school profile by ID
     */
    public function getById(string $id): SchoolProfile
    {
        return $this->schoolProfileModel->findOrFail($id);
    }

    /**
     * Get school profile by NPSN
     */
    public function getByNPSN(string $npsn): ?SchoolProfile
    {
        return $this->schoolProfileModel->where('npsn', $npsn)->first();
    }

    /**
     * Create new school profile
     */
    public function create(array $data): SchoolProfile
    {
        $validator = Validator::make($data, [
            'npsn' => 'required|string|unique:school_profiles',
            'nama_sekolah' => 'required|string|max:255',
            'jenjang' => 'required|in:SD,SMP,SMA,SMK',
            'alamat' => 'required|string',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'required|string|max:10',
            'nomor_telepon' => 'required|string|max:20',
            'email' => 'required|email',
            'website' => 'nullable|url',
            'logo_url' => 'nullable|url',
            'jenjang_aktif' => 'required|array',
            'tahun_berdiri' => 'required|integer|min:1900|max:' . date('Y'),
            'status_sekolah' => 'required|in:negeri,swasta',
            'akreditasi' => 'nullable|in:A,B,C,D',
            'kepala_sekolah' => 'required|string|max:255',
            'nip_kepala_sekolah' => 'nullable|string|max:20',
            'bendahara' => 'nullable|string|max:255',
            'nip_bendahara' => 'nullable|string|max:20',
            'operator' => 'nullable|string|max:255',
            'nip_operator' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->schoolProfileModel->create($data);
    }

    /**
     * Update school profile
     */
    public function update(string $id, array $data): SchoolProfile
    {
        $schoolProfile = $this->getById($id);
        
        $validator = Validator::make($data, [
            'npsn' => 'sometimes|required|string|unique:school_profiles,npsn,' . $id,
            'nama_sekolah' => 'sometimes|required|string|max:255',
            'jenjang' => 'sometimes|required|in:SD,SMP,SMA,SMK',
            'alamat' => 'sometimes|required|string',
            'kelurahan' => 'sometimes|required|string|max:255',
            'kecamatan' => 'sometimes|required|string|max:255',
            'kabupaten_kota' => 'sometimes|required|string|max:255',
            'provinsi' => 'sometimes|required|string|max:255',
            'kode_pos' => 'sometimes|required|string|max:10',
            'nomor_telepon' => 'sometimes|required|string|max:20',
            'email' => 'sometimes|required|email',
            'website' => 'nullable|url',
            'logo_url' => 'nullable|url',
            'jenjang_aktif' => 'sometimes|required|array',
            'tahun_berdiri' => 'sometimes|required|integer|min:1900|max:' . date('Y'),
            'status_sekolah' => 'sometimes|required|in:negeri,swasta',
            'akreditasi' => 'nullable|in:A,B,C,D',
            'kepala_sekolah' => 'sometimes|required|string|max:255',
            'nip_kepala_sekolah' => 'nullable|string|max:20',
            'bendahara' => 'nullable|string|max:255',
            'nip_bendahara' => 'nullable|string|max:20',
            'operator' => 'nullable|string|max:255',
            'nip_operator' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $schoolProfile->update($data);
        return $schoolProfile->fresh();
    }

    /**
     * Delete school profile
     */
    public function delete(string $id): bool
    {
        $schoolProfile = $this->getById($id);
        return $schoolProfile->delete();
    }

    /**
     * Activate school profile
     */
    public function activate(string $id): bool
    {
        $schoolProfile = $this->getById($id);
        $schoolProfile->update(['is_active' => true]);
        return true;
    }

    /**
     * Deactivate school profile
     */
    public function deactivate(string $id): bool
    {
        $schoolProfile = $this->getById($id);
        $schoolProfile->update(['is_active' => false]);
        return true;
    }

    /**
     * Get school profile statistics
     */
    public function getStatistics(): array
    {
        $total = $this->schoolProfileModel->count();
        $active = $this->schoolProfileModel->active()->count();
        $inactive = $this->schoolProfileModel->where('is_active', false)->count();

        // Statistics by jenjang
        $jenjangStats = $this->schoolProfileModel->selectRaw('jenjang, COUNT(*) as total')
            ->groupBy('jenjang')
            ->get()
            ->pluck('total', 'jenjang');

        // Statistics by status sekolah
        $statusStats = $this->schoolProfileModel->selectRaw('status_sekolah, COUNT(*) as total')
            ->groupBy('status_sekolah')
            ->get()
            ->pluck('total', 'status_sekolah');

        // Statistics by akreditasi
        $akreditasiStats = $this->schoolProfileModel->selectRaw('akreditasi, COUNT(*) as total')
            ->whereNotNull('akreditasi')
            ->groupBy('akreditasi')
            ->get()
            ->pluck('total', 'akreditasi');

        // Statistics by province
        $provinsiStats = $this->schoolProfileModel->selectRaw('provinsi, COUNT(*) as total')
            ->groupBy('provinsi')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get()
            ->pluck('total', 'provinsi');

        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
            'jenjang' => $jenjangStats,
            'status_sekolah' => $statusStats,
            'akreditasi' => $akreditasiStats,
            'provinsi' => $provinsiStats,
            'persentase_aktif' => $total > 0 ? round(($active / $total) * 100, 2) : 0
        ];
    }

    /**
     * Get active school profiles
     */
    public function getActive(): Collection
    {
        return $this->schoolProfileModel->active()->get();
    }

    /**
     * Get school profiles by jenjang
     */
    public function getByJenjang(string $jenjang): Collection
    {
        return $this->schoolProfileModel->withJenjang($jenjang)->get();
    }

    /**
     * Get school profiles by province
     */
    public function getByProvince(string $provinsi): Collection
    {
        return $this->schoolProfileModel->inProvince($provinsi)->get();
    }

    /**
     * Get school profiles by city
     */
    public function getByCity(string $kabupaten_kota): Collection
    {
        return $this->schoolProfileModel->inCity($kabupaten_kota)->get();
    }

    /**
     * Search school profiles
     */
    public function search(string $keyword): Collection
    {
        return $this->schoolProfileModel->where(function ($q) use ($keyword) {
            $q->where('nama_sekolah', 'like', "%{$keyword}%")
              ->orWhere('npsn', 'like', "%{$keyword}%")
              ->orWhere('kepala_sekolah', 'like', "%{$keyword}%");
        })->get();
    }

    /**
     * Get school profile by coordinates
     */
    public function getByCoordinates(float $latitude, float $longitude, float $radius = 10): Collection
    {
        // This would need to be implemented with proper geospatial queries
        // For now, return empty collection
        return collect();
    }
}

