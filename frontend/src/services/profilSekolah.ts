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
    return api.get<ProfilSekolahListResponse>('/profil-sekolah', { params })
  }

  /**
   * Get school profile by ID
   */
  async getProfilSekolahById(id: number): Promise<{ data: ProfilSekolah }> {
    return api.get<{ data: ProfilSekolah }>(`/profil-sekolah/${id}`)
  }

  /**
   * Get school profile by NPSN
   */
  async getProfilSekolahByNpsn(npsn: string): Promise<{ data: ProfilSekolah }> {
    return api.get<{ data: ProfilSekolah }>(`/profil-sekolah/npsn/${npsn}`)
  }

  /**
   * Get school profiles by jenjang
   */
  async getProfilSekolahByJenjang(jenjang: string): Promise<{ data: ProfilSekolah[] }> {
    return api.get<{ data: ProfilSekolah[] }>(`/profil-sekolah/jenjang/${jenjang}`)
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

    return api.upload<{ data: ProfilSekolah }>('/profil-sekolah', formData)
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

    return api.upload<{ data: ProfilSekolah }>(`/profil-sekolah/${id}`, formData, {
      method: 'PUT'
    })
  }

  /**
   * Delete school profile
   */
  async deleteProfilSekolah(id: number): Promise<{ success: boolean; message: string }> {
    return api.delete<{ success: boolean; message: string }>(`/profil-sekolah/${id}`)
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
    return api.get<{
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
  }

  /**
   * Search school profiles
   */
  async searchProfilSekolah(query: string): Promise<{ data: ProfilSekolah[] }> {
    return api.get<{ data: ProfilSekolah[] }>('/profil-sekolah/search', {
      params: { q: query }
    })
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
    return api.post<{
      data: {
        is_valid: boolean
        is_available: boolean
        message: string
      }
    }>('/profil-sekolah/validate-npsn', { npsn })
  }

  /**
   * Get active schools
   */
  async getActiveSchools(): Promise<{ data: ProfilSekolah[] }> {
    return api.get<{ data: ProfilSekolah[] }>('/profil-sekolah/active')
  }
}

export const profilSekolahService = new ProfilSekolahService()
export default profilSekolahService
