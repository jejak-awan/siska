<?php

namespace App\Http\Controllers;

use App\Services\SchoolProfileService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SchoolProfileController extends Controller
{
    protected $schoolProfileService;

    public function __construct(SchoolProfileService $schoolProfileService)
    {
        $this->schoolProfileService = $schoolProfileService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $schoolProfiles = $this->schoolProfileService->getAll($request->all());
            return response()->json([
                'success' => true,
                'data' => $schoolProfiles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data profil sekolah',
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
            $schoolProfile = $this->schoolProfileService->create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Profil sekolah berhasil ditambahkan',
                'data' => $schoolProfile
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
                'message' => 'Gagal menambahkan profil sekolah',
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
            $schoolProfile = $this->schoolProfileService->getById($id);
            return response()->json([
                'success' => true,
                'data' => $schoolProfile
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Profil sekolah tidak ditemukan',
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
            $schoolProfile = $this->schoolProfileService->update($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Profil sekolah berhasil diperbarui',
                'data' => $schoolProfile
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
                'message' => 'Gagal memperbarui profil sekolah',
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
            $this->schoolProfileService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Profil sekolah berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus profil sekolah',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Activate school profile
     */
    public function activate(string $id): JsonResponse
    {
        try {
            $this->schoolProfileService->activate($id);
            return response()->json([
                'success' => true,
                'message' => 'Profil sekolah berhasil diaktifkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengaktifkan profil sekolah',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Deactivate school profile
     */
    public function deactivate(string $id): JsonResponse
    {
        try {
            $this->schoolProfileService->deactivate($id);
            return response()->json([
                'success' => true,
                'message' => 'Profil sekolah berhasil dinonaktifkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menonaktifkan profil sekolah',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get school profile by NPSN
     */
    public function getByNPSN(string $npsn): JsonResponse
    {
        try {
            $schoolProfile = $this->schoolProfileService->getByNPSN($npsn);
            
            if (!$schoolProfile) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil sekolah tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $schoolProfile
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil profil sekolah',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get school profile statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->schoolProfileService->getStatistics();
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik profil sekolah',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get active school profiles
     */
    public function active(): JsonResponse
    {
        try {
            $schoolProfiles = $this->schoolProfileService->getActive();
            return response()->json([
                'success' => true,
                'data' => $schoolProfiles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil profil sekolah aktif',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get school profiles by jenjang
     */
    public function getByJenjang(string $jenjang): JsonResponse
    {
        try {
            $schoolProfiles = $this->schoolProfileService->getByJenjang($jenjang);
            return response()->json([
                'success' => true,
                'data' => $schoolProfiles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil profil sekolah berdasarkan jenjang',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get school profiles by province
     */
    public function getByProvince(string $provinsi): JsonResponse
    {
        try {
            $schoolProfiles = $this->schoolProfileService->getByProvince($provinsi);
            return response()->json([
                'success' => true,
                'data' => $schoolProfiles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil profil sekolah berdasarkan provinsi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get school profiles by city
     */
    public function getByCity(string $kabupaten_kota): JsonResponse
    {
        try {
            $schoolProfiles = $this->schoolProfileService->getByCity($kabupaten_kota);
            return response()->json([
                'success' => true,
                'data' => $schoolProfiles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil profil sekolah berdasarkan kota',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search school profiles
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $keyword = $request->input('keyword');
            
            if (!$keyword) {
                return response()->json([
                    'success' => false,
                    'message' => 'Keyword pencarian tidak ditemukan'
                ], 400);
            }

            $schoolProfiles = $this->schoolProfileService->search($keyword);
            return response()->json([
                'success' => true,
                'data' => $schoolProfiles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mencari profil sekolah',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get school profiles by coordinates
     */
    public function getByCoordinates(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'radius' => 'nullable|numeric|min:0.1|max:100'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $radius = $request->input('radius', 10);

            $schoolProfiles = $this->schoolProfileService->getByCoordinates($latitude, $longitude, $radius);
            return response()->json([
                'success' => true,
                'data' => $schoolProfiles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil profil sekolah berdasarkan koordinat',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

