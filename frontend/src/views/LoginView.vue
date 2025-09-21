<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <!-- Header -->
      <div>
        <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-primary-100">
          <svg class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
          </svg>
        </div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Masuk ke SISKA
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Sistem Informasi Sekolah Bidang Kesiswaan
        </p>
      </div>

      <!-- Login Form -->
      <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
        <!-- Username Field -->
        <BaseInput
          v-model="form.username"
          type="text"
          label="Username atau Email"
          placeholder="Masukkan username atau email"
          :error="errors.username"
          :disabled="isLoading"
          required
          autocomplete="username"
        />

        <!-- Password Field -->
        <BaseInput
          v-model="form.password"
          type="password"
          label="Password"
          placeholder="Masukkan password"
          :error="errors.password"
          :disabled="isLoading"
          required
          autocomplete="current-password"
        />

        <!-- Error Message -->
        <div v-if="errorMessage" class="alert alert-danger">
          {{ errorMessage }}
        </div>

        <!-- Submit Button -->
        <BaseButton
          type="submit"
          variant="primary"
          size="lg"
          :loading="isLoading"
          :disabled="isLoading"
          full-width
        >
          {{ isLoading ? 'Memproses...' : 'Masuk' }}
        </BaseButton>

        <!-- Demo Credentials -->
        <div class="mt-6 p-4 bg-gray-100 rounded-md">
          <h3 class="text-sm font-medium text-gray-900 mb-2">Demo Credentials:</h3>
          <div class="text-xs text-gray-600 space-y-1">
            <div><strong>Admin:</strong> admin / admin123</div>
            <div><strong>Guru:</strong> guru / guru123</div>
            <div><strong>Siswa:</strong> siswa / siswa123</div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useToast } from 'vue-toastification'
import BaseInput from '@/components/forms/BaseInput.vue'
import BaseButton from '@/components/forms/BaseButton.vue'
import type { LoginCredentials } from '@/types/auth'

const router = useRouter()
const authStore = useAuthStore()
const toast = useToast()

// Form state
const form = reactive<LoginCredentials>({
  username: '',
  password: '',
})

// UI state
const isLoading = ref(false)
const errorMessage = ref('')
const errors = reactive({
  username: '',
  password: '',
})

// Methods
const validateForm = () => {
  errors.username = ''
  errors.password = ''
  
  if (!form.username) {
    errors.username = 'Username wajib diisi'
    return false
  }
  
  if (!form.password) {
    errors.password = 'Password wajib diisi'
    return false
  }
  
  return true
}

const handleLogin = async () => {
  if (!validateForm()) {
    return
  }

  isLoading.value = true
  errorMessage.value = ''

  try {
    await authStore.login(form)
    toast.success('Login berhasil!')
    router.push('/dashboard')
  } catch (error: any) {
    errorMessage.value = error.message || 'Login gagal'
    toast.error(error.message || 'Login gagal')
  } finally {
    isLoading.value = false
  }
}
</script>
