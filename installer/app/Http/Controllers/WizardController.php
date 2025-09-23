<?php

namespace App\Installer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

class WizardController extends Controller
{
    /**
     * Get wizard steps configuration
     */
    public function getSteps(): JsonResponse
    {
        $steps = [
            [
                'id' => 1,
                'title' => 'Informasi Lisensi & Sekolah',
                'description' => 'Masukkan informasi lisensi dan data sekolah',
                'icon' => '📋',
                'completed' => false,
                'active' => true
            ],
            [
                'id' => 2,
                'title' => 'Pilihan Jenjang Pendidikan',
                'description' => 'Pilih jenjang yang akan diaktifkan',
                'icon' => '📚',
                'completed' => false,
                'active' => false
            ],
            [
                'id' => 3,
                'title' => 'Konfigurasi Database',
                'description' => 'Konfigurasi koneksi database',
                'icon' => '🗄️',
                'completed' => false,
                'active' => false
            ],
            [
                'id' => 4,
                'title' => 'Proses Instalasi',
                'description' => 'Menjalankan instalasi sistem',
                'icon' => '⚙️',
                'completed' => false,
                'active' => false
            ],
            [
                'id' => 5,
                'title' => 'Testing & Validasi',
                'description' => 'Testing sistem dan validasi',
                'icon' => '🧪',
                'completed' => false,
                'active' => false
            ],
            [
                'id' => 6,
                'title' => 'Selesai',
                'description' => 'Instalasi berhasil diselesaikan',
                'icon' => '✅',
                'completed' => false,
                'active' => false
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $steps
        ]);
    }

    /**
     * Validate license and school information
     */
    public function validateLicenseAndSchool(Request $request): JsonResponse
    {
        $request->validate([
            'license' => 'required|array',
            'license.type' => 'required|in:trial,single,multi,enterprise',
            'license.key' => 'required|string|min:10',
            'sekolah' => 'required|array',
            'sekolah.nama_sekolah' => 'required|string|min:3',
            'sekolah.jenis_sekolah' => 'required|in:SD,SMP,SMA,SMK',
            'sekolah.alamat' => 'required|string|min:10',
            'sekolah.telepon' => 'required|string',
            'sekolah.email' => 'required|email'
        ]);

        try {
            // Validate license key
            $licenseValidation = $this->validateLicenseKey($request->license['key'], $request->license['type']);
            
            if (!$licenseValidation['valid']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lisensi tidak valid',
                    'errors' => ['license' => $licenseValidation['message']]
                ], 400);
            }

            // Store license and school info in session
            session([
                'installer.license' => $request->license,
                'installer.sekolah' => $request->sekolah,
                'installer.step_1_completed' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Informasi lisensi dan sekolah berhasil divalidasi',
                'data' => [
                    'license' => $request->license,
                    'sekolah' => $request->sekolah
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat validasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available jenjang based on license
     */
    public function getAvailableJenjang(): JsonResponse
    {
        $license = session('installer.license');
        
        if (!$license) {
            return response()->json([
                'success' => false,
                'message' => 'Informasi lisensi tidak ditemukan'
            ], 400);
        }

        $availableJenjang = $this->getJenjangByLicenseType($license['type']);

        return response()->json([
            'success' => true,
            'data' => $availableJenjang
        ]);
    }

    /**
     * Validate jenjang selection
     */
    public function validateJenjangSelection(Request $request): JsonResponse
    {
        $request->validate([
            'selected_jenjang' => 'required|array|min:1',
            'selected_jenjang.*' => 'in:sd,smp,sma,smk'
        ]);

        $license = session('installer.license');
        $availableJenjang = $this->getJenjangByLicenseType($license['type']);

        // Validate selection against license
        foreach ($request->selected_jenjang as $jenjang) {
            if (!in_array($jenjang, $availableJenjang)) {
                return response()->json([
                    'success' => false,
                    'message' => "Jenjang {$jenjang} tidak tersedia untuk lisensi ini"
                ], 400);
            }
        }

        // Store selected jenjang
        session([
            'installer.selected_jenjang' => $request->selected_jenjang,
            'installer.step_2_completed' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pilihan jenjang berhasil disimpan',
            'data' => $request->selected_jenjang
        ]);
    }

    /**
     * Validate database configuration
     */
    public function validateDatabaseConfig(Request $request): JsonResponse
    {
        $request->validate([
            'database' => 'required|array',
            'database.host' => 'required|string',
            'database.port' => 'required|integer|min:1|max:65535',
            'database.username' => 'required|string',
            'database.password' => 'nullable|string',
            'database.prefix' => 'nullable|string|max:10'
        ]);

        try {
            // Test database connection
            $connection = $this->testDatabaseConnection($request->database);
            
            if (!$connection['success']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Koneksi database gagal',
                    'errors' => ['database' => $connection['message']]
                ], 400);
            }

            // Store database config
            session([
                'installer.database' => $request->database,
                'installer.step_3_completed' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Konfigurasi database berhasil divalidasi',
                'data' => $request->database
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat validasi database',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Start installation process
     */
    public function startInstallation(): JsonResponse
    {
        try {
            $selectedJenjang = session('installer.selected_jenjang');
            $databaseConfig = session('installer.database');
            $sekolah = session('installer.sekolah');

            if (!$selectedJenjang || !$databaseConfig || !$sekolah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data instalasi tidak lengkap'
                ], 400);
            }

            // Start installation process
            $installation = $this->runInstallation($selectedJenjang, $databaseConfig, $sekolah);

            return response()->json([
                'success' => true,
                'message' => 'Instalasi berhasil dimulai',
                'data' => $installation
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat instalasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get installation progress
     */
    public function getInstallationProgress(): JsonResponse
    {
        $progress = session('installer.progress', [
            'current_step' => 0,
            'total_steps' => 0,
            'percentage' => 0,
            'status' => 'pending',
            'message' => 'Menunggu instalasi dimulai'
        ]);

        return response()->json([
            'success' => true,
            'data' => $progress
        ]);
    }

    /**
     * Complete installation
     */
    public function completeInstallation(): JsonResponse
    {
        try {
            // Create installation complete flag
            File::put(storage_path('app/installer_complete.json'), json_encode([
                'completed_at' => now(),
                'license' => session('installer.license'),
                'sekolah' => session('installer.sekolah'),
                'selected_jenjang' => session('installer.selected_jenjang'),
                'database' => session('installer.database')
            ]));

            // Clear installer session
            session()->forget('installer');

            return response()->json([
                'success' => true,
                'message' => 'Instalasi berhasil diselesaikan',
                'data' => [
                    'redirect_url' => '/login',
                    'admin_credentials' => [
                        'username' => 'admin',
                        'password' => 'admin123'
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyelesaikan instalasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Private helper methods
     */
    private function validateLicenseKey(string $licenseKey, string $licenseType): array
    {
        // Mock license validation - replace with actual license validation logic
        if (strlen($licenseKey) < 10) {
            return ['valid' => false, 'message' => 'License key terlalu pendek'];
        }

        if (!in_array($licenseType, ['trial', 'single', 'multi', 'enterprise'])) {
            return ['valid' => false, 'message' => 'Tipe lisensi tidak valid'];
        }

        return ['valid' => true, 'message' => 'License valid'];
    }

    private function getJenjangByLicenseType(string $licenseType): array
    {
        $jenjangMap = [
            'trial' => ['sd'],
            'single' => ['sd', 'smp', 'sma', 'smk'], // User can choose one
            'multi' => ['sd', 'smp', 'sma', 'smk'], // User can choose multiple
            'enterprise' => ['sd', 'smp', 'sma', 'smk'] // All available
        ];

        return $jenjangMap[$licenseType] ?? [];
    }

    private function testDatabaseConnection(array $config): array
    {
        try {
            $connection = new \PDO(
                "mysql:host={$config['host']};port={$config['port']}",
                $config['username'],
                $config['password']
            );
            
            return ['success' => true, 'message' => 'Koneksi berhasil'];
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function runInstallation(array $selectedJenjang, array $databaseConfig, array $sekolah): array
    {
        // Mock installation process - replace with actual installation logic
        $steps = [
            'Creating databases...',
            'Running migrations...',
            'Creating admin user...',
            'Configuring modules...',
            'Finalizing installation...'
        ];

        session(['installer.progress' => [
            'current_step' => 0,
            'total_steps' => count($steps),
            'percentage' => 0,
            'status' => 'running',
            'message' => 'Instalasi sedang berjalan...'
        ]]);

        return [
            'steps' => $steps,
            'estimated_time' => '5-10 minutes'
        ];
    }
}
