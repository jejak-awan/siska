<?php

namespace App\Jenjang\SD\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jenjang\SD\Models\KreditPoinSD;
use App\Jenjang\SD\Models\SiswaSD;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class KreditPoinSDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = KreditPoinSD::with(['siswa.user', 'pemberiPoin']);

        // Filter by kategori
        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter by semester
        if ($request->has('semester')) {
            $query->where('semester', $request->semester);
        }

        // Filter by tahun akademik
        if ($request->has('tahun_akademik')) {
            $query->where('tahun_akademik', $request->tahun_akademik);
        }

        // Filter by siswa
        if ($request->has('id_siswa')) {
            $query->where('id_siswa', $request->id_siswa);
        }

        $kreditPoin = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $kreditPoin->items(),
            'meta' => [
                'current_page' => $kreditPoin->currentPage(),
                'last_page' => $kreditPoin->lastPage(),
                'per_page' => $kreditPoin->perPage(),
                'total' => $kreditPoin->total(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa_sd,id',
            'kategori' => 'required|in:positif,negatif',
            'poin' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'pemberi_poin_id' => 'required|exists:users_sd,id',
            'semester' => 'required|in:1,2',
            'tahun_akademik' => 'required|string|max:9',
        ]);

        $kreditPoin = KreditPoinSD::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Kredit poin berhasil ditambahkan',
            'data' => $kreditPoin->load(['siswa.user', 'pemberiPoin'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(KreditPoinSD $kreditPoin): JsonResponse
    {
        $kreditPoin->load(['siswa.user', 'pemberiPoin']);
        
        return response()->json([
            'success' => true,
            'data' => $kreditPoin
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KreditPoinSD $kreditPoin): JsonResponse
    {
        $request->validate([
            'kategori' => 'sometimes|in:positif,negatif',
            'poin' => 'sometimes|integer|min:1',
            'deskripsi' => 'sometimes|string',
            'tanggal' => 'sometimes|date',
        ]);

        $kreditPoin->update($request->only([
            'kategori', 'poin', 'deskripsi', 'tanggal'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Kredit poin berhasil diperbarui',
            'data' => $kreditPoin->load(['siswa.user', 'pemberiPoin'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KreditPoinSD $kreditPoin): JsonResponse
    {
        $kreditPoin->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kredit poin berhasil dihapus'
        ]);
    }

    /**
     * Get kredit poin statistics
     */
    public function statistics(Request $request): JsonResponse
    {
        $query = KreditPoinSD::query();

        if ($request->has('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->has('tahun_akademik')) {
            $query->where('tahun_akademik', $request->tahun_akademik);
        }

        $stats = [
            'total_poin_positif' => $query->clone()->where('kategori', 'positif')->sum('poin'),
            'total_poin_negatif' => $query->clone()->where('kategori', 'negatif')->sum('poin'),
            'jumlah_poin_positif' => $query->clone()->where('kategori', 'positif')->count(),
            'jumlah_poin_negatif' => $query->clone()->where('kategori', 'negatif')->count(),
            'siswa_terbaik' => $this->getTopStudents($query->clone()),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get top students by credit points
     */
    private function getTopStudents($query)
    {
        return $query->selectRaw('id_siswa, SUM(CASE WHEN kategori = "positif" THEN poin ELSE -poin END) as total_poin')
            ->with('siswa.user')
            ->groupBy('id_siswa')
            ->orderBy('total_poin', 'desc')
            ->limit(10)
            ->get();
    }
}
