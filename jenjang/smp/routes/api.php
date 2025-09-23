<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SMP Module API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your SMP module.
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('api/jenjang/smp')->middleware(['auth:sanctum'])->group(function () {
    
    // Siswa SMP Routes
    Route::apiResource('siswa', \Jenjang\SMP\Http\Controllers\SiswaSMPController::class);
    Route::get('siswa/statistics', [\Jenjang\SMP\Http\Controllers\SiswaSMPController::class, 'statistics']);
    
    // Presensi SMP Routes
    Route::apiResource('presensi', \Jenjang\SMP\Http\Controllers\PresensiSMPController::class);
    Route::post('presensi/bulk', [\Jenjang\SMP\Http\Controllers\PresensiSMPController::class, 'bulkCreate']);
    Route::get('presensi/statistics', [\Jenjang\SMP\Http\Controllers\PresensiSMPController::class, 'statistics']);
    
    // Ekstrakurikuler SMP Routes
    Route::apiResource('ekstrakurikuler', \Jenjang\SMP\Http\Controllers\EkstrakurikulerSMPController::class);
    Route::post('ekstrakurikuler/register-student', [\Jenjang\SMP\Http\Controllers\EkstrakurikulerSMPController::class, 'registerStudent']);
    Route::post('ekstrakurikuler/unregister-student', [\Jenjang\SMP\Http\Controllers\EkstrakurikulerSMPController::class, 'unregisterStudent']);
    Route::get('ekstrakurikuler/{ekstrakurikuler}/students', [\Jenjang\SMP\Http\Controllers\EkstrakurikulerSMPController::class, 'getStudents']);
    Route::get('ekstrakurikuler/statistics', [\Jenjang\SMP\Http\Controllers\EkstrakurikulerSMPController::class, 'statistics']);
    
    // Program Kesiswaan SMP Routes
    Route::apiResource('program-kesiswaan', \Jenjang\SMP\Http\Controllers\ProgramKesiswaanSMPController::class);
    Route::post('program-kesiswaan/{program}/add-participant', [\Jenjang\SMP\Http\Controllers\ProgramKesiswaanSMPController::class, 'addParticipant']);
    Route::post('program-kesiswaan/{program}/remove-participant', [\Jenjang\SMP\Http\Controllers\ProgramKesiswaanSMPController::class, 'removeParticipant']);
    Route::get('program-kesiswaan/{program}/participants', [\Jenjang\SMP\Http\Controllers\ProgramKesiswaanSMPController::class, 'getParticipants']);
    Route::post('program-kesiswaan/{program}/update-score', [\Jenjang\SMP\Http\Controllers\ProgramKesiswaanSMPController::class, 'updateParticipantScore']);
    Route::post('program-kesiswaan/{program}/complete', [\Jenjang\SMP\Http\Controllers\ProgramKesiswaanSMPController::class, 'completeProgram']);
    Route::get('program-kesiswaan/{program}/completion-rate', [\Jenjang\SMP\Http\Controllers\ProgramKesiswaanSMPController::class, 'getCompletionRate']);
    Route::get('program-kesiswaan/statistics', [\Jenjang\SMP\Http\Controllers\ProgramKesiswaanSMPController::class, 'statistics']);
    
    // SMP Module Statistics
    Route::get('statistics', function () {
        return response()->json([
            'success' => true,
            'data' => [
                'module' => 'SMP',
                'description' => 'Sekolah Menengah Pertama Module',
                'features' => [
                    'siswa',
                    'presensi', 
                    'ekstrakurikuler',
                    'program-kesiswaan'
                ],
                'database' => 'siska_smp',
                'version' => '1.0.0'
            ]
        ]);
    });
});
