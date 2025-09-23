<?php

namespace App\Services;

use App\Models\License;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LicenseService
{
    protected $licenseModel;

    public function __construct(License $licenseModel)
    {
        $this->licenseModel = $licenseModel;
    }

    /**
     * Get all licenses with pagination and filters
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = $this->licenseModel->newQuery();

        // Apply filters
        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['license_type']) && $filters['license_type']) {
            $query->where('license_type', $filters['license_type']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('license_key', 'like', "%{$search}%")
                  ->orWhere('school_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('contact_email', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')
                    ->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get license by ID
     */
    public function getById(string $id): License
    {
        return $this->licenseModel->findOrFail($id);
    }

    /**
     * Get license by key
     */
    public function getByKey(string $key): ?License
    {
        return $this->licenseModel->where('license_key', $key)->first();
    }

    /**
     * Create new license
     */
    public function create(array $data): License
    {
        $validator = Validator::make($data, [
            'license_key' => 'required|string|unique:licenses',
            'license_type' => 'required|in:basic,premium,enterprise',
            'school_name' => 'required|string|max:255',
            'school_address' => 'required|string',
            'contact_person' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'max_users' => 'required|integer|min:1',
            'max_students' => 'required|integer|min:1',
            'features' => 'required|array',
            'expires_at' => 'required|date|after:now',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->licenseModel->create($data);
    }

    /**
     * Update license
     */
    public function update(string $id, array $data): License
    {
        $license = $this->getById($id);
        
        $validator = Validator::make($data, [
            'license_key' => 'sometimes|required|string|unique:licenses,license_key,' . $id,
            'license_type' => 'sometimes|required|in:basic,premium,enterprise',
            'school_name' => 'sometimes|required|string|max:255',
            'school_address' => 'sometimes|required|string',
            'contact_person' => 'sometimes|required|string|max:255',
            'contact_email' => 'sometimes|required|email',
            'contact_phone' => 'sometimes|required|string|max:20',
            'max_users' => 'sometimes|required|integer|min:1',
            'max_students' => 'sometimes|required|integer|min:1',
            'features' => 'sometimes|required|array',
            'expires_at' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:active,inactive,expired',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $license->update($data);
        return $license->fresh();
    }

    /**
     * Delete license
     */
    public function delete(string $id): bool
    {
        $license = $this->getById($id);
        return $license->delete();
    }

    /**
     * Activate license
     */
    public function activate(string $id): bool
    {
        $license = $this->getById($id);
        return $license->activate();
    }

    /**
     * Deactivate license
     */
    public function deactivate(string $id): bool
    {
        $license = $this->getById($id);
        return $license->deactivate();
    }

    /**
     * Validate license
     */
    public function validateLicense(string $key): array
    {
        $license = $this->getByKey($key);
        
        if (!$license) {
            return [
                'valid' => false,
                'message' => 'License key tidak ditemukan'
            ];
        }

        if ($license->isExpired()) {
            return [
                'valid' => false,
                'message' => 'License telah expired'
            ];
        }

        if (!$license->isActive()) {
            return [
                'valid' => false,
                'message' => 'License tidak aktif'
            ];
        }

        return [
            'valid' => true,
            'message' => 'License valid',
            'license' => $license
        ];
    }

    /**
     * Generate license key
     */
    public function generateLicenseKey(): string
    {
        do {
            $key = 'SISKA-' . strtoupper(substr(md5(uniqid()), 0, 8)) . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while ($this->getByKey($key));

        return $key;
    }

    /**
     * Get license statistics
     */
    public function getStatistics(): array
    {
        $total = $this->licenseModel->count();
        $active = $this->licenseModel->active()->count();
        $inactive = $this->licenseModel->inactive()->count();
        $expired = $this->licenseModel->expired()->count();

        // Statistics by type
        $typeStats = $this->licenseModel->selectRaw('license_type, COUNT(*) as total')
            ->groupBy('license_type')
            ->get()
            ->pluck('total', 'license_type');

        // Statistics by status
        $statusStats = $this->licenseModel->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // Expiring soon (within 30 days)
        $expiringSoon = $this->licenseModel->where('expires_at', '<=', now()->addDays(30))
            ->where('expires_at', '>', now())
            ->count();

        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
            'expired' => $expired,
            'type' => $typeStats,
            'status' => $statusStats,
            'expiring_soon' => $expiringSoon,
            'persentase_aktif' => $total > 0 ? round(($active / $total) * 100, 2) : 0
        ];
    }

    /**
     * Get active licenses
     */
    public function getActive(): Collection
    {
        return $this->licenseModel->active()->get();
    }

    /**
     * Get expired licenses
     */
    public function getExpired(): Collection
    {
        return $this->licenseModel->expired()->get();
    }

    /**
     * Get licenses expiring soon
     */
    public function getExpiringSoon(int $days = 30): Collection
    {
        return $this->licenseModel->where('expires_at', '<=', now()->addDays($days))
            ->where('expires_at', '>', now())
            ->get();
    }

    /**
     * Check license usage
     */
    public function checkUsage(string $id): array
    {
        $license = $this->getById($id);
        
        // This would need to be implemented based on actual usage tracking
        // For now, return mock data
        return [
            'max_users' => $license->max_users,
            'used_users' => 0, // Would be calculated from actual usage
            'max_students' => $license->max_students,
            'used_students' => 0, // Would be calculated from actual usage
            'usage_percentage' => 0
        ];
    }
}
