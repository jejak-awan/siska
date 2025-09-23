import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { tahunAkademikService, type TahunAkademikListResponse } from '@/services/tahunAkademik'

// Types
interface TahunAkademik {
  id: number
  sekolah_id: number
  tahun_akademik: string
  tanggal_mulai: string
  tanggal_selesai: string
  status: string
  is_active: boolean
  keterangan?: string
  created_at: string
  updated_at: string
}

interface ApiResponse {
  data: TahunAkademik[]
  total: number
  current_page: number
  per_page: number
}


export const useAcademicYearStore = defineStore('academicYear', () => {
  // State
  const academicYears = ref<TahunAkademik[]>([])
  const currentAcademicYear = ref<TahunAkademik | null>(null)
  const isLoading = ref(false)
  const error = ref<string | null>(null)

  // Getters
  const hasData = computed(() => academicYears.value.length > 0)
  const activeYears = computed(() => academicYears.value.filter(year => year.status === 'aktif'))
  const inactiveYears = computed(() => academicYears.value.filter(year => year.status === 'nonaktif'))

  // Actions
  async function loadAcademicYears() {
    try {
      isLoading.value = true
      error.value = null

      const response: TahunAkademikListResponse = await tahunAkademikService.getTahunAkademik()
      academicYears.value = response.data || []
    } catch (err: any) {
      console.error('Error loading academic years:', err)
      error.value = err?.message || 'Gagal memuat data tahun akademik'
    } finally {
      isLoading.value = false
    }
  }

  async function loadCurrentAcademicYear() {
    try {
      const response: TahunAkademikListResponse = await tahunAkademikService.getTahunAkademik()
      // Find active academic year from the list
      const data = response.data || []
      
      // Ensure data is an array before using find
      if (Array.isArray(data)) {
        const activeYear = data.find(year => year.is_active === true)
        currentAcademicYear.value = activeYear || null
      } else {
        currentAcademicYear.value = null
      }
    } catch (err: any) {
      console.error('Error loading current academic year:', err)
      error.value = err?.message || 'Gagal memuat tahun akademik aktif'
      currentAcademicYear.value = null
    }
  }

  async function createAcademicYear(data: Partial<TahunAkademik>) {
    try {
      isLoading.value = true
      // Note: Create method not implemented in service yet
      console.warn('Create academic year not implemented yet')
      await loadAcademicYears() // Reload data
      return { success: true }
    } catch (err: any) {
      console.error('Error creating academic year:', err)
      error.value = err?.message || 'Gagal membuat tahun akademik'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  async function updateAcademicYear(id: number, data: Partial<TahunAkademik>) {
    try {
      isLoading.value = true
      // Note: Update method not implemented in service yet
      console.warn('Update academic year not implemented yet')
      await loadAcademicYears() // Reload data
      return { success: true }
    } catch (err: any) {
      console.error('Error updating academic year:', err)
      error.value = err?.message || 'Gagal memperbarui tahun akademik'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  async function deleteAcademicYear(id: number) {
    try {
      isLoading.value = true
      // Note: Delete method not implemented in service yet
      console.warn('Delete academic year not implemented yet')
      await loadAcademicYears() // Reload data
      return { success: true }
    } catch (err: any) {
      console.error('Error deleting academic year:', err)
      error.value = err?.message || 'Gagal menghapus tahun akademik'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  async function activateAcademicYear(id: number) {
    try {
      isLoading.value = true
      // Note: Activate method not implemented in service yet
      console.warn('Activate academic year not implemented yet')
      await loadAcademicYears() // Reload data
      return { success: true }
    } catch (err: any) {
      console.error('Error activating academic year:', err)
      error.value = err?.message || 'Gagal mengaktifkan tahun akademik'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  // Alias methods for compatibility
  const getAll = async (params = {}): Promise<ApiResponse> => {
    try {
      const response: TahunAkademikListResponse = await tahunAkademikService.getTahunAkademik()
      return {
        data: response.data || [],
        total: response.meta?.total || 0,
        current_page: response.meta?.current_page || 1,
        per_page: response.meta?.per_page || 15
      }
    } catch (err: any) {
      console.error('Error loading academic years:', err)
      return {
        data: [],
        total: 0,
        current_page: 1,
        per_page: 15
      }
    }
  }
  const getCurrent = loadCurrentAcademicYear
  const getStatistics = async () => {
    try {
      const response: TahunAkademikListResponse = await tahunAkademikService.getTahunAkademik()
      const data = response.data || []
      
      // Ensure data is an array
      if (!Array.isArray(data)) {
        return {
          total: 0,
          active: 0,
          completed: 0,
          upcoming: 0
        }
      }
      
      // Calculate statistics from the data
      const stats = {
        total: data.length,
        active: data.filter(year => year.is_active === true).length,
        completed: data.filter(year => year.status === 'completed').length,
        upcoming: data.filter(year => year.status === 'upcoming').length
      }
      
      return stats
    } catch (err: any) {
      console.error('Error loading statistics:', err)
      return {
        total: 0,
        active: 0,
        completed: 0,
        upcoming: 0
      }
    }
  }

  function reset() {
    academicYears.value = []
    currentAcademicYear.value = null
    isLoading.value = false
    error.value = null
  }

  return {
    // State
    academicYears,
    currentAcademicYear,
    isLoading,
    error,
    // Getters
    hasData,
    activeYears,
    inactiveYears,
    // Actions
    loadAcademicYears,
    loadCurrentAcademicYear,
    createAcademicYear,
    updateAcademicYear,
    deleteAcademicYear,
    activateAcademicYear,
    // Alias methods
    getAll,
    getCurrent,
    getStatistics,
    reset
  }
})
