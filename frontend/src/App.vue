<template>
  <div id="app" class="min-h-screen bg-gray-50">
    <!-- Loading Overlay -->
    <div
      v-if="isLoading"
      class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white rounded-lg p-6 flex items-center space-x-4">
        <div class="loading-spinner"></div>
        <span class="text-gray-700">Memuat...</span>
      </div>
    </div>

    <!-- Main Application -->
    <div v-else>
      <!-- Navigation -->
      <nav v-if="isAuthenticated" class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex items-center">
              <!-- Logo -->
              <div class="flex-shrink-0 flex items-center">
                <div class="h-8 w-8 bg-primary-600 rounded-lg flex items-center justify-center">
                  <span class="text-white font-bold text-sm">S</span>
                </div>
                <span class="ml-2 text-xl font-bold text-gray-900">SISKA</span>
              </div>

              <!-- Navigation Links -->
              <div class="hidden md:ml-6 md:flex md:space-x-8">
                <router-link
                  to="/dashboard"
                  class="nav-link"
                  :class="{ 'nav-link-active': $route.path === '/dashboard' }"
                >
                  Dashboard
                </router-link>
                <router-link
                  to="/profil-sekolah"
                  class="nav-link"
                  :class="{ 'nav-link-active': $route.path.startsWith('/profil-sekolah') }"
                >
                  Profil Sekolah
                </router-link>
                <router-link
                  to="/tahun-akademik"
                  class="nav-link"
                  :class="{ 'nav-link-active': $route.path.startsWith('/tahun-akademik') }"
                >
                  Tahun Akademik
                </router-link>
                <router-link
                  to="/lisensi"
                  class="nav-link"
                  :class="{ 'nav-link-active': $route.path.startsWith('/lisensi') }"
                >
                  Lisensi
                </router-link>
              </div>
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
              <!-- User Info -->
              <div class="hidden md:flex items-center space-x-2">
                <span class="text-sm text-gray-700">{{ user?.username }}</span>
                <span class="badge badge-primary">{{ user?.role_type }}</span>
              </div>

              <!-- Logout Button -->
              <button
                @click="handleLogout"
                class="btn btn-outline btn-sm"
              >
                Keluar
              </button>
            </div>
          </div>
        </div>
      </nav>

      <!-- Main Content -->
      <main :class="{ 'pt-16': isAuthenticated }">
        <router-view />
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useToast } from 'vue-toastification'

const router = useRouter()
const authStore = useAuthStore()
const toast = useToast()

// Computed properties
const isLoading = computed(() => authStore.isLoading)
const isAuthenticated = computed(() => authStore.isAuthenticated)
const user = computed(() => authStore.user)

// Methods
const handleLogout = async () => {
  try {
    await authStore.logout()
    toast.success('Berhasil keluar')
    router.push('/login')
  } catch (error) {
    toast.error('Gagal keluar')
  }
}

// Lifecycle
onMounted(async () => {
  // Check if user is already authenticated
  if (!authStore.isAuthenticated) {
    const token = localStorage.getItem('auth_token')
    if (token) {
      try {
        await authStore.checkAuth()
      } catch (error) {
        // Token is invalid, redirect to login
        router.push('/login')
      }
    } else {
      router.push('/login')
    }
  }
})
</script>

<style scoped>
.nav-link {
  @apply inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-colors duration-200;
}

.nav-link-active {
  @apply border-primary-500 text-primary-600;
}
</style>
