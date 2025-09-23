<template>
  <div class="organisasi-sma-view">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">
                Organisasi Siswa SMA
              </h1>
              <p class="mt-1 text-sm text-gray-500">
                Kelola organisasi siswa Sekolah Menengah Atas
              </p>
            </div>
            <button
              @click="showCreateModal = true"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
              Tambah Organisasi
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Total Organisasi
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
                    Total Anggota
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.total_anggota || 0 }}
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
                    Organisasi Aktif
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
                    Rata-rata Anggota
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ statistics.rata_anggota || 0 }}
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
              Cari Organisasi
            </label>
            <input
              v-model="filters.search"
              type="text"
              placeholder="Cari berdasarkan nama organisasi..."
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
              Pembina
            </label>
            <input
              v-model="filters.pembina"
              type="text"
              placeholder="Cari berdasarkan pembina..."
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          <div class="flex items-end">
            <button
              @click="loadOrganisasi"
              class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              Filter
            </button>
          </div>
        </div>
      </div>

      <!-- Organisasi Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="organisasi in organisasiList"
          :key="organisasi.id"
          class="bg-white shadow rounded-lg overflow-hidden"
        >
          <div class="p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-medium text-gray-900">
                {{ organisasi.nama_organisasi }}
              </h3>
              <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                    :class="getStatusClass(organisasi.status)">
                {{ getStatusLabel(organisasi.status) }}
              </span>
            </div>
            
            <p class="text-sm text-gray-600 mb-4">
              {{ organisasi.deskripsi || 'Tidak ada deskripsi' }}
            </p>
            
            <div class="space-y-2 mb-4">
              <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="font-medium">Pembina:</span>
                <span class="ml-1">{{ organisasi.pembina }}</span>
              </div>
              
              <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="font-medium">Jadwal:</span>
                <span class="ml-1">{{ organisasi.jadwal }}</span>
              </div>
              
              <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="font-medium">Lokasi:</span>
                <span class="ml-1">{{ organisasi.lokasi }}</span>
              </div>
              
              <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="font-medium">Anggota:</span>
                <span class="ml-1">{{ organisasi.total_anggota || 0 }} siswa</span>
              </div>
            </div>
            
            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
              <button
                @click="viewMembers(organisasi)"
                class="text-blue-600 hover:text-blue-900 text-sm font-medium"
              >
                Lihat Anggota
              </button>
              <div class="flex space-x-2">
                <button
                  @click="editOrganisasi(organisasi)"
                  class="text-indigo-600 hover:text-indigo-900 text-sm font-medium"
                >
                  Edit
                </button>
                <button
                  @click="deleteOrganisasi(organisasi)"
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
      <div v-if="organisasiList.length === 0 && !isLoading" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">
          Belum ada organisasi
        </h3>
        <p class="mt-1 text-sm text-gray-500">
          Mulai dengan menambahkan organisasi baru.
        </p>
        <div class="mt-6">
          <button
            @click="showCreateModal = true"
            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
          >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Organisasi
          </button>
        </div>
      </div>
    </div>

    <!-- Create Organisasi Modal -->
    <CreateOrganisasiSMAModal
      v-if="showCreateModal"
      @close="showCreateModal = false"
      @created="handleOrganisasiCreated"
    />

    <!-- Edit Organisasi Modal -->
    <EditOrganisasiSMAModal
      v-if="showEditModal && selectedOrganisasi"
      :organisasi="selectedOrganisasi"
      @close="showEditModal = false"
      @updated="handleOrganisasiUpdated"
    />

    <!-- View Members Modal -->
    <ViewMembersOrganisasiSMAModal
      v-if="showMembersModal && selectedOrganisasi"
      :organisasi="selectedOrganisasi"
      @close="showMembersModal = false"
    />
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useOrganisasiSMAStore } from '@/stores/jenjang/sma/organisasiSMA'
// import.*@/components/jenjang/sma/CreateOrganisasiSMAModal.vue'
// import.*@/components/jenjang/sma/EditOrganisasiSMAModal.vue'
// import.*@/components/jenjang/sma/ViewMembersOrganisasiSMAModal.vue'

// 
const organisasiSMA = useOrganisasiSMAStore()

// State
const organisasiList = ref([])
const statistics = ref({})
const isLoading = ref(false)
const showCreateModal = ref(false)
const showEditModal = ref(false)
const showMembersModal = ref(false)
const selectedOrganisasi = ref(null)

// Filters
const filters = reactive({
  search: '',
  status: '',
  pembina: ''
})

// Methods
const loadOrganisasi = async () => {
  isLoading.value = true
  try {
    const response = await organisasiSMA.getAll(filters)
    organisasiList.value = response.data
  } catch (error) {
    console.error('Error loading organisasi:', error)
  } finally {
    isLoading.value = false
  }
}

const loadStatistics = async () => {
  try {
    statistics.value = await organisasiSMA.getStatistics()
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

const viewMembers = (organisasi) => {
  selectedOrganisasi.value = organisasi
  showMembersModal.value = true
}

const editOrganisasi = (organisasi) => {
  selectedOrganisasi.value = organisasi
  showEditModal.value = true
}

const deleteOrganisasi = async (organisasi) => {
  if (confirm(`Apakah Anda yakin ingin menghapus organisasi ${organisasi.nama_organisasi}?`)) {
    try {
      await organisasiSMA.delete(organisasi.id)
      await loadOrganisasi()
      await loadStatistics()
    } catch (error) {
      console.error('Error deleting organisasi:', error)
    }
  }
}

const handleOrganisasiCreated = () => {
  showCreateModal.value = false
  loadOrganisasi()
  loadStatistics()
}

const handleOrganisasiUpdated = () => {
  showEditModal.value = false
  loadOrganisasi()
  loadStatistics()
}

// Lifecycle
onMounted(() => {
  loadOrganisasi()
  loadStatistics()
})
</script>

<style scoped>
.organisasi-sma-view {
  min-height: 100vh;
  background-color: #f9fafb;
}
</style>

