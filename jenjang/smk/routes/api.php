<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SMK Module API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your SMK module.
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('api/jenjang/smk')->middleware(['auth:sanctum'])->group(function () {
    
    // Siswa SMK Routes
    Route::apiResource('siswa', \Jenjang\SMK\Http\Controllers\SiswaSMKController::class);
    Route::get('siswa/statistics', [\Jenjang\SMK\Http\Controllers\SiswaSMKController::class, 'statistics']);
    
    // Presensi SMK Routes
    Route::apiResource('presensi', \Jenjang\SMK\Http\Controllers\PresensiSMKController::class);
    Route::post('presensi/bulk', [\Jenjang\SMK\Http\Controllers\PresensiSMKController::class, 'bulkCreate']);
    Route::get('presensi/statistics', [\Jenjang\SMK\Http\Controllers\PresensiSMKController::class, 'statistics']);
    
    // Kejuruan SMK Routes
    Route::apiResource('kejuruan', \Jenjang\SMK\Http\Controllers\KejuruanSMKController::class);
    Route::post('kejuruan/register-student', [\Jenjang\SMK\Http\Controllers\KejuruanSMKController::class, 'registerStudent']);
    Route::post('kejuruan/unregister-student', [\Jenjang\SMK\Http\Controllers\KejuruanSMKController::class, 'unregisterStudent']);
    Route::get('kejuruan/{kejuruan}/students', [\Jenjang\SMK\Http\Controllers\KejuruanSMKController::class, 'getStudents']);
    Route::get('kejuruan/statistics', [\Jenjang\SMK\Http\Controllers\KejuruanSMKController::class, 'statistics']);
    
    // Program Kesiswaan SMK Routes
    Route::apiResource('program-kesiswaan', \Jenjang\SMK\Http\Controllers\ProgramKesiswaanSMKController::class);
    Route::post('program-kesiswaan/{program}/add-participant', [\Jenjang\SMK\Http\Controllers\ProgramKesiswaanSMKController::class, 'addParticipant']);
    Route::post('program-kesiswaan/{program}/remove-participant', [\Jenjang\SMK\Http\Controllers\ProgramKesiswaanSMKController::class, 'removeParticipant']);
    Route::get('program-kesiswaan/{program}/participants', [\Jenjang\SMK\Http\Controllers\ProgramKesiswaanSMKController::class, 'getParticipants']);
    Route::post('program-kesiswaan/{program}/update-score', [\Jenjang\SMK\Http\Controllers\ProgramKesiswaanSMKController::class, 'updateParticipantScore']);
    Route::post('program-kesiswaan/{program}/complete', [\Jenjang\SMK\Http\Controllers\ProgramKesiswaanSMKController::class, 'completeProgram']);
    Route::get('program-kesiswaan/{program}/completion-rate', [\Jenjang\SMK\Http\Controllers\ProgramKesiswaanSMKController::class, 'getCompletionRate']);
    Route::get('program-kesiswaan/statistics', [\Jenjang\SMK\Http\Controllers\ProgramKesiswaanSMKController::class, 'statistics']);
    
    // SMK Module Statistics
    Route::get('statistics', function () {
        return response()->json([
            'success' => true,
            'data' => [
                'module' => 'SMK',
                'description' => 'Sekolah Menengah Kejuruan Module',
                'features' => [
                    'siswa',
                    'presensi', 
                    'kejuruan',
                    'program-kesiswaan'
                ],
                'database' => 'siska_smk',
                'version' => '1.0.0'
            ]
        ]);
    });
});
