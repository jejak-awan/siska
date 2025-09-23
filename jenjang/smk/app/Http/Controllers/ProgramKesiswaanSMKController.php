<?php

namespace App\Jenjang\SMK\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jenjang\SMK\Services\ProgramKesiswaanSMKService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProgramKesiswaanSMKController extends Controller
{
    protected $programService;

    public function __construct(ProgramKesiswaanSMKService $programService)
    {
        $this->programService = $programService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $programs = $this->programService->getAll($request->all());
            return response()->json([
                'success' => true,
                'data' => $programs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data program kesiswaan SMK',
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
            $program = $this->programService->create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Program kesiswaan SMK berhasil ditambahkan',
                'data' => $program
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan program kesiswaan SMK',
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
            $program = $this->programService->getById($id);
            return response()->json([
                'success' => true,
                'data' => $program
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Program kesiswaan SMK tidak ditemukan',
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
            $program = $this->programService->update($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Program kesiswaan SMK berhasil diperbarui',
                'data' => $program
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui program kesiswaan SMK',
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
            $this->programService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Program kesiswaan SMK berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus program kesiswaan SMK',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add participant to program
     */
    public function addParticipant(Request $request, string $id): JsonResponse
    {
        try {
            $result = $this->programService->addParticipant($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Peserta berhasil ditambahkan ke program',
                'data' => $result
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan peserta ke program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove participant from program
     */
    public function removeParticipant(Request $request, string $id): JsonResponse
    {
        try {
            $this->programService->removeParticipant($id, $request->input('siswa_id'));
            return response()->json([
                'success' => true,
                'message' => 'Peserta berhasil dikeluarkan dari program'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengeluarkan peserta dari program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get program participants
     */
    public function getParticipants(string $id): JsonResponse
    {
        try {
            $participants = $this->programService->getParticipants($id);
            return response()->json([
                'success' => true,
                'data' => $participants
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data peserta program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update participant score
     */
    public function updateParticipantScore(Request $request, string $id): JsonResponse
    {
        try {
            $this->programService->updateParticipantScore(
                $id,
                $request->input('siswa_id'),
                $request->input('nilai')
            );
            return response()->json([
                'success' => true,
                'message' => 'Nilai peserta berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui nilai peserta',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Complete program
     */
    public function completeProgram(string $id): JsonResponse
    {
        try {
            $this->programService->completeProgram($id);
            return response()->json([
                'success' => true,
                'message' => 'Program berhasil diselesaikan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyelesaikan program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get program completion rate
     */
    public function getCompletionRate(string $id): JsonResponse
    {
        try {
            $rate = $this->programService->getCompletionRate($id);
            return response()->json([
                'success' => true,
                'data' => ['completion_rate' => $rate]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tingkat penyelesaian program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics for SMK programs
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->programService->getStatistics();
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik program kesiswaan SMK',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}