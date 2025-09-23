<template>
  <div class="kejuruan-smk-view">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">
                Kejuruan SMK
              </h1>
              <p class="mt-1 text-sm text-gray-500">
                Kelola program kejuruan siswa Sekolah Menengah Kejuruan
              </p>
            </div>
            <button
              @click="showCreateModal = true"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
              Tambah Kejuruan
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Total Kejuruan
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
                <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Kejuruan Aktif
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
                <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Rata-rata Peserta
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.rata_peserta || 0 }}
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
              Cari Kejuruan
            </label>
            <input
              v-model="filters.search"
              type="text"
              placeholder="Cari berdasarkan nama kejuruan..."
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
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Instruktur
            </label>
            <input
              v-model="filters.instruktur"
              type="text"
              placeholder="Cari berdasarkan instruktur..."
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          <div class="flex items-end">
            <button
              @click="loadKejuruan"
              class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              Filter
            </button>
          </div>
        </div>
      </div>

      <!-- Kejuruan Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="kejuruan in kejuruanList"
          :key="kejuruan.id"
          class="bg-white shadow rounded-lg overflow-hidden"
        >
          <div class="p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-medium text-gray-900">
                {{ kejuruan.nama_kejuruan }}
              </h3>
              <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                    :class="getStatusClass(kejuruan.status)">
                {{ getStatusLabel(kejuruan.status) }}
              </span>
            </div>
            
            <p class="text-sm text-gray-600 mb-4">
              {{ kejuruan.deskripsi || 'Tidak ada deskripsi' }}
            </p>
            
            <div class="space-y-2 mb-4">
              <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="font-medium">Instruktur:</span>
                <span class="ml-1">{{ kejuruan.instruktur }}</span>
              </div>
              
              <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="font-medium">Jadwal:</span>
                <span class="ml-1">{{ kejuruan.jadwal }}</span>
              </div>
              
              <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="font-medium">Lokasi:</span>
                <span class="ml-1">{{ kejuruan.lokasi }}</span>
              </div>
              
              <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="font-medium">Peserta:</span>
                <span class="ml-1">{{ kejuruan.total_peserta || 0 }} siswa</span>
              </div>
            </div>
            
            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
              <button
                @click="viewStudents(kejuruan)"
                class="text-blue-600 hover:text-blue-900 text-sm font-medium"
              >
                Lihat Peserta
              </button>
              <div class="flex space-x-2">
                <button
                  @click="editKejuruan(kejuruan)"
                  class="text-indigo-600 hover:text-indigo-900 text-sm font-medium"
                >
                  Edit
                </button>
                <button
                  @click="deleteKejuruan(kejuruan)"
                  class="text-red-600 hover:text-red-900 text-sm font-medium"
                >
                  Hapus
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="kejuruanList.length === 0 && !isLoading" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">
          Belum ada kejuruan
        </h3>
        <p class="mt-1 text-sm text-gray-500">
          Mulai dengan menambahkan kejuruan baru.
        </p>
        <div class="mt-6">
          <button
            @click="showCreateModal = true"
            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
          >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Kejuruan
          </button>
        </div>
      </div>
    </div>

    <!-- Create Kejuruan Modal -->
    <CreateKejuruanSMKModal
      v-if="showCreateModal"
      @close="showCreateModal = false"
      @created="handleKejuruanCreated"
    />

    <!-- Edit Kejuruan Modal -->
    <EditKejuruanSMKModal
      v-if="showEditModal && selectedKejuruan"
      :kejuruan="selectedKejuruan"
      @close="showEditModal = false"
      @updated="handleKejuruanUpdated"
    />

    <!-- View Students Modal -->
    <ViewStudentsKejuruanSMKModal
      v-if="showStudentsModal && selectedKejuruan"
      :kejuruan="selectedKejuruan"
      @close="showStudentsModal = false"
    />
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useKejuruanSMKStore } from '@/stores/jenjang/smk/kejuruanSMK'
// import.*@/components/jenjang/smk/CreateKejuruanSMKModal.vue'
// import.*@/components/jenjang/smk/EditKejuruanSMKModal.vue'
// import.*@/components/jenjang/smk/ViewStudentsKejuruanSMKModal.vue'

// 
const kejuruanSMK = useKejuruanSMKStore()

// State
const kejuruanList = ref([])
const statistics = ref({})
const isLoading = ref(false)
const showCreateModal = ref(false)
const showEditModal = ref(false)
const showStudentsModal = ref(false)
const selectedKejuruan = ref(null)

// Filters
const filters = reactive({
  search: '',
  status: '',
  instruktur: ''
})

// Methods
const loadKejuruan = async () => {
  isLoading.value = true
  try {
    const response = await kejuruanSMK.getAll(filters)
    kejuruanList.value = response.data
  } catch (error) {
    console.error('Error loading kejuruan:', error)
  } finally {
    isLoading.value = false
  }
}

const loadStatistics = async () => {
  try {
    statistics.value = await kejuruanSMK.getStatistics()
  } catch (error) {
    console.error('Error loading statistics:', error)
  }
}

const getStatusClass = (status) => {
  const classes = {
    aktif: 'bg-green-100 text-green-800',
    nonaktif: 'bg-gray-100 text-gray-800'
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusLabel = (status) => {
  const labels = {
    aktif: 'Aktif',
    nonaktif: 'Tidak Aktif'
  }
  return labels[status] || status
}

const viewStudents = (kejuruan) => {
  selectedKejuruan.value = kejuruan
  showStudentsModal.value = true
}

const editKejuruan = (kejuruan) => {
  selectedKejuruan.value = kejuruan
  showEditModal.value = true
}

const deleteKejuruan = async (kejuruan) => {
  if (confirm(`Apakah Anda yakin ingin menghapus kejuruan ${kejuruan.nama_kejuruan}?`)) {
    try {
      await kejuruanSMK.delete(kejuruan.id)
      await loadKejuruan()
      await loadStatistics()
    } catch (error) {
      console.error('Error deleting kejuruan:', error)
    }
  }
}

const handleKejuruanCreated = () => {
  showCreateModal.value = false
  loadKejuruan()
  loadStatistics()
}

const handleKejuruanUpdated = () => {
  showEditModal.value = false
  loadKejuruan()
  loadStatistics()
}

// Lifecycle
onMounted(() => {
  loadKejuruan()
  loadStatistics()
})
</script>

<style scoped>
.kejuruan-smk-view {
  min-height: 100vh;
  background-color: #f9fafb;
}
</style>

