<?php

namespace App\Jenjang\SMA\Services;

use App\Jenjang\SMA\Models\ProgramKesiswaanSMA;
use App\Jenjang\SMA\Models\PenilaianKarakterSMA;
use Illuminate\Support\Facades\DB;

class ProgramKesiswaanSMAService
{
    /**
     * Get all programs with filters
     */
    public function getAllPrograms(array $filters = [])
    {
        $query = ProgramKesiswaanSMA::with('penanggungJawab');

        if (isset($filters['kategori'])) {
            $query->where('kategori', $filters['kategori']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['search'])) {
            $query->where('nama_program', 'like', "%{$filters['search']}%");
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Create program
     */
    public function createProgram(array $data)
    {
        return ProgramKesiswaanSMA::create($data);
    }

    /**
     * Update program
     */
    public function updateProgram(ProgramKesiswaanSMA $program, array $data)
    {
        $program->update($data);
        return $program->load('penanggungJawab');
    }

    /**
     * Delete program
     */
    public function deleteProgram(ProgramKesiswaanSMA $program)
    {
        // Check if there are related penilaian karakter
        $relatedPenilaian = $program->penilaianKarakter()->count();

        if ($relatedPenilaian > 0) {
            throw new \Exception('Tidak dapat menghapus program yang masih memiliki penilaian karakter');
        }

        return $program->delete();
    }

    /**
     * Get program statistics
     */
    public function getStatistics()
    {
        return [
            'total_program' => ProgramKesiswaanSMA::count(),
            'program_aktif' => ProgramKesiswaanSMA::where('status', 'active')->count(),
            'program_selesai' => ProgramKesiswaanSMA::where('status', 'completed')->count(),
            'program_per_kategori' => ProgramKesiswaanSMA::selectRaw('kategori, COUNT(*) as jumlah')
                ->where('status', 'active')
                ->groupBy('kategori')
                ->get(),
        ];
    }

    /**
     * Get program participants
     */
    public function getParticipants(ProgramKesiswaanSMA $program)
    {
        $participants = $program->penilaianKarakter()
            ->with('siswa.user')
            ->get()
            ->groupBy('id_siswa')
            ->map(function ($penilaian) {
                $siswa = $penilaian->first()->siswa;
                return [
                    'id' => $siswa->id,
                    'nama' => $siswa->nama,
                    'kelas' => $siswa->kelas,
                    'jumlah_penilaian' => $penilaian->count(),
                    'penilaian_terakhir' => $penilaian->max('tanggal_penilaian'),
                ];
            })
            ->values();

        return $participants;
    }

    /**
     * Get program progress
     */
    public function getProgramProgress(ProgramKesiswaanSMA $program)
    {
        $totalTargetSiswa = count($program->target_siswa ?? []);
        $totalParticipants = $program->penilaianKarakter()
            ->distinct('id_siswa')
            ->count();

        return [
            'total_target_siswa' => $totalTargetSiswa,
            'total_participants' => $totalParticipants,
            'progress_percentage' => $totalTargetSiswa > 0 ? round(($totalParticipants / $totalTargetSiswa) * 100, 2) : 0,
            'status' => $program->status,
        ];
    }

    /**
     * Get program evaluation
     */
    public function getProgramEvaluation(ProgramKesiswaanSMA $program)
    {
        $penilaian = $program->penilaianKarakter()->get();

        $evaluation = [
            'total_penilaian' => $penilaian->count(),
            'rata_rata_nilai' => $penilaian->avg('nilai_karakter'),
            'distribusi_nilai' => $penilaian->groupBy('nilai_karakter')->map->count(),
            'aspek_karakter' => $penilaian->groupBy('aspek_karakter')->map(function ($group) {
                return [
                    'jumlah' => $group->count(),
                    'rata_rata' => $group->avg('nilai_karakter'),
                ];
            }),
        ];

        return $evaluation;
    }
}
