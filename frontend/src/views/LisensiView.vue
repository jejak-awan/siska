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

    <!-- Licenses Table -->
    <div v-else class="card">
      <div class="card-header">
        <h3 class="text-lg font-medium text-gray-900">Daftar Lisensi</h3>
        <p class="mt-1 text-sm text-gray-500">Kelola semua lisensi sistem</p>
      </div>
      <div class="card-body p-0">
        <div class="overflow-x-auto">
          <table class="table">
            <thead class="table-header">
              <tr>
                <th class="table-header-cell">License Key</th>
                <th class="table-header-cell">Tipe</th>
                <th class="table-header-cell">Max Users</th>
                <th class="table-header-cell">Jenjang Access</th>
                <th class="table-header-cell">Expires</th>
                <th class="table-header-cell">Status</th>
                <th class="table-header-cell">Actions</th>
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
              <tr v-for="license in licenses" :key="license.id" class="hover:bg-gray-50">
                <td class="table-cell">
                  <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ license.license_key }}</code>
                </td>
                <td class="table-cell">
                  <span class="badge badge-primary">{{ license.license_type }}</span>
                </td>
                <td class="table-cell">{{ license.max_users }}</td>
                <td class="table-cell">
                  <div class="flex flex-wrap gap-1">
                    <span
                      v-for="jenjang in license.jenjang_access"
                      :key="jenjang"
                      class="badge badge-secondary text-xs"
                    >
                      {{ jenjang }}
                    </span>
                  </div>
                </td>
                <td class="table-cell">
                  {{ formatDate(license.expires_at) }}
                </td>
                <td class="table-cell">
                  <span
                    :class="license.is_active ? 'badge-success' : 'badge-danger'"
                    class="badge"
                  >
                    {{ license.is_active ? 'Aktif' : 'Nonaktif' }}
                  </span>
                </td>
                <td class="table-cell">
                  <div class="flex space-x-2">
                    <BaseButton
                      @click="openEditModal(license)"
                      variant="outline"
                      size="sm"
                    >
                      Edit
                    </BaseButton>
                    <BaseButton
                      @click="toggleLicenseStatus(license)"
                      :variant="license.is_active ? 'warning' : 'success'"
                      size="sm"
                    >
                      {{ license.is_active ? 'Nonaktifkan' : 'Aktifkan' }}
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
      :title="isEditing ? 'Edit Lisensi' : 'Tambah Lisensi Baru'"
      @close="closeModal"
      size="lg"
    >
      <form @submit.prevent="submitForm" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <BaseInput
            v-model="form.license_key"
            label="License Key"
            placeholder="Masukkan license key"
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
            label="Max Users"
            type="number"
            placeholder="Masukkan max users"
            :error="errors.max_users"
            required
          />
          
          <BaseInput
            v-model="form.expires_at"
            label="Tanggal Expired"
            type="date"
            :error="errors.expires_at"
            required
          />
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
            {{ isEditing ? 'Update' : 'Simpan' }}
          </BaseButton>
        </div>
      </form>
    </BaseModal>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, reactive } from 'vue'
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

// Form data
const form = reactive<CreateLicenseData>({
  license_key: '',
  license_type: '',
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
  editingId.value = license.id
  form.license_key = license.license_key
  form.license_type = license.license_type
  form.max_users = license.max_users
  form.expires_at = license.expires_at.split('T')[0] // Convert to date input format
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
  resetForm()
}

const resetForm = () => {
  form.license_key = ''
  form.license_type = ''
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
    if (license.is_active) {
      await licenseService.deactivateLicense(license.id)
      toast.success('Lisensi berhasil dinonaktifkan')
    } else {
      await licenseService.activateLicense(license.id)
      toast.success('Lisensi berhasil diaktifkan')
    }
    loadLicenses()
  } catch (error: any) {
    toast.error(error.message || 'Gagal mengubah status lisensi')
  }
}

const deleteLicense = async (license: License) => {
  if (!confirm(`Apakah Anda yakin ingin menghapus lisensi ${license.license_key}?`)) {
    return
  }

  try {
    await licenseService.deleteLicense(license.id)
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