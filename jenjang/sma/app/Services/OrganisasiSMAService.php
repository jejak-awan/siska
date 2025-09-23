<?php

namespace App\Jenjang\SMA\Services;

use App\Jenjang\SMA\Models\OrganisasiSMA;
use App\Jenjang\SMA\Models\OrganisasiAnggotaSMA;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OrganisasiSMAService
{
    protected $organisasiModel;
    protected $anggotaModel;

    public function __construct(OrganisasiSMA $organisasiModel, OrganisasiAnggotaSMA $anggotaModel)
    {
        $this->organisasiModel = $organisasiModel;
        $this->anggotaModel = $anggotaModel;
    }

    /**
     * Get all SMA organizations with pagination and filters
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = $this->organisasiModel->newQuery()->with('anggota');

        // Apply filters
        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama_organisasi', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('pembina', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('nama_organisasi')
                    ->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get organization by ID
     */
    public function getById(string $id): OrganisasiSMA
    {
        return $this->organisasiModel->with(['anggota.siswa', 'program'])->findOrFail($id);
    }

    /**
     * Create new organization
     */
    public function create(array $data): OrganisasiSMA
    {
        return $this->organisasiModel->create($data);
    }

    /**
     * Update organization
     */
    public function update(string $id, array $data): OrganisasiSMA
    {
        $organisasi = $this->getById($id);
        $organisasi->update($data);
        return $organisasi->fresh();
    }

    /**
     * Delete organization
     */
    public function delete(string $id): bool
    {
        $organisasi = $this->getById($id);
        return $organisasi->delete();
    }

    /**
     * Add member to organization
     */
    public function addMember(string $organisasiId, array $data): OrganisasiAnggotaSMA
    {
        $data['organisasi_id'] = $organisasiId;
        $data['tanggal_bergabung'] = now();
        $data['status'] = 'aktif';

        return $this->anggotaModel->create($data);
    }

    /**
     * Remove member from organization
     */
    public function removeMember(string $organisasiId, array $data): bool
    {
        $anggota = $this->anggotaModel->where('organisasi_id', $organisasiId)
            ->where('siswa_id', $data['siswa_id'])
            ->first();

        if ($anggota) {
            $anggota->update([
                'status' => 'keluar',
                'tanggal_keluar' => now()
            ]);
            return true;
        }

        return false;
    }

    /**
     * Get organization members
     */
    public function getMembers(string $organisasiId): Collection
    {
        return $this->anggotaModel->with('siswa')
            ->where('organisasi_id', $organisasiId)
            ->where('status', 'aktif')
            ->orderBy('jabatan')
            ->get();
    }

    /**
     * Get organization statistics
     */
    public function getStatistics(): array
    {
        $total = $this->organisasiModel->count();
        $aktif = $this->organisasiModel->where('status', 'aktif')->count();
        $nonaktif = $this->organisasiModel->where('status', 'nonaktif')->count();
        $dibubarkan = $this->organisasiModel->where('status', 'dibubarkan')->count();

        // Statistics by status
        $statusStats = $this->organisasiModel->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // Total members across all organizations
        $totalAnggota = $this->anggotaModel->where('status', 'aktif')->count();

        // Average members per organization
        $avgAnggota = $aktif > 0 ? round($totalAnggota / $aktif, 2) : 0;

        return [
            'total' => $total,
            'aktif' => $aktif,
            'nonaktif' => $nonaktif,
            'dibubarkan' => $dibubarkan,
            'status' => $statusStats,
            'total_anggota' => $totalAnggota,
            'avg_anggota_per_organisasi' => $avgAnggota,
            'persentase_aktif' => $total > 0 ? round(($aktif / $total) * 100, 2) : 0
        ];
    }

    /**
     * Get organizations by status
     */
    public function getByStatus(string $status): Collection
    {
        return $this->organisasiModel->where('status', $status)
            ->with('anggota')
            ->orderBy('nama_organisasi')
            ->get();
    }

    /**
     * Get active organizations
     */
    public function getActive(): Collection
    {
        return $this->getByStatus('aktif');
    }

    /**
     * Update member position
     */
    public function updateMemberPosition(string $organisasiId, string $siswaId, string $jabatan): bool
    {
        $anggota = $this->anggotaModel->where('organisasi_id', $organisasiId)
            ->where('siswa_id', $siswaId)
            ->first();

        if ($anggota) {
            $anggota->update(['jabatan' => $jabatan]);
            return true;
        }

        return false;
    }

    /**
     * Get organization leaders
     */
    public function getLeaders(string $organisasiId): Collection
    {
        return $this->anggotaModel->with('siswa')
            ->where('organisasi_id', $organisasiId)
            ->whereIn('jabatan', ['ketua', 'wakil_ketua', 'sekretaris', 'bendahara'])
            ->where('status', 'aktif')
            ->orderBy('jabatan')
            ->get();
    }
}

