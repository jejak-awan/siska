<?php

namespace App\Jenjang\SMA\Services;

use App\Jenjang\SMA\Models\KreditPoinSMA;
use App\Jenjang\SMA\Models\SiswaSMA;
use Illuminate\Support\Facades\DB;

class KreditPoinSMAService
{
    /**
     * Get all credit points with filters
     */
    public function getAllCreditPoints(array $filters = [])
    {
        $query = KreditPoinSMA::with(['siswa.user', 'pemberiPoin']);

        if (isset($filters['kategori'])) {
            $query->where('kategori', $filters['kategori']);
        }

        if (isset($filters['semester'])) {
            $query->where('semester', $filters['semester']);
        }

        if (isset($filters['tahun_akademik'])) {
            $query->where('tahun_akademik', $filters['tahun_akademik']);
        }

        if (isset($filters['id_siswa'])) {
            $query->where('id_siswa', $filters['id_siswa']);
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Create credit point
     */
    public function createCreditPoint(array $data)
    {
        return KreditPoinSMA::create($data);
    }

    /**
     * Update credit point
     */
    public function updateCreditPoint(KreditPoinSMA $kreditPoin, array $data)
    {
        $allowedFields = ['kategori', 'poin', 'deskripsi', 'tanggal'];
        $updateData = array_intersect_key($data, array_flip($allowedFields));

        $kreditPoin->update($updateData);

        return $kreditPoin->load(['siswa.user', 'pemberiPoin']);
    }

    /**
     * Delete credit point
     */
    public function deleteCreditPoint(KreditPoinSMA $kreditPoin)
    {
        return $kreditPoin->delete();
    }

    /**
     * Get credit points statistics
     */
    public function getStatistics(array $filters = [])
    {
        $query = KreditPoinSMA::query();

        if (isset($filters['semester'])) {
            $query->where('semester', $filters['semester']);
        }

        if (isset($filters['tahun_akademik'])) {
            $query->where('tahun_akademik', $filters['tahun_akademik']);
        }

        $totalPoinPositif = $query->clone()->where('kategori', 'positif')->sum('poin');
        $totalPoinNegatif = $query->clone()->where('kategori', 'negatif')->sum('poin');
        $jumlahPoinPositif = $query->clone()->where('kategori', 'positif')->count();
        $jumlahPoinNegatif = $query->clone()->where('kategori', 'negatif')->count();

        return [
            'total_poin_positif' => $totalPoinPositif,
            'total_poin_negatif' => $totalPoinNegatif,
            'jumlah_poin_positif' => $jumlahPoinPositif,
            'jumlah_poin_negatif' => $jumlahPoinNegatif,
            'siswa_terbaik' => $this->getTopStudents($query->clone()),
        ];
    }

    /**
     * Get top students by credit points
     */
    private function getTopStudents($query)
    {
        return $query->selectRaw('id_siswa, SUM(CASE WHEN kategori = "positif" THEN poin ELSE -poin END) as total_poin')
            ->with('siswa.user')
            ->groupBy('id_siswa')
            ->orderBy('total_poin', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get student credit points summary
     */
    public function getStudentCreditPointsSummary($idSiswa, $semester = null, $tahunAkademik = null)
    {
        $query = KreditPoinSMA::where('id_siswa', $idSiswa);

        if ($semester) {
            $query->where('semester', $semester);
        }

        if ($tahunAkademik) {
            $query->where('tahun_akademik', $tahunAkademik);
        }

        $kreditPoin = $query->get();

        return [
            'total_poin_positif' => $kreditPoin->where('kategori', 'positif')->sum('poin'),
            'total_poin_negatif' => $kreditPoin->where('kategori', 'negatif')->sum('poin'),
            'total_poin' => $kreditPoin->where('kategori', 'positif')->sum('poin') - $kreditPoin->where('kategori', 'negatif')->sum('poin'),
            'jumlah_poin_positif' => $kreditPoin->where('kategori', 'positif')->count(),
            'jumlah_poin_negatif' => $kreditPoin->where('kategori', 'negatif')->count(),
        ];
    }

    /**
     * Get monthly credit points report
     */
    public function getMonthlyReport($bulan, $tahun, $kelas = null)
    {
        $query = KreditPoinSMA::with('siswa')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan);

        if ($kelas) {
            $query->whereHas('siswa', function ($q) use ($kelas) {
                $q->where('kelas', $kelas);
            });
        }

        $kreditPoin = $query->get();

        $report = [];
        foreach ($kreditPoin as $kp) {
            $siswaId = $kp->id_siswa;
            $siswaNama = $kp->siswa->nama;
            
            if (!isset($report[$siswaId])) {
                $report[$siswaId] = [
                    'nama' => $siswaNama,
                    'kelas' => $kp->siswa->kelas,
                    'poin_positif' => 0,
                    'poin_negatif' => 0,
                    'total_poin' => 0,
                ];
            }

            if ($kp->kategori === 'positif') {
                $report[$siswaId]['poin_positif'] += $kp->poin;
            } else {
                $report[$siswaId]['poin_negatif'] += $kp->poin;
            }
            
            $report[$siswaId]['total_poin'] = $report[$siswaId]['poin_positif'] - $report[$siswaId]['poin_negatif'];
        }

        return array_values($report);
    }
}
