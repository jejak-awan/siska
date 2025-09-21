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
        <div class="rounded-md shadow-sm -space-y-px">
          <!-- Username Field -->
          <div>
            <label for="username" class="sr-only">Username</label>
            <input
              id="username"
              v-model="form.username"
              name="username"
              type="text"
              autocomplete="username"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm"
              placeholder="Username atau Email"
              :disabled="isLoading"
            />
          </div>

          <!-- Password Field -->
          <div>
            <label for="password" class="sr-only">Password</label>
            <input
              id="password"
              v-model="form.password"
              name="password"
              type="password"
              autocomplete="current-password"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm"
              placeholder="Password"
              :disabled="isLoading"
            />
          </div>
        </div>

        <!-- Error Message -->
        <div v-if="errorMessage" class="alert alert-danger">
          {{ errorMessage }}
        </div>

        <!-- Submit Button -->
        <div>
          <button
            type="submit"
            :disabled="isLoading"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="isLoading" class="absolute left-0 inset-y-0 flex items-center pl-3">
              <div class="loading-spinner h-4 w-4 border-white"></div>
            </span>
            <span v-else class="absolute left-0 inset-y-0 flex items-center pl-3">
              <svg class="h-5 w-5 text-primary-500 group-hover:text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
              </svg>
            </span>
            {{ isLoading ? 'Memproses...' : 'Masuk' }}
          </button>
        </div>

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

// Methods
const handleLogin = async () => {
  if (!form.username || !form.password) {
    errorMessage.value = 'Username dan password wajib diisi'
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
