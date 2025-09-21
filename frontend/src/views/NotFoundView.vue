<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center">
      <div class="mb-8">
        <h1 class="text-9xl font-bold text-primary-600">404</h1>
        <h2 class="text-2xl font-bold text-gray-900 mt-4">Halaman Tidak Ditemukan</h2>
        <p class="text-gray-600 mt-2">Maaf, halaman yang Anda cari tidak ditemukan.</p>
      </div>
      
      <div class="space-y-4">
        <router-link
          to="/dashboard"
          class="btn btn-primary"
        >
          Kembali ke Dashboard
        </router-link>
        
        <div class="text-sm text-gray-500">
          <p>Jika Anda yakin ini adalah kesalahan, silakan hubungi administrator.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
// NotFoundView component
</script>
