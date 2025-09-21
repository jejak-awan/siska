# 🎨 **FRONTEND SISKA**

## 📋 **INFORMASI PROYEK**

**SISKA** (Sistem Informasi Sekolah Bidang Kesiswaan)  
**Pengembang**: [jejakawan.com](https://jejakawan.com)  
**GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)  
**Supported by**: **K2NET** - PT. Kirana Karina Network  
*"Provide Different IT Solutions"*

## 🎯 **OVERVIEW**

Frontend SISKA dibangun dengan Vue.js 3 dan TypeScript, menggunakan Composition API untuk pengalaman development yang modern. Frontend ini mendukung semua modul (Core, Jenjang, Public, Installer) dengan arsitektur yang modular dan responsif.

## 🏗️ **STRUKTUR FRONTEND**

```
frontend/
├── src/
│   ├── components/
│   │   ├── core/              # Core components
│   │   │   ├── LicenseManager.vue
│   │   │   ├── SchoolProfile.vue
│   │   │   └── YearAcademic.vue
│   │   ├── jenjang/           # Jenjang components
│   │   │   ├── sd/            # SD components
│   │   │   ├── smp/           # SMP components
│   │   │   ├── sma/           # SMA components
│   │   │   └── smk/           # SMK components
│   │   ├── public/            # Public components
│   │   │   ├── NewsList.vue
│   │   │   ├── ProgramList.vue
│   │   │   └── GalleryView.vue
│   │   ├── installer/         # Installer components
│   │   │   ├── WizardStep.vue
│   │   │   ├── SchoolInfo.vue
│   │   │   └── JenjangSelection.vue
│   │   └── shared/            # Shared components
│   │       ├── Layout/
│   │       ├── Forms/
│   │       ├── Tables/
│   │       └── Modals/
│   ├── views/
│   │   ├── core/              # Core views
│   │   ├── jenjang/           # Jenjang views
│   │   ├── public/            # Public views
│   │   └── installer/         # Installer views
│   ├── stores/
│   │   ├── core/              # Core stores
│   │   ├── jenjang/           # Jenjang stores
│   │   ├── public/            # Public stores
│   │   └── installer/         # Installer stores
│   ├── services/
│   │   ├── api/               # API services
│   │   ├── auth/              # Auth services
│   │   └── utils/             # Utility services
│   ├── utils/
│   │   ├── helpers.ts         # Helper functions
│   │   ├── constants.ts       # Constants
│   │   └── validators.ts      # Validation functions
│   ├── assets/
│   │   ├── images/            # Images
│   │   ├── icons/             # Icons
│   │   └── fonts/             # Fonts
│   ├── styles/
│   │   ├── main.css           # Main styles
│   │   ├── components.css     # Component styles
│   │   └── utilities.css      # Utility styles
│   ├── App.vue                # Root component
│   ├── main.ts                # Entry point
│   └── router.ts              # Router configuration
├── public/
│   ├── index.html
│   ├── favicon.ico
│   └── manifest.json
├── package.json
├── vite.config.ts
├── tailwind.config.js
├── tsconfig.json
└── README.md
```

## 🚀 **TECHNOLOGY STACK**

### **Core Framework**
- **Vue.js 3.3.8** - Progressive JavaScript framework
- **TypeScript** - Type-safe JavaScript
- **Vite** - Fast build tool and dev server

### **UI Framework**
- **Tailwind CSS** - Utility-first CSS framework
- **Headless UI** - Unstyled, accessible UI components
- **Heroicons** - Beautiful hand-crafted SVG icons
- **Lucide Vue** - Beautiful & consistent icon toolkit

### **State Management**
- **Pinia** - Intuitive, type safe, light and flexible Store library

### **HTTP Client**
- **Axios** - Promise-based HTTP client

### **Charts & Visualization**
- **Chart.js** - Simple yet flexible JavaScript charting
- **Vue Chart.js** - Vue.js wrapper for Chart.js

### **Rich Text Editor**
- **CKEditor 5** - Modern rich text editor

### **Notifications**
- **Vue Toastification** - Toast notifications for Vue

## 🎨 **DESIGN SYSTEM**

### **Color Palette**
```css
:root {
  --primary-50: #eff6ff;
  --primary-500: #3b82f6;
  --primary-900: #1e3a8a;
  
  --secondary-50: #f0fdf4;
  --secondary-500: #22c55e;
  --secondary-900: #14532d;
  
  --accent-50: #fef3c7;
  --accent-500: #f59e0b;
  --accent-900: #92400e;
}
```

### **Typography**
```css
.font-heading {
  font-family: 'Inter', sans-serif;
  font-weight: 600;
}

.font-body {
  font-family: 'Inter', sans-serif;
  font-weight: 400;
}
```

### **Spacing Scale**
```css
.space-1 { margin: 0.25rem; }
.space-2 { margin: 0.5rem; }
.space-4 { margin: 1rem; }
.space-8 { margin: 2rem; }
```

## 🧩 **COMPONENT ARCHITECTURE**

### **Core Components**
```vue
<!-- components/core/LicenseManager.vue -->
<template>
  <div class="license-manager">
    <div class="license-header">
      <h2>Manajemen Lisensi</h2>
      <p>Kelola lisensi dan aktivasi sistem</p>
    </div>
    
    <div class="license-content">
      <LicenseForm @submit="handleSubmit" />
      <LicenseList :licenses="licenses" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useLicenseStore } from '@/stores/core/license'

const licenseStore = useLicenseStore()
const licenses = ref([])

onMounted(() => {
  licenseStore.fetchLicenses()
})

const handleSubmit = (data: any) => {
  licenseStore.createLicense(data)
}
</script>
```

### **Jenjang Components**
```vue
<!-- components/jenjang/sd/SiswaList.vue -->
<template>
  <div class="siswa-list">
    <div class="list-header">
      <h3>Daftar Siswa SD</h3>
      <button @click="showAddModal = true" class="btn-primary">
        Tambah Siswa
      </button>
    </div>
    
    <div class="list-content">
      <SiswaTable :siswa="siswaList" @edit="handleEdit" @delete="handleDelete" />
    </div>
    
    <SiswaModal 
      v-if="showAddModal" 
      @close="showAddModal = false"
      @save="handleSave"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useSiswaStore } from '@/stores/jenjang/sd/siswa'

const siswaStore = useSiswaStore()
const siswaList = ref([])
const showAddModal = ref(false)

onMounted(() => {
  siswaStore.fetchSiswa()
})

const handleEdit = (siswa: any) => {
  // Handle edit
}

const handleDelete = (id: number) => {
  // Handle delete
}

const handleSave = (data: any) => {
  siswaStore.createSiswa(data)
  showAddModal.value = false
}
</script>
```

## 🗂️ **STATE MANAGEMENT**

### **Core Store**
```typescript
// stores/core/license.ts
import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { LicenseService } from '@/services/api/license'

export const useLicenseStore = defineStore('license', () => {
  const licenses = ref([])
  const loading = ref(false)
  const error = ref(null)

  const activeLicenses = computed(() => 
    licenses.value.filter(license => license.is_active)
  )

  const fetchLicenses = async () => {
    loading.value = true
    try {
      const response = await LicenseService.getAll()
      licenses.value = response.data
    } catch (err) {
      error.value = err.message
    } finally {
      loading.value = false
    }
  }

  const createLicense = async (data: any) => {
    try {
      const response = await LicenseService.create(data)
      licenses.value.push(response.data)
      return response.data
    } catch (err) {
      error.value = err.message
      throw err
    }
  }

  return {
    licenses,
    loading,
    error,
    activeLicenses,
    fetchLicenses,
    createLicense
  }
})
```

### **Jenjang Store**
```typescript
// stores/jenjang/sd/siswa.ts
import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { SiswaService } from '@/services/api/jenjang/sd/siswa'

export const useSiswaStore = defineStore('siswa', () => {
  const siswa = ref([])
  const loading = ref(false)
  const error = ref(null)

  const activeSiswa = computed(() => 
    siswa.value.filter(s => s.status === 'active')
  )

  const siswaByKelas = computed(() => (kelasId: number) => 
    siswa.value.filter(s => s.kelas_id === kelasId)
  )

  const fetchSiswa = async () => {
    loading.value = true
    try {
      const response = await SiswaService.getAll()
      siswa.value = response.data
    } catch (err) {
      error.value = err.message
    } finally {
      loading.value = false
    }
  }

  const createSiswa = async (data: any) => {
    try {
      const response = await SiswaService.create(data)
      siswa.value.push(response.data)
      return response.data
    } catch (err) {
      error.value = err.message
      throw err
    }
  }

  return {
    siswa,
    loading,
    error,
    activeSiswa,
    siswaByKelas,
    fetchSiswa,
    createSiswa
  }
})
```

## 🔌 **API INTEGRATION**

### **API Service**
```typescript
// services/api/license.ts
import axios from 'axios'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api'

export class LicenseService {
  private static baseURL = `${API_BASE_URL}/core`

  static async getAll() {
    return axios.get(`${this.baseURL}/licenses`)
  }

  static async getById(id: number) {
    return axios.get(`${this.baseURL}/licenses/${id}`)
  }

  static async create(data: any) {
    return axios.post(`${this.baseURL}/licenses`, data)
  }

  static async update(id: number, data: any) {
    return axios.put(`${this.baseURL}/licenses/${id}`, data)
  }

  static async delete(id: number) {
    return axios.delete(`${this.baseURL}/licenses/${id}`)
  }

  static async validate(licenseKey: string) {
    return axios.post(`${this.baseURL}/licenses/validate`, { license_key: licenseKey })
  }

  static async activate(licenseKey: string, installationId: string, schoolData: any) {
    return axios.post(`${this.baseURL}/licenses/activate`, {
      license_key: licenseKey,
      installation_id: installationId,
      school_data: schoolData
    })
  }
}
```

## 🎯 **ROUTING**

### **Router Configuration**
```typescript
// router.ts
import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      redirect: '/dashboard'
    },
    {
      path: '/dashboard',
      name: 'Dashboard',
      component: () => import('@/views/Dashboard.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/core',
      name: 'Core',
      children: [
        {
          path: 'license',
          name: 'License',
          component: () => import('@/views/core/License.vue')
        },
        {
          path: 'school-profile',
          name: 'SchoolProfile',
          component: () => import('@/views/core/SchoolProfile.vue')
        }
      ]
    },
    {
      path: '/jenjang',
      name: 'Jenjang',
      children: [
        {
          path: 'sd',
          name: 'SD',
          children: [
            {
              path: 'siswa',
              name: 'SiswaSD',
              component: () => import('@/views/jenjang/sd/Siswa.vue')
            },
            {
              path: 'presensi',
              name: 'PresensiSD',
              component: () => import('@/views/jenjang/sd/Presensi.vue')
            }
          ]
        }
      ]
    },
    {
      path: '/public',
      name: 'Public',
      children: [
        {
          path: 'news',
          name: 'News',
          component: () => import('@/views/public/News.vue')
        },
        {
          path: 'programs',
          name: 'Programs',
          component: () => import('@/views/public/Programs.vue')
        }
      ]
    },
    {
      path: '/installer',
      name: 'Installer',
      component: () => import('@/views/installer/Wizard.vue'),
      meta: { requiresAuth: false }
    }
  ]
})

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()
  
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next('/login')
  } else {
    next()
  }
})

export default router
```

## 🚀 **DEVELOPMENT**

### **Installation**
```bash
# Install dependencies
npm install

# Start development server
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview

# Run linting
npm run lint

# Run type checking
npm run type-check
```

### **Environment Variables**
```env
# .env.development
VITE_API_BASE_URL=http://localhost:8000/api
VITE_APP_NAME=SISKA
VITE_APP_VERSION=1.0.0

# .env.production
VITE_API_BASE_URL=https://api.siska.com/api
VITE_APP_NAME=SISKA
VITE_APP_VERSION=1.0.0
```

## 📱 **RESPONSIVE DESIGN**

### **Breakpoints**
```css
/* Mobile First */
@media (min-width: 640px) { /* sm */ }
@media (min-width: 768px) { /* md */ }
@media (min-width: 1024px) { /* lg */ }
@media (min-width: 1280px) { /* xl */ }
@media (min-width: 1536px) { /* 2xl */ }
```

### **Mobile Components**
```vue
<!-- components/shared/MobileMenu.vue -->
<template>
  <div class="mobile-menu md:hidden">
    <button @click="toggleMenu" class="menu-toggle">
      <Bars3Icon class="w-6 h-6" />
    </button>
    
    <div v-if="isOpen" class="menu-overlay">
      <nav class="menu-nav">
        <a href="/dashboard" class="menu-link">Dashboard</a>
        <a href="/core" class="menu-link">Core</a>
        <a href="/jenjang" class="menu-link">Jenjang</a>
        <a href="/public" class="menu-link">Public</a>
      </nav>
    </div>
  </div>
</template>
```

## 🧪 **TESTING**

### **Unit Tests**
```typescript
// tests/components/SiswaList.test.ts
import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import SiswaList from '@/components/jenjang/sd/SiswaList.vue'

describe('SiswaList', () => {
  it('renders correctly', () => {
    const wrapper = mount(SiswaList)
    expect(wrapper.find('.siswa-list').exists()).toBe(true)
  })

  it('shows add button', () => {
    const wrapper = mount(SiswaList)
    expect(wrapper.find('.btn-primary').exists()).toBe(true)
  })
})
```

## 📞 **SUPPORT**

- **GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)
- **Website**: [jejakawan.com](https://jejakawan.com)
- **Company**: K2NET - PT. Kirana Karina Network

---

**SISKA Frontend** - Interface yang modern dan responsif untuk sistem kesiswaan! 🎨✨
