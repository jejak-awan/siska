<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SMA Module API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your SMA module.
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('api/jenjang/sma')->middleware(['auth:sanctum'])->group(function () {
    
    // Siswa SMA Routes
    Route::apiResource('siswa', \Jenjang\SMA\Http\Controllers\SiswaSMAController::class);
    Route::get('siswa/statistics', [\Jenjang\SMA\Http\Controllers\SiswaSMAController::class, 'statistics']);
    
    // Presensi SMA Routes
    Route::apiResource('presensi', \Jenjang\SMA\Http\Controllers\PresensiSMAController::class);
    Route::post('presensi/bulk', [\Jenjang\SMA\Http\Controllers\PresensiSMAController::class, 'bulkCreate']);
    Route::get('presensi/statistics', [\Jenjang\SMA\Http\Controllers\PresensiSMAController::class, 'statistics']);
    
    // Organisasi SMA Routes
    Route::apiResource('organisasi', \Jenjang\SMA\Http\Controllers\OrganisasiSMAController::class);
    Route::post('organisasi/{organisasi}/add-member', [\Jenjang\SMA\Http\Controllers\OrganisasiSMAController::class, 'addMember']);
    Route::post('organisasi/{organisasi}/remove-member', [\Jenjang\SMA\Http\Controllers\OrganisasiSMAController::class, 'removeMember']);
    Route::get('organisasi/{organisasi}/members', [\Jenjang\SMA\Http\Controllers\OrganisasiSMAController::class, 'getMembers']);
    Route::get('organisasi/statistics', [\Jenjang\SMA\Http\Controllers\OrganisasiSMAController::class, 'statistics']);
    
    // Program Kesiswaan SMA Routes
    Route::apiResource('program-kesiswaan', \Jenjang\SMA\Http\Controllers\ProgramKesiswaanSMAController::class);
    Route::post('program-kesiswaan/{program}/add-participant', [\Jenjang\SMA\Http\Controllers\ProgramKesiswaanSMAController::class, 'addParticipant']);
    Route::post('program-kesiswaan/{program}/remove-participant', [\Jenjang\SMA\Http\Controllers\ProgramKesiswaanSMAController::class, 'removeParticipant']);
    Route::get('program-kesiswaan/{program}/participants', [\Jenjang\SMA\Http\Controllers\ProgramKesiswaanSMAController::class, 'getParticipants']);
    Route::post('program-kesiswaan/{program}/update-score', [\Jenjang\SMA\Http\Controllers\ProgramKesiswaanSMAController::class, 'updateParticipantScore']);
    Route::post('program-kesiswaan/{program}/complete', [\Jenjang\SMA\Http\Controllers\ProgramKesiswaanSMAController::class, 'completeProgram']);
    Route::get('program-kesiswaan/{program}/completion-rate', [\Jenjang\SMA\Http\Controllers\ProgramKesiswaanSMAController::class, 'getCompletionRate']);
    Route::get('program-kesiswaan/statistics', [\Jenjang\SMA\Http\Controllers\ProgramKesiswaanSMAController::class, 'statistics']);
    
    // SMA Module Statistics
    Route::get('statistics', function () {
        return response()->json([
            'success' => true,
            'data' => [
                'module' => 'SMA',
                'description' => 'Sekolah Menengah Atas Module',
                'features' => [
                    'siswa',
                    'presensi', 
                    'organisasi',
                    'program-kesiswaan'
                ],
                'database' => 'siska_sma',
                'version' => '1.0.0'
            ]
        ]);
    });
});
