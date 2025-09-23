<?php

namespace App\Services;

use App\Models\TahunAkademik;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TahunAkademikService
{
    protected $tahunAkademikModel;

    public function __construct(TahunAkademik $tahunAkademikModel)
    {
        $this->tahunAkademikModel = $tahunAkademikModel;
    }

    /**
     * Get all academic years with pagination and filters
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = $this->tahunAkademikModel->newQuery();

        // Apply filters
        if (isset($filters['tahun_akademik']) && $filters['tahun_akademik']) {
            $query->forYear($filters['tahun_akademik']);
        }

        // Semester filter removed - not available in current schema

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['is_active']) && $filters['is_active'] !== null) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->orderBy('tahun_akademik', 'desc')
                    ->orderBy('tanggal_mulai', 'desc')
                    ->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get academic year by ID
     */
    public function getById(string $id): TahunAkademik
    {
        return $this->tahunAkademikModel->findOrFail($id);
    }

    /**
     * Get current active academic year
     */
    public function getCurrent(): ?TahunAkademik
    {
        return $this->tahunAkademikModel->active()->current()->first();
    }

    /**
     * Create new academic year
     */
    public function create(array $data): TahunAkademik
    {
        $validator = Validator::make($data, [
            'tahun_akademik' => 'required|string|max:10',
            'semester' => 'required|integer|in:1,2',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,nonaktif,selesai',
            'is_active' => 'boolean',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Check if academic year already exists
        $existing = $this->tahunAkademikModel->where('tahun_akademik', $data['tahun_akademik'])
            ->where('semester', $data['semester'])
            ->first();

        if ($existing) {
            throw ValidationException::withMessages([
                'tahun_akademik' => ['Tahun akademik dan semester sudah ada.'],
            ]);
        }

        return $this->tahunAkademikModel->create($data);
    }

    /**
     * Update academic year
     */
    public function update(string $id, array $data): TahunAkademik
    {
        $tahunAkademik = $this->getById($id);
        
        $validator = Validator::make($data, [
            'tahun_akademik' => 'sometimes|required|string|max:10',
            'semester' => 'sometimes|required|integer|in:1,2',
            'tanggal_mulai' => 'sometimes|required|date',
            'tanggal_selesai' => 'sometimes|required|date|after:tanggal_mulai',
            'status' => 'sometimes|required|in:aktif,nonaktif,selesai',
            'is_active' => 'boolean',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Check if academic year already exists (excluding current record)
        if (isset($data['tahun_akademik']) || isset($data['semester'])) {
            $tahun = $data['tahun_akademik'] ?? $tahunAkademik->tahun_akademik;
            $semester = $data['semester'] ?? $tahunAkademik->semester;
            
            $existing = $this->tahunAkademikModel->where('tahun_akademik', $tahun)
                ->where('semester', $semester)
                ->where('id', '!=', $id)
                ->first();

            if ($existing) {
                throw ValidationException::withMessages([
                    'tahun_akademik' => ['Tahun akademik dan semester sudah ada.'],
                ]);
            }
        }

        $tahunAkademik->update($data);
        return $tahunAkademik->fresh();
    }

    /**
     * Delete academic year
     */
    public function delete(string $id): bool
    {
        $tahunAkademik = $this->getById($id);
        
        // Prevent deletion of active academic year
        if ($tahunAkademik->isActive()) {
            throw new \Exception('Tidak dapat menghapus tahun akademik yang sedang aktif.');
        }
        
        return $tahunAkademik->delete();
    }

    /**
     * Activate academic year
     */
    public function activate(string $id): bool
    {
        $tahunAkademik = $this->getById($id);
        return $tahunAkademik->activate();
    }

    /**
     * Deactivate academic year
     */
    public function deactivate(string $id): bool
    {
        $tahunAkademik = $this->getById($id);
        return $tahunAkademik->deactivate();
    }

    /**
     * Get academic year statistics
     */
    public function getStatistics(): array
    {
        $total = $this->tahunAkademikModel->count();
        $active = $this->tahunAkademikModel->active()->count();
        $current = $this->tahunAkademikModel->current()->count();
        $past = $this->tahunAkademikModel->past()->count();
        $future = $this->tahunAkademikModel->future()->count();

        // Statistics by year
        $yearStats = $this->tahunAkademikModel->selectRaw('tahun_akademik, COUNT(*) as total')
            ->groupBy('tahun_akademik')
            ->orderBy('tahun_akademik', 'desc')
            ->get()
            ->pluck('total', 'tahun_akademik');

        // Statistics by semester
        $semesterStats = $this->tahunAkademikModel->selectRaw('semester, COUNT(*) as total')
            ->groupBy('semester')
            ->get()
            ->pluck('total', 'semester');

        // Statistics by status
        $statusStats = $this->tahunAkademikModel->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        return [
            'total' => $total,
            'active' => $active,
            'current' => $current,
            'past' => $past,
            'future' => $future,
            'year' => $yearStats,
            'semester' => $semesterStats,
            'status' => $statusStats,
            'persentase_aktif' => $total > 0 ? round(($active / $total) * 100, 2) : 0
        ];
    }

    /**
     * Get active academic years
     */
    public function getActive(): Collection
    {
        return $this->tahunAkademikModel->active()->get();
    }

    /**
     * Get current academic years
     */
    public function getCurrentYears(): Collection
    {
        return $this->tahunAkademikModel->current()->get();
    }

    /**
     * Get past academic years
     */
    public function getPast(): Collection
    {
        return $this->tahunAkademikModel->past()->get();
    }

    /**
     * Get future academic years
     */
    public function getFuture(): Collection
    {
        return $this->tahunAkademikModel->future()->get();
    }

    /**
     * Get academic years by year
     */
    public function getByYear(string $tahun): Collection
    {
        return $this->tahunAkademikModel->forYear($tahun)->get();
    }

    /**
     * Get academic years by semester
     */
    public function getBySemester(int $semester): Collection
    {
        return $this->tahunAkademikModel->forSemester($semester)->get();
    }

    /**
     * Get academic year by year and semester
     */
    public function getByYearAndSemester(string $tahun, int $semester): ?TahunAkademik
    {
        return $this->tahunAkademikModel->forYear($tahun)->forSemester($semester)->first();
    }

    /**
     * Get next academic year
     */
    public function getNext(): ?TahunAkademik
    {
        $current = $this->getCurrent();
        
        if (!$current) {
            return null;
        }

        $nextSemester = $current->semester === 1 ? 2 : 1;
        $nextYear = $current->semester === 1 ? $current->tahun_akademik : $this->getNextYear($current->tahun_akademik);

        return $this->getByYearAndSemester($nextYear, $nextSemester);
    }

    /**
     * Get previous academic year
     */
    public function getPrevious(): ?TahunAkademik
    {
        $current = $this->getCurrent();
        
        if (!$current) {
            return null;
        }

        $prevSemester = $current->semester === 2 ? 1 : 2;
        $prevYear = $current->semester === 2 ? $current->tahun_akademik : $this->getPreviousYear($current->tahun_akademik);

        return $this->getByYearAndSemester($prevYear, $prevSemester);
    }

    /**
     * Get next year from academic year string
     */
    private function getNextYear(string $tahunAkademik): string
    {
        // Assuming format like "2023/2024"
        $parts = explode('/', $tahunAkademik);
        if (count($parts) === 2) {
            $start = (int)$parts[0];
            $end = (int)$parts[1];
            return ($start + 1) . '/' . ($end + 1);
        }
        
        // If format is different, just increment
        return (int)$tahunAkademik + 1;
    }

    /**
     * Get previous year from academic year string
     */
    private function getPreviousYear(string $tahunAkademik): string
    {
        // Assuming format like "2023/2024"
        $parts = explode('/', $tahunAkademik);
        if (count($parts) === 2) {
            $start = (int)$parts[0];
            $end = (int)$parts[1];
            return ($start - 1) . '/' . ($end - 1);
        }
        
        // If format is different, just decrement
        return (int)$tahunAkademik - 1;
    }
}
