<?php

namespace App\Jenjang\SMA\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jenjang\SMA\Models\SiswaSMA;
use App\Jenjang\SMA\Services\SiswaSMAService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SiswaSMAController extends Controller
{
    protected $siswaService;

    public function __construct(SiswaSMAService $siswaService)
    {
        $this->siswaService = $siswaService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $siswa = $this->siswaService->getAll($request->all());
            return response()->json([
                'success' => true,
                'data' => $siswa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data siswa SMA',
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
            $siswa = $this->siswaService->create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Siswa SMA berhasil ditambahkan',
                'data' => $siswa
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan siswa SMA',
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
            $siswa = $this->siswaService->getById($id);
            return response()->json([
                'success' => true,
                'data' => $siswa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa SMA tidak ditemukan',
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
            $siswa = $this->siswaService->update($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Siswa SMA berhasil diperbarui',
                'data' => $siswa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui siswa SMA',
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
            $this->siswaService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Siswa SMA berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus siswa SMA',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics for SMA students
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->siswaService->getStatistics();
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik siswa SMA',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
