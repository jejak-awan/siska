<?php

use Illuminate\Support\Facades\Route;
use App\Installer\Http\Controllers\WizardController;

/*
|--------------------------------------------------------------------------
| Installer Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for the installer.
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "web" middleware group. Enjoy building your installer!
|
*/

// Check if installation is already completed
Route::middleware(['installer.check'])->group(function () {
    
    // Wizard main page
    Route::get('/', function () {
        return view('wizard.index');
    })->name('installer.index');
    
    // API routes for wizard
    Route::prefix('api')->group(function () {
        
        // Get wizard steps
        Route::get('/steps', [WizardController::class, 'getSteps'])->name('installer.api.steps');
        
        // Step 1: License and School Information
        Route::post('/validate-license-school', [WizardController::class, 'validateLicenseAndSchool'])
            ->name('installer.api.validate-license-school');
        
        // Step 2: Jenjang Selection
        Route::get('/available-jenjang', [WizardController::class, 'getAvailableJenjang'])
            ->name('installer.api.available-jenjang');
        Route::post('/validate-jenjang-selection', [WizardController::class, 'validateJenjangSelection'])
            ->name('installer.api.validate-jenjang-selection');
        
        // Step 3: Database Configuration
        Route::post('/validate-database-config', [WizardController::class, 'validateDatabaseConfig'])
            ->name('installer.api.validate-database-config');
        
        // Step 4: Installation Process
        Route::post('/start-installation', [WizardController::class, 'startInstallation'])
            ->name('installer.api.start-installation');
        Route::get('/installation-progress', [WizardController::class, 'getInstallationProgress'])
            ->name('installer.api.installation-progress');
        
        // Step 5: Complete Installation
        Route::post('/complete-installation', [WizardController::class, 'completeInstallation'])
            ->name('installer.api.complete-installation');
    });
});

// Redirect to main app if installation is completed
Route::get('/completed', function () {
    return view('wizard.completed');
})->name('installer.completed');
