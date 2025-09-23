<?php

namespace App\Http\Controllers;

use App\Services\TahunAkademikService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TahunAkademikController extends Controller
{
    protected $tahunAkademikService;

    public function __construct(TahunAkademikService $tahunAkademikService)
    {
        $this->tahunAkademikService = $tahunAkademikService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $tahunAkademik = $this->tahunAkademikService->getAll($request->all());
            return response()->json([
                'success' => true,
                'data' => $tahunAkademik
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data tahun akademik',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get active academic year
     */
    public function active(): JsonResponse
    {
        try {
            $tahunAkademik = $this->tahunAkademikService->getActive();
            return response()->json([
                'success' => true,
                'data' => $tahunAkademik
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tahun akademik aktif',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $tahunAkademik = $this->tahunAkademikService->create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Tahun akademik berhasil ditambahkan',
                'data' => $tahunAkademik
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan tahun akademik',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $tahunAkademik = $this->tahunAkademikService->getById($id);
            return response()->json([
                'success' => true,
                'data' => $tahunAkademik
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tahun akademik tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $tahunAkademik = $this->tahunAkademikService->update($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Tahun akademik berhasil diperbarui',
                'data' => $tahunAkademik
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui tahun akademik',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->tahunAkademikService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Tahun akademik berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus tahun akademik',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Activate academic year
     */
    public function activate(string $id): JsonResponse
    {
        try {
            $this->tahunAkademikService->activate($id);
            return response()->json([
                'success' => true,
                'message' => 'Tahun akademik berhasil diaktifkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengaktifkan tahun akademik',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Deactivate academic year
     */
    public function deactivate(string $id): JsonResponse
    {
        try {
            $this->tahunAkademikService->deactivate($id);
            return response()->json([
                'success' => true,
                'message' => 'Tahun akademik berhasil dinonaktifkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menonaktifkan tahun akademik',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current active academic year
     */
    public function getActive(): JsonResponse
    {
        try {
            $tahunAkademik = $this->tahunAkademikService->getActive();
            return response()->json([
                'success' => true,
                'data' => $tahunAkademik
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tahun akademik aktif',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get academic year statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->tahunAkademikService->getStatistics();
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik tahun akademik',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get active academic years
     */

    /**
     * Get current academic years
     */
    public function getCurrentYears(): JsonResponse
    {
        try {
            $tahunAkademik = $this->tahunAkademikService->getCurrentYears();
            return response()->json([
                'success' => true,
                'data' => $tahunAkademik
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tahun akademik berjalan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get past academic years
     */
    public function getPast(): JsonResponse
    {
        try {
            $tahunAkademik = $this->tahunAkademikService->getPast();
            return response()->json([
                'success' => true,
                'data' => $tahunAkademik
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tahun akademik lampau',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get future academic years
     */
    public function getFuture(): JsonResponse
    {
        try {
            $tahunAkademik = $this->tahunAkademikService->getFuture();
            return response()->json([
                'success' => true,
                'data' => $tahunAkademik
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tahun akademik mendatang',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get academic years by year
     */
    public function getByYear(string $tahun): JsonResponse
    {
        try {
            $tahunAkademik = $this->tahunAkademikService->getByYear($tahun);
            return response()->json([
                'success' => true,
                'data' => $tahunAkademik
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tahun akademik berdasarkan tahun',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get academic years by semester
     */
    public function getBySemester(int $semester): JsonResponse
    {
        try {
            $tahunAkademik = $this->tahunAkademikService->getBySemester($semester);
            return response()->json([
                'success' => true,
                'data' => $tahunAkademik
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tahun akademik berdasarkan semester',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get academic year by year and semester
     */
    public function getByYearAndSemester(string $tahun, int $semester): JsonResponse
    {
        try {
            $tahunAkademik = $this->tahunAkademikService->getByYearAndSemester($tahun, $semester);
            
            if (!$tahunAkademik) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun akademik tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $tahunAkademik
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tahun akademik',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get next academic year
     */
    public function getNext(): JsonResponse
    {
        try {
            $tahunAkademik = $this->tahunAkademikService->getNext();
            return response()->json([
                'success' => true,
                'data' => $tahunAkademik
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tahun akademik berikutnya',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get previous academic year
     */
    public function getPrevious(): JsonResponse
    {
        try {
            $tahunAkademik = $this->tahunAkademikService->getPrevious();
            return response()->json([
                'success' => true,
                'data' => $tahunAkademik
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tahun akademik sebelumnya',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}