export interface User {
  id: number
  username: string
  email: string
  role_type: 'admin' | 'guru' | 'siswa'
  status: 'aktif' | 'nonaktif'
  last_login_at: string | null
  profile_data?: Record<string, any>
  created_at: string
  updated_at: string
}

export interface LoginCredentials {
  username: string
  password: string
}

export interface AuthResponse {
  success: boolean
  message: string
  data: {
    user: User
    token: string
    token_type: string
  }
}

export interface ApiResponse {
  success: boolean
  message: string
  data?: any
  errors?: Record<string, string[]>
}
