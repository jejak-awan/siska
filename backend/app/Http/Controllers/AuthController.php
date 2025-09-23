<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login user
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $result = $this->authService->authenticate($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'data' => $result
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login gagal',
                'error' => $e->getMessage()
            ], 401);
        }
    }

    /**
     * Register new user
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $result = $this->authService->register($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil',
                'data' => $result
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registrasi gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout();
            
            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current user
     */
    public function me(Request $request): JsonResponse
    {
        try {
            $user = $this->authService->getCurrentUser();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'permissions' => $this->authService->getUserPermissions()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check authentication status
     */
    public function check(Request $request): JsonResponse
    {
        try {
            $isAuthenticated = $this->authService->isAuthenticated();
            $user = $isAuthenticated ? $this->authService->getCurrentUser() : null;
            
            return response()->json([
                'success' => true,
                'data' => [
                    'authenticated' => $isAuthenticated,
                    'user' => $user,
                    'permissions' => $isAuthenticated ? $this->authService->getUserPermissions() : []
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengecek status autentikasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Refresh token
     */
    public function refresh(Request $request): JsonResponse
    {
        try {
            $result = $this->authService->refreshToken();
            
            return response()->json([
                'success' => true,
                'message' => 'Token berhasil diperbarui',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui token',
                'error' => $e->getMessage()
            ], 401);
        }
    }

    /**
     * Change password
     */
    public function changePassword(Request $request): JsonResponse
    {
        try {
            $this->authService->changePassword($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diubah'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah password',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        try {
            $user = $this->authService->updateProfile($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui',
                'data' => $user
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui profil',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check permission
     */
    public function checkPermission(Request $request): JsonResponse
    {
        try {
            $permission = $request->input('permission');
            
            if (!$permission) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permission tidak ditemukan'
                ], 400);
            }

            $hasPermission = $this->authService->hasPermission($permission);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'permission' => $permission,
                    'has_permission' => $hasPermission
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengecek permission',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

