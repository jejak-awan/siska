<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Core\TahunAkademik;
use App\Models\Core\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * Tahun Akademik Controller untuk SISKA Backend System
 * 
 * @package App\Http\Controllers\Core
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class TahunAkademikController extends Controller
{
    /**
     * Get all academic years
     */
    public function index(Request $request): JsonResponse
    {
        $tahunAkademik = TahunAkademik::with('sekolah')
            ->when($request->sekolah_id, function ($query, $sekolahId) {
                return $query->where('sekolah_id', $sekolahId);
            })
            ->when($request->search, function ($query, $search) {
                return $query->where('tahun_akademik', 'like', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('tahun_akademik', 'desc')
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'message' => 'Data tahun akademik berhasil diambil',
            'data' => $tahunAkademik
        ]);
    }

    /**
     * Get academic year by ID
     */
    public function show(TahunAkademik $tahunAkademik): JsonResponse
    {
        $tahunAkademik->load(['sekolah', 'semester']);

        return response()->json([
            'success' => true,
            'message' => 'Data tahun akademik berhasil diambil',
            'data' => $tahunAkademik
        ]);
    }

    /**
     * Create new academic year
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'sekolah_id' => 'required|exists:profil_sekolah,id',
            'tahun_akademik' => 'required|string|unique:tahun_akademik,tahun_akademik,NULL,id,sekolah_id,' . $request->sekolah_id,
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,nonaktif',
            'keterangan' => 'nullable|string',
        ], [
            'sekolah_id.required' => 'ID sekolah wajib diisi',
            'sekolah_id.exists' => 'Sekolah tidak ditemukan',
            'tahun_akademik.required' => 'Tahun akademik wajib diisi',
            'tahun_akademik.unique' => 'Tahun akademik sudah ada untuk sekolah ini',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
            'status.required' => 'Status wajib diisi',
            'status.in' => 'Status tidak valid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // If this is set as active, deactivate other academic years for the same school
        if ($request->status === 'aktif') {
            TahunAkademik::where('sekolah_id', $request->sekolah_id)
                ->where('status', 'aktif')
                ->update(['status' => 'nonaktif']);
        }

        $tahunAkademik = TahunAkademik::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Tahun akademik berhasil dibuat',
            'data' => $tahunAkademik
        ], 201);
    }

    /**
     * Update academic year
     */
    public function update(Request $request, TahunAkademik $tahunAkademik): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'tahun_akademik' => 'sometimes|string|unique:tahun_akademik,tahun_akademik,' . $tahunAkademik->id . ',id,sekolah_id,' . $tahunAkademik->sekolah_id,
            'tanggal_mulai' => 'sometimes|date',
            'tanggal_selesai' => 'sometimes|date|after:tanggal_mulai',
            'status' => 'sometimes|in:aktif,nonaktif',
            'keterangan' => 'nullable|string',
        ], [
            'tahun_akademik.unique' => 'Tahun akademik sudah ada untuk sekolah ini',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
            'status.in' => 'Status tidak valid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // If this is set as active, deactivate other academic years for the same school
        if ($request->has('status') && $request->status === 'aktif') {
            TahunAkademik::where('sekolah_id', $tahunAkademik->sekolah_id)
                ->where('id', '!=', $tahunAkademik->id)
                ->where('status', 'aktif')
                ->update(['status' => 'nonaktif']);
        }

        $tahunAkademik->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Tahun akademik berhasil diperbarui',
            'data' => $tahunAkademik
        ]);
    }

    /**
     * Delete academic year
     */
    public function destroy(TahunAkademik $tahunAkademik): JsonResponse
    {
        // Check if there are semesters associated with this academic year
        if ($tahunAkademik->semester()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus tahun akademik yang memiliki semester'
            ], 422);
        }

        $tahunAkademik->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tahun akademik berhasil dihapus'
        ]);
    }

    /**
     * Activate academic year
     */
    public function activate(TahunAkademik $tahunAkademik): JsonResponse
    {
        // Deactivate other academic years for the same school
        TahunAkademik::where('sekolah_id', $tahunAkademik->sekolah_id)
            ->where('id', '!=', $tahunAkademik->id)
            ->where('status', 'aktif')
            ->update(['status' => 'nonaktif']);

        $tahunAkademik->update(['status' => 'aktif']);

        return response()->json([
            'success' => true,
            'message' => 'Tahun akademik berhasil diaktifkan',
            'data' => $tahunAkademik
        ]);
    }

    /**
     * Get active academic year for school
     */
    public function getActive(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'sekolah_id' => 'required|exists:profil_sekolah,id',
        ], [
            'sekolah_id.required' => 'ID sekolah wajib diisi',
            'sekolah_id.exists' => 'Sekolah tidak ditemukan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $tahunAkademik = TahunAkademik::where('sekolah_id', $request->sekolah_id)
            ->where('status', 'aktif')
            ->with(['sekolah', 'semester'])
            ->first();

        if (!$tahunAkademik) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada tahun akademik aktif untuk sekolah ini'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tahun akademik aktif berhasil diambil',
            'data' => $tahunAkademik
        ]);
    }

    /**
     * Get academic years by school
     */
    public function getBySchool(ProfilSekolah $sekolah): JsonResponse
    {
        $tahunAkademik = TahunAkademik::where('sekolah_id', $sekolah->id)
            ->with(['semester'])
            ->orderBy('tahun_akademik', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => "Data tahun akademik sekolah {$sekolah->nama_sekolah} berhasil diambil",
            'data' => $tahunAkademik
        ]);
    }
}
