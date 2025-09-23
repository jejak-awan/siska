import { api } from './api'

// Types for presensi data
export interface Presensi {
  id: number
  id_siswa: number
  tanggal: string
  status_presensi: 'hadir' | 'izin' | 'sakit' | 'alpha'
  keterangan?: string
  created_at: string
  updated_at: string
  siswa?: {
    id: number
    nama: string
    kelas: string
    user?: {
      id: number
      nama: string
      email: string
    }
  }
}

export interface PresensiListResponse {
  data: Presensi[]
  meta: {
    current_page: number
    last_page: number
    per_page: number
    total: number
  }
}

export interface PresensiStats {
  total_presensi: number
  hadir: number
  izin: number
  sakit: number
  alpha: number
  persentase_kehadiran: number
}

export interface BulkPresensiData {
  tanggal: string
  presensi_data: Array<{
    id_siswa: number
    status_presensi: 'hadir' | 'izin' | 'sakit' | 'alpha'
    keterangan?: string
  }>
}

// Presensi service functions
export const presensiService = {
  // Get all presensi for specific jenjang
  async getAllPresensi(jenjang: string, params?: any): Promise<PresensiListResponse> {
    try {
      const response = await api.get(`/jenjang/${jenjang}/presensi`, { params })
      return response.data
    } catch (error) {
      console.error(`Error fetching ${jenjang} presensi:`, error)
      throw error
    }
  },

  // Get presensi by ID
  async getPresensiById(jenjang: string, id: number): Promise<Presensi> {
    try {
      const response = await api.get(`/jenjang/${jenjang}/presensi/${id}`)
      return response.data.data
    } catch (error) {
      console.error(`Error fetching ${jenjang} presensi ${id}:`, error)
      throw error
    }
  },

  // Create new presensi
  async createPresensi(jenjang: string, data: Partial<Presensi>): Promise<Presensi> {
    try {
      const response = await api.post(`/jenjang/${jenjang}/presensi`, data)
      return response.data.data
    } catch (error) {
      console.error(`Error creating ${jenjang} presensi:`, error)
      throw error
    }
  },

  // Update presensi
  async updatePresensi(jenjang: string, id: number, data: Partial<Presensi>): Promise<Presensi> {
    try {
      const response = await api.put(`/jenjang/${jenjang}/presensi/${id}`, data)
      return response.data.data
    } catch (error) {
      console.error(`Error updating ${jenjang} presensi ${id}:`, error)
      throw error
    }
  },

  // Delete presensi
  async deletePresensi(jenjang: string, id: number): Promise<void> {
    try {
      await api.delete(`/jenjang/${jenjang}/presensi/${id}`)
    } catch (error) {
      console.error(`Error deleting ${jenjang} presensi ${id}:`, error)
      throw error
    }
  },

  // Bulk create presensi
  async bulkCreatePresensi(jenjang: string, data: BulkPresensiData): Promise<Presensi[]> {
    try {
      const response = await api.post(`/jenjang/${jenjang}/presensi/bulk`, data)
      return response.data.data
    } catch (error) {
      console.error(`Error bulk creating ${jenjang} presensi:`, error)
      throw error
    }
  },

  // Get presensi statistics
  async getPresensiStats(jenjang: string, params?: any): Promise<PresensiStats> {
    try {
      const response = await api.get(`/jenjang/${jenjang}/presensi/statistics`, { params })
      return response.data.data
    } catch (error) {
      console.error(`Error fetching ${jenjang} presensi statistics:`, error)
      throw error
    }
  },

  // Get presensi by tanggal
  async getPresensiByTanggal(jenjang: string, tanggal: string): Promise<PresensiListResponse> {
    try {
      const response = await api.get(`/jenjang/${jenjang}/presensi`, {
        params: { tanggal }
      })
      return response.data
    } catch (error) {
      console.error(`Error fetching ${jenjang} presensi by tanggal ${tanggal}:`, error)
      throw error
    }
  },

  // Get presensi by siswa
  async getPresensiBySiswa(jenjang: string, idSiswa: number): Promise<PresensiListResponse> {
    try {
      const response = await api.get(`/jenjang/${jenjang}/presensi`, {
        params: { id_siswa: idSiswa }
      })
      return response.data
    } catch (error) {
      console.error(`Error fetching ${jenjang} presensi by siswa ${idSiswa}:`, error)
      throw error
    }
  },

  // Get presensi by kelas
  async getPresensiByKelas(jenjang: string, kelas: string): Promise<PresensiListResponse> {
    try {
      const response = await api.get(`/jenjang/${jenjang}/presensi`, {
        params: { kelas }
      })
      return response.data
    } catch (error) {
      console.error(`Error fetching ${jenjang} presensi by kelas ${kelas}:`, error)
      throw error
    }
  }
}

// Export default
export default presensiService
