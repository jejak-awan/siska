import { api } from './api'
import type { LoginCredentials, AuthResponse, User, ApiResponse } from '@/types/auth'

class AuthService {
  /**
   * Login user
   */
  async login(credentials: LoginCredentials): Promise<AuthResponse> {
    return api.post<AuthResponse>('/auth/login', credentials)
  }

  /**
   * Logout user
   */
  async logout(): Promise<ApiResponse> {
    return api.post<ApiResponse>('/auth/logout')
  }

  /**
   * Check authentication status
   */
  async checkAuth(): Promise<AuthResponse> {
    return api.get<AuthResponse>('/auth/check')
  }

  /**
   * Get user profile
   */
  async getProfile(): Promise<AuthResponse> {
    return api.get<AuthResponse>('/auth/profile')
  }

  /**
   * Update user profile
   */
  async updateProfile(profileData: Partial<User>): Promise<AuthResponse> {
    return api.put<AuthResponse>('/auth/profile', profileData)
  }

  /**
   * Refresh authentication token
   */
  async refreshToken(): Promise<AuthResponse> {
    return api.post<AuthResponse>('/auth/refresh')
  }

  /**
   * Change password
   */
  async changePassword(data: { 
    current_password: string
    new_password: string
    new_password_confirmation: string 
  }): Promise<ApiResponse> {
    return api.post<ApiResponse>('/auth/change-password', data)
  }

  /**
   * Forgot password
   */
  async forgotPassword(email: string): Promise<ApiResponse> {
    return api.post<ApiResponse>('/auth/forgot-password', { email })
  }

  /**
   * Reset password
   */
  async resetPassword(data: { 
    token: string
    email: string
    password: string
    password_confirmation: string 
  }): Promise<ApiResponse> {
    return api.post<ApiResponse>('/auth/reset-password', data)
  }
}

export const authService = new AuthService()
export default authService