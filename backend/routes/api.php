<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\SchoolProfileController;
use App\Http\Controllers\TahunAkademikController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes (no authentication required)
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('validate-license', [LicenseController::class, 'validateLicense']);
});

// Protected routes (authentication required)
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        Route::get('check', [AuthController::class, 'check']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::post('update-profile', [AuthController::class, 'updateProfile']);
        Route::post('check-permission', [AuthController::class, 'checkPermission']);
    });

    // License routes
    Route::apiResource('licenses', LicenseController::class);
    Route::prefix('licenses')->group(function () {
        Route::post('{id}/activate', [LicenseController::class, 'activate']);
        Route::post('{id}/deactivate', [LicenseController::class, 'deactivate']);
        Route::get('{id}/usage', [LicenseController::class, 'usage']);
        Route::get('active', [LicenseController::class, 'active']);
        Route::get('expired', [LicenseController::class, 'expired']);
        Route::get('expiring-soon', [LicenseController::class, 'expiringSoon']);
        Route::get('statistics', [LicenseController::class, 'statistics']);
        Route::post('generate-key', [LicenseController::class, 'generateKey']);
    });

    // School Profile routes
    Route::apiResource('profil-sekolah', SchoolProfileController::class);
    Route::prefix('profil-sekolah')->group(function () {
        Route::post('{id}/activate', [SchoolProfileController::class, 'activate']);
        Route::post('{id}/deactivate', [SchoolProfileController::class, 'deactivate']);
        Route::get('npsn/{npsn}', [SchoolProfileController::class, 'getByNPSN']);
        Route::get('jenjang/{jenjang}', [SchoolProfileController::class, 'getByJenjang']);
        Route::get('provinsi/{provinsi}', [SchoolProfileController::class, 'getByProvince']);
        Route::get('kota/{kabupaten_kota}', [SchoolProfileController::class, 'getByCity']);
        Route::get('active', [SchoolProfileController::class, 'active']);
        Route::get('statistics', [SchoolProfileController::class, 'statistics']);
        Route::get('search', [SchoolProfileController::class, 'search']);
        Route::get('coordinates', [SchoolProfileController::class, 'getByCoordinates']);
    });

    // Academic Year routes
    Route::apiResource('tahun-akademik', TahunAkademikController::class);
    Route::prefix('tahun-akademik')->group(function () {
        Route::post('{id}/activate', [TahunAkademikController::class, 'activate']);
        Route::post('{id}/deactivate', [TahunAkademikController::class, 'deactivate']);
        Route::get('active', [TahunAkademikController::class, 'getActive']);
        Route::get('active-years', [TahunAkademikController::class, 'getActiveYears']);
        Route::get('current-years', [TahunAkademikController::class, 'getCurrentYears']);
        Route::get('past', [TahunAkademikController::class, 'getPast']);
        Route::get('future', [TahunAkademikController::class, 'getFuture']);
        Route::get('year/{tahun}', [TahunAkademikController::class, 'getByYear']);
        Route::get('semester/{semester}', [TahunAkademikController::class, 'getBySemester']);
        Route::get('year/{tahun}/semester/{semester}', [TahunAkademikController::class, 'getByYearAndSemester']);
        Route::get('next', [TahunAkademikController::class, 'getNext']);
        Route::get('previous', [TahunAkademikController::class, 'getPrevious']);
        Route::get('statistics', [TahunAkademikController::class, 'statistics']);
    });

    // Note: Jenjang-specific routes have been moved to individual jenjang modules
    // Routes are now handled by each jenjang's service provider
});

// Health check route
Route::get('health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'version' => '1.0.0'
    ]);
});