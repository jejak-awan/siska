<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Tahun Akademik</h1>
          <p class="mt-2 text-gray-600">Kelola data tahun akademik</p>
        </div>
        <BaseButton
          @click="openCreateModal"
          variant="primary"
          class="flex items-center"
        >
          <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Tambah Tahun Akademik
        </BaseButton>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="isLoading" class="flex justify-center items-center py-12">
      <div class="loading-spinner"></div>
    </div>

    <!-- Academic Years Table -->
    <div v-else class="card">
      <div class="card-header">
        <h3 class="text-lg font-medium text-gray-900">Daftar Tahun Akademik</h3>
        <p class="mt-1 text-sm text-gray-500">Kelola semua tahun akademik</p>
      </div>
      <div class="card-body p-0">
        <div class="overflow-x-auto">
          <table class="table">
            <thead class="table-header">
              <tr>
                <th class="table-header-cell">Tahun Akademik</th>
                <th class="table-header-cell">Sekolah ID</th>
                <th class="table-header-cell">Status</th>
                <th class="table-header-cell">Dibuat</th>
                <th class="table-header-cell">Actions</th>
              </tr>
            </thead>
            <tbody class="table-body">
              <tr v-if="academicYears.length === 0">
                <td colspan="5" class="table-cell text-center py-8 text-gray-500">
                  <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  <p>Belum ada tahun akademik</p>
                </td>
              </tr>
              <tr v-for="academicYear in academicYears" :key="academicYear?.id || Math.random()" v-if="academicYear" class="hover:bg-gray-50">
                <td class="table-cell">
                  <div class="font-medium text-gray-900">
                    {{ academicYear?.tahun_akademik }}
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ formatDate(academicYear?.tanggal_mulai) }} - {{ formatDate(academicYear?.tanggal_selesai) }}
                  </div>
                </td>
                <td class="table-cell">
                  <span class="badge badge-secondary">{{ academicYear?.sekolah_id }}</span>
                </td>
                <td class="table-cell">
                  <span
                    :class="academicYear?.is_active ? 'badge-success' : 'badge-secondary'"
                    class="badge"
                  >
                    {{ academicYear?.is_active ? 'Aktif' : 'Nonaktif' }}
                  </span>
                </td>
                <td class="table-cell">
                  {{ formatDate(academicYear?.created_at) }}
                </td>
                <td class="table-cell">
                  <div class="flex space-x-2">
                    <BaseButton
                      @click="openEditModal(academicYear)"
                      variant="outline"
                      size="sm"
                    >
                      Edit
                    </BaseButton>
                    <BaseButton
                      v-if="!academicYear?.is_active"
                      @click="activateAcademicYear(academicYear)"
                      variant="success"
                      size="sm"
                    >
                      Aktifkan
                    </BaseButton>
                    <BaseButton
                      @click="deleteAcademicYear(academicYear)"
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
      :title="isEditing ? 'Edit Tahun Akademik' : 'Tambah Tahun Akademik Baru'"
      @close="closeModal"
      size="lg"
    >
      <form @submit.prevent="submitForm" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <BaseInput
            v-model.number="form.sekolah_id"
            label="ID Sekolah"
            type="number"
            placeholder="Masukkan ID sekolah"
            :error="errors.sekolah_id"
            required
          />
          
          <BaseInput
            v-model="form.tahun_akademik"
            label="Tahun Akademik"
            placeholder="Masukkan tahun akademik (e.g., 2024/2025)"
            :error="errors.tahun_akademik"
            required
          />
          
          <BaseInput
            v-model="form.tanggal_mulai"
            label="Tanggal Mulai"
            type="date"
            placeholder="Masukkan tanggal mulai"
            :error="errors.tanggal_mulai"
            required
          />
          
          <BaseInput
            v-model="form.tanggal_selesai"
            label="Tanggal Selesai"
            type="date"
            placeholder="Masukkan tanggal selesai"
            :error="errors.tanggal_selesai"
            required
          />
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
              <div class="mt-2 text-sm text-blue-700">
                <p>Tahun akademik: <strong>{{ form.tahun_akademik }}</strong></p>
                <p class="mt-1">Periode: {{ formatDate(form.tanggal_mulai) }} - {{ formatDate(form.tanggal_selesai) }}</p>
                <p class="mt-1">Pastikan tanggal selesai lebih besar dari tanggal mulai.</p>
              </div>
            </div>
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
            {{ isEditing ? 'Update' : 'Simpan' }}
          </BaseButton>
        </div>
      </form>
    </BaseModal>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, reactive } from 'vue'
import { tahunAkademikService, type TahunAkademik, type CreateTahunAkademikData } from '@/services/tahunAkademik'
import { useToast } from 'vue-toastification'
import BaseButton from '@/components/forms/BaseButton.vue'
import BaseInput from '@/components/forms/BaseInput.vue'
import BaseModal from '@/components/modals/BaseModal.vue'

const toast = useToast()

// State
const academicYears = ref<TahunAkademik[]>([])
const isLoading = ref(false)
const isModalOpen = ref(false)
const isEditing = ref(false)
const isSubmitting = ref(false)
const editingId = ref<number | null>(null)

// Form data
const form = reactive<CreateTahunAkademikData>({
  sekolah_id: 0,
  tahun_akademik: '',
  tanggal_mulai: '',
  tanggal_selesai: '',
  keterangan: '',
})

// Form errors
const errors = reactive<Record<string, string>>({})

// Methods
const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  })
}

const loadAcademicYears = async () => {
  isLoading.value = true
  try {
    const response = await tahunAkademikService.getTahunAkademik()
    const academicYearsData = response.data
    academicYears.value = academicYearsData?.data || academicYearsData || []
  } catch (error: any) {
    toast.error(error.message || 'Gagal memuat daftar tahun akademik')
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

const openEditModal = (academicYear: TahunAkademik) => {
  isEditing.value = true
  editingId.value = academicYear?.id
  form.sekolah_id = academicYear?.sekolah_id
  form.tahun_akademik = academicYear?.tahun_akademik
  form.tanggal_mulai = academicYear?.tanggal_mulai?.split('T')[0] // Convert to date input format
  form.tanggal_selesai = academicYear?.tanggal_selesai?.split('T')[0] // Convert to date input format
  form.keterangan = academicYear?.keterangan
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
  resetForm()
}

const resetForm = () => {
  form.sekolah_id = 0
  form.tahun_akademik = ''
  form.tanggal_mulai = ''
  form.tanggal_selesai = ''
  form.keterangan = ''
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

  // Validation
  if (form.tanggal_selesai <= form.tanggal_mulai) {
    errors.tanggal_selesai = 'Tanggal selesai harus lebih besar dari tanggal mulai'
    isSubmitting.value = false
    return
  }

  try {
    if (isEditing.value && editingId.value) {
      await tahunAkademikService.updateTahunAkademik(editingId.value, form)
      toast.success('Tahun akademik berhasil diperbarui')
    } else {
      await tahunAkademikService.createTahunAkademik(form)
      toast.success('Tahun akademik berhasil dibuat')
    }
    
    closeModal()
    loadAcademicYears()
  } catch (error: any) {
    if (error.response?.data?.errors) {
      Object.assign(errors, error.response.data.errors)
    } else {
      toast.error(error.message || 'Gagal menyimpan tahun akademik')
    }
  } finally {
    isSubmitting.value = false
  }
}

const activateAcademicYear = async (academicYear: TahunAkademik) => {
  try {
    await tahunAkademikService.activateTahunAkademik(academicYear?.id)
    toast.success('Tahun akademik berhasil diaktifkan')
    loadAcademicYears()
  } catch (error: any) {
    toast.error(error.message || 'Gagal mengaktifkan tahun akademik')
  }
}

const deleteAcademicYear = async (academicYear: TahunAkademik) => {
  if (!confirm(`Apakah Anda yakin ingin menghapus tahun akademik ${academicYear?.tahun_akademik}?`)) {
    return
  }

  try {
    await tahunAkademikService.deleteTahunAkademik(academicYear?.id)
    toast.success('Tahun akademik berhasil dihapus')
    loadAcademicYears()
  } catch (error: any) {
    toast.error(error.message || 'Gagal menghapus tahun akademik')
  }
}

// Lifecycle
onMounted(() => {
  loadAcademicYears()
})
</script>
