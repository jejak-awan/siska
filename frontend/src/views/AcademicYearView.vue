<template>
  <div class="academic-year-view">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">
                Tahun Akademik
              </h1>
              <p class="mt-1 text-sm text-gray-500">
                Kelola tahun akademik dan semester
              </p>
            </div>
            <button
              @click="showCreateModal = true"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
              Tambah Tahun Akademik
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      
      <!-- Current Academic Year Card -->
      <div v-if="currentAcademicYear" class="bg-white shadow rounded-lg p-6 mb-8">
        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-lg font-medium text-gray-900">
              Tahun Akademik Aktif
            </h3>
            <p class="mt-1 text-sm text-gray-500">
              Tahun akademik yang sedang berjalan
            </p>
          </div>
          <div class="text-right">
            <p class="text-2xl font-bold text-blue-600">
              {{ currentAcademicYear.tahun_akademik }}
            </p>
            <p class="text-sm text-gray-500">
              Semester {{ currentAcademicYear.semester }}
            </p>
          </div>
        </div>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <p class="text-sm font-medium text-gray-500">Tanggal Mulai</p>
            <p class="text-sm text-gray-900">{{ formatDate(currentAcademicYear.tanggal_mulai) }}</p>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-500">Tanggal Selesai</p>
            <p class="text-sm text-gray-900">{{ formatDate(currentAcademicYear.tanggal_selesai) }}</p>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-500">Status</p>
            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
              {{ getStatusLabel(currentAcademicYear.status) }}
            </span>
          </div>
        </div>
      </div>

      <!-- Statistics Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Total Tahun Akademik
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.total || 0 }}
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
                <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Tahun Aktif
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.active || 0 }}
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Tahun Selesai
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.completed || 0 }}
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Tahun Mendatang
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.future || 0 }}
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Filters -->
      <div class="bg-white shadow rounded-lg p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Cari Tahun Akademik
            </label>
            <input
              v-model="filters.search"
              type="text"
              placeholder="Cari berdasarkan tahun akademik..."
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
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
              <option value="aktif">Aktif</option>
              <option value="nonaktif">Tidak Aktif</option>
              <option value="selesai">Selesai</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Semester
            </label>
            <select
              v-model="filters.semester"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">Semua Semester</option>
              <option value="1">Semester 1</option>
              <option value="2">Semester 2</option>
            </select>
          </div>
          <div class="flex items-end">
            <button
              @click="loadAcademicYears"
              class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              Filter
            </button>
          </div>
        </div>
      </div>

      <!-- Academic Years Table -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">
            Daftar Tahun Akademik
          </h3>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Tahun Akademik
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Semester
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Tanggal Mulai
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Tanggal Selesai
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="academicYear in academicYears" :key="academicYear?.id || Math.random()" v-if="academicYear">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ academicYear.tahun_akademik }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ academicYear.status || 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ formatDate(academicYear.tanggal_mulai) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ formatDate(academicYear.tanggal_selesai) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                        :class="getStatusClass(academicYear.status)">
                    {{ getStatusLabel(academicYear.status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button
                      @click="viewAcademicYear(academicYear)"
                      class="text-blue-600 hover:text-blue-900"
                    >
                      Lihat
                    </button>
                    <button
                      @click="editAcademicYear(academicYear)"
                      class="text-indigo-600 hover:text-indigo-900"
                    >
                      Edit
                    </button>
                    <button
                      v-if="academicYear.status === 'aktif'"
                      @click="deactivateAcademicYear(academicYear)"
                      class="text-red-600 hover:text-red-900"
                    >
                      Nonaktifkan
                    </button>
                    <button
                      v-else-if="academicYear.status === 'nonaktif'"
                      @click="activateAcademicYear(academicYear)"
                      class="text-green-600 hover:text-green-900"
                    >
                      Aktifkan
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

    <!-- Create Academic Year Modal -->
    <CreateAcademicYearModal
      v-if="showCreateModal"
      @close="showCreateModal = false"
      @created="handleAcademicYearCreated"
    />

    <!-- Edit Academic Year Modal -->
    <EditAcademicYearModal
      v-if="showEditModal && selectedAcademicYear"
      :academic-year="selectedAcademicYear"
      @close="showEditModal = false"
      @updated="handleAcademicYearUpdated"
    />

    <!-- View Academic Year Modal -->
    <ViewAcademicYearModal
      v-if="showViewModal && selectedAcademicYear"
      :academic-year="selectedAcademicYear"
      @close="showViewModal = false"
    />
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { useAcademicYearStore } from '@/stores/academicYear'
import CreateAcademicYearModal from '@/components/academic-year/CreateAcademicYearModal.vue'
import EditAcademicYearModal from '@/components/academic-year/EditAcademicYearModal.vue'
import ViewAcademicYearModal from '@/components/academic-year/ViewAcademicYearModal.vue'

// Store
const academicYearStore = useAcademicYearStore()

// State
const academicYears = ref([])
const currentAcademicYear = ref(null)
const statistics = ref({})
const isLoading = ref(false)
const showCreateModal = ref(false)
const showEditModal = ref(false)
const showViewModal = ref(false)
const selectedAcademicYear = ref(null)

// Pagination
const currentPage = ref(1)
const perPage = ref(15)
const totalItems = ref(0)

// Filters
const filters = reactive({
  search: '',
  status: '',
  semester: ''
})

// Computed
const totalPages = computed(() => Math.ceil(totalItems.value / perPage.value))

// Methods
const loadAcademicYears = async () => {
  isLoading.value = true
  try {
    const response = await academicYearStore.getAll({
      page: currentPage.value,
      per_page: perPage.value,
      ...filters
    })
    
    academicYears.value = response?.data || []
    totalItems.value = response?.total || 0
  } catch (error) {
    console.error('Error loading academic years:', error)
  } finally {
    isLoading.value = false
  }
}

const loadCurrentAcademicYear = async () => {
  try {
    currentAcademicYear.value = await academicYearStore.getCurrent()
  } catch (error) {
    console.error('Error loading current academic year:', error)
  }
}

const loadStatistics = async () => {
  try {
    statistics.value = await academicYearStore.getStatistics()
  } catch (error) {
    console.error('Error loading statistics:', error)
  }
}

const getStatusClass = (status) => {
  const classes = {
    aktif: 'bg-green-100 text-green-800',
    nonaktif: 'bg-gray-100 text-gray-800',
    selesai: 'bg-blue-100 text-blue-800'
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusLabel = (status) => {
  const labels = {
    aktif: 'Aktif',
    nonaktif: 'Tidak Aktif',
    selesai: 'Selesai'
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

const viewAcademicYear = (academicYear) => {
  selectedAcademicYear.value = academicYear
  showViewModal.value = true
}

const editAcademicYear = (academicYear) => {
  selectedAcademicYear.value = academicYear
  showEditModal.value = true
}

const activateAcademicYear = async (academicYear) => {
  try {
    await academicYearStore.activate(academicYear.id)
    await loadAcademicYears()
    await loadCurrentAcademicYear()
    await loadStatistics()
  } catch (error) {
    console.error('Error activating academic year:', error)
  }
}

const deactivateAcademicYear = async (academicYear) => {
  try {
    await academicYearStore.deactivate(academicYear.id)
    await loadAcademicYears()
    await loadCurrentAcademicYear()
    await loadStatistics()
  } catch (error) {
    console.error('Error deactivating academic year:', error)
  }
}

const handleAcademicYearCreated = () => {
  showCreateModal.value = false
  loadAcademicYears()
  loadCurrentAcademicYear()
  loadStatistics()
}

const handleAcademicYearUpdated = () => {
  showEditModal.value = false
  loadAcademicYears()
  loadCurrentAcademicYear()
  loadStatistics()
}

const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--
    loadAcademicYears()
  }
}

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++
    loadAcademicYears()
  }
}

// Lifecycle
onMounted(() => {
  loadAcademicYears()
  loadCurrentAcademicYear()
  loadStatistics()
})
</script>

<style scoped>
.academic-year-view {
  min-height: 100vh;
  background-color: #f9fafb;
}
</style>
