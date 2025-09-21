<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Core\LicenseController;
use App\Http\Controllers\Core\ProfilSekolahController;
use App\Http\Controllers\Core\TahunAkademikController;

/*
|--------------------------------------------------------------------------
| API Routes untuk SISKA Backend System
|--------------------------------------------------------------------------
|
| API routes untuk authentication dan core system
| 
| @author jejakawan.com
| @supported K2NET - PT. Kirana Karina Network
|
*/

// Public routes (tidak perlu authentication)
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

// Protected routes (perlu authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Authentication routes
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::put('profile', [AuthController::class, 'updateProfile']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('check', [AuthController::class, 'check']);
    });

    // Core system routes
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Data user berhasil diambil',
            'data' => [
                'user' => $request->user()
            ]
        ]);
    });

    // License management routes
    Route::apiResource('licenses', LicenseController::class);
    Route::post('licenses/{license}/activate', [LicenseController::class, 'activate']);
    Route::post('licenses/{license}/deactivate', [LicenseController::class, 'deactivate']);
    Route::get('licenses/{license}/check', [LicenseController::class, 'check']);

    // School profile routes
    Route::apiResource('profil-sekolah', ProfilSekolahController::class);
    Route::get('profil-sekolah/npsn/{npsn}', [ProfilSekolahController::class, 'getByNpsn']);
    Route::get('profil-sekolah/jenjang/{jenjang}', [ProfilSekolahController::class, 'getByJenjang']);

    // Academic year routes
    Route::apiResource('tahun-akademik', TahunAkademikController::class);
    Route::post('tahun-akademik/{tahunAkademik}/activate', [TahunAkademikController::class, 'activate']);
    Route::get('tahun-akademik/active', [TahunAkademikController::class, 'getActive']);
    Route::get('tahun-akademik/sekolah/{sekolah}', [TahunAkademikController::class, 'getBySchool']);
});
