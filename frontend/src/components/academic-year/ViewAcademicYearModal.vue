<template>
  <BaseModal
    :is-open="isOpen"
    :title="'Detail Tahun Akademik'"
    @close="$emit('close')"
  >
    <div v-if="academicYear" class="space-y-4">
      <!-- Tahun Akademik -->
      <div>
        <label class="block text-sm font-medium text-gray-700">
          Tahun Akademik
        </label>
        <p class="mt-1 text-sm text-gray-900">{{ academicYear.tahun_akademik }}</p>
      </div>

      <!-- Semester -->
      <div>
        <label class="block text-sm font-medium text-gray-700">
          Semester
        </label>
        <p class="mt-1 text-sm text-gray-900">Semester {{ academicYear.semester }}</p>
      </div>

      <!-- Tanggal Mulai -->
      <div>
        <label class="block text-sm font-medium text-gray-700">
          Tanggal Mulai
        </label>
        <p class="mt-1 text-sm text-gray-900">{{ formatDate(academicYear.tanggal_mulai) }}</p>
      </div>

      <!-- Tanggal Selesai -->
      <div>
        <label class="block text-sm font-medium text-gray-700">
          Tanggal Selesai
        </label>
        <p class="mt-1 text-sm text-gray-900">{{ formatDate(academicYear.tanggal_selesai) }}</p>
      </div>

      <!-- Status -->
      <div>
        <label class="block text-sm font-medium text-gray-700">
          Status
        </label>
        <span
          class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
          :class="academicYear.status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
        >
          {{ academicYear.status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
        </span>
      </div>

      <!-- Keterangan -->
      <div v-if="academicYear.keterangan">
        <label class="block text-sm font-medium text-gray-700">
          Keterangan
        </label>
        <p class="mt-1 text-sm text-gray-900">{{ academicYear.keterangan }}</p>
      </div>

      <!-- Created At -->
      <div>
        <label class="block text-sm font-medium text-gray-700">
          Dibuat Pada
        </label>
        <p class="mt-1 text-sm text-gray-900">{{ formatDateTime(academicYear.created_at) }}</p>
      </div>

      <!-- Updated At -->
      <div>
        <label class="block text-sm font-medium text-gray-700">
          Diperbarui Pada
        </label>
        <p class="mt-1 text-sm text-gray-900">{{ formatDateTime(academicYear.updated_at) }}</p>
      </div>

      <!-- Actions -->
      <div class="flex justify-end space-x-3 pt-4">
        <button
          type="button"
          @click="$emit('close')"
          class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
          Tutup
        </button>
        <button
          v-if="academicYear.status === 'nonaktif'"
          @click="handleActivate"
          :disabled="isLoading"
          class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50"
        >
          <span v-if="isLoading">Mengaktifkan...</span>
          <span v-else>Aktifkan</span>
        </button>
        <button
          v-if="academicYear.status === 'aktif'"
          @click="handleDeactivate"
          :disabled="isLoading"
          class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50"
        >
          <span v-if="isLoading">Menonaktifkan...</span>
          <span v-else>Nonaktifkan</span>
        </button>
      </div>
    </div>
  </BaseModal>
</template>

<script setup>
import { ref } from 'vue'
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
const emit = defineEmits(['close', 'activate', 'deactivate'])

// State
const isLoading = ref(false)

// Methods
const formatDate = (dateString) => {
  if (!dateString) return '-'
  return new Date(dateString).toLocaleDateString('id-ID')
}

const formatDateTime = (dateString) => {
  if (!dateString) return '-'
  return new Date(dateString).toLocaleString('id-ID')
}

const handleActivate = async () => {
  try {
    isLoading.value = true
    emit('activate', props.academicYear.id)
  } catch (error) {
    console.error('Error activating academic year:', error)
  } finally {
    isLoading.value = false
  }
}

const handleDeactivate = async () => {
  try {
    isLoading.value = true
    emit('deactivate', props.academicYear.id)
  } catch (error) {
    console.error('Error deactivating academic year:', error)
  } finally {
    isLoading.value = false
  }
}
</script>

