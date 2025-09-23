<?php

namespace App\Jenjang\SMA\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jenjang\SMA\Models\ProgramKesiswaanSMA;
use App\Jenjang\SMA\Models\PenilaianKarakterSMA;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProgramKesiswaanSMAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = ProgramKesiswaanSMA::with('penanggungJawab');

        // Filter by kategori
        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Search by nama
        if ($request->has('search')) {
            $query->where('nama_program', 'like', "%{$request->search}%");
        }

        $programs = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $programs->items(),
            'meta' => [
                'current_page' => $programs->currentPage(),
                'last_page' => $programs->lastPage(),
                'per_page' => $programs->perPage(),
                'total' => $programs->total(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|in:karakter_dasar,kebersihan,kedisiplinan',
            'target_siswa' => 'nullable|array',
            'durasi' => 'nullable|integer|min:1',
            'penanggung_jawab_id' => 'nullable|exists:users_sd,id',
            'status' => 'sometimes|in:active,inactive,completed',
        ]);

        $program = ProgramKesiswaanSMA::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Program kesiswaan berhasil ditambahkan',
            'data' => $program->load('penanggungJawab')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramKesiswaanSMA $program): JsonResponse
    {
        $program->load(['penanggungJawab', 'penilaianKarakter.siswa.user']);
        
        return response()->json([
            'success' => true,
            'data' => $program
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgramKesiswaanSMA $program): JsonResponse
    {
        $request->validate([
            'nama_program' => 'sometimes|required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'sometimes|in:karakter_dasar,kebersihan,kedisiplinan',
            'target_siswa' => 'nullable|array',
            'durasi' => 'nullable|integer|min:1',
            'penanggung_jawab_id' => 'nullable|exists:users_sd,id',
            'status' => 'sometimes|in:active,inactive,completed',
        ]);

        $program->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Program kesiswaan berhasil diperbarui',
            'data' => $program->load('penanggungJawab')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramKesiswaanSMA $program): JsonResponse
    {
        // Check if there are related penilaian karakter
        $relatedPenilaian = $program->penilaianKarakter()->count();

        if ($relatedPenilaian > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus program yang masih memiliki penilaian karakter'
            ], 422);
        }

        $program->delete();

        return response()->json([
            'success' => true,
            'message' => 'Program kesiswaan berhasil dihapus'
        ]);
    }

    /**
     * Get program statistics
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_program' => ProgramKesiswaanSMA::count(),
            'program_aktif' => ProgramKesiswaanSMA::where('status', 'active')->count(),
            'program_selesai' => ProgramKesiswaanSMA::where('status', 'completed')->count(),
            'program_per_kategori' => ProgramKesiswaanSMA::selectRaw('kategori, COUNT(*) as jumlah')
                ->where('status', 'active')
                ->groupBy('kategori')
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get program participants
     */
    public function getParticipants(ProgramKesiswaanSMA $program): JsonResponse
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

        return response()->json([
            'success' => true,
            'data' => $participants
        ]);
    }
}
