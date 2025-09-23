<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SD Module API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your SD module.
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('api/jenjang/sd')->middleware(['auth:sanctum'])->group(function () {
    
    // Siswa SD Routes
    Route::apiResource('siswa', \Jenjang\SD\Http\Controllers\SiswaSDController::class);
    Route::get('siswa/statistics', [\Jenjang\SD\Http\Controllers\SiswaSDController::class, 'statistics']);
    
    // Presensi SD Routes
    Route::apiResource('presensi', \Jenjang\SD\Http\Controllers\PresensiSDController::class);
    Route::post('presensi/bulk', [\Jenjang\SD\Http\Controllers\PresensiSDController::class, 'bulkCreate']);
    Route::get('presensi/statistics', [\Jenjang\SD\Http\Controllers\PresensiSDController::class, 'statistics']);
    
    // Kredit Poin SD Routes
    Route::apiResource('kredit-poin', \Jenjang\SD\Http\Controllers\KreditPoinSDController::class);
    Route::get('kredit-poin/statistics', [\Jenjang\SD\Http\Controllers\KreditPoinSDController::class, 'statistics']);
    
    // Program Kesiswaan SD Routes
    Route::apiResource('program-kesiswaan', \Jenjang\SD\Http\Controllers\ProgramKesiswaanSDController::class);
    Route::get('program-kesiswaan/statistics', [\Jenjang\SD\Http\Controllers\ProgramKesiswaanSDController::class, 'statistics']);
    Route::get('program-kesiswaan/{program}/participants', [\Jenjang\SD\Http\Controllers\ProgramKesiswaanSDController::class, 'getParticipants']);
    
    // Penilaian Karakter SD Routes
    Route::apiResource('penilaian-karakter', \Jenjang\SD\Http\Controllers\PenilaianKarakterSDController::class);
    Route::get('penilaian-karakter/statistics', [\Jenjang\SD\Http\Controllers\PenilaianKarakterSDController::class, 'statistics']);
    
    // SD Module Statistics
    Route::get('statistics', function () {
        return response()->json([
            'success' => true,
            'data' => [
                'module' => 'SD',
                'description' => 'Sekolah Dasar Module',
                'features' => [
                    'siswa',
                    'presensi', 
                    'kredit-poin',
                    'program-kesiswaan',
                    'penilaian-karakter'
                ],
                'database' => 'siska_sd',
                'version' => '1.0.0'
            ]
        ]);
    });
});
