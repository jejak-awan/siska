<?php

namespace App\Jenjang\SMK\Services;

use App\Jenjang\SMK\Models\PresensiSMK;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PresensiSMKService
{
    protected $presensiModel;

    public function __construct(PresensiSMK $presensiModel)
    {
        $this->presensiModel = $presensiModel;
    }

    /**
     * Get all SMK presensi with pagination and filters
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

        if (isset($filters['jurusan']) && $filters['jurusan']) {
            $query->whereHas('siswa', function ($q) use ($filters) {
                $q->where('jurusan', $filters['jurusan']);
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
    public function getById(string $id): PresensiSMK
    {
        return $this->presensiModel->with('siswa')->findOrFail($id);
    }

    /**
     * Create new presensi
     */
    public function create(array $data): PresensiSMK
    {
        return $this->presensiModel->create($data);
    }

    /**
     * Update presensi
     */
    public function update(string $id, array $data): PresensiSMK
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
        $kelasStats = $this->presensiModel->join('siswa_smk', 'presensi_smk.siswa_id', '=', 'siswa_smk.id')
            ->selectRaw('siswa_smk.kelas, COUNT(*) as total')
            ->where('presensi_smk.status', 'hadir')
            ->groupBy('siswa_smk.kelas')
            ->get()
            ->pluck('total', 'kelas');

        // Statistics by jurusan
        $jurusanStats = $this->presensiModel->join('siswa_smk', 'presensi_smk.siswa_id', '=', 'siswa_smk.id')
            ->selectRaw('siswa_smk.jurusan, COUNT(*) as total')
            ->where('presensi_smk.status', 'hadir')
            ->groupBy('siswa_smk.jurusan')
            ->get()
            ->pluck('total', 'jurusan');

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
            'jurusan' => $jurusanStats,
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
        $query = $this->presensiModel->join('siswa_smk', 'presensi_smk.siswa_id', '=', 'siswa_smk.id')
            ->where('siswa_smk.kelas', $kelas)
            ->select('presensi_smk.*');

        if (isset($filters['tanggal_mulai']) && $filters['tanggal_mulai']) {
            $query->where('presensi_smk.tanggal', '>=', $filters['tanggal_mulai']);
        }

        if (isset($filters['tanggal_selesai']) && $filters['tanggal_selesai']) {
            $query->where('presensi_smk.tanggal', '<=', $filters['tanggal_selesai']);
        }

        return $query->orderBy('presensi_smk.tanggal', 'desc')->get();
    }

    /**
     * Get presensi by jurusan
     */
    public function getByJurusan(string $jurusan, array $filters = []): Collection
    {
        $query = $this->presensiModel->join('siswa_smk', 'presensi_smk.siswa_id', '=', 'siswa_smk.id')
            ->where('siswa_smk.jurusan', $jurusan)
            ->select('presensi_smk.*');

        if (isset($filters['tanggal_mulai']) && $filters['tanggal_mulai']) {
            $query->where('presensi_smk.tanggal', '>=', $filters['tanggal_mulai']);
        }

        if (isset($filters['tanggal_selesai']) && $filters['tanggal_selesai']) {
            $query->where('presensi_smk.tanggal', '<=', $filters['tanggal_selesai']);
        }

        return $query->orderBy('presensi_smk.tanggal', 'desc')->get();
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
        $siswa = \App\Jenjang\SMK\Models\SiswaSMK::where('kelas', $kelas)
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

    /**
     * Get attendance summary by jurusan
     */
    public function getAttendanceSummaryByJurusan(string $jurusan, string $tanggal): array
    {
        $siswa = \App\Jenjang\SMK\Models\SiswaSMK::where('jurusan', $jurusan)
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

