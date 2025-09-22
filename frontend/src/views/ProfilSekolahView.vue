<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Profil Sekolah</h1>
          <p class="mt-2 text-gray-600">Kelola data profil sekolah</p>
        </div>
        <BaseButton
          @click="openCreateModal"
          variant="primary"
          class="flex items-center"
        >
          <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Tambah Profil Sekolah
        </BaseButton>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="isLoading" class="flex justify-center items-center py-12">
      <div class="loading-spinner"></div>
    </div>

    <!-- Schools Grid -->
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-if="schools.length === 0" class="col-span-full">
        <div class="card">
          <div class="card-body text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <p class="text-gray-500">Belum ada profil sekolah</p>
          </div>
        </div>
      </div>

      <div
        v-for="school in schools"
        :key="school?.id || Math.random()"
        v-if="school"
        class="card hover:shadow-lg transition-shadow"
      >
        <div class="card-body">
          <div class="flex items-start justify-between mb-4">
            <div class="flex items-center">
              <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                <img
                  v-if="school?.logo_url"
                  :src="school.logo_url"
                  :alt="school?.nama_sekolah"
                  class="w-8 h-8 rounded"
                />
                <svg v-else class="w-6 h-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ school?.nama_sekolah }}</h3>
                <p class="text-sm text-gray-500">NPSN: {{ school?.npsn }}</p>
              </div>
            </div>
            <span class="badge badge-primary">{{ school?.jenjang }}</span>
          </div>

          <div class="space-y-2 mb-4">
            <div class="flex items-center text-sm text-gray-600">
              <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              {{ school?.alamat }}
            </div>
            <div class="flex items-center text-sm text-gray-600">
              <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
              {{ school?.kota }}, {{ school?.provinsi }}
            </div>
          </div>

          <div class="flex justify-end space-x-2">
            <BaseButton
              @click="openEditModal(school)"
              variant="outline"
              size="sm"
            >
              Edit
            </BaseButton>
            <BaseButton
              @click="deleteSchool(school)"
              variant="danger"
              size="sm"
            >
              Hapus
            </BaseButton>
          </div>
        </div>
      </div>
    </div>

    <!-- Create/Edit Modal -->
    <BaseModal
      :isOpen="isModalOpen"
      :title="isEditing ? 'Edit Profil Sekolah' : 'Tambah Profil Sekolah Baru'"
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
            v-model="form.nama_sekolah"
            label="Nama Sekolah"
            placeholder="Masukkan nama sekolah"
            :error="errors.nama_sekolah"
            required
          />
          
          <BaseInput
            v-model="form.npsn"
            label="NPSN"
            placeholder="Masukkan NPSN"
            :error="errors.npsn"
            required
          />
          
          <BaseSelect
            v-model="form.jenjang"
            label="Jenjang"
            :options="jenjangOptions"
            :error="errors.jenjang"
            required
          />
          
          <BaseInput
            v-model="form.alamat"
            label="Alamat"
            placeholder="Masukkan alamat"
            :error="errors.alamat"
            required
          />
          
          <BaseInput
            v-model="form.kota"
            label="Kota"
            placeholder="Masukkan kota"
            :error="errors.kota"
            required
          />
          
          <BaseInput
            v-model="form.provinsi"
            label="Provinsi"
            placeholder="Masukkan provinsi"
            :error="errors.provinsi"
            required
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Logo Sekolah
          </label>
          <input
            ref="logoInput"
            type="file"
            accept="image/*"
            @change="handleLogoChange"
            class="form-input"
          />
          <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB</p>
          <p v-if="errors.logo_file" class="mt-1 text-sm text-red-600">{{ errors.logo_file }}</p>
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
import { profilSekolahService, type ProfilSekolah, type CreateProfilSekolahData } from '@/services/profilSekolah'
import { useToast } from 'vue-toastification'
import BaseButton from '@/components/forms/BaseButton.vue'
import BaseInput from '@/components/forms/BaseInput.vue'
import BaseSelect from '@/components/forms/BaseSelect.vue'
import BaseModal from '@/components/modals/BaseModal.vue'

const toast = useToast()

// State
const schools = ref<ProfilSekolah[]>([])
const isLoading = ref(false)
const isModalOpen = ref(false)
const isEditing = ref(false)
const isSubmitting = ref(false)
const editingId = ref<number | null>(null)
const logoInput = ref<HTMLInputElement>()

// Form data
const form = reactive<CreateProfilSekolahData>({
  sekolah_id: 0,
  nama_sekolah: '',
  npsn: '',
  jenjang: '',
  alamat: '',
  kota: '',
  provinsi: '',
})

// Form errors
const errors = reactive<Record<string, string>>({})

// Jenjang options
const jenjangOptions = [
  { value: 'SD', label: 'Sekolah Dasar (SD)' },
  { value: 'SMP', label: 'Sekolah Menengah Pertama (SMP)' },
  { value: 'SMA', label: 'Sekolah Menengah Atas (SMA)' },
  { value: 'SMK', label: 'Sekolah Menengah Kejuruan (SMK)' },
]

// Methods
const loadSchools = async () => {
  isLoading.value = true
  try {
    const response = await profilSekolahService.getProfilSekolah()
    const schoolsData = response.data
    schools.value = schoolsData?.data || schoolsData || []
  } catch (error: any) {
    toast.error(error.message || 'Gagal memuat daftar profil sekolah')
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

const openEditModal = (school: ProfilSekolah) => {
  if (!school) return
  
  isEditing.value = true
  editingId.value = school.id
  form.sekolah_id = school.sekolah_id
  form.nama_sekolah = school.nama_sekolah
  form.npsn = school.npsn
  form.jenjang = school.jenjang
  form.alamat = school.alamat
  form.kota = school.kota
  form.provinsi = school.provinsi
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
  resetForm()
}

const resetForm = () => {
  form.sekolah_id = 0
  form.nama_sekolah = ''
  form.npsn = ''
  form.jenjang = ''
  form.alamat = ''
  form.kota = ''
  form.provinsi = ''
  if (logoInput.value) {
    logoInput.value.value = ''
  }
  clearErrors()
}

const clearErrors = () => {
  Object.keys(errors).forEach(key => {
    delete errors[key]
  })
}

const handleLogoChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files[0]) {
    form.logo_file = target.files[0]
  }
}

const submitForm = async () => {
  clearErrors()
  isSubmitting.value = true

  try {
    if (isEditing.value && editingId.value) {
      await profilSekolahService.updateProfilSekolah(editingId.value, form)
      toast.success('Profil sekolah berhasil diperbarui')
    } else {
      await profilSekolahService.createProfilSekolah(form)
      toast.success('Profil sekolah berhasil dibuat')
    }
    
    closeModal()
    loadSchools()
  } catch (error: any) {
    if (error.response?.data?.errors) {
      Object.assign(errors, error.response.data.errors)
    } else {
      toast.error(error.message || 'Gagal menyimpan profil sekolah')
    }
  } finally {
    isSubmitting.value = false
  }
}

const deleteSchool = async (school: ProfilSekolah) => {
  if (!school) return
  
  if (!confirm(`Apakah Anda yakin ingin menghapus profil sekolah ${school.nama_sekolah}?`)) {
    return
  }

  try {
    await profilSekolahService.deleteProfilSekolah(school.id)
    toast.success('Profil sekolah berhasil dihapus')
    loadSchools()
  } catch (error: any) {
    toast.error(error.message || 'Gagal menghapus profil sekolah')
  }
}

// Lifecycle
onMounted(() => {
  loadSchools()
})
</script>
