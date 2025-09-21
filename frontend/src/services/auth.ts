import axios, { type AxiosResponse } from 'axios'
import type { LoginCredentials, AuthResponse, User, ApiResponse } from '@/types/auth'

// Create axios instance
const api = axios.create({
  baseURL: '/api',
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
})

// Request interceptor to add auth token
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('auth_token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

// Response interceptor to handle errors
api.interceptors.response.use(
  (response) => {
    return response
  },
  (error) => {
    if (error.response?.status === 401) {
      // Token expired or invalid, clear auth data
      localStorage.removeItem('auth_token')
      window.location.href = '/login'
    }
    return Promise.reject(error)
  }
)

class AuthService {
  /**
   * Set authorization token
   */
  setAuthToken(token: string): void {
    api.defaults.headers.common['Authorization'] = `Bearer ${token}`
  }

  /**
   * Clear authorization token
   */
  clearAuthToken(): void {
    delete api.defaults.headers.common['Authorization']
  }

  /**
   * Login user
   */
  async login(credentials: LoginCredentials): Promise<AuthResponse> {
    try {
      const response: AxiosResponse<AuthResponse> = await api.post('/auth/login', credentials)
      return response.data
    } catch (error: any) {
      if (error.response?.data) {
        throw new Error(error.response.data.message || 'Login gagal')
      }
      throw new Error('Terjadi kesalahan saat login')
    }
  }

  /**
   * Logout user
   */
  async logout(): Promise<ApiResponse> {
    try {
      const response: AxiosResponse<ApiResponse> = await api.post('/auth/logout')
      return response.data
    } catch (error: any) {
      if (error.response?.data) {
        throw new Error(error.response.data.message || 'Logout gagal')
      }
      throw new Error('Terjadi kesalahan saat logout')
    }
  }

  /**
   * Check authentication status
   */
  async checkAuth(): Promise<AuthResponse> {
    try {
      const response: AxiosResponse<AuthResponse> = await api.get('/auth/check')
      return response.data
    } catch (error: any) {
      if (error.response?.data) {
        throw new Error(error.response.data.message || 'Autentikasi gagal')
      }
      throw new Error('Terjadi kesalahan saat mengecek autentikasi')
    }
  }

  /**
   * Get user profile
   */
  async getProfile(): Promise<AuthResponse> {
    try {
      const response: AxiosResponse<AuthResponse> = await api.get('/auth/profile')
      return response.data
    } catch (error: any) {
      if (error.response?.data) {
        throw new Error(error.response.data.message || 'Gagal mengambil profil')
      }
      throw new Error('Terjadi kesalahan saat mengambil profil')
    }
  }

  /**
   * Update user profile
   */
  async updateProfile(profileData: Partial<User>): Promise<AuthResponse> {
    try {
      const response: AxiosResponse<AuthResponse> = await api.put('/auth/profile', profileData)
      return response.data
    } catch (error: any) {
      if (error.response?.data) {
        throw new Error(error.response.data.message || 'Gagal memperbarui profil')
      }
      throw new Error('Terjadi kesalahan saat memperbarui profil')
    }
  }

  /**
   * Refresh authentication token
   */
  async refreshToken(): Promise<AuthResponse> {
    try {
      const response: AxiosResponse<AuthResponse> = await api.post('/auth/refresh')
      return response.data
    } catch (error: any) {
      if (error.response?.data) {
        throw new Error(error.response.data.message || 'Gagal memperbarui token')
      }
      throw new Error('Terjadi kesalahan saat memperbarui token')
    }
  }
}

export const authService = new AuthService()
