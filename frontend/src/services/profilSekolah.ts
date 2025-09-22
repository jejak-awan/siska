import api from './api'

// Profil Sekolah Types
export interface ProfilSekolah {
  id: number
  nama_sekolah: string
  jenis_sekolah: 'negeri' | 'swasta' | 'yayasan'
  jenjang_aktif: string[]
  multi_jenjang: boolean
  alamat: string
  telepon: string
  email: string
  website: string
  logo: string
  struktur_organisasi: any
  sejarah: string
  visi: string
  misi: string
  tujuan: string
  status: boolean
  tahun_berdiri: number
  npsn: string
  akreditasi: string
  kepala_sekolah: string
  wakil_kepala_sekolah: string
  created_at: string
  updated_at: string
}

export interface CreateProfilSekolahData {
  nama_sekolah: string
  jenis_sekolah: 'negeri' | 'swasta' | 'yayasan'
  jenjang_aktif: string[]
  multi_jenjang: boolean
  alamat: string
  telepon: string
  email: string
  website: string
  logo?: File
  struktur_organisasi?: any
  sejarah?: string
  visi?: string
  misi?: string
  tujuan?: string
  tahun_berdiri?: number
  npsn: string
  akreditasi?: string
  kepala_sekolah?: string
  wakil_kepala_sekolah?: string
}

export interface UpdateProfilSekolahData {
  nama_sekolah?: string
  jenis_sekolah?: 'negeri' | 'swasta' | 'yayasan'
  jenjang_aktif?: string[]
  multi_jenjang?: boolean
  alamat?: string
  telepon?: string
  email?: string
  website?: string
  logo?: File
  struktur_organisasi?: any
  sejarah?: string
  visi?: string
  misi?: string
  tujuan?: string
  tahun_berdiri?: number
  npsn?: string
  akreditasi?: string
  kepala_sekolah?: string
  wakil_kepala_sekolah?: string
}

export interface ProfilSekolahListResponse {
  data: ProfilSekolah[]
  meta: {
    current_page: number
    last_page: number
    per_page: number
    total: number
  }
}

class ProfilSekolahService {
  /**
   * Get all school profiles with pagination
   */
  async getProfilSekolah(params?: {
    page?: number
    per_page?: number
    search?: string
    jenjang?: string
    provinsi?: string
    kabupaten_kota?: string
  }): Promise<ProfilSekolahListResponse> {
    const response = await api.get<ProfilSekolahListResponse>('/profil-sekolah', { params })
    return response.data
  }

  /**
   * Get school profile by ID
   */
  async getProfilSekolahById(id: number): Promise<{ data: ProfilSekolah }> {
    const response = await api.get<{ data: ProfilSekolah }>(`/profil-sekolah/${id}`)
    return response.data
  }

  /**
   * Get school profile by NPSN
   */
  async getProfilSekolahByNpsn(npsn: string): Promise<{ data: ProfilSekolah }> {
    const response = await api.get<{ data: ProfilSekolah }>(`/profil-sekolah/npsn/${npsn}`)
    return response.data
  }

  /**
   * Get school profiles by jenjang
   */
  async getProfilSekolahByJenjang(jenjang: string): Promise<{ data: ProfilSekolah[] }> {
    const response = await api.get<{ data: ProfilSekolah[] }>(`/profil-sekolah/jenjang/${jenjang}`)
    return response.data
  }

  /**
   * Create new school profile
   */
  async createProfilSekolah(data: CreateProfilSekolahData): Promise<{ data: ProfilSekolah }> {
    const formData = new FormData()
    
    // Append all fields to FormData
    Object.entries(data).forEach(([key, value]) => {
      if (value !== undefined && value !== null) {
        formData.append(key, value)
      }
    })

    const response = await api.post<{ data: ProfilSekolah }>('/profil-sekolah', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    return response.data
  }

  /**
   * Update school profile
   */
  async updateProfilSekolah(id: number, data: UpdateProfilSekolahData): Promise<{ data: ProfilSekolah }> {
    const formData = new FormData()
    
    // Append all fields to FormData
    Object.entries(data).forEach(([key, value]) => {
      if (value !== undefined && value !== null) {
        formData.append(key, value)
      }
    })

    const response = await api.post<{ data: ProfilSekolah }>(`/profil-sekolah/${id}`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    return response.data
  }

  /**
   * Delete school profile
   */
  async deleteProfilSekolah(id: number): Promise<{ success: boolean; message: string }> {
    const response = await api.delete<{ success: boolean; message: string }>(`/profil-sekolah/${id}`)
    return response.data
  }

  /**
   * Get school profile statistics
   */
  async getProfilSekolahStats(): Promise<{
    data: {
      total_sekolah: number
      sekolah_per_jenjang: {
        SD: number
        SMP: number
        SMA: number
        SMK: number
      }
      sekolah_per_provinsi: Record<string, number>
      sekolah_per_kabupaten: Record<string, number>
    }
  }> {
    const response = await api.get<{
      data: {
        total_sekolah: number
        sekolah_per_jenjang: {
          SD: number
          SMP: number
          SMA: number
          SMK: number
        }
        sekolah_per_provinsi: Record<string, number>
        sekolah_per_kabupaten: Record<string, number>
      }
    }>('/profil-sekolah/stats')
    return response.data
  }

  /**
   * Search school profiles
   */
  async searchProfilSekolah(query: string): Promise<{ data: ProfilSekolah[] }> {
    const response = await api.get<{ data: ProfilSekolah[] }>('/profil-sekolah/search', {
      params: { q: query }
    })
    return response.data
  }

  /**
   * Validate NPSN
   */
  async validateNpsn(npsn: string): Promise<{
    data: {
      is_valid: boolean
      is_available: boolean
      message: string
    }
  }> {
    const response = await api.post<{
      data: {
        is_valid: boolean
        is_available: boolean
        message: string
      }
    }>('/profil-sekolah/validate-npsn', { npsn })
    return response.data
  }

  /**
   * Get active schools
   */
  async getActiveSchools(): Promise<{ data: ProfilSekolah[] }> {
    const response = await api.get<{ data: ProfilSekolah[] }>('/profil-sekolah/active')
    return response.data
  }
}

export const profilSekolahService = new ProfilSekolahService()
export default profilSekolahService
