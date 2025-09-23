<?php

namespace App\Installer\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WizardInstallationService
{
    /**
     * Create databases for selected jenjang
     */
    public function createDatabases(array $selectedJenjang, array $databaseConfig): array
    {
        $results = [];
        $prefix = $databaseConfig['prefix'] ?? 'siska_';

        foreach ($selectedJenjang as $jenjang) {
            $databaseName = $prefix . $jenjang;
            
            try {
                // Create database
                $this->createDatabase($databaseName, $databaseConfig);
                
                // Create database connection config
                $this->createDatabaseConnection($jenjang, $databaseName, $databaseConfig);
                
                $results[$jenjang] = [
                    'success' => true,
                    'database' => $databaseName,
                    'message' => "Database {$databaseName} berhasil dibuat"
                ];
            } catch (\Exception $e) {
                $results[$jenjang] = [
                    'success' => false,
                    'database' => $databaseName,
                    'message' => "Gagal membuat database {$databaseName}: " . $e->getMessage()
                ];
            }
        }

        return $results;
    }

    /**
     * Run migrations for selected jenjang
     */
    public function runMigrations(array $selectedJenjang): array
    {
        $results = [];

        foreach ($selectedJenjang as $jenjang) {
            try {
                // Run core migrations first
                $this->runCoreMigrations();
                
                // Run jenjang-specific migrations
                $this->runJenjangMigrations($jenjang);
                
                $results[$jenjang] = [
                    'success' => true,
                    'message' => "Migrations untuk {$jenjang} berhasil dijalankan"
                ];
            } catch (\Exception $e) {
                $results[$jenjang] = [
                    'success' => false,
                    'message' => "Gagal menjalankan migrations untuk {$jenjang}: " . $e->getMessage()
                ];
            }
        }

        return $results;
    }

    /**
     * Create admin user
     */
    public function createAdminUser(array $sekolah): array
    {
        try {
            $adminData = [
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => $sekolah['email'],
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ];

            // Insert admin user to backend database
            DB::connection('backend')->table('users')->insert($adminData);

            return [
                'success' => true,
                'message' => 'Admin user berhasil dibuat',
                'data' => [
                    'username' => 'admin',
                    'password' => 'admin123'
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal membuat admin user: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Configure modules based on selected jenjang
     */
    public function configureModules(array $selectedJenjang): array
    {
        $results = [];

        foreach ($selectedJenjang as $jenjang) {
            try {
                // Register jenjang service provider
                $this->registerJenjangServiceProvider($jenjang);
                
                // Create module configuration
                $this->createModuleConfiguration($jenjang);
                
                // Seed initial data
                $this->seedInitialData($jenjang);
                
                $results[$jenjang] = [
                    'success' => true,
                    'message' => "Module {$jenjang} berhasil dikonfigurasi"
                ];
            } catch (\Exception $e) {
                $results[$jenjang] = [
                    'success' => false,
                    'message' => "Gagal mengkonfigurasi module {$jenjang}: " . $e->getMessage()
                ];
            }
        }

        return $results;
    }

    /**
     * Create school profile
     */
    public function createSchoolProfile(array $sekolah, array $selectedJenjang): array
    {
        try {
            $schoolData = [
                'npsn' => $sekolah['npsn'] ?? Str::random(8),
                'nama_sekolah' => $sekolah['nama_sekolah'],
                'jenjang' => $sekolah['jenis_sekolah'],
                'alamat' => $sekolah['alamat'],
                'kelurahan' => $sekolah['kelurahan'] ?? '',
                'kecamatan' => $sekolah['kecamatan'] ?? '',
                'kabupaten_kota' => $sekolah['kabupaten_kota'] ?? '',
                'provinsi' => $sekolah['provinsi'] ?? '',
                'kode_pos' => $sekolah['kode_pos'] ?? '',
                'telepon' => $sekolah['telepon'],
                'email' => $sekolah['email'],
                'website' => $sekolah['website'] ?? '',
                'jenjang_aktif' => $selectedJenjang,
                'created_at' => now(),
                'updated_at' => now()
            ];

            // Insert school profile to backend database
            DB::connection('backend')->table('school_profiles')->insert($schoolData);

            return [
                'success' => true,
                'message' => 'Profil sekolah berhasil dibuat',
                'data' => $schoolData
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal membuat profil sekolah: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Create license record
     */
    public function createLicenseRecord(array $license, array $sekolah): array
    {
        try {
            $licenseData = [
                'license_key' => $license['key'],
                'license_type' => $license['type'],
                'school_id' => 1, // Will be updated after school profile is created
                'is_active' => true,
                'expires_at' => $this->calculateExpiryDate($license['type']),
                'max_schools' => $this->getMaxSchools($license['type']),
                'created_at' => now(),
                'updated_at' => now()
            ];

            // Insert license to backend database
            DB::connection('backend')->table('licenses')->insert($licenseData);

            return [
                'success' => true,
                'message' => 'Record lisensi berhasil dibuat',
                'data' => $licenseData
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal membuat record lisensi: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Finalize installation
     */
    public function finalizeInstallation(): array
    {
        try {
            // Create installation complete flag
            $this->createInstallationCompleteFlag();
            
            // Clear cache
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('route:clear');
            
            // Optimize application
            Artisan::call('config:cache');
            Artisan::call('route:cache');

            return [
                'success' => true,
                'message' => 'Instalasi berhasil diselesaikan'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal menyelesaikan instalasi: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Private helper methods
     */
    private function createDatabase(string $databaseName, array $config): void
    {
        $connection = new \PDO(
            "mysql:host={$config['host']};port={$config['port']}",
            $config['username'],
            $config['password']
        );
        
        $connection->exec("CREATE DATABASE IF NOT EXISTS `{$databaseName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    }

    private function createDatabaseConnection(string $jenjang, string $databaseName, array $config): void
    {
        $connectionConfig = [
            'driver' => 'mysql',
            'host' => $config['host'],
            'port' => $config['port'],
            'database' => $databaseName,
            'username' => $config['username'],
            'password' => $config['password'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ];

        // Update database configuration
        $configPath = config_path('database.php');
        $configContent = File::get($configPath);
        
        // Add new connection to config
        $newConnection = "        '{$jenjang}' => " . var_export($connectionConfig, true) . ",\n";
        $configContent = str_replace(
            "    'connections' => [",
            "    'connections' => [\n{$newConnection}",
            $configContent
        );
        
        File::put($configPath, $configContent);
    }

    private function runCoreMigrations(): void
    {
        Artisan::call('migrate', [
            '--path' => 'database/migrations/core',
            '--force' => true
        ]);
    }

    private function runJenjangMigrations(string $jenjang): void
    {
        Artisan::call('migrate', [
            '--path' => "jenjang/{$jenjang}/database/migrations",
            '--database' => $jenjang,
            '--force' => true
        ]);
    }

    private function registerJenjangServiceProvider(string $jenjang): void
    {
        $providerClass = "App\\Jenjang\\" . strtoupper($jenjang) . "\\Providers\\" . strtoupper($jenjang) . "ServiceProvider";
        
        // Add to config/app.php providers array
        $configPath = config_path('app.php');
        $configContent = File::get($configPath);
        
        $newProvider = "        {$providerClass}::class,\n";
        $configContent = str_replace(
            "        // Package Service Providers...",
            "        // Package Service Providers...\n{$newProvider}",
            $configContent
        );
        
        File::put($configPath, $configContent);
    }

    private function createModuleConfiguration(string $jenjang): void
    {
        // Module configuration is already created in jenjang modules
        // This method can be used for additional configuration if needed
    }

    private function seedInitialData(string $jenjang): void
    {
        // Run seeders for the jenjang
        Artisan::call('db:seed', [
            '--class' => "{$jenjang}DatabaseSeeder",
            '--database' => $jenjang,
            '--force' => true
        ]);
    }

    private function calculateExpiryDate(string $licenseType): string
    {
        $expiryMap = [
            'trial' => now()->addDays(30),
            'single' => now()->addYear(),
            'multi' => now()->addYear(),
            'enterprise' => now()->addYears(3)
        ];

        return $expiryMap[$licenseType] ?? now()->addYear();
    }

    private function getMaxSchools(string $licenseType): int
    {
        $maxSchoolsMap = [
            'trial' => 1,
            'single' => 1,
            'multi' => 5,
            'enterprise' => -1 // Unlimited
        ];

        return $maxSchoolsMap[$licenseType] ?? 1;
    }

    private function createInstallationCompleteFlag(): void
    {
        $flagData = [
            'completed_at' => now()->toISOString(),
            'version' => '1.0.0',
            'installer_version' => '1.0.0'
        ];

        File::put(storage_path('app/installer_complete.json'), json_encode($flagData, JSON_PRETTY_PRINT));
    }
}
