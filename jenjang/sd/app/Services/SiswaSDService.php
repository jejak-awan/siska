<?php

namespace App\Jenjang\SD\Services;

use App\Jenjang\SD\Models\SiswaSD;
use App\Jenjang\SD\Models\UserSD;
use App\Jenjang\SD\Models\PresensiSD;
use App\Jenjang\SD\Models\KreditPoinSD;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaSDService
{
    /**
     * Get all students with filters
     */
    public function getAllStudents(array $filters = [])
    {
        $query = SiswaSD::with('user');

        if (isset($filters['kelas'])) {
            $query->where('kelas', $filters['kelas']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Create new student
     */
    public function createStudent(array $data)
    {
        DB::connection('sd')->beginTransaction();

        try {
            // Create user
            $user = UserSD::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'jenis_user' => 'siswa',
                'status' => 'active',
            ]);

            // Create student
            $siswa = SiswaSD::create([
                'id_user' => $user->id,
                'nis' => $data['nis'],
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'kelas' => $data['kelas'],
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
                'alamat' => $data['alamat'] ?? null,
                'telepon' => $data['telepon'] ?? null,
                'nama_orang_tua' => $data['nama_orang_tua'] ?? null,
                'telepon_orang_tua' => $data['telepon_orang_tua'] ?? null,
                'status' => 'active',
            ]);

            DB::connection('sd')->commit();

            return $siswa->load('user');

        } catch (\Exception $e) {
            DB::connection('sd')->rollback();
            throw $e;
        }
    }

    /**
     * Update student
     */
    public function updateStudent(SiswaSD $siswa, array $data)
    {
        DB::connection('sd')->beginTransaction();

        try {
            // Update user if needed
            if (isset($data['nama']) || isset($data['email']) || isset($data['password'])) {
                $userData = [];
                if (isset($data['nama'])) $userData['nama'] = $data['nama'];
                if (isset($data['email'])) $userData['email'] = $data['email'];
                if (isset($data['password'])) $userData['password'] = Hash::make($data['password']);

                $siswa->user->update($userData);
            }

            // Update student
            $siswaData = array_intersect_key($data, array_flip([
                'nama', 'nis', 'nisn', 'kelas', 'tanggal_lahir',
                'jenis_kelamin', 'alamat', 'telepon', 'nama_orang_tua',
                'telepon_orang_tua', 'status'
            ]));

            $siswa->update($siswaData);

            DB::connection('sd')->commit();

            return $siswa->load('user');

        } catch (\Exception $e) {
            DB::connection('sd')->rollback();
            throw $e;
        }
    }

    /**
     * Delete student
     */
    public function deleteStudent(SiswaSD $siswa)
    {
        DB::connection('sd')->beginTransaction();

        try {
            // Delete related data
            $siswa->presensi()->delete();
            $siswa->kreditPoin()->delete();
            $siswa->penilaianKarakter()->delete();

            // Delete student
            $siswa->delete();

            // Delete user
            $siswa->user->delete();

            DB::connection('sd')->commit();

            return true;

        } catch (\Exception $e) {
            DB::connection('sd')->rollback();
            throw $e;
        }
    }

    /**
     * Get student statistics
     */
    public function getStatistics()
    {
        return [
            'total_siswa' => SiswaSD::count(),
            'siswa_aktif' => SiswaSD::where('status', 'active')->count(),
            'siswa_per_kelas' => SiswaSD::selectRaw('kelas, COUNT(*) as jumlah')
                ->where('status', 'active')
                ->groupBy('kelas')
                ->get(),
            'siswa_per_jenis_kelamin' => SiswaSD::selectRaw('jenis_kelamin, COUNT(*) as jumlah')
                ->where('status', 'active')
                ->groupBy('jenis_kelamin')
                ->get(),
        ];
    }

    /**
     * Get student attendance summary
     */
    public function getAttendanceSummary(SiswaSD $siswa, $semester = null, $tahunAkademik = null)
    {
        $query = $siswa->presensi();

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
     * Get student credit points summary
     */
    public function getCreditPointsSummary(SiswaSD $siswa, $semester = null, $tahunAkademik = null)
    {
        $query = $siswa->kreditPoin();

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
}
