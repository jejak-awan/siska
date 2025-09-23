<?php

namespace App\Jenjang\SMP\Services;

use App\Jenjang\SMP\Models\EkstrakurikulerSMP;
use App\Jenjang\SMP\Models\EkstrakurikulerSiswaSMP;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EkstrakurikulerSMPService
{
    protected $ekstrakurikulerModel;
    protected $participationModel;

    public function __construct(EkstrakurikulerSMP $ekstrakurikulerModel, EkstrakurikulerSiswaSMP $participationModel)
    {
        $this->ekstrakurikulerModel = $ekstrakurikulerModel;
        $this->participationModel = $participationModel;
    }

    /**
     * Get all SMP ekstrakurikuler with pagination and filters
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = $this->ekstrakurikulerModel->newQuery()->with('siswa');

        // Apply filters
        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama_ekstrakurikuler', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('pembina', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('nama_ekstrakurikuler')
                    ->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get ekstrakurikuler by ID
     */
    public function getById(string $id): EkstrakurikulerSMP
    {
        return $this->ekstrakurikulerModel->with(['siswa.siswa'])->findOrFail($id);
    }

    /**
     * Create new ekstrakurikuler
     */
    public function create(array $data): EkstrakurikulerSMP
    {
        return $this->ekstrakurikulerModel->create($data);
    }

    /**
     * Update ekstrakurikuler
     */
    public function update(string $id, array $data): EkstrakurikulerSMP
    {
        $ekstrakurikuler = $this->getById($id);
        $ekstrakurikuler->update($data);
        return $ekstrakurikuler->fresh();
    }

    /**
     * Delete ekstrakurikuler
     */
    public function delete(string $id): bool
    {
        $ekstrakurikuler = $this->getById($id);
        return $ekstrakurikuler->delete();
    }

    /**
     * Register student to ekstrakurikuler
     */
    public function registerStudent(string $ekstrakurikulerId, array $data): EkstrakurikulerSiswaSMP
    {
        $data['ekstrakurikuler_id'] = $ekstrakurikulerId;
        $data['tanggal_daftar'] = now();
        $data['status'] = 'aktif';

        return $this->participationModel->create($data);
    }

    /**
     * Unregister student from ekstrakurikuler
     */
    public function unregisterStudent(string $ekstrakurikulerId, string $siswaId): bool
    {
        $participation = $this->participationModel->where('ekstrakurikuler_id', $ekstrakurikulerId)
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
     * Get ekstrakurikuler students
     */
    public function getStudents(string $ekstrakurikulerId): Collection
    {
        return $this->participationModel->with('siswa')
            ->where('ekstrakurikuler_id', $ekstrakurikulerId)
            ->where('status', 'aktif')
            ->orderBy('tanggal_daftar')
            ->get();
    }

    /**
     * Get ekstrakurikuler statistics
     */
    public function getStatistics(): array
    {
        $total = $this->ekstrakurikulerModel->count();
        $aktif = $this->ekstrakurikulerModel->where('status', 'aktif')->count();
        $nonaktif = $this->ekstrakurikulerModel->where('status', 'nonaktif')->count();
        $ditutup = $this->ekstrakurikulerModel->where('status', 'ditutup')->count();

        // Statistics by status
        $statusStats = $this->ekstrakurikulerModel->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // Total participants across all ekstrakurikuler
        $totalPeserta = $this->participationModel->where('status', 'aktif')->count();

        // Average participants per ekstrakurikuler
        $avgPeserta = $aktif > 0 ? round($totalPeserta / $aktif, 2) : 0;

        // Most popular ekstrakurikuler
        $popular = $this->ekstrakurikulerModel->withCount(['siswa as total_peserta' => function ($query) {
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
            'avg_peserta_per_ekstrakurikuler' => $avgPeserta,
            'popular' => $popular,
            'persentase_aktif' => $total > 0 ? round(($aktif / $total) * 100, 2) : 0
        ];
    }

    /**
     * Get ekstrakurikuler by status
     */
    public function getByStatus(string $status): Collection
    {
        return $this->ekstrakurikulerModel->where('status', $status)
            ->with('siswa')
            ->orderBy('nama_ekstrakurikuler')
            ->get();
    }

    /**
     * Get active ekstrakurikuler
     */
    public function getActive(): Collection
    {
        return $this->getByStatus('aktif');
    }

    /**
     * Update student score in ekstrakurikuler
     */
    public function updateStudentScore(string $ekstrakurikulerId, string $siswaId, float $nilai): bool
    {
        $participation = $this->participationModel->where('ekstrakurikuler_id', $ekstrakurikulerId)
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
    public function completeParticipation(string $ekstrakurikulerId, string $siswaId): bool
    {
        $participation = $this->participationModel->where('ekstrakurikuler_id', $ekstrakurikulerId)
            ->where('siswa_id', $siswaId)
            ->first();

        if ($participation) {
            $participation->update(['status' => 'selesai']);
            return true;
        }

        return false;
    }

    /**
     * Get student's ekstrakurikuler participation
     */
    public function getStudentParticipation(string $siswaId): Collection
    {
        return $this->participationModel->with('ekstrakurikuler')
            ->where('siswa_id', $siswaId)
            ->orderBy('tanggal_daftar', 'desc')
            ->get();
    }

    /**
     * Check if student can join ekstrakurikuler
     */
    public function canStudentJoin(string $ekstrakurikulerId, string $siswaId): array
    {
        $ekstrakurikuler = $this->getById($ekstrakurikulerId);
        
        // Check if ekstrakurikuler is active
        if (!$ekstrakurikuler->isActive()) {
            return ['can_join' => false, 'reason' => 'Ekstrakurikuler tidak aktif'];
        }

        // Check if ekstrakurikuler is full
        if ($ekstrakurikuler->isFull()) {
            return ['can_join' => false, 'reason' => 'Ekstrakurikuler sudah penuh'];
        }

        // Check if student is already participating
        $existingParticipation = $this->participationModel->where('ekstrakurikuler_id', $ekstrakurikulerId)
            ->where('siswa_id', $siswaId)
            ->where('status', 'aktif')
            ->first();

        if ($existingParticipation) {
            return ['can_join' => false, 'reason' => 'Siswa sudah terdaftar di ekstrakurikuler ini'];
        }

        return ['can_join' => true, 'reason' => 'Siswa dapat mendaftar'];
    }
}

