import api from './api'

// License Types
export interface License {
  id: number
  license_key: string
  license_type: 'trial' | 'single' | 'multi' | 'enterprise'
  max_users: number
  jenjang_access: string[]
  features: string[]
  expires_at: string
  is_active: boolean
  created_at: string
  updated_at: string
}

export interface CreateLicenseData {
  license_key: string
  license_type: 'trial' | 'single' | 'multi' | 'enterprise'
  max_users: number
  jenjang_access: string[]
  features: string[]
  expires_at: string
}

export interface UpdateLicenseData {
  license_key?: string
  license_type?: 'trial' | 'single' | 'multi' | 'enterprise'
  max_users?: number
  jenjang_access?: string[]
  features?: string[]
  expires_at?: string
  is_active?: boolean
}

export interface LicenseListResponse {
  data: License[]
  meta: {
    current_page: number
    last_page: number
    per_page: number
    total: number
  }
}

class LicenseService {
  /**
   * Get all licenses with pagination
   */
  async getLicenses(params?: {
    page?: number
    per_page?: number
    search?: string
    license_type?: string
    is_active?: boolean
  }): Promise<LicenseListResponse> {
    const response = await api.get<LicenseListResponse>('/licenses', { params })
    return response.data
  }

  /**
   * Get license by ID
   */
  async getLicense(id: number): Promise<{ data: License }> {
    const response = await api.get<{ data: License }>(`/licenses/${id}`)
    return response.data
  }

  /**
   * Create new license
   */
  async createLicense(data: CreateLicenseData): Promise<{ data: License }> {
    const response = await api.post<{ data: License }>('/licenses', data)
    return response.data
  }

  /**
   * Update license
   */
  async updateLicense(id: number, data: UpdateLicenseData): Promise<{ data: License }> {
    const response = await api.put<{ data: License }>(`/licenses/${id}`, data)
    return response.data
  }

  /**
   * Delete license
   */
  async deleteLicense(id: number): Promise<{ success: boolean; message: string }> {
    const response = await api.delete<{ success: boolean; message: string }>(`/licenses/${id}`)
    return response.data
  }

  /**
   * Activate license
   */
  async activateLicense(id: number): Promise<{ data: License }> {
    const response = await api.post<{ data: License }>(`/licenses/${id}/activate`)
    return response.data
  }

  /**
   * Deactivate license
   */
  async deactivateLicense(id: number): Promise<{ data: License }> {
    const response = await api.post<{ data: License }>(`/licenses/${id}/deactivate`)
    return response.data
  }

  /**
   * Check license status
   */
  async checkLicense(id: number): Promise<{ 
    data: { 
      is_valid: boolean
      is_active: boolean
      is_expired: boolean
      days_remaining: number
      message: string
    }
  }> {
    const response = await api.get<{ 
      data: { 
        is_valid: boolean
        is_active: boolean
        is_expired: boolean
        days_remaining: number
        message: string
      }
    }>(`/licenses/${id}/check`)
    return response.data
  }

  /**
   * Get license statistics
   */
  async getLicenseStats(): Promise<{
    data: {
      total_licenses: number
      active_licenses: number
      expired_licenses: number
      trial_licenses: number
      basic_licenses: number
      premium_licenses: number
      enterprise_licenses: number
    }
  }> {
    const response = await api.get<{
      data: {
        total_licenses: number
        active_licenses: number
        expired_licenses: number
        trial_licenses: number
        basic_licenses: number
        premium_licenses: number
        enterprise_licenses: number
      }
    }>('/licenses/stats')
    return response.data
  }

  /**
   * Validate license key
   */
  async validateLicenseKey(licenseKey: string): Promise<{
    data: {
      is_valid: boolean
      license_type?: string
      message: string
    }
  }> {
    const response = await api.post<{
      data: {
        is_valid: boolean
        license_type?: string
        message: string
      }
    }>('/licenses/validate', { license_key: licenseKey })
    return response.data
  }

  /**
   * Get available jenjang based on license
   */
  async getAvailableJenjang(): Promise<string[]> {
    try {
      const response = await api.get('/license/available-jenjang')
      return response.data.data || []
    } catch (error) {
      console.error('Error fetching available jenjang:', error)
      return []
    }
  }

  /**
   * Check if jenjang is available in license
   */
  async isJenjangAvailable(jenjang: string): Promise<boolean> {
    try {
      const availableJenjang = await this.getAvailableJenjang()
      return availableJenjang.includes(jenjang)
    } catch (error) {
      console.error('Error checking jenjang availability:', error)
      return false
    }
  }

  /**
   * Get license features for specific jenjang
   */
  async getJenjangFeatures(jenjang: string): Promise<string[]> {
    try {
      const response = await api.get(`/license/jenjang/${jenjang}/features`)
      return response.data.data || []
    } catch (error) {
      console.error('Error fetching jenjang features:', error)
      return []
    }
  }
}

export const licenseService = new LicenseService()
export default licenseService
