<?php

namespace App\Jenjang\SMA\Services;

use App\Jenjang\SMA\Models\SiswaSMA;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SiswaSMAService
{
    protected $siswaModel;

    public function __construct(SiswaSMA $siswaModel)
    {
        $this->siswaModel = $siswaModel;
    }

    /**
     * Get all SMA students with pagination and filters
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = $this->siswaModel->newQuery();

        // Apply filters
        if (isset($filters['kelas']) && $filters['kelas']) {
            $query->where('kelas', $filters['kelas']);
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get SMA student by ID
     */
    public function getById(string $id): SiswaSMA
    {
        return $this->siswaModel->findOrFail($id);
    }

    /**
     * Create new SMA student
     */
    public function create(array $data): SiswaSMA
    {
        return $this->siswaModel->create($data);
    }

    /**
     * Update SMA student
     */
    public function update(string $id, array $data): SiswaSMA
    {
        $siswa = $this->getById($id);
        $siswa->update($data);
        return $siswa->fresh();
    }

    /**
     * Delete SMA student
     */
    public function delete(string $id): bool
    {
        $siswa = $this->getById($id);
        return $siswa->delete();
    }

    /**
     * Get SMA students statistics
     */
    public function getStatistics(): array
    {
        $total = $this->siswaModel->count();
        $aktif = $this->siswaModel->where('status', 'aktif')->count();
        $lulus = $this->siswaModel->where('status', 'lulus')->count();
        $pindah = $this->siswaModel->where('status', 'pindah')->count();

        // Statistics by class
        $kelasStats = $this->siswaModel->selectRaw('kelas, COUNT(*) as total')
            ->where('status', 'aktif')
            ->groupBy('kelas')
            ->get()
            ->pluck('total', 'kelas');

        return [
            'total' => $total,
            'aktif' => $aktif,
            'lulus' => $lulus,
            'pindah' => $pindah,
            'kelas' => $kelasStats,
            'persentase_aktif' => $total > 0 ? round(($aktif / $total) * 100, 2) : 0
        ];
    }

    /**
     * Get SMA students by class
     */
    public function getByClass(string $kelas): Collection
    {
        return $this->siswaModel->where('kelas', $kelas)
            ->where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get();
    }

    /**
     * Get SMA students by status
     */
    public function getByStatus(string $status): Collection
    {
        return $this->siswaModel->where('status', $status)
            ->orderBy('nama_lengkap')
            ->get();
    }
}

