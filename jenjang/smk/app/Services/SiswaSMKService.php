<?php

namespace App\Jenjang\SMK\Services;

use App\Jenjang\SMK\Models\SiswaSMK;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SiswaSMKService
{
    protected $siswaModel;

    public function __construct(SiswaSMK $siswaModel)
    {
        $this->siswaModel = $siswaModel;
    }

    /**
     * Get all SMK students with pagination and filters
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = $this->siswaModel->newQuery()->with('user');

        // Apply filters
        if (isset($filters['kelas']) && $filters['kelas']) {
            $query->where('kelas', $filters['kelas']);
        }

        if (isset($filters['jurusan']) && $filters['jurusan']) {
            $query->where('jurusan', $filters['jurusan']);
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['jenis_kelamin']) && $filters['jenis_kelamin']) {
            $query->where('jenis_kelamin', $filters['jenis_kelamin']);
        }

        if (isset($filters['tahun_masuk']) && $filters['tahun_masuk']) {
            $query->where('tahun_masuk', $filters['tahun_masuk']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('nama_lengkap')
                    ->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get student by ID
     */
    public function getById(string $id): SiswaSMK
    {
        return $this->siswaModel->with(['user', 'presensi', 'kejuruan', 'programKesiswaan'])->findOrFail($id);
    }

    /**
     * Create new student
     */
    public function create(array $data): SiswaSMK
    {
        return $this->siswaModel->create($data);
    }

    /**
     * Update student
     */
    public function update(string $id, array $data): SiswaSMK
    {
        $siswa = $this->getById($id);
        $siswa->update($data);
        return $siswa->fresh();
    }

    /**
     * Delete student
     */
    public function delete(string $id): bool
    {
        $siswa = $this->getById($id);
        return $siswa->delete();
    }

    /**
     * Get student statistics
     */
    public function getStatistics(): array
    {
        $total = $this->siswaModel->count();
        $aktif = $this->siswaModel->where('status', 'aktif')->count();
        $lulus = $this->siswaModel->where('status', 'lulus')->count();
        $pindah = $this->siswaModel->where('status', 'pindah')->count();
        $nonaktif = $this->siswaModel->where('status', 'nonaktif')->count();

        // Statistics by class
        $kelasStats = $this->siswaModel->selectRaw('kelas, COUNT(*) as total')
            ->where('status', 'aktif')
            ->groupBy('kelas')
            ->orderBy('kelas')
            ->get()
            ->pluck('total', 'kelas');

        // Statistics by jurusan
        $jurusanStats = $this->siswaModel->selectRaw('jurusan, COUNT(*) as total')
            ->where('status', 'aktif')
            ->groupBy('jurusan')
            ->orderBy('jurusan')
            ->get()
            ->pluck('total', 'jurusan');

        // Statistics by gender
        $genderStats = $this->siswaModel->selectRaw('jenis_kelamin, COUNT(*) as total')
            ->where('status', 'aktif')
            ->groupBy('jenis_kelamin')
            ->get()
            ->pluck('total', 'jenis_kelamin');

        // Statistics by entry year
        $tahunStats = $this->siswaModel->selectRaw('tahun_masuk, COUNT(*) as total')
            ->groupBy('tahun_masuk')
            ->orderBy('tahun_masuk', 'desc')
            ->get()
            ->pluck('total', 'tahun_masuk');

        return [
            'total' => $total,
            'aktif' => $aktif,
            'lulus' => $lulus,
            'pindah' => $pindah,
            'nonaktif' => $nonaktif,
            'kelas' => $kelasStats,
            'jurusan' => $jurusanStats,
            'jenis_kelamin' => $genderStats,
            'tahun_masuk' => $tahunStats,
            'persentase_aktif' => $total > 0 ? round(($aktif / $total) * 100, 2) : 0
        ];
    }

    /**
     * Get students by class
     */
    public function getByClass(string $kelas): Collection
    {
        return $this->siswaModel->where('kelas', $kelas)
            ->where('status', 'aktif')
            ->with('user')
            ->orderBy('nama_lengkap')
            ->get();
    }

    /**
     * Get students by jurusan
     */
    public function getByJurusan(string $jurusan): Collection
    {
        return $this->siswaModel->where('jurusan', $jurusan)
            ->where('status', 'aktif')
            ->with('user')
            ->orderBy('nama_lengkap')
            ->get();
    }

    /**
     * Get students by status
     */
    public function getByStatus(string $status): Collection
    {
        return $this->siswaModel->where('status', $status)
            ->with('user')
            ->orderBy('nama_lengkap')
            ->get();
    }

    /**
     * Get active students
     */
    public function getActive(): Collection
    {
        return $this->getByStatus('aktif');
    }

    /**
     * Get students by entry year
     */
    public function getByEntryYear(int $tahun): Collection
    {
        return $this->siswaModel->where('tahun_masuk', $tahun)
            ->with('user')
            ->orderBy('nama_lengkap')
            ->get();
    }

    /**
     * Search students
     */
    public function search(string $keyword): Collection
    {
        return $this->siswaModel->where(function ($q) use ($keyword) {
            $q->where('nama_lengkap', 'like', "%{$keyword}%")
              ->orWhere('nis', 'like', "%{$keyword}%")
              ->orWhere('nisn', 'like', "%{$keyword}%");
        })
        ->with('user')
        ->orderBy('nama_lengkap')
        ->get();
    }

    /**
     * Get student's kejuruan activities
     */
    public function getKejuruan(string $siswaId): Collection
    {
        $siswa = $this->getById($siswaId);
        return $siswa->kejuruan()->with('kejuruan')->get();
    }

    /**
     * Get student's programs
     */
    public function getPrograms(string $siswaId): Collection
    {
        $siswa = $this->getById($siswaId);
        return $siswa->programKesiswaan()->with('program')->get();
    }

    /**
     * Get student's attendance records
     */
    public function getPresensi(string $siswaId, array $filters = []): Collection
    {
        $query = $this->siswaModel->findOrFail($siswaId)->presensi();

        if (isset($filters['tanggal_mulai']) && $filters['tanggal_mulai']) {
            $query->where('tanggal', '>=', $filters['tanggal_mulai']);
        }

        if (isset($filters['tanggal_selesai']) && $filters['tanggal_selesai']) {
            $query->where('tanggal', '<=', $filters['tanggal_selesai']);
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('tanggal', 'desc')->get();
    }

    /**
     * Get student's attendance statistics
     */
    public function getPresensiStatistics(string $siswaId): array
    {
        $presensi = $this->siswaModel->findOrFail($siswaId)->presensi();
        
        $total = $presensi->count();
        $hadir = $presensi->where('status', 'hadir')->count();
        $izin = $presensi->where('status', 'izin')->count();
        $sakit = $presensi->where('status', 'sakit')->count();
        $alpha = $presensi->where('status', 'alpha')->count();

        return [
            'total' => $total,
            'hadir' => $hadir,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpha' => $alpha,
            'persentase_hadir' => $total > 0 ? round(($hadir / $total) * 100, 2) : 0
        ];
    }
}

