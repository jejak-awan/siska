<?php

namespace App\Jenjang\SMA\Services;

use App\Jenjang\SMA\Models\PresensiSMA;
use App\Jenjang\SMA\Models\SiswaSMA;
use Illuminate\Support\Facades\DB;

class PresensiSMAService
{
    /**
     * Get all attendance records with filters
     */
    public function getAllAttendance(array $filters = [])
    {
        $query = PresensiSMA::with('siswa.user');

        if (isset($filters['tanggal'])) {
            $query->where('tanggal', $filters['tanggal']);
        }

        if (isset($filters['semester'])) {
            $query->where('semester', $filters['semester']);
        }

        if (isset($filters['tahun_akademik'])) {
            $query->where('tahun_akademik', $filters['tahun_akademik']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['kelas'])) {
            $query->whereHas('siswa', function ($q) use ($filters) {
                $q->where('kelas', $filters['kelas']);
            });
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Create attendance record
     */
    public function createAttendance(array $data)
    {
        // Check if attendance already exists
        $existingPresensi = PresensiSMA::where('id_siswa', $data['id_siswa'])
            ->where('tanggal', $data['tanggal'])
            ->first();

        if ($existingPresensi) {
            throw new \Exception('Presensi untuk siswa ini pada tanggal tersebut sudah ada');
        }

        return PresensiSMA::create($data);
    }

    /**
     * Update attendance record
     */
    public function updateAttendance(PresensiSMA $presensi, array $data)
    {
        $allowedFields = ['jam_masuk', 'jam_keluar', 'status', 'keterangan'];
        $updateData = array_intersect_key($data, array_flip($allowedFields));

        $presensi->update($updateData);

        return $presensi->load('siswa.user');
    }

    /**
     * Delete attendance record
     */
    public function deleteAttendance(PresensiSMA $presensi)
    {
        return $presensi->delete();
    }

    /**
     * Bulk create attendance for a class
     */
    public function bulkCreateAttendance(array $data)
    {
        DB::connection('sd')->beginTransaction();

        try {
            $createdPresensi = [];

            foreach ($data['presensi_data'] as $presensiData) {
                // Check if attendance already exists
                $existingPresensi = PresensiSMA::where('id_siswa', $presensiData['id_siswa'])
                    ->where('tanggal', $data['tanggal'])
                    ->first();

                if (!$existingPresensi) {
                    $presensi = PresensiSMA::create([
                        'id_siswa' => $presensiData['id_siswa'],
                        'tanggal' => $data['tanggal'],
                        'jam_masuk' => $presensiData['jam_masuk'] ?? null,
                        'status' => $presensiData['status'],
                        'keterangan' => $presensiData['keterangan'] ?? null,
                        'semester' => $data['semester'],
                        'tahun_akademik' => $data['tahun_akademik'],
                    ]);

                    $createdPresensi[] = $presensi->load('siswa.user');
                }
            }

            DB::connection('sd')->commit();

            return $createdPresensi;

        } catch (\Exception $e) {
            DB::connection('sd')->rollback();
            throw $e;
        }
    }

    /**
     * Get attendance statistics
     */
    public function getStatistics(array $filters = [])
    {
        $query = PresensiSMA::query();

        if (isset($filters['semester'])) {
            $query->where('semester', $filters['semester']);
        }

        if (isset($filters['tahun_akademik'])) {
            $query->where('tahun_akademik', $filters['tahun_akademik']);
        }

        $totalPresensi = $query->count();
        $hadir = $query->clone()->where('status', 'hadir')->count();
        $izin = $query->clone()->where('status', 'izin')->count();
        $sakit = $query->clone()->where('status', 'sakit')->count();
        $alpa = $query->clone()->where('status', 'alpa')->count();

        return [
            'total_presensi' => $totalPresensi,
            'hadir' => $hadir,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpa' => $alpa,
            'persentase_kehadiran' => $totalPresensi > 0 ? round(($hadir / $totalPresensi) * 100, 2) : 0,
        ];
    }

    /**
     * Get attendance by class and date
     */
    public function getAttendanceByClassAndDate($kelas, $tanggal)
    {
        return PresensiSMA::with('siswa.user')
            ->whereHas('siswa', function ($query) use ($kelas) {
                $query->where('kelas', $kelas);
            })
            ->where('tanggal', $tanggal)
            ->get();
    }

    /**
     * Get student attendance summary
     */
    public function getStudentAttendanceSummary($idSiswa, $semester = null, $tahunAkademik = null)
    {
        $query = PresensiSMA::where('id_siswa', $idSiswa);

        if ($semester) {
            $query->where('semester', $semester);
        }

        if ($tahunAkademik) {
            $query->where('tahun_akademik', $tahunAkademik);
        }

        $presensi = $query->get();

        return [
            'total_hari' => $presensi->count(),
            'hadir' => $presensi->where('status', 'hadir')->count(),
            'izin' => $presensi->where('status', 'izin')->count(),
            'sakit' => $presensi->where('status', 'sakit')->count(),
            'alpa' => $presensi->where('status', 'alpa')->count(),
            'persentase_kehadiran' => $presensi->count() > 0 
                ? round(($presensi->where('status', 'hadir')->count() / $presensi->count()) * 100, 2)
                : 0,
        ];
    }

    /**
     * Get monthly attendance report
     */
    public function getMonthlyReport($bulan, $tahun, $kelas = null)
    {
        $query = PresensiSMA::with('siswa')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan);

        if ($kelas) {
            $query->whereHas('siswa', function ($q) use ($kelas) {
                $q->where('kelas', $kelas);
            });
        }

        $presensi = $query->get();

        $report = [];
        foreach ($presensi as $p) {
            $siswaId = $p->id_siswa;
            $siswaNama = $p->siswa->nama;
            
            if (!isset($report[$siswaId])) {
                $report[$siswaId] = [
                    'nama' => $siswaNama,
                    'kelas' => $p->siswa->kelas,
                    'hadir' => 0,
                    'izin' => 0,
                    'sakit' => 0,
                    'alpa' => 0,
                ];
            }

            $report[$siswaId][$p->status]++;
        }

        return array_values($report);
    }
}
