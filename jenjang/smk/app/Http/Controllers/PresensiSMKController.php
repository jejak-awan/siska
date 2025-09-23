<?php

namespace App\Jenjang\SMK\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jenjang\SMK\Services\PresensiSMKService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PresensiSMKController extends Controller
{
    protected $presensiService;

    public function __construct(PresensiSMKService $presensiService)
    {
        $this->presensiService = $presensiService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $presensi = $this->presensiService->getAll($request->all());
            return response()->json([
                'success' => true,
                'data' => $presensi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data presensi SMK',
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
            $presensi = $this->presensiService->create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Presensi SMK berhasil ditambahkan',
                'data' => $presensi
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan presensi SMK',
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
            $presensi = $this->presensiService->getById($id);
            return response()->json([
                'success' => true,
                'data' => $presensi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Presensi SMK tidak ditemukan',
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
            $presensi = $this->presensiService->update($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Presensi SMK berhasil diperbarui',
                'data' => $presensi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui presensi SMK',
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
            $this->presensiService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Presensi SMK berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus presensi SMK',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk create presensi
     */
    public function bulkCreate(Request $request): JsonResponse
    {
        try {
            $result = $this->presensiService->bulkCreate($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Presensi SMK berhasil ditambahkan secara massal',
                'data' => $result
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan presensi SMK secara massal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics for SMK presensi
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->presensiService->getStatistics();
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik presensi SMK',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

