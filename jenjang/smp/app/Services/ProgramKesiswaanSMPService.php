<?php

namespace App\Jenjang\SMP\Services;

use App\Jenjang\SMP\Models\ProgramKesiswaanSMP;
use App\Jenjang\SMP\Models\ProgramPesertaSMP;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProgramKesiswaanSMPService
{
    protected $programModel;
    protected $pesertaModel;

    public function __construct(ProgramKesiswaanSMP $programModel, ProgramPesertaSMP $pesertaModel)
    {
        $this->programModel = $programModel;
        $this->pesertaModel = $pesertaModel;
    }

    /**
     * Get all SMP programs with pagination and filters
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = $this->programModel->newQuery()->with('peserta');

        // Apply filters
        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['tanggal_mulai']) && $filters['tanggal_mulai']) {
            $query->where('tanggal_mulai', '>=', $filters['tanggal_mulai']);
        }

        if (isset($filters['tanggal_selesai']) && $filters['tanggal_selesai']) {
            $query->where('tanggal_selesai', '<=', $filters['tanggal_selesai']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama_program', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('penanggung_jawab', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('tanggal_mulai', 'desc')
                    ->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get program by ID
     */
    public function getById(string $id): ProgramKesiswaanSMP
    {
        return $this->programModel->with('peserta.siswa')->findOrFail($id);
    }

    /**
     * Create new program
     */
    public function create(array $data): ProgramKesiswaanSMP
    {
        return $this->programModel->create($data);
    }

    /**
     * Update program
     */
    public function update(string $id, array $data): ProgramKesiswaanSMP
    {
        $program = $this->getById($id);
        $program->update($data);
        return $program->fresh();
    }

    /**
     * Delete program
     */
    public function delete(string $id): bool
    {
        $program = $this->getById($id);
        return $program->delete();
    }

    /**
     * Add participant to program
     */
    public function addParticipant(string $programId, array $data): ProgramPesertaSMP
    {
        $data['program_id'] = $programId;
        $data['tanggal_daftar'] = now();
        $data['status'] = 'aktif';

        return $this->pesertaModel->create($data);
    }

    /**
     * Remove participant from program
     */
    public function removeParticipant(string $programId, string $siswaId): bool
    {
        $peserta = $this->pesertaModel->where('program_id', $programId)
            ->where('siswa_id', $siswaId)
            ->first();

        if ($peserta) {
            $peserta->update(['status' => 'keluar']);
            return true;
        }

        return false;
    }

    /**
     * Get program participants
     */
    public function getParticipants(string $programId): Collection
    {
        return $this->pesertaModel->with('siswa')
            ->where('program_id', $programId)
            ->where('status', 'aktif')
            ->orderBy('tanggal_daftar')
            ->get();
    }

    /**
     * Get program statistics
     */
    public function getStatistics(): array
    {
        $total = $this->programModel->count();
        $aktif = $this->programModel->where('status', 'aktif')->count();
        $selesai = $this->programModel->where('status', 'selesai')->count();
        $ditunda = $this->programModel->where('status', 'ditunda')->count();
        $dibatalkan = $this->programModel->where('status', 'dibatalkan')->count();

        // Statistics by status
        $statusStats = $this->programModel->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // Total participants across all programs
        $totalPeserta = $this->pesertaModel->where('status', 'aktif')->count();

        // Average participants per program
        $avgPeserta = $aktif > 0 ? round($totalPeserta / $aktif, 2) : 0;

        // Programs by month
        $bulanStats = $this->programModel->selectRaw('MONTH(tanggal_mulai) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_mulai', date('Y'))
            ->groupBy('bulan')
            ->get()
            ->pluck('total', 'bulan');

        // Most popular programs
        $popular = $this->programModel->withCount(['peserta as total_peserta' => function ($query) {
            $query->where('status', 'aktif');
        }])
        ->orderBy('total_peserta', 'desc')
        ->limit(5)
        ->get();

        return [
            'total' => $total,
            'aktif' => $aktif,
            'selesai' => $selesai,
            'ditunda' => $ditunda,
            'dibatalkan' => $dibatalkan,
            'status' => $statusStats,
            'total_peserta' => $totalPeserta,
            'avg_peserta_per_program' => $avgPeserta,
            'bulan' => $bulanStats,
            'popular' => $popular,
            'persentase_aktif' => $total > 0 ? round(($aktif / $total) * 100, 2) : 0
        ];
    }

    /**
     * Get programs by status
     */
    public function getByStatus(string $status): Collection
    {
        return $this->programModel->where('status', $status)
            ->with('peserta')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();
    }

    /**
     * Get active programs
     */
    public function getActive(): Collection
    {
        return $this->getByStatus('aktif');
    }

    /**
     * Get upcoming programs
     */
    public function getUpcoming(): Collection
    {
        return $this->programModel->where('tanggal_mulai', '>', now())
            ->where('status', 'aktif')
            ->with('peserta')
            ->orderBy('tanggal_mulai')
            ->get();
    }

    /**
     * Get ongoing programs
     */
    public function getOngoing(): Collection
    {
        return $this->programModel->where('tanggal_mulai', '<=', now())
            ->where(function ($query) {
                $query->whereNull('tanggal_selesai')
                      ->orWhere('tanggal_selesai', '>=', now());
            })
            ->where('status', 'aktif')
            ->with('peserta')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();
    }

    /**
     * Update participant score
     */
    public function updateParticipantScore(string $programId, string $siswaId, float $nilai): bool
    {
        $peserta = $this->pesertaModel->where('program_id', $programId)
            ->where('siswa_id', $siswaId)
            ->first();

        if ($peserta) {
            $peserta->update(['nilai' => $nilai]);
            return true;
        }

        return false;
    }

    /**
     * Complete program
     */
    public function completeProgram(string $programId): bool
    {
        $program = $this->getById($programId);
        $program->update([
            'status' => 'selesai',
            'tanggal_selesai' => now()
        ]);

        // Update all participants status to completed
        $this->pesertaModel->where('program_id', $programId)
            ->where('status', 'aktif')
            ->update(['status' => 'selesai']);

        return true;
    }

    /**
     * Get program completion rate
     */
    public function getCompletionRate(string $programId): float
    {
        $totalPeserta = $this->pesertaModel->where('program_id', $programId)->count();
        $selesaiPeserta = $this->pesertaModel->where('program_id', $programId)
            ->where('status', 'selesai')
            ->count();

        return $totalPeserta > 0 ? round(($selesaiPeserta / $totalPeserta) * 100, 2) : 0;
    }

    /**
     * Get student's program participation
     */
    public function getStudentParticipation(string $siswaId): Collection
    {
        return $this->pesertaModel->with('program')
            ->where('siswa_id', $siswaId)
            ->orderBy('tanggal_daftar', 'desc')
            ->get();
    }

    /**
     * Check if student can join program
     */
    public function canStudentJoin(string $programId, string $siswaId): array
    {
        $program = $this->getById($programId);
        
        // Check if program is active
        if (!$program->isActive()) {
            return ['can_join' => false, 'reason' => 'Program tidak aktif'];
        }

        // Check if program is ongoing or upcoming
        if ($program->isPast()) {
            return ['can_join' => false, 'reason' => 'Program sudah selesai'];
        }

        // Check if student is already participating
        $existingParticipation = $this->pesertaModel->where('program_id', $programId)
            ->where('siswa_id', $siswaId)
            ->where('status', 'aktif')
            ->first();

        if ($existingParticipation) {
            return ['can_join' => false, 'reason' => 'Siswa sudah terdaftar di program ini'];
        }

        return ['can_join' => true, 'reason' => 'Siswa dapat mendaftar'];
    }
}

