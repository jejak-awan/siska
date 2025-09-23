<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Authenticate user
     */
    public function authenticate(array $credentials): array
    {
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Find user by email (which is stored in email field)
        $user = User::where('email', $credentials['email'])->first();
        
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial tidak valid.'],
            ]);
        }

        // Manually login the user
        Auth::login($user);

        $user = Auth::user();
        
        if (!$user->isActive()) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => ['Akun tidak aktif.'],
            ]);
        }

        $user->updateLastLogin();
        
        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ];
    }

    /**
     * Register new user
     */
    public function register(array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,guru,siswa'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'status' => 'aktif'
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ];
    }

    /**
     * Logout user
     */
    public function logout(): bool
    {
        $user = Auth::user();
        
        if ($user) {
            $user->tokens()->delete();
            Auth::logout();
            return true;
        }

        return false;
    }

    /**
     * Get current user
     */
    public function getCurrentUser(): ?User
    {
        return Auth::user();
    }

    /**
     * Check if user is authenticated
     */
    public function isAuthenticated(): bool
    {
        return Auth::check();
    }

    /**
     * Refresh token
     */
    public function refreshToken(): array
    {
        $user = Auth::user();
        
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        // Delete old tokens
        $user->tokens()->delete();
        
        // Create new token
        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ];
    }

    /**
     * Change password
     */
    public function changePassword(array $data): bool
    {
        $validator = Validator::make($data, [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = Auth::user();
        
        if (!Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Password saat ini tidak benar.'],
            ]);
        }

        $user->update([
            'password' => Hash::make($data['new_password'])
        ]);

        return true;
    }

    /**
     * Update profile
     */
    public function updateProfile(array $data): User
    {
        $user = Auth::user();
        
        $validator = Validator::make($data, [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user->update($data);

        return $user->fresh();
    }

    /**
     * Get user permissions
     */
    public function getUserPermissions(): array
    {
        $user = Auth::user();
        
        if (!$user) {
            return [];
        }

        $permissions = [];

        switch ($user->role) {
            case 'admin':
                $permissions = [
                    'view_any_user',
                    'create_user',
                    'update_user',
                    'delete_user',
                    'view_any_license',
                    'create_license',
                    'update_license',
                    'delete_license',
                    'view_any_school_profile',
                    'update_school_profile',
                    'view_any_tahun_akademik',
                    'create_tahun_akademik',
                    'update_tahun_akademik',
                    'delete_tahun_akademik'
                ];
                break;
                
            case 'guru':
                $permissions = [
                    'view_any_siswa',
                    'view_siswa',
                    'update_siswa',
                    'view_any_presensi',
                    'create_presensi',
                    'update_presensi',
                    'view_any_ekstrakurikuler',
                    'view_any_organisasi',
                    'view_any_kejuruan',
                    'view_any_program_kesiswaan'
                ];
                break;
                
            case 'siswa':
                $permissions = [
                    'view_own_profile',
                    'update_own_profile',
                    'view_own_presensi',
                    'view_own_ekstrakurikuler',
                    'view_own_organisasi',
                    'view_own_kejuruan',
                    'view_own_program_kesiswaan'
                ];
                break;
        }

        return $permissions;
    }

    /**
     * Check if user has permission
     */
    public function hasPermission(string $permission): bool
    {
        $permissions = $this->getUserPermissions();
        return in_array($permission, $permissions);
    }
}
