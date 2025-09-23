<?php

namespace App\Jenjang\SMK\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jenjang\SMK\Services\KejuruanSMKService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KejuruanSMKController extends Controller
{
    protected $kejuruanService;

    public function __construct(KejuruanSMKService $kejuruanService)
    {
        $this->kejuruanService = $kejuruanService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $kejuruan = $this->kejuruanService->getAll($request->all());
            return response()->json([
                'success' => true,
                'data' => $kejuruan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kejuruan SMK',
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
            $kejuruan = $this->kejuruanService->create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Kejuruan SMK berhasil ditambahkan',
                'data' => $kejuruan
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kejuruan SMK',
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
            $kejuruan = $this->kejuruanService->getById($id);
            return response()->json([
                'success' => true,
                'data' => $kejuruan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kejuruan SMK tidak ditemukan',
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
            $kejuruan = $this->kejuruanService->update($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Kejuruan SMK berhasil diperbarui',
                'data' => $kejuruan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui kejuruan SMK',
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
            $this->kejuruanService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Kejuruan SMK berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kejuruan SMK',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Register student to kejuruan
     */
    public function registerStudent(Request $request, string $id): JsonResponse
    {
        try {
            $result = $this->kejuruanService->registerStudent($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Siswa berhasil didaftarkan ke kejuruan',
                'data' => $result
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendaftarkan siswa ke kejuruan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Unregister student from kejuruan
     */
    public function unregisterStudent(Request $request, string $id): JsonResponse
    {
        try {
            $this->kejuruanService->unregisterStudent($id, $request->input('siswa_id'));
            return response()->json([
                'success' => true,
                'message' => 'Siswa berhasil dikeluarkan dari kejuruan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengeluarkan siswa dari kejuruan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get kejuruan students
     */
    public function getStudents(string $id): JsonResponse
    {
        try {
            $students = $this->kejuruanService->getStudents($id);
            return response()->json([
                'success' => true,
                'data' => $students
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data siswa kejuruan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics for SMK kejuruan
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->kejuruanService->getStatistics();
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik kejuruan SMK',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

