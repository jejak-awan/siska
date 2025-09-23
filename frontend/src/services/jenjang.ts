import { api } from './api'

// Types for jenjang-specific data
export interface JenjangInfo {
  id: string
  name: string
  displayName: string
  description: string
  features: string[]
  isActive: boolean
}

export interface JenjangStats {
  totalSiswa: number
  totalPresensi: number
  totalProgram: number
  persentaseKehadiran: number
}

// Jenjang configuration
export const JENJANG_CONFIG: Record<string, JenjangInfo> = {
  sd: {
    id: 'sd',
    name: 'SD',
    displayName: 'Sekolah Dasar',
    description: 'Manajemen siswa SD dengan fokus pada karakter dasar, kebersihan, dan kedisiplinan',
    features: ['siswa', 'presensi', 'kredit-poin', 'program-kesiswaan', 'penilaian-karakter'],
    isActive: false
  },
  smp: {
    id: 'smp',
    name: 'SMP',
    displayName: 'Sekolah Menengah Pertama',
    description: 'Manajemen siswa SMP dengan ekstrakurikuler dan program kesiswaan',
    features: ['siswa', 'presensi', 'ekstrakurikuler', 'program-kesiswaan'],
    isActive: false
  },
  sma: {
    id: 'sma',
    name: 'SMA',
    displayName: 'Sekolah Menengah Atas',
    description: 'Manajemen siswa SMA dengan organisasi dan kepemimpinan',
    features: ['siswa', 'presensi', 'organisasi', 'program-kesiswaan'],
    isActive: false
  },
  smk: {
    id: 'smk',
    name: 'SMK',
    displayName: 'Sekolah Menengah Kejuruan',
    description: 'Manajemen siswa SMK dengan kejuruan dan kompetensi',
    features: ['siswa', 'presensi', 'kejuruan', 'program-kesiswaan'],
    isActive: false
  }
}

// Jenjang service functions
export const jenjangService = {
  // Get available jenjang based on license
  async getAvailableJenjang(): Promise<JenjangInfo[]> {
    try {
      const response = await api.get('/license/available-jenjang')
      const availableJenjang = response.data.data || []
      
      // Update isActive status based on license
      return Object.values(JENJANG_CONFIG).map(jenjang => ({
        ...jenjang,
        isActive: availableJenjang.includes(jenjang.id)
      }))
    } catch (error) {
      console.error('Error fetching available jenjang:', error)
      return Object.values(JENJANG_CONFIG).map(jenjang => ({
        ...jenjang,
        isActive: false
      }))
    }
  },

  // Get jenjang statistics
  async getJenjangStats(jenjang: string): Promise<JenjangStats> {
    try {
      const response = await api.get(`/jenjang/${jenjang}/statistics`)
      return response.data.data
    } catch (error) {
      console.error(`Error fetching ${jenjang} statistics:`, error)
      return {
        totalSiswa: 0,
        totalPresensi: 0,
        totalProgram: 0,
        persentaseKehadiran: 0
      }
    }
  },

  // Check if feature is available for jenjang
  isFeatureAvailable(jenjang: string, feature: string): boolean {
    const jenjangConfig = JENJANG_CONFIG[jenjang]
    return jenjangConfig ? jenjangConfig.features.includes(feature) : false
  },

  // Get jenjang display name
  getJenjangDisplayName(jenjang: string): string {
    return JENJANG_CONFIG[jenjang]?.displayName || jenjang.toUpperCase()
  },

  // Get jenjang description
  getJenjangDescription(jenjang: string): string {
    return JENJANG_CONFIG[jenjang]?.description || ''
  }
}

// Export default
export default jenjangService
