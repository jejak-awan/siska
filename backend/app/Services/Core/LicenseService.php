<?php

namespace App\Services\Core;

use App\Models\Core\License;
use App\Models\Core\ProfilSekolah;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Service untuk manajemen lisensi SISKA
 * 
 * @package App\Services\Core
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class LicenseService
{
    /**
     * Cek validitas lisensi
     */
    public function validateLicense($licenseKey, $installationId = null)
    {
        try {
            $license = License::where('license_key', $licenseKey)
                            ->where('is_active', true)
                            ->first();

            if (!$license) {
                return [
                    'valid' => false,
                    'message' => 'Lisensi tidak ditemukan atau tidak aktif'
                ];
            }

            // Cek expiry
            if ($license->expires_at < now()) {
                return [
                    'valid' => false,
                    'message' => 'Lisensi sudah expired'
                ];
            }

            // Cek installation ID jika diberikan
            if ($installationId && $license->installation_id !== $installationId) {
                return [
                    'valid' => false,
                    'message' => 'Installation ID tidak sesuai'
                ];
            }

            // Update last check
            $license->updateLastCheck();

            return [
                'valid' => true,
                'license' => $license,
                'message' => 'Lisensi valid'
            ];

        } catch (\Exception $e) {
            Log::error('License validation error: ' . $e->getMessage());
            return [
                'valid' => false,
                'message' => 'Error validasi lisensi'
            ];
        }
    }

    /**
     * Cek akses jenjang
     */
    public function checkJenjangAccess($licenseKey, $jenjang)
    {
        $validation = $this->validateLicense($licenseKey);
        
        if (!$validation['valid']) {
            return false;
        }

        return $validation['license']->hasJenjangAccess($jenjang);
    }

    /**
     * Cek akses fitur
     */
    public function checkFeatureAccess($licenseKey, $feature)
    {
        $validation = $this->validateLicense($licenseKey);
        
        if (!$validation['valid']) {
            return false;
        }

        return $validation['license']->hasFeature($feature);
    }

    /**
     * Get informasi lisensi
     */
    public function getLicenseInfo($licenseKey)
    {
        return Cache::remember("license_info_{$licenseKey}", 3600, function () use ($licenseKey) {
            $validation = $this->validateLicense($licenseKey);
            
            if (!$validation['valid']) {
                return null;
            }

            $license = $validation['license'];
            $sekolah = $license->sekolah;

            return [
                'license_key' => $license->license_key,
                'license_type' => $license->license_type,
                'jenjang_access' => $license->jenjang_access,
                'features' => $license->features,
                'max_users' => $license->max_users,
                'expires_at' => $license->expires_at,
                'sekolah' => $sekolah ? [
                    'nama_sekolah' => $sekolah->nama_sekolah,
                    'jenis_sekolah' => $sekolah->jenis_sekolah,
                    'jenjang_aktif' => $sekolah->jenjang_aktif,
                    'multi_jenjang' => $sekolah->multi_jenjang,
                ] : null,
            ];
        });
    }

    /**
     * Aktifkan lisensi
     */
    public function activateLicense($licenseKey, $installationId, $sekolahData)
    {
        try {
            $license = License::where('license_key', $licenseKey)->first();

            if (!$license) {
                return [
                    'success' => false,
                    'message' => 'Lisensi tidak ditemukan'
                ];
            }

            if ($license->is_active) {
                return [
                    'success' => false,
                    'message' => 'Lisensi sudah aktif'
                ];
            }

            // Create profil sekolah
            $sekolah = ProfilSekolah::create([
                'nama_sekolah' => $sekolahData['nama_sekolah'],
                'jenis_sekolah' => $sekolahData['jenis_sekolah'],
                'jenjang_aktif' => $sekolahData['jenjang_aktif'],
                'multi_jenjang' => $sekolahData['multi_jenjang'],
                'alamat' => $sekolahData['alamat'],
                'telepon' => $sekolahData['telepon'],
                'email' => $sekolahData['email'],
                'status' => true,
            ]);

            // Update license
            $license->update([
                'installation_id' => $installationId,
                'sekolah_id' => $sekolah->id,
                'is_active' => true,
                'activated_at' => now(),
                'last_check' => now(),
            ]);

            // Clear cache
            Cache::forget("license_info_{$licenseKey}");

            return [
                'success' => true,
                'message' => 'Lisensi berhasil diaktifkan',
                'sekolah' => $sekolah,
                'license' => $license,
            ];

        } catch (\Exception $e) {
            Log::error('License activation error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error aktivasi lisensi: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Deaktifkan lisensi
     */
    public function deactivateLicense($licenseKey)
    {
        try {
            $license = License::where('license_key', $licenseKey)->first();

            if (!$license) {
                return [
                    'success' => false,
                    'message' => 'Lisensi tidak ditemukan'
                ];
            }

            $license->update([
                'is_active' => false,
                'last_check' => now(),
            ]);

            // Clear cache
            Cache::forget("license_info_{$licenseKey}");

            return [
                'success' => true,
                'message' => 'Lisensi berhasil dideaktifkan'
            ];

        } catch (\Exception $e) {
            Log::error('License deactivation error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error deaktivasi lisensi: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update lisensi
     */
    public function updateLicense($licenseKey, $data)
    {
        try {
            $license = License::where('license_key', $licenseKey)->first();

            if (!$license) {
                return [
                    'success' => false,
                    'message' => 'Lisensi tidak ditemukan'
                ];
            }

            $license->update($data);

            // Clear cache
            Cache::forget("license_info_{$licenseKey}");

            return [
                'success' => true,
                'message' => 'Lisensi berhasil diupdate',
                'license' => $license,
            ];

        } catch (\Exception $e) {
            Log::error('License update error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error update lisensi: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Create license
     */
    public function createLicense(array $data)
    {
        try {
            $license = License::create($data);

            return [
                'success' => true,
                'message' => 'Lisensi berhasil dibuat',
                'data' => $license
            ];

        } catch (\Exception $e) {
            Log::error('Create license error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error membuat lisensi: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update license by model
     */
    public function updateLicenseModel(License $license, array $data)
    {
        try {
            $license->update($data);

            // Clear cache
            Cache::forget("license_info_{$license->license_key}");

            return [
                'success' => true,
                'message' => 'Lisensi berhasil diperbarui',
                'data' => $license
            ];

        } catch (\Exception $e) {
            Log::error('Update license model error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error memperbarui lisensi: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Activate license by model
     */
    public function activateLicenseModel(License $license, int $sekolahId)
    {
        try {
            $license->update([
                'sekolah_id' => $sekolahId,
                'is_active' => true,
                'activated_at' => now(),
                'last_check' => now(),
            ]);

            // Clear cache
            Cache::forget("license_info_{$license->license_key}");

            return [
                'success' => true,
                'message' => 'Lisensi berhasil diaktifkan',
                'data' => $license
            ];

        } catch (\Exception $e) {
            Log::error('Activate license model error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error mengaktifkan lisensi: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Deactivate license by model
     */
    public function deactivateLicenseModel(License $license)
    {
        try {
            $license->update([
                'is_active' => false,
                'last_check' => now(),
            ]);

            // Clear cache
            Cache::forget("license_info_{$license->license_key}");

            return [
                'success' => true,
                'message' => 'Lisensi berhasil dinonaktifkan',
                'data' => $license
            ];

        } catch (\Exception $e) {
            Log::error('Deactivate license model error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error menonaktifkan lisensi: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Check license status
     */
    public function checkLicenseStatus(License $license)
    {
        try {
            $isValid = $license->isValid();
            $isExpired = $license->expires_at < now();
            $isActive = $license->is_active;

            $status = 'invalid';
            if ($isValid) {
                $status = 'valid';
            } elseif ($isExpired) {
                $status = 'expired';
            } elseif (!$isActive) {
                $status = 'inactive';
            }

            return [
                'success' => true,
                'message' => 'Status lisensi berhasil dicek',
                'data' => [
                    'status' => $status,
                    'is_valid' => $isValid,
                    'is_active' => $isActive,
                    'is_expired' => $isExpired,
                    'expires_at' => $license->expires_at,
                    'activated_at' => $license->activated_at,
                    'last_check' => $license->last_check,
                    'license_type' => $license->license_type,
                    'max_users' => $license->max_users,
                    'jenjang_access' => $license->jenjang_access,
                    'features' => $license->features,
                ]
            ];

        } catch (\Exception $e) {
            Log::error('Check license status error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error mengecek status lisensi: ' . $e->getMessage()
            ];
        }
    }
}
