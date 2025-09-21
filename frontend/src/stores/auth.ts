import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { useToast } from 'vue-toastification'
import { authService } from '@/services/auth'
import type { User, LoginCredentials, AuthResponse } from '@/types/auth'

export const useAuthStore = defineStore('auth', () => {
  // State
  const user = ref<User | null>(null)
  const token = ref<string | null>(localStorage.getItem('auth_token'))
  const isLoading = ref(false)

  // Getters
  const isAuthenticated = computed(() => !!token.value && !!user.value)
  const userRole = computed(() => user.value?.role_type || null)
  const isAdmin = computed(() => user.value?.role_type === 'admin')
  const isGuru = computed(() => user.value?.role_type === 'guru')
  const isSiswa = computed(() => user.value?.role_type === 'siswa')

  // Actions
  const login = async (credentials: LoginCredentials): Promise<AuthResponse> => {
    isLoading.value = true
    try {
      const response = await authService.login(credentials)
      
      if (response.success) {
        token.value = response.data.token
        user.value = response.data.user
        
        // Store token in localStorage
        localStorage.setItem('auth_token', response.data.token)
        
        // Set default authorization header
        authService.setAuthToken(response.data.token)
        
        return response
      } else {
        throw new Error(response.message || 'Login gagal')
      }
    } catch (error: any) {
      throw error
    } finally {
      isLoading.value = false
    }
  }

  const logout = async (): Promise<void> => {
    isLoading.value = true
    try {
      if (token.value) {
        await authService.logout()
      }
    } catch (error) {
      // Even if logout fails on server, clear local state
      console.error('Logout error:', error)
    } finally {
      // Clear local state
      token.value = null
      user.value = null
      localStorage.removeItem('auth_token')
      authService.clearAuthToken()
      isLoading.value = false
    }
  }

  const checkAuth = async (): Promise<void> => {
    if (!token.value) {
      throw new Error('No token found')
    }

    isLoading.value = true
    try {
      const response = await authService.checkAuth()
      
      if (response.success) {
        user.value = response.data.user
        authService.setAuthToken(token.value)
      } else {
        throw new Error('Authentication failed')
      }
    } catch (error) {
      // Clear invalid token
      token.value = null
      user.value = null
      localStorage.removeItem('auth_token')
      authService.clearAuthToken()
      throw error
    } finally {
      isLoading.value = false
    }
  }

  const getProfile = async (): Promise<User> => {
    if (!token.value) {
      throw new Error('No token found')
    }

    isLoading.value = true
    try {
      const response = await authService.getProfile()
      
      if (response.success) {
        user.value = response.data.user
        return response.data.user
      } else {
        throw new Error(response.message || 'Gagal mengambil profil')
      }
    } catch (error) {
      throw error
    } finally {
      isLoading.value = false
    }
  }

  const updateProfile = async (profileData: Partial<User>): Promise<User> => {
    if (!token.value) {
      throw new Error('No token found')
    }

    isLoading.value = true
    try {
      const response = await authService.updateProfile(profileData)
      
      if (response.success) {
        user.value = response.data.user
        return response.data.user
      } else {
        throw new Error(response.message || 'Gagal memperbarui profil')
      }
    } catch (error) {
      throw error
    } finally {
      isLoading.value = false
    }
  }

  const refreshToken = async (): Promise<string> => {
    if (!token.value) {
      throw new Error('No token found')
    }

    isLoading.value = true
    try {
      const response = await authService.refreshToken()
      
      if (response.success) {
        token.value = response.data.token
        localStorage.setItem('auth_token', response.data.token)
        authService.setAuthToken(response.data.token)
        return response.data.token
      } else {
        throw new Error(response.message || 'Gagal memperbarui token')
      }
    } catch (error) {
      throw error
    } finally {
      isLoading.value = false
    }
  }

  // Initialize auth token if exists
  const initializeAuth = () => {
    const storedToken = localStorage.getItem('auth_token')
    if (storedToken) {
      token.value = storedToken
      authService.setAuthToken(storedToken)
    }
  }

  return {
    // State
    user,
    token,
    isLoading,
    
    // Getters
    isAuthenticated,
    userRole,
    isAdmin,
    isGuru,
    isSiswa,
    
    // Actions
    login,
    logout,
    checkAuth,
    getProfile,
    updateProfile,
    refreshToken,
    initializeAuth,
  }
})
