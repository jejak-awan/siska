import { api } from './api'

// Types for SD-specific data
export interface KreditPoinSD {
  id: number
  id_siswa: number
  kategori: 'positif' | 'negatif'
  poin: number
  deskripsi: string
  tanggal: string
  pemberi_poin_id: number
  semester: number
  tahun_akademik: string
  created_at: string
  updated_at: string
  siswa?: {
    id: number
    nama: string
    kelas: string
    user?: {
      id: number
      nama: string
    }
  }
  pemberiPoin?: {
    id: number
    nama: string
  }
}

export interface ProgramKesiswaanSD {
  id: number
  nama_program: string
  deskripsi?: string
  kategori: 'karakter_dasar' | 'kebersihan' | 'kedisiplinan'
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

export interface PenilaianKarakterSD {
  id: number
  id_siswa: number
  id_program: number
  aspek_karakter: string
  nilai_karakter: number
  catatan?: string
  tanggal_penilaian: string
  created_at: string
  updated_at: string
  siswa?: {
    id: number
    nama: string
    kelas: string
  }
  program?: {
    id: number
    nama_program: string
  }
}

// SD service functions
export const sdService = {
  // Kredit Poin SD
  async getAllKreditPoin(params?: any): Promise<{ data: KreditPoinSD[], meta: any }> {
    try {
      const response = await api.get('/jenjang/sd/kredit-poin', { params })
      return response.data
    } catch (error) {
      console.error('Error fetching SD kredit poin:', error)
      throw error
    }
  },

  async createKreditPoin(data: Partial<KreditPoinSD>): Promise<KreditPoinSD> {
    try {
      const response = await api.post('/jenjang/sd/kredit-poin', data)
      return response.data.data
    } catch (error) {
      console.error('Error creating SD kredit poin:', error)
      throw error
    }
  },

  async updateKreditPoin(id: number, data: Partial<KreditPoinSD>): Promise<KreditPoinSD> {
    try {
      const response = await api.put(`/jenjang/sd/kredit-poin/${id}`, data)
      return response.data.data
    } catch (error) {
      console.error('Error updating SD kredit poin:', error)
      throw error
    }
  },

  async deleteKreditPoin(id: number): Promise<void> {
    try {
      await api.delete(`/jenjang/sd/kredit-poin/${id}`)
    } catch (error) {
      console.error('Error deleting SD kredit poin:', error)
      throw error
    }
  },

  async getKreditPoinStats(params?: any): Promise<any> {
    try {
      const response = await api.get('/jenjang/sd/kredit-poin/statistics', { params })
      return response.data.data
    } catch (error) {
      console.error('Error fetching SD kredit poin statistics:', error)
      throw error
    }
  },

  // Program Kesiswaan SD
  async getAllProgramKesiswaan(params?: any): Promise<{ data: ProgramKesiswaanSD[], meta: any }> {
    try {
      const response = await api.get('/jenjang/sd/program-kesiswaan', { params })
      return response.data
    } catch (error) {
      console.error('Error fetching SD program kesiswaan:', error)
      throw error
    }
  },

  async createProgramKesiswaan(data: Partial<ProgramKesiswaanSD>): Promise<ProgramKesiswaanSD> {
    try {
      const response = await api.post('/jenjang/sd/program-kesiswaan', data)
      return response.data.data
    } catch (error) {
      console.error('Error creating SD program kesiswaan:', error)
      throw error
    }
  },

  async updateProgramKesiswaan(id: number, data: Partial<ProgramKesiswaanSD>): Promise<ProgramKesiswaanSD> {
    try {
      const response = await api.put(`/jenjang/sd/program-kesiswaan/${id}`, data)
      return response.data.data
    } catch (error) {
      console.error('Error updating SD program kesiswaan:', error)
      throw error
    }
  },

  async deleteProgramKesiswaan(id: number): Promise<void> {
    try {
      await api.delete(`/jenjang/sd/program-kesiswaan/${id}`)
    } catch (error) {
      console.error('Error deleting SD program kesiswaan:', error)
      throw error
    }
  },

  async getProgramKesiswaanStats(): Promise<any> {
    try {
      const response = await api.get('/jenjang/sd/program-kesiswaan/statistics')
      return response.data.data
    } catch (error) {
      console.error('Error fetching SD program kesiswaan statistics:', error)
      throw error
    }
  },

  async getProgramParticipants(id: number): Promise<any> {
    try {
      const response = await api.get(`/jenjang/sd/program-kesiswaan/${id}/participants`)
      return response.data.data
    } catch (error) {
      console.error('Error fetching SD program participants:', error)
      throw error
    }
  }
}

// Export default
export default sdService
