<?php

namespace App\Jenjang\SMA\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jenjang\SMA\Models\PresensiSMA;
use App\Jenjang\SMA\Models\SiswaSMA;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PresensiSMAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = PresensiSMA::with('siswa.user');

        // Filter by tanggal
        if ($request->has('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        // Filter by semester
        if ($request->has('semester')) {
            $query->where('semester', $request->semester);
        }

        // Filter by tahun akademik
        if ($request->has('tahun_akademik')) {
            $query->where('tahun_akademik', $request->tahun_akademik);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by kelas
        if ($request->has('kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        $presensi = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $presensi->items(),
            'meta' => [
                'current_page' => $presensi->currentPage(),
                'last_page' => $presensi->lastPage(),
                'per_page' => $presensi->perPage(),
                'total' => $presensi->total(),
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
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,izin,sakit,alpa',
            'keterangan' => 'nullable|string',
            'semester' => 'required|in:1,2',
            'tahun_akademik' => 'required|string|max:9',
        ]);

        // Check if presensi already exists for this student on this date
        $existingPresensi = PresensiSMA::where('id_siswa', $request->id_siswa)
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($existingPresensi) {
            return response()->json([
                'success' => false,
                'message' => 'Presensi untuk siswa ini pada tanggal tersebut sudah ada'
            ], 422);
        }

        $presensi = PresensiSMA::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil ditambahkan',
            'data' => $presensi->load('siswa.user')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PresensiSMA $presensi): JsonResponse
    {
        $presensi->load('siswa.user');
        
        return response()->json([
            'success' => true,
            'data' => $presensi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PresensiSMA $presensi): JsonResponse
    {
        $request->validate([
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i',
            'status' => 'sometimes|in:hadir,izin,sakit,alpa',
            'keterangan' => 'nullable|string',
        ]);

        $presensi->update($request->only([
            'jam_masuk', 'jam_keluar', 'status', 'keterangan'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil diperbarui',
            'data' => $presensi->load('siswa.user')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PresensiSMA $presensi): JsonResponse
    {
        $presensi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil dihapus'
        ]);
    }

    /**
     * Bulk create presensi for a class on a specific date
     */
    public function bulkCreate(Request $request): JsonResponse
    {
        $request->validate([
            'kelas' => 'required|in:1,2,3,4,5,6',
            'tanggal' => 'required|date',
            'semester' => 'required|in:1,2',
            'tahun_akademik' => 'required|string|max:9',
            'presensi_data' => 'required|array',
            'presensi_data.*.id_siswa' => 'required|exists:siswa_sd,id',
            'presensi_data.*.status' => 'required|in:hadir,izin,sakit,alpa',
            'presensi_data.*.jam_masuk' => 'nullable|date_format:H:i',
            'presensi_data.*.keterangan' => 'nullable|string',
        ]);

        DB::connection('sd')->beginTransaction();

        try {
            $createdPresensi = [];

            foreach ($request->presensi_data as $data) {
                // Check if presensi already exists
                $existingPresensi = PresensiSMA::where('id_siswa', $data['id_siswa'])
                    ->where('tanggal', $request->tanggal)
                    ->first();

                if (!$existingPresensi) {
                    $presensi = PresensiSMA::create([
                        'id_siswa' => $data['id_siswa'],
                        'tanggal' => $request->tanggal,
                        'jam_masuk' => $data['jam_masuk'] ?? null,
                        'status' => $data['status'],
                        'keterangan' => $data['keterangan'] ?? null,
                        'semester' => $request->semester,
                        'tahun_akademik' => $request->tahun_akademik,
                    ]);

                    $createdPresensi[] = $presensi->load('siswa.user');
                }
            }

            DB::connection('sd')->commit();

            return response()->json([
                'success' => true,
                'message' => 'Presensi berhasil ditambahkan',
                'data' => $createdPresensi
            ], 201);

        } catch (\Exception $e) {
            DB::connection('sd')->rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan presensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get presensi statistics
     */
    public function statistics(Request $request): JsonResponse
    {
        $query = PresensiSMA::query();

        if ($request->has('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->has('tahun_akademik')) {
            $query->where('tahun_akademik', $request->tahun_akademik);
        }

        $stats = [
            'total_presensi' => $query->count(),
            'hadir' => $query->clone()->where('status', 'hadir')->count(),
            'izin' => $query->clone()->where('status', 'izin')->count(),
            'sakit' => $query->clone()->where('status', 'sakit')->count(),
            'alpa' => $query->clone()->where('status', 'alpa')->count(),
            'persentase_kehadiran' => $query->count() > 0 
                ? round(($query->clone()->where('status', 'hadir')->count() / $query->count()) * 100, 2)
                : 0,
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
