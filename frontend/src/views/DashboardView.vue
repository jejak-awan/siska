<template>
  <div class="dashboard-view">
    <!-- Header Section -->
    <div class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">
                Dashboard SISKA
              </h1>
              <p class="mt-1 text-sm text-gray-500">
                Selamat datang di Sistem Informasi Sekolah Bidang Kesiswaan
              </p>
            </div>
            <div class="flex items-center space-x-4">
              <div class="text-right">
                <p class="text-sm font-medium text-gray-900">
                  {{ user?.name || 'Pengguna' }}
                </p>
                <p class="text-xs text-gray-500">
                  {{ user?.role_display_name || 'Role' }}
                </p>
              </div>
              <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                <span class="text-white text-sm font-medium">
                  {{ user?.name?.charAt(0) || 'U' }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      
      <!-- Statistics Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Siswa Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Total Siswa
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.totalSiswa || 0 }}
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <!-- Presensi Hari Ini Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Presensi Hari Ini
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.presensiHariIni || 0 }}%
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <!-- Program Aktif Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Program Aktif
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.programAktif || 0 }}
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <!-- Ekstrakurikuler Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Ekstrakurikuler
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.ekstrakurikuler || 0 }}
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Charts Section -->
      <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">
        <!-- Presensi Chart -->
        <div class="bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">
            Grafik Presensi Bulan Ini
          </h3>
          <div class="h-80 w-full">
            <BaseChart
              type="line"
              :data="presensiChartData"
              :options="presensiChartOptions"
              title="Presensi Bulan Ini"
            />
          </div>
        </div>

        <!-- Jenjang Distribution Chart -->
        <div class="bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">
            Distribusi Jenjang
          </h3>
          <div class="h-80 w-full">
            <BaseChart
              type="doughnut"
              :data="jenjangChartData"
              :options="jenjangChartOptions"
              title="Distribusi Jenjang"
            />
          </div>
        </div>
      </div>

      <!-- Recent Activities -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">
            Aktivitas Terbaru
          </h3>
        </div>
        <div class="divide-y divide-gray-200">
          <div
            v-for="activity in recentActivities"
            :key="activity.id"
            class="px-6 py-4 flex items-center space-x-4"
          >
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm text-gray-900">
                {{ activity.description }}
              </p>
              <p class="text-xs text-gray-500">
                {{ formatDate(activity.created_at) }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useDashboardStore } from '@/stores/dashboard'
import BaseChart from '@/components/charts/BaseChart.vue'

// Stores
const authStore = useAuthStore()
const dashboardStore = useDashboardStore()

// Reactive data
const statistics = ref({
  totalSiswa: 0,
  presensiHariIni: 0,
  programAktif: 0,
  ekstrakurikuler: 0
})

const recentActivities = ref([])

// Computed
const user = computed(() => authStore.user)

// Chart data
const presensiChartData = ref({
  labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
  datasets: [{
    label: 'Presensi (%)',
    data: [95, 87, 92, 89],
    borderColor: 'rgb(59, 130, 246)',
    backgroundColor: 'rgba(59, 130, 246, 0.1)',
    tension: 0.4
  }]
})

const jenjangChartData = ref({
  labels: ['SD', 'SMP', 'SMA', 'SMK'],
  datasets: [{
    data: [120, 150, 180, 200],
    backgroundColor: [
      'rgb(239, 68, 68)',
      'rgb(34, 197, 94)',
      'rgb(59, 130, 246)',
      'rgb(168, 85, 247)'
    ]
  }]
})

const presensiChartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'bottom'
    }
  },
  scales: {
    y: {
      beginAtZero: true,
      max: 100
    }
  }
})

const jenjangChartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'bottom'
    }
  }
})

// Methods
const loadDashboardData = async () => {
  try {
    await dashboardStore.loadDashboardData()
    statistics.value = dashboardStore.statistics
    recentActivities.value = dashboardStore.recentActivities
  } catch (error) {
    console.error('Error loading dashboard data:', error)
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Lifecycle
onMounted(() => {
  loadDashboardData()
})
</script>

<style scoped>
.dashboard-view {
  min-height: 100vh;
  background-color: #f9fafb;
}
</style>