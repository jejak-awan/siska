import { api } from './api'

// Types for SMA-specific data
export interface OrganisasiSMA {
  id: number
  nama_organisasi: string
  deskripsi?: string
  ketua_id?: number
  wakil_ketua_id?: number
  sekretaris_id?: number
  bendahara_id?: number
  anggota?: number[]
  program_kerja?: any[]
  status: 'aktif' | 'non-aktif'
  created_at: string
  updated_at: string
  ketua?: {
    id: number
    nama: string
    kelas: string
  }
  wakilKetua?: {
    id: number
    nama: string
    kelas: string
  }
  sekretaris?: {
    id: number
    nama: string
    kelas: string
  }
  bendahara?: {
    id: number
    nama: string
    kelas: string
  }
}

export interface ProgramKesiswaanSMA {
  id: number
  nama_program: string
  deskripsi?: string
  kategori: 'organisasi' | 'prestasi' | 'karir'
  target_siswa?: number[]
  durasi?: number
  penanggung_jawab_id?: number
  status: 'active' | 'inactive' | 'completed'
  created_at: string
  updated_at: string
  penanggungJawab?: {
    id: number
    nama: string
  }
}

// SMA service functions
export const smaService = {
  // Organisasi SMA
  async getAllOrganisasi(params?: any): Promise<{ data: OrganisasiSMA[], meta: any }> {
    try {
      const response = await api.get('/jenjang/sma/organisasi', { params })
      return response.data
    } catch (error) {
      console.error('Error fetching SMA organisasi:', error)
      throw error
    }
  },

  async createOrganisasi(data: Partial<OrganisasiSMA>): Promise<OrganisasiSMA> {
    try {
      const response = await api.post('/jenjang/sma/organisasi', data)
      return response.data.data
    } catch (error) {
      console.error('Error creating SMA organisasi:', error)
      throw error
    }
  },

  async updateOrganisasi(id: number, data: Partial<OrganisasiSMA>): Promise<OrganisasiSMA> {
    try {
      const response = await api.put(`/jenjang/sma/organisasi/${id}`, data)
      return response.data.data
    } catch (error) {
      console.error('Error updating SMA organisasi:', error)
      throw error
    }
  },

  async deleteOrganisasi(id: number): Promise<void> {
    try {
      await api.delete(`/jenjang/sma/organisasi/${id}`)
    } catch (error) {
      console.error('Error deleting SMA organisasi:', error)
      throw error
    }
  },

  async addMember(organisasiId: number, siswaId: number): Promise<void> {
    try {
      await api.post(`/jenjang/sma/organisasi/${organisasiId}/add-member`, {
        id_siswa: siswaId
      })
    } catch (error) {
      console.error('Error adding member to SMA organisasi:', error)
      throw error
    }
  },

  async removeMember(organisasiId: number, siswaId: number): Promise<void> {
    try {
      await api.post(`/jenjang/sma/organisasi/${organisasiId}/remove-member`, {
        id_siswa: siswaId
      })
    } catch (error) {
      console.error('Error removing member from SMA organisasi:', error)
      throw error
    }
  },

  async getOrganisasiMembers(id: number): Promise<any[]> {
    try {
      const response = await api.get(`/jenjang/sma/organisasi/${id}/members`)
      return response.data.data
    } catch (error) {
      console.error('Error fetching SMA organisasi members:', error)
      throw error
    }
  },

  async getOrganisasiStats(): Promise<any> {
    try {
      const response = await api.get('/jenjang/sma/organisasi/statistics')
      return response.data.data
    } catch (error) {
      console.error('Error fetching SMA organisasi statistics:', error)
      throw error
    }
  },

  // Program Kesiswaan SMA
  async getAllProgramKesiswaan(params?: any): Promise<{ data: ProgramKesiswaanSMA[], meta: any }> {
    try {
      const response = await api.get('/jenjang/sma/program-kesiswaan', { params })
      return response.data
    } catch (error) {
      console.error('Error fetching SMA program kesiswaan:', error)
      throw error
    }
  },

  async createProgramKesiswaan(data: Partial<ProgramKesiswaanSMA>): Promise<ProgramKesiswaanSMA> {
    try {
      const response = await api.post('/jenjang/sma/program-kesiswaan', data)
      return response.data.data
    } catch (error) {
      console.error('Error creating SMA program kesiswaan:', error)
      throw error
    }
  },

  async updateProgramKesiswaan(id: number, data: Partial<ProgramKesiswaanSMA>): Promise<ProgramKesiswaanSMA> {
    try {
      const response = await api.put(`/jenjang/sma/program-kesiswaan/${id}`, data)
      return response.data.data
    } catch (error) {
      console.error('Error updating SMA program kesiswaan:', error)
      throw error
    }
  },

  async deleteProgramKesiswaan(id: number): Promise<void> {
    try {
      await api.delete(`/jenjang/sma/program-kesiswaan/${id}`)
    } catch (error) {
      console.error('Error deleting SMA program kesiswaan:', error)
      throw error
    }
  },

  async getProgramKesiswaanStats(): Promise<any> {
    try {
      const response = await api.get('/jenjang/sma/program-kesiswaan/statistics')
      return response.data.data
    } catch (error) {
      console.error('Error fetching SMA program kesiswaan statistics:', error)
      throw error
    }
  }
}

// Export default
export default smaService
