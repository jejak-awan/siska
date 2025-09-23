<?php

namespace App\Jenjang\SMP\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jenjang\SMP\Services\EkstrakurikulerSMPService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EkstrakurikulerSMPController extends Controller
{
    protected $ekstrakurikulerService;

    public function __construct(EkstrakurikulerSMPService $ekstrakurikulerService)
    {
        $this->ekstrakurikulerService = $ekstrakurikulerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $ekstrakurikuler = $this->ekstrakurikulerService->getAll($request->all());
            return response()->json([
                'success' => true,
                'data' => $ekstrakurikuler
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data ekstrakurikuler SMP',
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
            $ekstrakurikuler = $this->ekstrakurikulerService->create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Ekstrakurikuler SMP berhasil ditambahkan',
                'data' => $ekstrakurikuler
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan ekstrakurikuler SMP',
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
            $ekstrakurikuler = $this->ekstrakurikulerService->getById($id);
            return response()->json([
                'success' => true,
                'data' => $ekstrakurikuler
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ekstrakurikuler SMP tidak ditemukan',
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
            $ekstrakurikuler = $this->ekstrakurikulerService->update($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Ekstrakurikuler SMP berhasil diperbarui',
                'data' => $ekstrakurikuler
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui ekstrakurikuler SMP',
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
            $this->ekstrakurikulerService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Ekstrakurikuler SMP berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus ekstrakurikuler SMP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Register student to ekstrakurikuler
     */
    public function registerStudent(Request $request, string $id): JsonResponse
    {
        try {
            $result = $this->ekstrakurikulerService->registerStudent($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Siswa berhasil didaftarkan ke ekstrakurikuler',
                'data' => $result
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendaftarkan siswa ke ekstrakurikuler',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Unregister student from ekstrakurikuler
     */
    public function unregisterStudent(Request $request, string $id): JsonResponse
    {
        try {
            $this->ekstrakurikulerService->unregisterStudent($id, $request->input('siswa_id'));
            return response()->json([
                'success' => true,
                'message' => 'Siswa berhasil dikeluarkan dari ekstrakurikuler'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengeluarkan siswa dari ekstrakurikuler',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get ekstrakurikuler students
     */
    public function getStudents(string $id): JsonResponse
    {
        try {
            $students = $this->ekstrakurikulerService->getStudents($id);
            return response()->json([
                'success' => true,
                'data' => $students
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data siswa ekstrakurikuler',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics for SMP ekstrakurikuler
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->ekstrakurikulerService->getStatistics();
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik ekstrakurikuler SMP',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

