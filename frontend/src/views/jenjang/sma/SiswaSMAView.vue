<template>
  <div class="siswa-sma-view">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">
                Manajemen Siswa SMA
              </h1>
              <p class="mt-1 text-sm text-gray-500">
                Kelola data siswa Sekolah Menengah Atas
              </p>
            </div>
            <button
              @click="showCreateModal = true"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
              Tambah Siswa
            </button>
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
                    Siswa Aktif
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.aktif || 0 }}
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
                    Lulus Tahun Ini
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.lulus || 0 }}
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
                <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Pindah Tahun Ini
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.pindah || 0 }}
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
              Cari Siswa
            </label>
            <input
              v-model="filters.search"
              type="text"
              placeholder="Cari berdasarkan nama, NIS, atau NISN..."
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
              <option value="aktif">Aktif</option>
              <option value="nonaktif">Tidak Aktif</option>
              <option value="lulus">Lulus</option>
              <option value="pindah">Pindah</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Jenis Kelamin
            </label>
            <select
              v-model="filters.jenis_kelamin"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">Semua</option>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          <div class="flex items-end">
            <button
              @click="loadStudents"
              class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              Filter
            </button>
          </div>
        </div>
      </div>

      <!-- Students Table -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">
              Daftar Siswa SMA
            </h3>
            <div class="flex space-x-2">
              <button
                @click="exportStudents"
                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Ekspor
              </button>
              <button
                @click="showImportModal = true"
                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                </svg>
                Impor
              </button>
            </div>
          </div>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Foto
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  NIS/NISN
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Nama Lengkap
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Kelas
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Jenis Kelamin
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
              <tr v-for="student in students" :key="student.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                    <img
                      v-if="student.foto_url"
                      :src="student.foto_url"
                      :alt="student.nama_lengkap"
                      class="h-full w-full object-cover"
                    />
                    <svg
                      v-else
                      class="h-6 w-6 text-gray-400"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">
                    {{ student.nis }}
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ student.nisn }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">
                    {{ student.nama_lengkap }}
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ student.nama_panggilan }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ student.kelas }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ student.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                        :class="getStatusClass(student.status)">
                    {{ getStatusLabel(student.status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button
                      @click="viewStudent(student)"
                      class="text-blue-600 hover:text-blue-900"
                    >
                      Lihat
                    </button>
                    <button
                      @click="editStudent(student)"
                      class="text-indigo-600 hover:text-indigo-900"
                    >
                      Edit
                    </button>
                    <button
                      @click="deleteStudent(student)"
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

    <!-- Create Student Modal -->
    <CreateStudentSMAModal
      v-if="showCreateModal"
      @close="showCreateModal = false"
      @created="handleStudentCreated"
    />

    <!-- Edit Student Modal -->
    <EditStudentSMAModal
      v-if="showEditModal && selectedStudent"
      :student="selectedStudent"
      @close="showEditModal = false"
      @updated="handleStudentUpdated"
    />

    <!-- View Student Modal -->
    <ViewStudentSMAModal
      v-if="showViewModal && selectedStudent"
      :student="selectedStudent"
      @close="showViewModal = false"
    />

    <!-- Import Students Modal -->
    <ImportStudentsSMAModal
      v-if="showImportModal"
      @close="showImportModal = false"
      @imported="handleStudentsImported"
    />
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { useSiswaSMAStore } from '@/stores/jenjang/sma/siswaSMA'
// import.*@/components/jenjang/sma/CreateStudentSMAModal.vue'
// import.*@/components/jenjang/sma/EditStudentSMAModal.vue'
// import.*@/components/jenjang/sma/ViewStudentSMAModal.vue'
// import.*@/components/jenjang/sma/ImportStudentsSMAModal.vue'

// 
const siswaSMA = useSiswaSMAStore()

// State
const students = ref([])
const statistics = ref({})
const isLoading = ref(false)
const showCreateModal = ref(false)
const showEditModal = ref(false)
const showViewModal = ref(false)
const showImportModal = ref(false)
const selectedStudent = ref(null)

// Pagination
const currentPage = ref(1)
const perPage = ref(15)
const totalItems = ref(0)

// Filters
const filters = reactive({
  search: '',
  kelas: '',
  status: '',
  jenis_kelamin: ''
})

// Computed
const totalPages = computed(() => Math.ceil(totalItems.value / perPage.value))

// Methods
const loadStudents = async () => {
  isLoading.value = true
  try {
    const response = await siswaSMA.getAll({
      page: currentPage.value,
      per_page: perPage.value,
      ...filters
    })
    
    students.value = response.data
    totalItems.value = response.total
  } catch (error) {
    console.error('Error loading students:', error)
  } finally {
    isLoading.value = false
  }
}

const loadStatistics = async () => {
  try {
    statistics.value = await siswaSMA.getStatistics()
  } catch (error) {
    console.error('Error loading statistics:', error)
  }
}

const getStatusClass = (status) => {
  const classes = {
    aktif: 'bg-green-100 text-green-800',
    nonaktif: 'bg-gray-100 text-gray-800',
    lulus: 'bg-blue-100 text-blue-800',
    pindah: 'bg-yellow-100 text-yellow-800'
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusLabel = (status) => {
  const labels = {
    aktif: 'Aktif',
    nonaktif: 'Tidak Aktif',
    lulus: 'Lulus',
    pindah: 'Pindah'
  }
  return labels[status] || status
}

const viewStudent = (student) => {
  selectedStudent.value = student
  showViewModal.value = true
}

const editStudent = (student) => {
  selectedStudent.value = student
  showEditModal.value = true
}

const deleteStudent = async (student) => {
  if (confirm(`Apakah Anda yakin ingin menghapus siswa ${student.nama_lengkap}?`)) {
    try {
      await siswaSMA.delete(student.id)
      await loadStudents()
      await loadStatistics()
    } catch (error) {
      console.error('Error deleting student:', error)
    }
  }
}

const exportStudents = async () => {
  try {
    await siswaSMA.export(filters)
  } catch (error) {
    console.error('Error exporting students:', error)
  }
}

const handleStudentCreated = () => {
  showCreateModal.value = false
  loadStudents()
  loadStatistics()
}

const handleStudentUpdated = () => {
  showEditModal.value = false
  loadStudents()
  loadStatistics()
}

const handleStudentsImported = () => {
  showImportModal.value = false
  loadStudents()
  loadStatistics()
}

const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--
    loadStudents()
  }
}

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++
    loadStudents()
  }
}

// Lifecycle
onMounted(() => {
  loadStudents()
  loadStatistics()
})
</script>

<style scoped>
.siswa-sma-view {
  min-height: 100vh;
  background-color: #f9fafb;
}
</style>