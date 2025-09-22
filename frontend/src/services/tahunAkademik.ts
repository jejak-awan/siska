import api from './api'

// Tahun Akademik Types
export interface TahunAkademik {
  id: number
  tahun_akademik: string
  semester: 'ganjil' | 'genap'
  tanggal_mulai: string
  tanggal_selesai: string
  is_active: boolean
  sekolah_id: number
  created_at: string
  updated_at: string
}

export interface CreateTahunAkademikData {
  tahun_akademik: string
  semester: string
  tanggal_mulai: string
  tanggal_selesai: string
  sekolah_id: number
}

export interface UpdateTahunAkademikData {
  tahun_akademik?: string
  semester?: string
  tanggal_mulai?: string
  tanggal_selesai?: string
  is_active?: boolean
}

export interface TahunAkademikListResponse {
  data: TahunAkademik[]
  meta: {
    current_page: number
    last_page: number
    per_page: number
    total: number
  }
}

class TahunAkademikService {
  /**
   * Get all academic years with pagination
   */
  async getTahunAkademik(params?: {
    page?: number
    per_page?: number
    search?: string
    sekolah_id?: number
    is_active?: boolean
  }): Promise<TahunAkademikListResponse> {
    return api.get<TahunAkademikListResponse>('/tahun-akademik', { params })
  }

  /**
   * Get academic year by ID
   */
  async getTahunAkademikById(id: number): Promise<{ data: TahunAkademik }> {
    return api.get<{ data: TahunAkademik }>(`/tahun-akademik/${id}`)
  }

  /**
   * Get active academic year
   */
  async getActiveTahunAkademik(): Promise<{ data: TahunAkademik }> {
    return api.get<{ data: TahunAkademik }>('/tahun-akademik/active')
  }

  /**
   * Get academic years by school
   */
  async getTahunAkademikBySchool(sekolahId: number): Promise<{ data: TahunAkademik[] }> {
    return api.get<{ data: TahunAkademik[] }>(`/tahun-akademik/sekolah/${sekolahId}`)
  }

  /**
   * Create new academic year
   */
  async createTahunAkademik(data: CreateTahunAkademikData): Promise<{ data: TahunAkademik }> {
    return api.post<{ data: TahunAkademik }>('/tahun-akademik', data)
  }

  /**
   * Update academic year
   */
  async updateTahunAkademik(id: number, data: UpdateTahunAkademikData): Promise<{ data: TahunAkademik }> {
    return api.put<{ data: TahunAkademik }>(`/tahun-akademik/${id}`, data)
  }

  /**
   * Delete academic year
   */
  async deleteTahunAkademik(id: number): Promise<{ success: boolean; message: string }> {
    return api.delete<{ success: boolean; message: string }>(`/tahun-akademik/${id}`)
  }

  /**
   * Activate academic year
   */
  async activateTahunAkademik(id: number): Promise<{ data: TahunAkademik }> {
    return api.post<{ data: TahunAkademik }>(`/tahun-akademik/${id}/activate`)
  }

  /**
   * Get academic year statistics
   */
  async getTahunAkademikStats(): Promise<{
    data: {
      total_tahun_akademik: number
      active_tahun_akademik: number
      tahun_akademik_per_sekolah: Record<string, number>
      semester_distribution: {
        ganjil: number
        genap: number
      }
    }
  }> {
    return api.get<{
      data: {
        total_tahun_akademik: number
        active_tahun_akademik: number
        tahun_akademik_per_sekolah: Record<string, number>
        semester_distribution: {
          ganjil: number
          genap: number
        }
      }
    }>('/tahun-akademik/stats')
  }

  /**
   * Get current academic year progress
   */
  async getAcademicYearProgress(id: number): Promise<{
    data: {
      progress_percentage: number
      days_elapsed: number
      days_remaining: number
      is_completed: boolean
      current_week: number
      total_weeks: number
    }
  }> {
    return api.get<{
      data: {
        progress_percentage: number
        days_elapsed: number
        days_remaining: number
        is_completed: boolean
        current_week: number
        total_weeks: number
      }
    }>(`/tahun-akademik/${id}/progress`)
  }

  /**
   * Validate academic year data
   */
  async validateTahunAkademik(data: CreateTahunAkademikData): Promise<{
    data: {
      is_valid: boolean
      errors: Record<string, string[]>
      message: string
    }
  }> {
    return api.post<{
      data: {
        is_valid: boolean
        errors: Record<string, string[]>
        message: string
      }
    }>('/tahun-akademik/validate', data)
  }

  /**
   * Get academic year calendar
   */
  async getAcademicYearCalendar(id: number): Promise<{
    data: {
      events: Array<{
        id: number
        title: string
        date: string
        type: 'academic' | 'holiday' | 'exam' | 'event'
        description?: string
      }>
    }
  }> {
    return api.get<{
      data: {
        events: Array<{
          id: number
          title: string
          date: string
          type: 'academic' | 'holiday' | 'exam' | 'event'
          description?: string
        }>
      }
    }>(`/tahun-akademik/${id}/calendar`)
  }
}

export const tahunAkademikService = new TahunAkademikService()
export default tahunAkademikService
