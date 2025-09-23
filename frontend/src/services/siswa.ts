import { api } from './api'

// Types for siswa data
export interface Siswa {
  id: number
  id_user: number
  nis: string
  nisn: string
  nama: string
  kelas: string
  tanggal_lahir?: string
  jenis_kelamin?: string
  alamat?: string
  telepon?: string
  nama_orang_tua?: string
  telepon_orang_tua?: string
  status: string
  created_at: string
  updated_at: string
  user?: {
    id: number
    nama: string
    email: string
    jenis_user: string
    status: string
  }
}

export interface SiswaListResponse {
  data: Siswa[]
  meta: {
    current_page: number
    last_page: number
    per_page: number
    total: number
  }
}

export interface SiswaStats {
  total_siswa: number
  siswa_aktif: number
  siswa_per_kelas: Array<{
    kelas: string
    jumlah: number
  }>
  siswa_per_jenis_kelamin: Array<{
    jenis_kelamin: string
    jumlah: number
  }>
}

// Siswa service functions
export const siswaService = {
  // Get all siswa for specific jenjang
  async getAllSiswa(jenjang: string, params?: any): Promise<SiswaListResponse> {
    try {
      const response = await api.get(`/jenjang/${jenjang}/siswa`, { params })
      return response.data
    } catch (error) {
      console.error(`Error fetching ${jenjang} siswa:`, error)
      throw error
    }
  },

  // Get siswa by ID
  async getSiswaById(jenjang: string, id: number): Promise<Siswa> {
    try {
      const response = await api.get(`/jenjang/${jenjang}/siswa/${id}`)
      return response.data.data
    } catch (error) {
      console.error(`Error fetching ${jenjang} siswa ${id}:`, error)
      throw error
    }
  },

  // Create new siswa
  async createSiswa(jenjang: string, data: Partial<Siswa>): Promise<Siswa> {
    try {
      const response = await api.post(`/jenjang/${jenjang}/siswa`, data)
      return response.data.data
    } catch (error) {
      console.error(`Error creating ${jenjang} siswa:`, error)
      throw error
    }
  },

  // Update siswa
  async updateSiswa(jenjang: string, id: number, data: Partial<Siswa>): Promise<Siswa> {
    try {
      const response = await api.put(`/jenjang/${jenjang}/siswa/${id}`, data)
      return response.data.data
    } catch (error) {
      console.error(`Error updating ${jenjang} siswa ${id}:`, error)
      throw error
    }
  },

  // Delete siswa
  async deleteSiswa(jenjang: string, id: number): Promise<void> {
    try {
      await api.delete(`/jenjang/${jenjang}/siswa/${id}`)
    } catch (error) {
      console.error(`Error deleting ${jenjang} siswa ${id}:`, error)
      throw error
    }
  },

  // Get siswa statistics
  async getSiswaStats(jenjang: string): Promise<SiswaStats> {
    try {
      const response = await api.get(`/jenjang/${jenjang}/siswa/statistics`)
      return response.data.data
    } catch (error) {
      console.error(`Error fetching ${jenjang} siswa statistics:`, error)
      throw error
    }
  },

  // Search siswa
  async searchSiswa(jenjang: string, query: string): Promise<SiswaListResponse> {
    try {
      const response = await api.get(`/jenjang/${jenjang}/siswa`, {
        params: { search: query }
      })
      return response.data
    } catch (error) {
      console.error(`Error searching ${jenjang} siswa:`, error)
      throw error
    }
  },

  // Get siswa by kelas
  async getSiswaByKelas(jenjang: string, kelas: string): Promise<SiswaListResponse> {
    try {
      const response = await api.get(`/jenjang/${jenjang}/siswa`, {
        params: { kelas }
      })
      return response.data
    } catch (error) {
      console.error(`Error fetching ${jenjang} siswa by kelas ${kelas}:`, error)
      throw error
    }
  }
}

// Export default
export default siswaService
