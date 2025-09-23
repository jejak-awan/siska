import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { licenseService, type License } from '@/services/license'
import { profilSekolahService, type ProfilSekolah } from '@/services/profilSekolah'
import { tahunAkademikService, type TahunAkademik } from '@/services/tahunAkademik'

// Types
interface Activity {
  id: number
  type: string
  message: string
  timestamp: string
  user: string
}

export const useDashboardStore = defineStore('dashboard', () => {
  // State
  const statistics = ref({
    totalLicenses: 0,
    activeLicenses: 0,
    expiredLicenses: 0,
    totalStudents: 0,
    totalTeachers: 0,
    totalPrograms: 0,
    attendanceRate: 0,
    programCompletionRate: 0
  })

  const recentActivities = ref<Activity[]>([])
  const isLoading = ref(false)
  const error = ref<string | null>(null)

  // Getters
  const hasData = computed(() => statistics.value.totalLicenses > 0)

  // Actions
  async function loadDashboardData() {
    try {
      isLoading.value = true
      error.value = null

      // Load licenses data
      const licensesResponse = await licenseService.getLicenses()
      const licenses = licensesResponse.data || []
      
      // Load school profile data
      const schoolResponse = await profilSekolahService.getProfilSekolah()
      const school = schoolResponse.data?.[0] || null
      
      // Load academic year data
      const academicYearResponse = await tahunAkademikService.getTahunAkademik()
      const academicYear = academicYearResponse.data?.[0] || null

      // Calculate statistics
      statistics.value = {
        totalLicenses: licenses.length,
        activeLicenses: licenses.filter((license: License) => license.is_active === true).length,
        expiredLicenses: licenses.filter((license: License) => license.is_active === false).length,
        totalStudents: 0, // Will be calculated from actual student data
        totalTeachers: 0, // Will be calculated from actual teacher data
        totalPrograms: 0, // Will be calculated from actual program data
        attendanceRate: 0, // Will be calculated from actual attendance data
        programCompletionRate: 0 // Will be calculated from actual program completion data
      }

      // Generate recent activities (mock data for now)
      recentActivities.value = [
        {
          id: 1,
          type: 'license',
          message: 'Lisensi baru ditambahkan',
          timestamp: new Date().toISOString(),
          user: 'Admin'
        },
        {
          id: 2,
          type: 'student',
          message: 'Siswa baru terdaftar',
          timestamp: new Date(Date.now() - 3600000).toISOString(),
          user: 'Guru'
        },
        {
          id: 3,
          type: 'program',
          message: 'Program kesiswaan dimulai',
          timestamp: new Date(Date.now() - 7200000).toISOString(),
          user: 'Admin'
        }
      ]

    } catch (err: any) {
      console.error('Error loading dashboard data:', err)
      error.value = err?.message || 'Gagal memuat data dashboard'
    } finally {
      isLoading.value = false
    }
  }

  function reset() {
    statistics.value = {
      totalLicenses: 0,
      activeLicenses: 0,
      expiredLicenses: 0,
      totalStudents: 0,
      totalTeachers: 0,
      totalPrograms: 0,
      attendanceRate: 0,
      programCompletionRate: 0
    }
    recentActivities.value = []
    isLoading.value = false
    error.value = null
  }

  return {
    // State
    statistics,
    recentActivities,
    isLoading,
    error,
    // Getters
    hasData,
    // Actions
    loadDashboardData,
    reset
  }
})
