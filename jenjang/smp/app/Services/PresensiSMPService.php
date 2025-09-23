<?php

namespace App\Jenjang\SMP\Services;

use App\Jenjang\SMP\Models\PresensiSMP;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PresensiSMPService
{
    protected $presensiModel;

    public function __construct(PresensiSMP $presensiModel)
    {
        $this->presensiModel = $presensiModel;
    }

    /**
     * Get all SMP presensi with pagination and filters
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
    public function getById(string $id): PresensiSMP
    {
        return $this->presensiModel->with('siswa')->findOrFail($id);
    }

    /**
     * Create new presensi
     */
    public function create(array $data): PresensiSMP
    {
        return $this->presensiModel->create($data);
    }

    /**
     * Update presensi
     */
    public function update(string $id, array $data): PresensiSMP
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
        $kelasStats = $this->presensiModel->join('siswa_smp', 'presensi_smp.siswa_id', '=', 'siswa_smp.id')
            ->selectRaw('siswa_smp.kelas, COUNT(*) as total')
            ->where('presensi_smp.status', 'hadir')
            ->groupBy('siswa_smp.kelas')
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
        $query = $this->presensiModel->join('siswa_smp', 'presensi_smp.siswa_id', '=', 'siswa_smp.id')
            ->where('siswa_smp.kelas', $kelas)
            ->select('presensi_smp.*');

        if (isset($filters['tanggal_mulai']) && $filters['tanggal_mulai']) {
            $query->where('presensi_smp.tanggal', '>=', $filters['tanggal_mulai']);
        }

        if (isset($filters['tanggal_selesai']) && $filters['tanggal_selesai']) {
            $query->where('presensi_smp.tanggal', '<=', $filters['tanggal_selesai']);
        }

        return $query->orderBy('presensi_smp.tanggal', 'desc')->get();
    }

    /**
     * Get presensi by date
     */
    public function getByDate(string $tanggal): Collection
    {
        return $this->presensiModel->with('siswa')
            ->where('tanggal', $tanggal)
            ->orderBy('siswa_id')
            ->get();
    }

    /**
     * Get presensi by date range
     */
    public function getByDateRange(string $tanggalMulai, string $tanggalSelesai): Collection
    {
        return $this->presensiModel->with('siswa')
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    /**
     * Get attendance summary by class
     */
    public function getAttendanceSummaryByClass(string $kelas, string $tanggal): array
    {
        $siswa = \App\Jenjang\SMP\Models\SiswaSMP::where('kelas', $kelas)
            ->where('status', 'aktif')
            ->get();

        $presensi = $this->presensiModel->whereIn('siswa_id', $siswa->pluck('id'))
            ->where('tanggal', $tanggal)
            ->get()
            ->keyBy('siswa_id');

        $summary = [
            'total_siswa' => $siswa->count(),
            'hadir' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpha' => 0,
            'detail' => []
        ];

        foreach ($siswa as $s) {
            $p = $presensi->get($s->id);
            $status = $p ? $p->status : 'alpha';
            
            $summary[$status]++;
            $summary['detail'][] = [
                'siswa' => $s,
                'status' => $status,
                'keterangan' => $p ? $p->keterangan : null
            ];
        }

        return $summary;
    }
}

