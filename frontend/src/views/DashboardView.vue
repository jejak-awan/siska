<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
      <p class="mt-2 text-gray-600">Selamat datang di SISKA - Sistem Informasi Sekolah Bidang Kesiswaan</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <!-- Total Schools -->
      <div class="card">
        <div class="card-body">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-primary-100 rounded-md flex items-center justify-center">
                <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Sekolah</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.totalSchools || 0 }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Active Licenses -->
      <div class="card">
        <div class="card-body">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-success-100 rounded-md flex items-center justify-center">
                <svg class="w-5 h-5 text-success-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Lisensi Aktif</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.activeLicenses || 0 }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Academic Years -->
      <div class="card">
        <div class="card-body">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-warning-100 rounded-md flex items-center justify-center">
                <svg class="w-5 h-5 text-warning-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Tahun Akademik</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.academicYears || 0 }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Users -->
      <div class="card">
        <div class="card-body">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.totalUsers || 0 }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
      <!-- User Distribution Chart -->
      <BaseChart
        type="doughnut"
        :data="userDistributionData"
        title="Distribusi Pengguna"
        subtitle="Berdasarkan peran pengguna"
        :height="300"
      />
      
      <!-- License Status Chart -->
      <BaseChart
        type="bar"
        :data="licenseStatusData"
        title="Status Lisensi"
        subtitle="Distribusi status lisensi"
        :height="300"
      />
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
      <!-- Quick Actions Card -->
      <div class="card">
        <div class="card-header">
          <h3 class="text-lg font-medium text-gray-900">Aksi Cepat</h3>
        </div>
        <div class="card-body">
          <div class="grid grid-cols-2 gap-4">
            <router-link
              to="/profil-sekolah"
              class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
            >
              <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-6 h-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">Profil Sekolah</p>
                <p class="text-xs text-gray-500">Kelola data sekolah</p>
              </div>
            </router-link>

            <router-link
              to="/tahun-akademik"
              class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
            >
              <div class="w-10 h-10 bg-warning-100 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-6 h-6 text-warning-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">Tahun Akademik</p>
                <p class="text-xs text-gray-500">Kelola tahun ajaran</p>
              </div>
            </router-link>

            <router-link
              to="/lisensi"
              class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
            >
              <div class="w-10 h-10 bg-success-100 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-6 h-6 text-success-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">Lisensi</p>
                <p class="text-xs text-gray-500">Kelola lisensi sistem</p>
              </div>
            </router-link>

            <router-link
              to="/profile"
              class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
            >
              <div class="w-10 h-10 bg-info-100 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-6 h-6 text-info-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">Profil</p>
                <p class="text-xs text-gray-500">Kelola profil pengguna</p>
              </div>
            </router-link>
          </div>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="card">
        <div class="card-header">
          <h3 class="text-lg font-medium text-gray-900">Aktivitas Terbaru</h3>
        </div>
        <div class="card-body">
          <div class="space-y-4">
            <div v-if="recentActivity.length === 0" class="text-center py-8 text-gray-500">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
              </svg>
              <p class="mt-2">Belum ada aktivitas</p>
            </div>
            <div v-else class="space-y-3">
              <div
                v-for="activity in recentActivity"
                :key="activity.id"
                class="flex items-start space-x-3"
              >
                <div class="flex-shrink-0">
                  <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm text-gray-900">{{ activity.message }}</p>
                  <p class="text-xs text-gray-500">{{ formatDate(activity.created_at) }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- System Information -->
    <div class="card">
      <div class="card-header">
        <h3 class="text-lg font-medium text-gray-900">Informasi Sistem</h3>
      </div>
      <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <h4 class="text-sm font-medium text-gray-900 mb-2">Versi Sistem</h4>
            <p class="text-sm text-gray-600">SISKA v1.0.0</p>
          </div>
          <div>
            <h4 class="text-sm font-medium text-gray-900 mb-2">Status Server</h4>
            <span class="badge badge-success">Online</span>
          </div>
          <div>
            <h4 class="text-sm font-medium text-gray-900 mb-2">Terakhir Update</h4>
            <p class="text-sm text-gray-600">{{ formatDate(new Date().toISOString()) }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { licenseService } from '@/services/license'
import { profilSekolahService } from '@/services/profilSekolah'
import { tahunAkademikService } from '@/services/tahunAkademik'
import BaseChart from '@/components/charts/BaseChart.vue'
import { useToast } from 'vue-toastification'

const authStore = useAuthStore()
const toast = useToast()

// State
const stats = ref({
  totalSchools: 0,
  activeLicenses: 0,
  academicYears: 0,
  totalUsers: 0,
})

const isLoading = ref(false)
const recentActivity = ref([
  {
    id: 1,
    message: 'Sistem berhasil diinisialisasi',
    created_at: new Date().toISOString(),
  },
])

// Chart Data
const userDistributionData = computed(() => ({
  labels: ['Admin', 'Guru', 'Siswa'],
  datasets: [
    {
      label: 'Jumlah Pengguna',
      data: [1, 1, 1], // Static for now, will be updated with real data
      backgroundColor: [
        '#3B82F6', // Primary blue
        '#10B981', // Success green
        '#F59E0B', // Warning yellow
      ],
      borderColor: [
        '#2563EB',
        '#059669',
        '#D97706',
      ],
      borderWidth: 2,
    },
  ],
}))

const licenseStatusData = computed(() => ({
  labels: ['Aktif', 'Nonaktif', 'Expired'],
  datasets: [
    {
      label: 'Jumlah Lisensi',
      data: [stats.value.activeLicenses, 0, 0], // Dynamic based on real data
      backgroundColor: [
        '#10B981', // Success green
        '#6B7280', // Gray
        '#EF4444', // Danger red
      ],
      borderColor: [
        '#059669',
        '#4B5563',
        '#DC2626',
      ],
      borderWidth: 1,
    },
  ],
}))

// Methods
const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
}

const loadDashboardData = async () => {
  isLoading.value = true
  try {
    // Load data from multiple APIs in parallel
    const [licensesResponse, schoolsResponse, academicYearsResponse] = await Promise.allSettled([
      licenseService.getLicenses(),
      profilSekolahService.getProfilSekolah(),
      tahunAkademikService.getTahunAkademik(),
    ])

    // Process licenses data
    if (licensesResponse.status === 'fulfilled') {
      const licensesData = licensesResponse.value.data
      const licenses = licensesData?.data || licensesData || []
      stats.value.activeLicenses = Array.isArray(licenses) ? licenses.filter((license: any) => license?.is_active).length : 0
    }

    // Process schools data
    if (schoolsResponse.status === 'fulfilled') {
      const schoolsData = schoolsResponse.value.data
      const schools = schoolsData?.data || schoolsData || []
      stats.value.totalSchools = Array.isArray(schools) ? schools.length : 0
    }

    // Process academic years data
    if (academicYearsResponse.status === 'fulfilled') {
      const academicYearsData = academicYearsResponse.value.data
      const academicYears = academicYearsData?.data || academicYearsData || []
      stats.value.academicYears = Array.isArray(academicYears) ? academicYears.length : 0
    }

    // Update recent activity with real data
    recentActivity.value = [
      {
        id: 1,
        message: 'Dashboard berhasil dimuat dengan data real',
        created_at: new Date().toISOString(),
      },
    ]

  } catch (error: any) {
    console.error('Error loading dashboard data:', error)
    toast.error('Gagal memuat data dashboard')
    
    // Fallback to default values
    stats.value = {
      totalSchools: 0,
      activeLicenses: 0,
      academicYears: 0,
      totalUsers: 3, // Static user count
    }
  } finally {
    isLoading.value = false
  }
}

// Lifecycle
onMounted(() => {
  loadDashboardData()
})
</script>
