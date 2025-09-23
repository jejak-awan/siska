<template>
  <div class="presensi-sma-view">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">
                Presensi Siswa SMA
              </h1>
              <p class="mt-1 text-sm text-gray-500">
                Kelola presensi siswa Sekolah Menengah Atas
              </p>
            </div>
            <div class="flex space-x-3">
              <button
                @click="showBulkCreateModal = true"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Presensi Massal
              </button>
              <button
                @click="showCreateModal = true"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Presensi
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      
      <!-- Statistics Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Hadir Hari Ini
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.hadir_hari_ini || 0 }}
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Izin Hari Ini
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.izin_hari_ini || 0 }}
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Sakit Hari Ini
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.sakit_hari_ini || 0 }}
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-gray-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Alpha Hari Ini
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.alpha_hari_ini || 0 }}
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Filters -->
      <div class="bg-white shadow rounded-lg p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Tanggal
            </label>
            <input
              v-model="filters.tanggal"
              type="date"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Kelas
            </label>
            <select
              v-model="filters.kelas"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">Semua Kelas</option>
              <option value="10">Kelas 10</option>
              <option value="11">Kelas 11</option>
              <option value="12">Kelas 12</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Status
            </label>
            <select
              v-model="filters.status"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">Semua Status</option>
              <option value="hadir">Hadir</option>
              <option value="izin">Izin</option>
              <option value="sakit">Sakit</option>
              <option value="alpha">Alpha</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Cari Siswa
            </label>
            <input
              v-model="filters.search"
              type="text"
              placeholder="Cari berdasarkan nama siswa..."
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          <div class="flex items-end">
            <button
              @click="loadPresensi"
              class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              Filter
            </button>
          </div>
        </div>
      </div>

      <!-- Presensi Table -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">
              Daftar Presensi
            </h3>
            <div class="flex space-x-2">
              <button
                @click="exportPresensi"
                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Ekspor
              </button>
            </div>
          </div>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Tanggal
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  NIS
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Nama Siswa
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Kelas
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Keterangan
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="presensi in presensiList" :key="presensi.id">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ formatDate(presensi.tanggal) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ presensi.siswa?.nis }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ presensi.siswa?.nama_lengkap }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ presensi.siswa?.kelas }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                        :class="getStatusClass(presensi.status)">
                    {{ getStatusLabel(presensi.status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ presensi.keterangan || '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button
                      @click="editPresensi(presensi)"
                      class="text-indigo-600 hover:text-indigo-900"
                    >
                      Edit
                    </button>
                    <button
                      @click="deletePresensi(presensi)"
                      class="text-red-600 hover:text-red-900"
                    >
                      Hapus
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
          <div class="flex-1 flex justify-between sm:hidden">
            <button
              @click="previousPage"
              :disabled="currentPage === 1"
              class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50"
            >
              Sebelumnya
            </button>
            <button
              @click="nextPage"
              :disabled="currentPage === totalPages"
              class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50"
            >
              Selanjutnya
            </button>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Menampilkan
                <span class="font-medium">{{ (currentPage - 1) * perPage + 1 }}</span>
                sampai
                <span class="font-medium">{{ Math.min(currentPage * perPage, totalItems) }}</span>
                dari
                <span class="font-medium">{{ totalItems }}</span>
                hasil
              </p>
            </div>
            <div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                <button
                  @click="previousPage"
                  :disabled="currentPage === 1"
                  class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50"
                >
                  Sebelumnya
                </button>
                <button
                  @click="nextPage"
                  :disabled="currentPage === totalPages"
                  class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50"
                >
                  Selanjutnya
                </button>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Create Presensi Modal -->
    <CreatePresensiSMAModal
      v-if="showCreateModal"
      @close="showCreateModal = false"
      @created="handlePresensiCreated"
    />

    <!-- Edit Presensi Modal -->
    <EditPresensiSMAModal
      v-if="showEditModal && selectedPresensi"
      :presensi="selectedPresensi"
      @close="showEditModal = false"
      @updated="handlePresensiUpdated"
    />

    <!-- Bulk Create Presensi Modal -->
    <BulkCreatePresensiSMAModal
      v-if="showBulkCreateModal"
      @close="showBulkCreateModal = false"
      @created="handlePresensiCreated"
    />
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { usePresensiSMAStore } from '@/stores/jenjang/sma/presensiSMA'
// import.*@/components/jenjang/sma/CreatePresensiSMAModal.vue'
// import.*@/components/jenjang/sma/EditPresensiSMAModal.vue'
// import.*@/components/jenjang/sma/BulkCreatePresensiSMAModal.vue'

// 
const presensiSMA = usePresensiSMAStore()

// State
const presensiList = ref([])
const statistics = ref({})
const isLoading = ref(false)
const showCreateModal = ref(false)
const showEditModal = ref(false)
const showBulkCreateModal = ref(false)
const selectedPresensi = ref(null)

// Pagination
const currentPage = ref(1)
const perPage = ref(15)
const totalItems = ref(0)

// Filters
const filters = reactive({
  tanggal: new Date().toISOString().split('T')[0],
  kelas: '',
  status: '',
  search: ''
})

// Computed
const totalPages = computed(() => Math.ceil(totalItems.value / perPage.value))

// Methods
const loadPresensi = async () => {
  isLoading.value = true
  try {
    const response = await presensiSMA.getAll({
      page: currentPage.value,
      per_page: perPage.value,
      ...filters
    })
    
    presensiList.value = response.data
    totalItems.value = response.total
  } catch (error) {
    console.error('Error loading presensi:', error)
  } finally {
    isLoading.value = false
  }
}

const loadStatistics = async () => {
  try {
    statistics.value = await presensiSMA.getStatistics()
  } catch (error) {
    console.error('Error loading statistics:', error)
  }
}

const getStatusClass = (status) => {
  const classes = {
    hadir: 'bg-green-100 text-green-800',
    izin: 'bg-yellow-100 text-yellow-800',
    sakit: 'bg-red-100 text-red-800',
    alpha: 'bg-gray-100 text-gray-800'
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusLabel = (status) => {
  const labels = {
    hadir: 'Hadir',
    izin: 'Izin',
    sakit: 'Sakit',
    alpha: 'Alpha'
  }
  return labels[status] || status
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const editPresensi = (presensi) => {
  selectedPresensi.value = presensi
  showEditModal.value = true
}

const deletePresensi = async (presensi) => {
  if (confirm(`Apakah Anda yakin ingin menghapus presensi ${presensi.siswa?.nama_lengkap} pada ${formatDate(presensi.tanggal)}?`)) {
    try {
      await presensiSMA.delete(presensi.id)
      await loadPresensi()
      await loadStatistics()
    } catch (error) {
      console.error('Error deleting presensi:', error)
    }
  }
}

const exportPresensi = async () => {
  try {
    await presensiSMA.export(filters)
  } catch (error) {
    console.error('Error exporting presensi:', error)
  }
}

const handlePresensiCreated = () => {
  showCreateModal.value = false
  showBulkCreateModal.value = false
  loadPresensi()
  loadStatistics()
}

const handlePresensiUpdated = () => {
  showEditModal.value = false
  loadPresensi()
  loadStatistics()
}

const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--
    loadPresensi()
  }
}

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++
    loadPresensi()
  }
}

// Lifecycle
onMounted(() => {
  loadPresensi()
  loadStatistics()
})
</script>

<style scoped>
.presensi-sma-view {
  min-height: 100vh;
  background-color: #f9fafb;
}
</style>

