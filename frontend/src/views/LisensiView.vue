<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Lisensi</h1>
          <p class="mt-2 text-gray-600">Kelola lisensi sistem</p>
        </div>
        <BaseButton
          @click="openCreateModal"
          variant="primary"
          class="flex items-center"
        >
          <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Tambah Lisensi
        </BaseButton>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="isLoading" class="flex justify-center items-center py-12">
      <div class="loading-spinner"></div>
    </div>

    <!-- Search and Filter Section -->
    <div v-else class="card mb-6">
      <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Search Input -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Lisensi</label>
            <div class="relative">
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Cari berdasarkan license key, tipe, atau jenjang..."
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
              />
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>
          
          <!-- Status Filter -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
            <select
              v-model="statusFilter"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
            >
              <option value="">Semua Status</option>
              <option value="active">Aktif</option>
              <option value="inactive">Nonaktif</option>
            </select>
          </div>
        </div>
        
        <!-- Filter Tags -->
        <div v-if="hasActiveFilters" class="mt-4 flex flex-wrap gap-2">
          <span
            v-if="searchQuery"
            class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-primary-100 text-primary-800"
          >
            Pencarian: "{{ searchQuery }}"
            <button @click="searchQuery = ''" class="ml-2 text-primary-600 hover:text-primary-800">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </span>
          <span
            v-if="statusFilter"
            class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-primary-100 text-primary-800"
          >
            Status: {{ statusFilter === 'active' ? 'Aktif' : 'Nonaktif' }}
            <button @click="statusFilter = ''" class="ml-2 text-primary-600 hover:text-primary-800">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </span>
          <button
            @click="clearAllFilters"
            class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-800 hover:bg-gray-200"
          >
            Hapus Semua Filter
          </button>
        </div>
      </div>
    </div>

    <!-- Licenses Table -->
    <div class="card">
      <div class="card-header">
        <h3 class="text-lg font-medium text-gray-900">Daftar Lisensi</h3>
        <p class="mt-1 text-sm text-gray-500">
          Menampilkan {{ filteredLicenses.length }} dari {{ licenses.length }} lisensi
        </p>
      </div>
      <div class="card-body p-0">
        <div class="overflow-x-auto">
          <table class="table">
            <thead class="table-header">
              <tr>
                <th class="table-header-cell">Kunci Lisensi</th>
                <th class="table-header-cell">Tipe Lisensi</th>
                <th class="table-header-cell">Maksimal Pengguna</th>
                <th class="table-header-cell">Akses Jenjang</th>
                <th class="table-header-cell">Tanggal Kadaluarsa</th>
                <th class="table-header-cell">Status</th>
                <th class="table-header-cell">Aksi</th>
              </tr>
            </thead>
            <tbody class="table-body">
              <tr v-if="licenses.length === 0">
                <td colspan="7" class="table-cell text-center py-8 text-gray-500">
                  <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <p>Belum ada lisensi</p>
                </td>
              </tr>
              <tr v-for="license in filteredLicenses" :key="license?.id || Math.random()" v-if="license" class="hover:bg-gray-50">
                <td class="table-cell">
                  <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ license?.license_key }}</code>
                </td>
                <td class="table-cell">
                  <span class="badge badge-primary">{{ license?.license_type }}</span>
                </td>
                <td class="table-cell">{{ license?.max_users }}</td>
                <td class="table-cell">
                  <div class="flex flex-wrap gap-1">
                    <span
                      v-for="jenjang in license?.jenjang_access"
                      :key="jenjang"
                      class="badge badge-secondary text-xs"
                    >
                      {{ jenjang }}
                    </span>
                  </div>
                </td>
                <td class="table-cell">
                  {{ formatDate(license?.expires_at) }}
                </td>
                <td class="table-cell">
                  <span
                    :class="license?.is_active ? 'badge-success' : 'badge-danger'"
                    class="badge"
                  >
                    {{ license?.is_active ? 'Aktif' : 'Nonaktif' }}
                  </span>
                </td>
                <td class="table-cell">
                  <div class="flex space-x-2">
                    <BaseButton
                      @click="openEditModal(license)"
                      variant="outline"
                      size="sm"
                    >
                      Ubah
                    </BaseButton>
                    <BaseButton
                      @click="toggleLicenseStatus(license)"
                      :variant="license?.is_active ? 'warning' : 'success'"
                      size="sm"
                    >
                      {{ license?.is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </BaseButton>
                    <BaseButton
                      @click="deleteLicense(license)"
                      variant="danger"
                      size="sm"
                    >
                      Hapus
                    </BaseButton>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Create/Edit Modal -->
    <BaseModal
      :isOpen="isModalOpen"
      :title="isEditing ? 'Ubah Lisensi' : 'Tambah Lisensi Baru'"
      @close="closeModal"
      size="lg"
    >
      <form @submit.prevent="submitForm" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <BaseInput
            v-model="form.license_key"
            label="Kunci Lisensi"
            placeholder="Masukkan kunci lisensi"
            :error="errors.license_key"
            required
          />
          
          <BaseSelect
            v-model="form.license_type"
            label="Tipe Lisensi"
            :options="licenseTypes"
            :error="errors.license_type"
            required
          />
          
          <BaseInput
            v-model.number="form.max_users"
            label="Maksimal Pengguna"
            type="number"
            placeholder="Masukkan maksimal pengguna"
            :error="errors.max_users"
            required
          />
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kadaluarsa</label>
            <input
              v-model="form.expires_at"
              type="date"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
              :class="{ 'border-red-500': errors.expires_at }"
              required
            />
            <p v-if="errors.expires_at" class="mt-1 text-sm text-red-600">{{ errors.expires_at }}</p>
          </div>
        </div>

        <div class="flex justify-end space-x-3">
          <BaseButton
            type="button"
            variant="outline"
            @click="closeModal"
          >
            Batal
          </BaseButton>
          <BaseButton
            type="submit"
            variant="primary"
            :loading="isSubmitting"
          >
            {{ isEditing ? 'Perbarui' : 'Simpan' }}
          </BaseButton>
        </div>
      </form>
    </BaseModal>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, reactive, computed } from 'vue'
import { licenseService, type License, type CreateLicenseData } from '@/services/license'
import { useToast } from 'vue-toastification'
import BaseButton from '@/components/forms/BaseButton.vue'
import BaseInput from '@/components/forms/BaseInput.vue'
import BaseSelect from '@/components/forms/BaseSelect.vue'
import BaseModal from '@/components/modals/BaseModal.vue'

const toast = useToast()

// State
const licenses = ref<License[]>([])
const isLoading = ref(false)
const isModalOpen = ref(false)
const isEditing = ref(false)
const isSubmitting = ref(false)
const editingId = ref<number | null>(null)

// Search and Filter
const searchQuery = ref('')
const statusFilter = ref('')

// Form data
const form = reactive<CreateLicenseData>({
  license_key: '',
  license_type: 'trial',
  max_users: 0,
  jenjang_access: [],
  features: [],
  expires_at: '',
})

// Form errors
const errors = reactive<Record<string, string>>({})

// License types
const licenseTypes = [
  { value: 'basic', label: 'Basic' },
  { value: 'premium', label: 'Premium' },
  { value: 'enterprise', label: 'Enterprise' },
]

// Computed properties
const filteredLicenses = computed(() => {
  let filtered = licenses.value

  // Search filter
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(license => 
      license?.license_key?.toLowerCase().includes(query) ||
      license?.license_type?.toLowerCase().includes(query) ||
      license?.jenjang_access?.some(jenjang => jenjang.toLowerCase().includes(query))
    )
  }

  // Status filter
  if (statusFilter.value) {
    filtered = filtered.filter(license => {
      if (statusFilter.value === 'active') {
        return license?.is_active === true
      } else if (statusFilter.value === 'inactive') {
        return license?.is_active === false
      }
      return true
    })
  }

  return filtered
})

const hasActiveFilters = computed(() => {
  return searchQuery.value || statusFilter.value
})

// Methods
const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  })
}

const loadLicenses = async () => {
  isLoading.value = true
  try {
    const response = await licenseService.getLicenses()
    licenses.value = response.data || []
  } catch (error: any) {
    toast.error(error.message || 'Gagal memuat daftar lisensi')
  } finally {
    isLoading.value = false
  }
}

const openCreateModal = () => {
  isEditing.value = false
  editingId.value = null
  resetForm()
  isModalOpen.value = true
}

const openEditModal = (license: License) => {
  isEditing.value = true
  editingId.value = license?.id
  form.license_key = license?.license_key
  form.license_type = license?.license_type
  form.max_users = license?.max_users
  form.expires_at = license?.expires_at?.split('T')[0] // Convert to date input format
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
  resetForm()
}

const resetForm = () => {
  form.license_key = ''
  form.license_type = 'trial'
  form.max_users = 0
  form.jenjang_access = []
  form.features = []
  form.expires_at = ''
  clearErrors()
}

const clearErrors = () => {
  Object.keys(errors).forEach(key => {
    delete errors[key]
  })
}

const clearAllFilters = () => {
  searchQuery.value = ''
  statusFilter.value = ''
}

const submitForm = async () => {
  clearErrors()
  isSubmitting.value = true

  try {
    if (isEditing.value && editingId.value) {
      await licenseService.updateLicense(editingId.value, form)
      toast.success('Lisensi berhasil diperbarui')
    } else {
      await licenseService.createLicense(form)
      toast.success('Lisensi berhasil dibuat')
    }
    
    closeModal()
    loadLicenses()
  } catch (error: any) {
    if (error.response?.data?.errors) {
      Object.assign(errors, error.response.data.errors)
    } else {
      toast.error(error.message || 'Gagal menyimpan lisensi')
    }
  } finally {
    isSubmitting.value = false
  }
}

const toggleLicenseStatus = async (license: License) => {
  try {
    if (license?.is_active) {
      await licenseService.deactivateLicense(license?.id)
      toast.success('Lisensi berhasil dinonaktifkan')
    } else {
      await licenseService.activateLicense(license?.id)
      toast.success('Lisensi berhasil diaktifkan')
    }
    loadLicenses()
  } catch (error: any) {
    toast.error(error.message || 'Gagal mengubah status lisensi')
  }
}

const deleteLicense = async (license: License) => {
  if (!confirm(`Apakah Anda yakin ingin menghapus lisensi ${license?.license_key}?`)) {
    return
  }

  try {
    await licenseService.deleteLicense(license?.id)
    toast.success('Lisensi berhasil dihapus')
    loadLicenses()
  } catch (error: any) {
    toast.error(error.message || 'Gagal menghapus lisensi')
  }
}

// Lifecycle
onMounted(() => {
  loadLicenses()
})
</script>