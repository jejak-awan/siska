<?php

namespace App\Jenjang\SMA\Services;

use App\Jenjang\SMA\Models\PresensiSMA;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PresensiSMAService
{
    protected $presensiModel;

    public function __construct(PresensiSMA $presensiModel)
    {
        $this->presensiModel = $presensiModel;
    }

    /**
     * Get all SMA presensi with pagination and filters
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = $this->presensiModel->newQuery()->with('siswa');

        // Apply filters
        if (isset($filters['tanggal_mulai']) && $filters['tanggal_mulai']) {
            $query->where('tanggal', '>=', $filters['tanggal_mulai']);
        }

        if (isset($filters['tanggal_selesai']) && $filters['tanggal_selesai']) {
            $query->where('tanggal', '<=', $filters['tanggal_selesai']);
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['kelas']) && $filters['kelas']) {
            $query->whereHas('siswa', function ($q) use ($filters) {
                $q->where('kelas', $filters['kelas']);
            });
        }

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('tanggal', 'desc')
                    ->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get presensi by ID
     */
    public function getById(string $id): PresensiSMA
    {
        return $this->presensiModel->with('siswa')->findOrFail($id);
    }

    /**
     * Create new presensi
     */
    public function create(array $data): PresensiSMA
    {
        return $this->presensiModel->create($data);
    }

    /**
     * Update presensi
     */
    public function update(string $id, array $data): PresensiSMA
    {
        $presensi = $this->getById($id);
        $presensi->update($data);
        return $presensi->fresh();
    }

    /**
     * Delete presensi
     */
    public function delete(string $id): bool
    {
        $presensi = $this->getById($id);
        return $presensi->delete();
    }

    /**
     * Bulk create presensi
     */
    public function bulkCreate(array $data): array
    {
        $result = [
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];

        foreach ($data['presensi'] as $presensiData) {
            try {
                $this->create($presensiData);
                $result['success']++;
            } catch (\Exception $e) {
                $result['failed']++;
                $result['errors'][] = [
                    'data' => $presensiData,
                    'error' => $e->getMessage()
                ];
            }
        }

        return $result;
    }

    /**
     * Get presensi statistics
     */
    public function getStatistics(): array
    {
        $total = $this->presensiModel->count();
        $hadir = $this->presensiModel->where('status', 'hadir')->count();
        $izin = $this->presensiModel->where('status', 'izin')->count();
        $sakit = $this->presensiModel->where('status', 'sakit')->count();
        $alpha = $this->presensiModel->where('status', 'alpha')->count();

        // Statistics by class
        $kelasStats = $this->presensiModel->join('siswa_sma', 'presensi_sma.siswa_id', '=', 'siswa_sma.id')
            ->selectRaw('siswa_sma.kelas, COUNT(*) as total')
            ->where('presensi_sma.status', 'hadir')
            ->groupBy('siswa_sma.kelas')
            ->get()
            ->pluck('total', 'kelas');

        // Statistics by month
        $bulanStats = $this->presensiModel->selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', date('Y'))
            ->groupBy('bulan')
            ->get()
            ->pluck('total', 'bulan');

        return [
            'total' => $total,
            'hadir' => $hadir,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpha' => $alpha,
            'kelas' => $kelasStats,
            'bulan' => $bulanStats,
            'persentase_hadir' => $total > 0 ? round(($hadir / $total) * 100, 2) : 0
        ];
    }

    /**
     * Get presensi by student
     */
    public function getByStudent(string $siswaId, array $filters = []): Collection
    {
        $query = $this->presensiModel->where('siswa_id', $siswaId);

        if (isset($filters['tanggal_mulai']) && $filters['tanggal_mulai']) {
            $query->where('tanggal', '>=', $filters['tanggal_mulai']);
        }

        if (isset($filters['tanggal_selesai']) && $filters['tanggal_selesai']) {
            $query->where('tanggal', '<=', $filters['tanggal_selesai']);
        }

        return $query->orderBy('tanggal', 'desc')->get();
    }

    /**
     * Get presensi by class
     */
    public function getByClass(string $kelas, array $filters = []): Collection
    {
        $query = $this->presensiModel->join('siswa_sma', 'presensi_sma.siswa_id', '=', 'siswa_sma.id')
            ->where('siswa_sma.kelas', $kelas)
            ->select('presensi_sma.*');

        if (isset($filters['tanggal_mulai']) && $filters['tanggal_mulai']) {
            $query->where('presensi_sma.tanggal', '>=', $filters['tanggal_mulai']);
        }

        if (isset($filters['tanggal_selesai']) && $filters['tanggal_selesai']) {
            $query->where('presensi_sma.tanggal', '<=', $filters['tanggal_selesai']);
        }

        return $query->orderBy('presensi_sma.tanggal', 'desc')->get();
    }
}

