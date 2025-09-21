<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Core\License;
use App\Services\Core\LicenseService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * License Controller untuk SISKA Backend System
 * 
 * @package App\Http\Controllers\Core
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class LicenseController extends Controller
{
    protected $licenseService;

    public function __construct(LicenseService $licenseService)
    {
        $this->licenseService = $licenseService;
    }

    /**
     * Get all licenses
     */
    public function index(Request $request): JsonResponse
    {
        $licenses = License::with('sekolah')
            ->when($request->search, function ($query, $search) {
                return $query->where('license_key', 'like', "%{$search}%")
                    ->orWhere('installation_id', 'like', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('is_active', $status === 'aktif');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'message' => 'Data lisensi berhasil diambil',
            'data' => $licenses
        ]);
    }

    /**
     * Get license by ID
     */
    public function show(License $license): JsonResponse
    {
        $license->load('sekolah');

        return response()->json([
            'success' => true,
            'message' => 'Data lisensi berhasil diambil',
            'data' => $license
        ]);
    }

    /**
     * Create new license
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'license_key' => 'required|string|unique:license_management,license_key',
            'installation_id' => 'nullable|string',
            'sekolah_id' => 'nullable|exists:profil_sekolah,id',
            'license_type' => 'required|in:trial,single,multi,enterprise',
            'jenjang_access' => 'nullable|array',
            'features' => 'nullable|array',
            'max_users' => 'required|integer|min:1',
            'expires_at' => 'nullable|date|after:now',
        ], [
            'license_key.required' => 'Kunci lisensi wajib diisi',
            'license_key.unique' => 'Kunci lisensi sudah digunakan',
            'license_type.required' => 'Jenis lisensi wajib diisi',
            'license_type.in' => 'Jenis lisensi tidak valid',
            'max_users.required' => 'Maksimal pengguna wajib diisi',
            'max_users.min' => 'Maksimal pengguna minimal 1',
            'expires_at.after' => 'Tanggal kadaluarsa harus setelah hari ini',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $license = $this->licenseService->createLicense($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Lisensi berhasil dibuat',
            'data' => $license
        ], 201);
    }

    /**
     * Update license
     */
    public function update(Request $request, License $license): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'license_key' => 'sometimes|string|unique:license_management,license_key,' . $license->id,
            'installation_id' => 'nullable|string',
            'sekolah_id' => 'nullable|exists:profil_sekolah,id',
            'license_type' => 'sometimes|in:trial,single,multi,enterprise',
            'jenjang_access' => 'nullable|array',
            'features' => 'nullable|array',
            'max_users' => 'sometimes|integer|min:1',
            'expires_at' => 'nullable|date|after:now',
            'is_active' => 'sometimes|boolean',
        ], [
            'license_key.unique' => 'Kunci lisensi sudah digunakan',
            'license_type.in' => 'Jenis lisensi tidak valid',
            'max_users.min' => 'Maksimal pengguna minimal 1',
            'expires_at.after' => 'Tanggal kadaluarsa harus setelah hari ini',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $license = $this->licenseService->updateLicense($license, $request->all());

        return response()->json([
            'success' => true,
            'message' => 'Lisensi berhasil diperbarui',
            'data' => $license
        ]);
    }

    /**
     * Delete license
     */
    public function destroy(License $license): JsonResponse
    {
        $license->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lisensi berhasil dihapus'
        ]);
    }

    /**
     * Activate license
     */
    public function activate(Request $request, License $license): JsonResponse
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

        $license = $this->licenseService->activateLicense($license, $request->sekolah_id);

        return response()->json([
            'success' => true,
            'message' => 'Lisensi berhasil diaktifkan',
            'data' => $license
        ]);
    }

    /**
     * Deactivate license
     */
    public function deactivate(License $license): JsonResponse
    {
        $license = $this->licenseService->deactivateLicense($license);

        return response()->json([
            'success' => true,
            'message' => 'Lisensi berhasil dinonaktifkan',
            'data' => $license
        ]);
    }

    /**
     * Check license status
     */
    public function check(License $license): JsonResponse
    {
        $status = $this->licenseService->checkLicenseStatus($license);

        return response()->json([
            'success' => true,
            'message' => 'Status lisensi berhasil dicek',
            'data' => $status
        ]);
    }
}
