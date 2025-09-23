<?php

namespace App\Http\Controllers;

use App\Services\LicenseService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LicenseController extends Controller
{
    protected $licenseService;

    public function __construct(LicenseService $licenseService)
    {
        $this->licenseService = $licenseService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $licenses = $this->licenseService->getAll($request->all());
            return response()->json([
                'success' => true,
                'data' => $licenses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data lisensi',
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
            $license = $this->licenseService->create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Lisensi berhasil ditambahkan',
                'data' => $license
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan lisensi',
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
            $license = $this->licenseService->getById($id);
            return response()->json([
                'success' => true,
                'data' => $license
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lisensi tidak ditemukan',
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
            $license = $this->licenseService->update($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Lisensi berhasil diperbarui',
                'data' => $license
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui lisensi',
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
            $this->licenseService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Lisensi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus lisensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Activate license
     */
    public function activate(string $id): JsonResponse
    {
        try {
            $this->licenseService->activate($id);
            return response()->json([
                'success' => true,
                'message' => 'Lisensi berhasil diaktifkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengaktifkan lisensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Deactivate license
     */
    public function deactivate(string $id): JsonResponse
    {
        try {
            $this->licenseService->deactivate($id);
            return response()->json([
                'success' => true,
                'message' => 'Lisensi berhasil dinonaktifkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menonaktifkan lisensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate license
     */
    public function validateLicense(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'license_key' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $result = $this->licenseService->validateLicense($request->input('license_key'));
            
            return response()->json([
                'success' => $result['valid'],
                'message' => $result['message'],
                'data' => $result['license'] ?? null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memvalidasi lisensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate license key
     */
    public function generateKey(): JsonResponse
    {
        try {
            $key = $this->licenseService->generateLicenseKey();
            return response()->json([
                'success' => true,
                'data' => [
                    'license_key' => $key
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghasilkan license key',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get license statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->licenseService->getStatistics();
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik lisensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get active licenses
     */
    public function active(): JsonResponse
    {
        try {
            $licenses = $this->licenseService->getActive();
            return response()->json([
                'success' => true,
                'data' => $licenses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil lisensi aktif',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get expired licenses
     */
    public function expired(): JsonResponse
    {
        try {
            $licenses = $this->licenseService->getExpired();
            return response()->json([
                'success' => true,
                'data' => $licenses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil lisensi expired',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get licenses expiring soon
     */
    public function expiringSoon(Request $request): JsonResponse
    {
        try {
            $days = $request->input('days', 30);
            $licenses = $this->licenseService->getExpiringSoon($days);
            return response()->json([
                'success' => true,
                'data' => $licenses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil lisensi yang akan expired',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check license usage
     */
    public function usage(string $id): JsonResponse
    {
        try {
            $usage = $this->licenseService->checkUsage($id);
            return response()->json([
                'success' => true,
                'data' => $usage
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengecek penggunaan lisensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
