<?php

namespace App\Jenjang\SMA\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jenjang\SMA\Services\OrganisasiSMAService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrganisasiSMAController extends Controller
{
    protected $organisasiService;

    public function __construct(OrganisasiSMAService $organisasiService)
    {
        $this->organisasiService = $organisasiService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $organisasi = $this->organisasiService->getAll($request->all());
            return response()->json([
                'success' => true,
                'data' => $organisasi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data organisasi SMA',
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
            $organisasi = $this->organisasiService->create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Organisasi SMA berhasil ditambahkan',
                'data' => $organisasi
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan organisasi SMA',
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
            $organisasi = $this->organisasiService->getById($id);
            return response()->json([
                'success' => true,
                'data' => $organisasi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Organisasi SMA tidak ditemukan',
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
            $organisasi = $this->organisasiService->update($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Organisasi SMA berhasil diperbarui',
                'data' => $organisasi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui organisasi SMA',
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
            $this->organisasiService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Organisasi SMA berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus organisasi SMA',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add member to organization
     */
    public function addMember(Request $request, string $id): JsonResponse
    {
        try {
            $result = $this->organisasiService->addMember($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Anggota berhasil ditambahkan ke organisasi',
                'data' => $result
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan anggota ke organisasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove member from organization
     */
    public function removeMember(Request $request, string $id): JsonResponse
    {
        try {
            $this->organisasiService->removeMember($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Anggota berhasil dikeluarkan dari organisasi'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengeluarkan anggota dari organisasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get organization members
     */
    public function getMembers(string $id): JsonResponse
    {
        try {
            $members = $this->organisasiService->getMembers($id);
            return response()->json([
                'success' => true,
                'data' => $members
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data anggota organisasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics for SMA organizations
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->organisasiService->getStatistics();
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik organisasi SMA',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

