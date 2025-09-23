import { api } from './api'

// Types for SMP-specific data
export interface EkstrakurikulerSMP {
  id: number
  nama_ekstrakurikuler: string
  deskripsi?: string
  pembina?: string
  jadwal?: string
  lokasi?: string
  status: 'aktif' | 'non-aktif'
  created_at: string
  updated_at: string
}

export interface EkstrakurikulerSiswaSMP {
  id: number
  id_siswa: number
  id_ekstrakurikuler: number
  tanggal_daftar: string
  status: 'aktif' | 'non-aktif'
  created_at: string
  updated_at: string
  siswa?: {
    id: number
    nama: string
    kelas: string
  }
  ekstrakurikuler?: {
    id: number
    nama_ekstrakurikuler: string
  }
}

export interface ProgramKesiswaanSMP {
  id: number
  nama_program: string
  deskripsi?: string
  kategori: 'ekstrakurikuler' | 'organisasi' | 'prestasi'
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

// SMP service functions
export const smpService = {
  // Ekstrakurikuler SMP
  async getAllEkstrakurikuler(params?: any): Promise<{ data: EkstrakurikulerSMP[], meta: any }> {
    try {
      const response = await api.get('/jenjang/smp/ekstrakurikuler', { params })
      return response.data
    } catch (error) {
      console.error('Error fetching SMP ekstrakurikuler:', error)
      throw error
    }
  },

  async createEkstrakurikuler(data: Partial<EkstrakurikulerSMP>): Promise<EkstrakurikulerSMP> {
    try {
      const response = await api.post('/jenjang/smp/ekstrakurikuler', data)
      return response.data.data
    } catch (error) {
      console.error('Error creating SMP ekstrakurikuler:', error)
      throw error
    }
  },

  async updateEkstrakurikuler(id: number, data: Partial<EkstrakurikulerSMP>): Promise<EkstrakurikulerSMP> {
    try {
      const response = await api.put(`/jenjang/smp/ekstrakurikuler/${id}`, data)
      return response.data.data
    } catch (error) {
      console.error('Error updating SMP ekstrakurikuler:', error)
      throw error
    }
  },

  async deleteEkstrakurikuler(id: number): Promise<void> {
    try {
      await api.delete(`/jenjang/smp/ekstrakurikuler/${id}`)
    } catch (error) {
      console.error('Error deleting SMP ekstrakurikuler:', error)
      throw error
    }
  },

  async registerStudent(ekstrakurikulerId: number, siswaId: number): Promise<void> {
    try {
      await api.post(`/jenjang/smp/ekstrakurikuler/register-student`, {
        id_ekstrakurikuler: ekstrakurikulerId,
        id_siswa: siswaId
      })
    } catch (error) {
      console.error('Error registering student to SMP ekstrakurikuler:', error)
      throw error
    }
  },

  async unregisterStudent(ekstrakurikulerId: number, siswaId: number): Promise<void> {
    try {
      await api.post(`/jenjang/smp/ekstrakurikuler/unregister-student`, {
        id_ekstrakurikuler: ekstrakurikulerId,
        id_siswa: siswaId
      })
    } catch (error) {
      console.error('Error unregistering student from SMP ekstrakurikuler:', error)
      throw error
    }
  },

  async getEkstrakurikulerStudents(id: number): Promise<EkstrakurikulerSiswaSMP[]> {
    try {
      const response = await api.get(`/jenjang/smp/ekstrakurikuler/${id}/students`)
      return response.data.data
    } catch (error) {
      console.error('Error fetching SMP ekstrakurikuler students:', error)
      throw error
    }
  },

  async getEkstrakurikulerStats(): Promise<any> {
    try {
      const response = await api.get('/jenjang/smp/ekstrakurikuler/statistics')
      return response.data.data
    } catch (error) {
      console.error('Error fetching SMP ekstrakurikuler statistics:', error)
      throw error
    }
  },

  // Program Kesiswaan SMP
  async getAllProgramKesiswaan(params?: any): Promise<{ data: ProgramKesiswaanSMP[], meta: any }> {
    try {
      const response = await api.get('/jenjang/smp/program-kesiswaan', { params })
      return response.data
    } catch (error) {
      console.error('Error fetching SMP program kesiswaan:', error)
      throw error
    }
  },

  async createProgramKesiswaan(data: Partial<ProgramKesiswaanSMP>): Promise<ProgramKesiswaanSMP> {
    try {
      const response = await api.post('/jenjang/smp/program-kesiswaan', data)
      return response.data.data
    } catch (error) {
      console.error('Error creating SMP program kesiswaan:', error)
      throw error
    }
  },

  async updateProgramKesiswaan(id: number, data: Partial<ProgramKesiswaanSMP>): Promise<ProgramKesiswaanSMP> {
    try {
      const response = await api.put(`/jenjang/smp/program-kesiswaan/${id}`, data)
      return response.data.data
    } catch (error) {
      console.error('Error updating SMP program kesiswaan:', error)
      throw error
    }
  },

  async deleteProgramKesiswaan(id: number): Promise<void> {
    try {
      await api.delete(`/jenjang/smp/program-kesiswaan/${id}`)
    } catch (error) {
      console.error('Error deleting SMP program kesiswaan:', error)
      throw error
    }
  },

  async getProgramKesiswaanStats(): Promise<any> {
    try {
      const response = await api.get('/jenjang/smp/program-kesiswaan/statistics')
      return response.data.data
    } catch (error) {
      console.error('Error fetching SMP program kesiswaan statistics:', error)
      throw error
    }
  }
}

// Export default
export default smpService
