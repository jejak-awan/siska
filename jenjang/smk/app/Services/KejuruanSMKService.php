<?php

namespace App\Jenjang\SMK\Services;

use App\Jenjang\SMK\Models\KejuruanSMK;
use App\Jenjang\SMK\Models\KejuruanSiswaSMK;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class KejuruanSMKService
{
    protected $kejuruanModel;
    protected $participationModel;

    public function __construct(KejuruanSMK $kejuruanModel, KejuruanSiswaSMK $participationModel)
    {
        $this->kejuruanModel = $kejuruanModel;
        $this->participationModel = $participationModel;
    }

    /**
     * Get all SMK kejuruan with pagination and filters
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = $this->kejuruanModel->newQuery()->with('siswa');

        // Apply filters
        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama_kejuruan', 'like', "%{$search}%")
                  ->orWhere('kode_kejuruan', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('pembina', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('nama_kejuruan')
                    ->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get kejuruan by ID
     */
    public function getById(string $id): KejuruanSMK
    {
        return $this->kejuruanModel->with(['siswa.siswa'])->findOrFail($id);
    }

    /**
     * Create new kejuruan
     */
    public function create(array $data): KejuruanSMK
    {
        return $this->kejuruanModel->create($data);
    }

    /**
     * Update kejuruan
     */
    public function update(string $id, array $data): KejuruanSMK
    {
        $kejuruan = $this->getById($id);
        $kejuruan->update($data);
        return $kejuruan->fresh();
    }

    /**
     * Delete kejuruan
     */
    public function delete(string $id): bool
    {
        $kejuruan = $this->getById($id);
        return $kejuruan->delete();
    }

    /**
     * Register student to kejuruan
     */
    public function registerStudent(string $kejuruanId, array $data): KejuruanSiswaSMK
    {
        $data['kejuruan_id'] = $kejuruanId;
        $data['tanggal_daftar'] = now();
        $data['status'] = 'aktif';

        return $this->participationModel->create($data);
    }

    /**
     * Unregister student from kejuruan
     */
    public function unregisterStudent(string $kejuruanId, string $siswaId): bool
    {
        $participation = $this->participationModel->where('kejuruan_id', $kejuruanId)
            ->where('siswa_id', $siswaId)
            ->first();

        if ($participation) {
            $participation->update([
                'status' => 'keluar',
                'tanggal_keluar' => now()
            ]);
            return true;
        }

        return false;
    }

    /**
     * Get kejuruan students
     */
    public function getStudents(string $kejuruanId): Collection
    {
        return $this->participationModel->with('siswa')
            ->where('kejuruan_id', $kejuruanId)
            ->where('status', 'aktif')
            ->orderBy('tanggal_daftar')
            ->get();
    }

    /**
     * Get kejuruan statistics
     */
    public function getStatistics(): array
    {
        $total = $this->kejuruanModel->count();
        $aktif = $this->kejuruanModel->where('status', 'aktif')->count();
        $nonaktif = $this->kejuruanModel->where('status', 'nonaktif')->count();
        $ditutup = $this->kejuruanModel->where('status', 'ditutup')->count();

        // Statistics by status
        $statusStats = $this->kejuruanModel->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // Total participants across all kejuruan
        $totalPeserta = $this->participationModel->where('status', 'aktif')->count();

        // Average participants per kejuruan
        $avgPeserta = $aktif > 0 ? round($totalPeserta / $aktif, 2) : 0;

        // Most popular kejuruan
        $popular = $this->kejuruanModel->withCount(['siswa as total_peserta' => function ($query) {
            $query->where('status', 'aktif');
        }])
        ->orderBy('total_peserta', 'desc')
        ->limit(5)
        ->get();

        return [
            'total' => $total,
            'aktif' => $aktif,
            'nonaktif' => $nonaktif,
            'ditutup' => $ditutup,
            'status' => $statusStats,
            'total_peserta' => $totalPeserta,
            'avg_peserta_per_kejuruan' => $avgPeserta,
            'popular' => $popular,
            'persentase_aktif' => $total > 0 ? round(($aktif / $total) * 100, 2) : 0
        ];
    }

    /**
     * Get kejuruan by status
     */
    public function getByStatus(string $status): Collection
    {
        return $this->kejuruanModel->where('status', $status)
            ->with('siswa')
            ->orderBy('nama_kejuruan')
            ->get();
    }

    /**
     * Get active kejuruan
     */
    public function getActive(): Collection
    {
        return $this->getByStatus('aktif');
    }

    /**
     * Update student score in kejuruan
     */
    public function updateStudentScore(string $kejuruanId, string $siswaId, float $nilai): bool
    {
        $participation = $this->participationModel->where('kejuruan_id', $kejuruanId)
            ->where('siswa_id', $siswaId)
            ->first();

        if ($participation) {
            $participation->update(['nilai' => $nilai]);
            return true;
        }

        return false;
    }

    /**
     * Complete student participation
     */
    public function completeParticipation(string $kejuruanId, string $siswaId): bool
    {
        $participation = $this->participationModel->where('kejuruan_id', $kejuruanId)
            ->where('siswa_id', $siswaId)
            ->first();

        if ($participation) {
            $participation->update(['status' => 'selesai']);
            return true;
        }

        return false;
    }

    /**
     * Get student's kejuruan participation
     */
    public function getStudentParticipation(string $siswaId): Collection
    {
        return $this->participationModel->with('kejuruan')
            ->where('siswa_id', $siswaId)
            ->orderBy('tanggal_daftar', 'desc')
            ->get();
    }

    /**
     * Check if student can join kejuruan
     */
    public function canStudentJoin(string $kejuruanId, string $siswaId): array
    {
        $kejuruan = $this->getById($kejuruanId);
        
        // Check if kejuruan is active
        if (!$kejuruan->isActive()) {
            return ['can_join' => false, 'reason' => 'Kejuruan tidak aktif'];
        }

        // Check if kejuruan is full
        if ($kejuruan->isFull()) {
            return ['can_join' => false, 'reason' => 'Kejuruan sudah penuh'];
        }

        // Check if student is already participating
        $existingParticipation = $this->participationModel->where('kejuruan_id', $kejuruanId)
            ->where('siswa_id', $siswaId)
            ->where('status', 'aktif')
            ->first();

        if ($existingParticipation) {
            return ['can_join' => false, 'reason' => 'Siswa sudah terdaftar di kejuruan ini'];
        }

        return ['can_join' => true, 'reason' => 'Siswa dapat mendaftar'];
    }
}

