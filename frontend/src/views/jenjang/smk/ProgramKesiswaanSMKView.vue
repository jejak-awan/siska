<template>
  <div class="program-kesiswaan-smk-view">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">
                Program Kesiswaan SMK
              </h1>
              <p class="mt-1 text-sm text-gray-500">
                Kelola program kesiswaan siswa Sekolah Menengah Kejuruan
              </p>
            </div>
            <button
              @click="showCreateModal = true"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
              Tambah Program
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Total Program
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
                    Program Aktif
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Total Peserta
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.total_peserta || 0 }}
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Program Selesai
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.selesai || 0 }}
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
              Cari Program
            </label>
            <input
              v-model="filters.search"
              type="text"
              placeholder="Cari berdasarkan nama program..."
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
              <option value="selesai">Selesai</option>
              <option value="ditunda">Ditunda</option>
              <option value="dibatalkan">Dibatalkan</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Penanggung Jawab
            </label>
            <input
              v-model="filters.penanggung_jawab"
              type="text"
              placeholder="Cari berdasarkan penanggung jawab..."
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          <div class="flex items-end">
            <button
              @click="loadPrograms"
              class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              Filter
            </button>
          </div>
        </div>
      </div>

      <!-- Programs Table -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">
            Daftar Program Kesiswaan
          </h3>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Nama Program
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Deskripsi
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Tanggal Mulai
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Tanggal Selesai
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Penanggung Jawab
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Peserta
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="program in programs" :key="program.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">
                    {{ program.nama_program }}
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900 max-w-xs truncate">
                    {{ program.deskripsi || '-' }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ formatDate(program.tanggal_mulai) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ program.tanggal_selesai ? formatDate(program.tanggal_selesai) : '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ program.penanggung_jawab }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                        :class="getStatusClass(program.status)">
                    {{ getStatusLabel(program.status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ program.total_peserta || 0 }} peserta
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button
                      @click="viewProgram(program)"
                      class="text-blue-600 hover:text-blue-900"
                    >
                      Lihat
                    </button>
                    <button
                      @click="editProgram(program)"
                      class="text-indigo-600 hover:text-indigo-900"
                    >
                      Edit
                    </button>
                    <button
                      @click="manageParticipants(program)"
                      class="text-green-600 hover:text-green-900"
                    >
                      Peserta
                    </button>
                    <button
                      @click="deleteProgram(program)"
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

    <!-- Create Program Modal -->
    <CreateProgramKesiswaanSMKModal
      v-if="showCreateModal"
      @close="showCreateModal = false"
      @created="handleProgramCreated"
    />

    <!-- Edit Program Modal -->
    <EditProgramKesiswaanSMKModal
      v-if="showEditModal && selectedProgram"
      :program="selectedProgram"
      @close="showEditModal = false"
      @updated="handleProgramUpdated"
    />

    <!-- View Program Modal -->
    <ViewProgramKesiswaanSMKModal
      v-if="showViewModal && selectedProgram"
      :program="selectedProgram"
      @close="showViewModal = false"
    />

    <!-- Manage Participants Modal -->
    <ManageParticipantsProgramKesiswaanSMKModal
      v-if="showParticipantsModal && selectedProgram"
      :program="selectedProgram"
      @close="showParticipantsModal = false"
      @updated="handleProgramUpdated"
    />
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { useProgramKesiswaanSMKStore } from '@/stores/jenjang/smk/programKesiswaanSMK'
// import.*@/components/jenjang/smk/CreateProgramKesiswaanSMKModal.vue'
// import.*@/components/jenjang/smk/EditProgramKesiswaanSMKModal.vue'
// import.*@/components/jenjang/smk/ViewProgramKesiswaanSMKModal.vue'
// import.*@/components/jenjang/smk/ManageParticipantsProgramKesiswaanSMKModal.vue'

// 
const programKesiswaanSMK = useProgramKesiswaanSMKStore()

// State
const programs = ref([])
const statistics = ref({})
const isLoading = ref(false)
const showCreateModal = ref(false)
const showEditModal = ref(false)
const showViewModal = ref(false)
const showParticipantsModal = ref(false)
const selectedProgram = ref(null)

// Pagination
const currentPage = ref(1)
const perPage = ref(15)
const totalItems = ref(0)

// Filters
const filters = reactive({
  search: '',
  status: '',
  penanggung_jawab: ''
})

// Computed
const totalPages = computed(() => Math.ceil(totalItems.value / perPage.value))

// Methods
const loadPrograms = async () => {
  isLoading.value = true
  try {
    const response = await programKesiswaanSMK.getAll({
      page: currentPage.value,
      per_page: perPage.value,
      ...filters
    })
    
    programs.value = response.data
    totalItems.value = response.total
  } catch (error) {
    console.error('Error loading programs:', error)
  } finally {
    isLoading.value = false
  }
}

const loadStatistics = async () => {
  try {
    statistics.value = await programKesiswaanSMK.getStatistics()
  } catch (error) {
    console.error('Error loading statistics:', error)
  }
}

const getStatusClass = (status) => {
  const classes = {
    aktif: 'bg-green-100 text-green-800',
    selesai: 'bg-blue-100 text-blue-800',
    ditunda: 'bg-yellow-100 text-yellow-800',
    dibatalkan: 'bg-red-100 text-red-800'
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusLabel = (status) => {
  const labels = {
    aktif: 'Aktif',
    selesai: 'Selesai',
    ditunda: 'Ditunda',
    dibatalkan: 'Dibatalkan'
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

const viewProgram = (program) => {
  selectedProgram.value = program
  showViewModal.value = true
}

const editProgram = (program) => {
  selectedProgram.value = program
  showEditModal.value = true
}

const manageParticipants = (program) => {
  selectedProgram.value = program
  showParticipantsModal.value = true
}

const deleteProgram = async (program) => {
  if (confirm(`Apakah Anda yakin ingin menghapus program ${program.nama_program}?`)) {
    try {
      await programKesiswaanSMK.delete(program.id)
      await loadPrograms()
      await loadStatistics()
    } catch (error) {
      console.error('Error deleting program:', error)
    }
  }
}

const handleProgramCreated = () => {
  showCreateModal.value = false
  loadPrograms()
  loadStatistics()
}

const handleProgramUpdated = () => {
  showEditModal.value = false
  showParticipantsModal.value = false
  loadPrograms()
  loadStatistics()
}

const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--
    loadPrograms()
  }
}

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++
    loadPrograms()
  }
}

// Lifecycle
onMounted(() => {
  loadPrograms()
  loadStatistics()
})
</script>

<style scoped>
.program-kesiswaan-smk-view {
  min-height: 100vh;
  background-color: #f9fafb;
}
</style>

