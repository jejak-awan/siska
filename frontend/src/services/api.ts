import axios, { type AxiosInstance, type AxiosRequestConfig, type AxiosResponse, type AxiosError } from 'axios'
import { useToast } from 'vue-toastification'
import { useAuthStore } from '@/stores/auth'

// API Configuration
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8001/api'
const API_TIMEOUT = parseInt(import.meta.env.VITE_API_TIMEOUT || '10000')

// Create axios instance
const apiClient: AxiosInstance = axios.create({
  baseURL: API_BASE_URL,
  timeout: API_TIMEOUT,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
})

// Request interceptor
apiClient.interceptors.request.use(
  (config: AxiosRequestConfig) => {
    // Add auth token to requests
    const token = localStorage.getItem('auth_token')
    if (token && config.headers) {
      config.headers.Authorization = `Bearer ${token}`
    }
    
    // Add request timestamp for debugging
    config.metadata = { startTime: new Date() }
    
    return config
  },
  (error: AxiosError) => {
    return Promise.reject(error)
  }
)

// Response interceptor
apiClient.interceptors.response.use(
  (response: AxiosResponse) => {
    // Calculate request duration
    if (response.config.metadata?.startTime) {
      const duration = new Date().getTime() - response.config.metadata.startTime.getTime()
      console.log(`API Request: ${response.config.method?.toUpperCase()} ${response.config.url} - ${duration}ms`)
    }
    
    return response
  },
  (error: AxiosError) => {
    const toast = useToast()
    const authStore = useAuthStore()
    
    // Handle different error types
    if (error.response) {
      const { status, data } = error.response
      
      switch (status) {
        case 401:
          // Unauthorized - clear auth and redirect to login
          authStore.logout()
          toast.error('Sesi telah berakhir. Silakan login kembali.')
          break
          
        case 403:
          // Forbidden
          toast.error('Anda tidak memiliki izin untuk mengakses resource ini.')
          break
          
        case 404:
          // Not Found
          toast.error('Resource yang diminta tidak ditemukan.')
          break
          
        case 422:
          // Validation Error
          if (data?.errors) {
            // Handle validation errors
            const errorMessages = Object.values(data.errors).flat()
            errorMessages.forEach((message: any) => {
              toast.error(message)
            })
          } else {
            toast.error(data?.message || 'Data tidak valid.')
          }
          break
          
        case 429:
          // Too Many Requests
          toast.error('Terlalu banyak permintaan. Silakan coba lagi nanti.')
          break
          
        case 500:
          // Server Error
          toast.error('Terjadi kesalahan pada server. Silakan coba lagi.')
          break
          
        default:
          toast.error(data?.message || 'Terjadi kesalahan yang tidak diketahui.')
      }
    } else if (error.request) {
      // Network Error
      toast.error('Tidak dapat terhubung ke server. Periksa koneksi internet Anda.')
    } else {
      // Other Error
      toast.error('Terjadi kesalahan yang tidak diketahui.')
    }
    
    return Promise.reject(error)
  }
)

// API Response Types
export interface ApiResponse<T = any> {
  success: boolean
  message: string
  data: T
  meta?: {
    current_page?: number
    last_page?: number
    per_page?: number
    total?: number
  }
}

export interface ApiError {
  message: string
  errors?: Record<string, string[]>
}

// Generic API methods
export const api = {
  // GET request
  get: <T = any>(url: string, config?: AxiosRequestConfig): Promise<ApiResponse<T>> => {
    return apiClient.get(url, config).then(response => response.data)
  },
  
  // POST request
  post: <T = any>(url: string, data?: any, config?: AxiosRequestConfig): Promise<ApiResponse<T>> => {
    return apiClient.post(url, data, config).then(response => response.data)
  },
  
  // PUT request
  put: <T = any>(url: string, data?: any, config?: AxiosRequestConfig): Promise<ApiResponse<T>> => {
    return apiClient.put(url, data, config).then(response => response.data)
  },
  
  // PATCH request
  patch: <T = any>(url: string, data?: any, config?: AxiosRequestConfig): Promise<ApiResponse<T>> => {
    return apiClient.patch(url, data, config).then(response => response.data)
  },
  
  // DELETE request
  delete: <T = any>(url: string, config?: AxiosRequestConfig): Promise<ApiResponse<T>> => {
    return apiClient.delete(url, config).then(response => response.data)
  },
  
  // Upload file
  upload: <T = any>(url: string, formData: FormData, config?: AxiosRequestConfig): Promise<ApiResponse<T>> => {
    return apiClient.post(url, formData, {
      ...config,
      headers: {
        'Content-Type': 'multipart/form-data',
        ...config?.headers,
      },
    }).then(response => response.data)
  },
}

export default apiClient
