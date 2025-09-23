import { api } from './api'

// Types for SMK-specific data
export interface KejuruanSMK {
  id: number
  nama_kejuruan: string
  deskripsi?: string
  kaprog?: string
  fasilitas?: string
  status: 'aktif' | 'non-aktif'
  created_at: string
  updated_at: string
}

export interface SiswaKejuruanSMK {
  id: number
  id_siswa: number
  id_kejuruan: number
  tanggal_daftar: string
  status: 'aktif' | 'non-aktif'
  created_at: string
  updated_at: string
  siswa?: {
    id: number
    nama: string
    kelas: string
  }
  kejuruan?: {
    id: number
    nama_kejuruan: string
  }
}

export interface ProgramKesiswaanSMK {
  id: number
  nama_program: string
  deskripsi?: string
  kategori: 'kejuruan' | 'magang' | 'sertifikasi' | 'karir'
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

// SMK service functions
export const smkService = {
  // Kejuruan SMK
  async getAllKejuruan(params?: any): Promise<{ data: KejuruanSMK[], meta: any }> {
    try {
      const response = await api.get('/jenjang/smk/kejuruan', { params })
      return response.data
    } catch (error) {
      console.error('Error fetching SMK kejuruan:', error)
      throw error
    }
  },

  async createKejuruan(data: Partial<KejuruanSMK>): Promise<KejuruanSMK> {
    try {
      const response = await api.post('/jenjang/smk/kejuruan', data)
      return response.data.data
    } catch (error) {
      console.error('Error creating SMK kejuruan:', error)
      throw error
    }
  },

  async updateKejuruan(id: number, data: Partial<KejuruanSMK>): Promise<KejuruanSMK> {
    try {
      const response = await api.put(`/jenjang/smk/kejuruan/${id}`, data)
      return response.data.data
    } catch (error) {
      console.error('Error updating SMK kejuruan:', error)
      throw error
    }
  },

  async deleteKejuruan(id: number): Promise<void> {
    try {
      await api.delete(`/jenjang/smk/kejuruan/${id}`)
    } catch (error) {
      console.error('Error deleting SMK kejuruan:', error)
      throw error
    }
  },

  async registerStudent(kejuruanId: number, siswaId: number): Promise<void> {
    try {
      await api.post(`/jenjang/smk/kejuruan/register-student`, {
        id_kejuruan: kejuruanId,
        id_siswa: siswaId
      })
    } catch (error) {
      console.error('Error registering student to SMK kejuruan:', error)
      throw error
    }
  },

  async unregisterStudent(kejuruanId: number, siswaId: number): Promise<void> {
    try {
      await api.post(`/jenjang/smk/kejuruan/unregister-student`, {
        id_kejuruan: kejuruanId,
        id_siswa: siswaId
      })
    } catch (error) {
      console.error('Error unregistering student from SMK kejuruan:', error)
      throw error
    }
  },

  async getKejuruanStudents(id: number): Promise<SiswaKejuruanSMK[]> {
    try {
      const response = await api.get(`/jenjang/smk/kejuruan/${id}/students`)
      return response.data.data
    } catch (error) {
      console.error('Error fetching SMK kejuruan students:', error)
      throw error
    }
  },

  async getKejuruanStats(): Promise<any> {
    try {
      const response = await api.get('/jenjang/smk/kejuruan/statistics')
      return response.data.data
    } catch (error) {
      console.error('Error fetching SMK kejuruan statistics:', error)
      throw error
    }
  },

  // Program Kesiswaan SMK
  async getAllProgramKesiswaan(params?: any): Promise<{ data: ProgramKesiswaanSMK[], meta: any }> {
    try {
      const response = await api.get('/jenjang/smk/program-kesiswaan', { params })
      return response.data
    } catch (error) {
      console.error('Error fetching SMK program kesiswaan:', error)
      throw error
    }
  },

  async createProgramKesiswaan(data: Partial<ProgramKesiswaanSMK>): Promise<ProgramKesiswaanSMK> {
    try {
      const response = await api.post('/jenjang/smk/program-kesiswaan', data)
      return response.data.data
    } catch (error) {
      console.error('Error creating SMK program kesiswaan:', error)
      throw error
    }
  },

  async updateProgramKesiswaan(id: number, data: Partial<ProgramKesiswaanSMK>): Promise<ProgramKesiswaanSMK> {
    try {
      const response = await api.put(`/jenjang/smk/program-kesiswaan/${id}`, data)
      return response.data.data
    } catch (error) {
      console.error('Error updating SMK program kesiswaan:', error)
      throw error
    }
  },

  async deleteProgramKesiswaan(id: number): Promise<void> {
    try {
      await api.delete(`/jenjang/smk/program-kesiswaan/${id}`)
    } catch (error) {
      console.error('Error deleting SMK program kesiswaan:', error)
      throw error
    }
  },

  async getProgramKesiswaanStats(): Promise<any> {
    try {
      const response = await api.get('/jenjang/smk/program-kesiswaan/statistics')
      return response.data.data
    } catch (error) {
      console.error('Error fetching SMK program kesiswaan statistics:', error)
      throw error
    }
  }
}

// Export default
export default smkService
