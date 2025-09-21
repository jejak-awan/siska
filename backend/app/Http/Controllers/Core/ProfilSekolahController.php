<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Core\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

/**
 * Profil Sekolah Controller untuk SISKA Backend System
 * 
 * @package App\Http\Controllers\Core
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class ProfilSekolahController extends Controller
{
    /**
     * Get all school profiles
     */
    public function index(Request $request): JsonResponse
    {
        $profiles = ProfilSekolah::with(['license', 'tahunAkademik'])
            ->when($request->search, function ($query, $search) {
                return $query->where('nama_sekolah', 'like', "%{$search}%")
                    ->orWhere('npsn', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%");
            })
            ->when($request->jenjang, function ($query, $jenjang) {
                return $query->where('jenjang', $jenjang);
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'message' => 'Data profil sekolah berhasil diambil',
            'data' => $profiles
        ]);
    }

    /**
     * Get school profile by ID
     */
    public function show(ProfilSekolah $profilSekolah): JsonResponse
    {
        $profilSekolah->load(['license', 'tahunAkademik']);

        return response()->json([
            'success' => true,
            'message' => 'Data profil sekolah berhasil diambil',
            'data' => $profilSekolah
        ]);
    }

    /**
     * Create new school profile
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'required|string|unique:profil_sekolah,npsn',
            'jenjang' => 'required|in:SD,SMP,SMA,SMK',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'provinsi' => 'required|string',
            'kode_pos' => 'nullable|string',
            'telepon' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kepala_sekolah' => 'required|string',
            'nip_kepala_sekolah' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'struktur_organisasi' => 'nullable|json',
        ], [
            'nama_sekolah.required' => 'Nama sekolah wajib diisi',
            'npsn.required' => 'NPSN wajib diisi',
            'npsn.unique' => 'NPSN sudah digunakan',
            'jenjang.required' => 'Jenjang wajib diisi',
            'jenjang.in' => 'Jenjang tidak valid',
            'alamat.required' => 'Alamat wajib diisi',
            'kecamatan.required' => 'Kecamatan wajib diisi',
            'kabupaten_kota.required' => 'Kabupaten/Kota wajib diisi',
            'provinsi.required' => 'Provinsi wajib diisi',
            'email.email' => 'Format email tidak valid',
            'website.url' => 'Format website tidak valid',
            'logo.image' => 'File logo harus berupa gambar',
            'logo.mimes' => 'Format logo harus jpeg, png, jpg, atau gif',
            'logo.max' => 'Ukuran logo maksimal 2MB',
            'kepala_sekolah.required' => 'Nama kepala sekolah wajib diisi',
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

        $data = $request->except('logo');
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        $profilSekolah = ProfilSekolah::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Profil sekolah berhasil dibuat',
            'data' => $profilSekolah
        ], 201);
    }

    /**
     * Update school profile
     */
    public function update(Request $request, ProfilSekolah $profilSekolah): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_sekolah' => 'sometimes|string|max:255',
            'npsn' => 'sometimes|string|unique:profil_sekolah,npsn,' . $profilSekolah->id,
            'jenjang' => 'sometimes|in:SD,SMP,SMA,SMK',
            'alamat' => 'sometimes|string',
            'kecamatan' => 'sometimes|string',
            'kabupaten_kota' => 'sometimes|string',
            'provinsi' => 'sometimes|string',
            'kode_pos' => 'nullable|string',
            'telepon' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kepala_sekolah' => 'sometimes|string',
            'nip_kepala_sekolah' => 'nullable|string',
            'status' => 'sometimes|in:aktif,nonaktif',
            'struktur_organisasi' => 'nullable|json',
        ], [
            'npsn.unique' => 'NPSN sudah digunakan',
            'jenjang.in' => 'Jenjang tidak valid',
            'email.email' => 'Format email tidak valid',
            'website.url' => 'Format website tidak valid',
            'logo.image' => 'File logo harus berupa gambar',
            'logo.mimes' => 'Format logo harus jpeg, png, jpg, atau gif',
            'logo.max' => 'Ukuran logo maksimal 2MB',
            'status.in' => 'Status tidak valid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except('logo');
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($profilSekolah->logo && Storage::disk('public')->exists($profilSekolah->logo)) {
                Storage::disk('public')->delete($profilSekolah->logo);
            }
            
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        $profilSekolah->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profil sekolah berhasil diperbarui',
            'data' => $profilSekolah
        ]);
    }

    /**
     * Delete school profile
     */
    public function destroy(ProfilSekolah $profilSekolah): JsonResponse
    {
        // Delete logo if exists
        if ($profilSekolah->logo && Storage::disk('public')->exists($profilSekolah->logo)) {
            Storage::disk('public')->delete($profilSekolah->logo);
        }

        $profilSekolah->delete();

        return response()->json([
            'success' => true,
            'message' => 'Profil sekolah berhasil dihapus'
        ]);
    }

    /**
     * Get school profile by NPSN
     */
    public function getByNpsn(string $npsn): JsonResponse
    {
        $profilSekolah = ProfilSekolah::where('npsn', $npsn)
            ->with(['license', 'tahunAkademik'])
            ->first();

        if (!$profilSekolah) {
            return response()->json([
                'success' => false,
                'message' => 'Profil sekolah tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data profil sekolah berhasil diambil',
            'data' => $profilSekolah
        ]);
    }

    /**
     * Get schools by jenjang
     */
    public function getByJenjang(string $jenjang): JsonResponse
    {
        $profiles = ProfilSekolah::where('jenjang', $jenjang)
            ->where('status', 'aktif')
            ->with(['license'])
            ->orderBy('nama_sekolah')
            ->get();

        return response()->json([
            'success' => true,
            'message' => "Data sekolah jenjang {$jenjang} berhasil diambil",
            'data' => $profiles
        ]);
    }
}
