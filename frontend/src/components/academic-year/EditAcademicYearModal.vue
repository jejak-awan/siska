<template>
  <BaseModal
    :is-open="isOpen"
    :title="'Edit Tahun Akademik'"
    @close="$emit('close')"
  >
    <form @submit.prevent="handleSubmit" class="space-y-4">
      <!-- Tahun Akademik -->
      <div>
        <label for="tahun_akademik" class="block text-sm font-medium text-gray-700">
          Tahun Akademik *
        </label>
        <input
          id="tahun_akademik"
          v-model="form.tahun_akademik"
          type="text"
          placeholder="2024/2025"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          :class="{ 'border-red-500': errors.tahun_akademik }"
          required
        />
        <p v-if="errors.tahun_akademik" class="mt-1 text-sm text-red-600">
          {{ errors.tahun_akademik[0] }}
        </p>
      </div>

      <!-- Semester -->
      <div>
        <label for="semester" class="block text-sm font-medium text-gray-700">
          Semester *
        </label>
        <select
          id="semester"
          v-model="form.semester"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          :class="{ 'border-red-500': errors.semester }"
          required
        >
          <option value="">Pilih Semester</option>
          <option value="1">Semester 1</option>
          <option value="2">Semester 2</option>
        </select>
        <p v-if="errors.semester" class="mt-1 text-sm text-red-600">
          {{ errors.semester[0] }}
        </p>
      </div>

      <!-- Tanggal Mulai -->
      <div>
        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">
          Tanggal Mulai *
        </label>
        <input
          id="tanggal_mulai"
          v-model="form.tanggal_mulai"
          type="date"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          :class="{ 'border-red-500': errors.tanggal_mulai }"
          required
        />
        <p v-if="errors.tanggal_mulai" class="mt-1 text-sm text-red-600">
          {{ errors.tanggal_mulai[0] }}
        </p>
      </div>

      <!-- Tanggal Selesai -->
      <div>
        <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">
          Tanggal Selesai *
        </label>
        <input
          id="tanggal_selesai"
          v-model="form.tanggal_selesai"
          type="date"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          :class="{ 'border-red-500': errors.tanggal_selesai }"
          required
        />
        <p v-if="errors.tanggal_selesai" class="mt-1 text-sm text-red-600">
          {{ errors.tanggal_selesai[0] }}
        </p>
      </div>

      <!-- Keterangan -->
      <div>
        <label for="keterangan" class="block text-sm font-medium text-gray-700">
          Keterangan
        </label>
        <textarea
          id="keterangan"
          v-model="form.keterangan"
          rows="3"
          placeholder="Keterangan tambahan..."
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          :class="{ 'border-red-500': errors.keterangan }"
        ></textarea>
        <p v-if="errors.keterangan" class="mt-1 text-sm text-red-600">
          {{ errors.keterangan[0] }}
        </p>
      </div>

      <!-- Actions -->
      <div class="flex justify-end space-x-3 pt-4">
        <button
          type="button"
          @click="$emit('close')"
          class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
          Batal
        </button>
        <button
          type="submit"
          :disabled="isLoading"
          class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
        >
          <span v-if="isLoading">Menyimpan...</span>
          <span v-else>Simpan</span>
        </button>
      </div>
    </form>
  </BaseModal>
</template>

<script setup>
import { ref, reactive, watch } from 'vue'
import BaseModal from '@/components/modals/BaseModal.vue'

// Props
const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  },
  academicYear: {
    type: Object,
    default: null
  }
})

// Emits
const emit = defineEmits(['close', 'success'])

// State
const isLoading = ref(false)
const errors = ref({})

const form = reactive({
  tahun_akademik: '',
  semester: '',
  tanggal_mulai: '',
  tanggal_selesai: '',
  keterangan: ''
})

// Methods
const resetForm = () => {
  form.tahun_akademik = ''
  form.semester = ''
  form.tanggal_mulai = ''
  form.tanggal_selesai = ''
  form.keterangan = ''
  errors.value = {}
}

const loadAcademicYearData = () => {
  if (props.academicYear) {
    form.tahun_akademik = props.academicYear.tahun_akademik || ''
    form.semester = props.academicYear.semester || ''
    form.tanggal_mulai = props.academicYear.tanggal_mulai || ''
    form.tanggal_selesai = props.academicYear.tanggal_selesai || ''
    form.keterangan = props.academicYear.keterangan || ''
  }
}

const handleSubmit = async () => {
  try {
    isLoading.value = true
    errors.value = {}

    // Emit success event with form data
    emit('success', { ...form })
    
    // Reset form and close modal
    resetForm()
    emit('close')
  } catch (error) {
    console.error('Error updating academic year:', error)
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors
    }
  } finally {
    isLoading.value = false
  }
}

// Watch for modal open to load data
watch(() => props.isOpen, (newValue) => {
  if (newValue) {
    loadAcademicYearData()
  } else {
    resetForm()
  }
})

// Watch for academic year changes
watch(() => props.academicYear, () => {
  if (props.isOpen) {
    loadAcademicYearData()
  }
})
</script>

