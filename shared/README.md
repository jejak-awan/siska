# 🔧 **SHARED COMPONENTS SISKA**

## 📋 **INFORMASI PROYEK**

**SISKA** (Sistem Informasi Sekolah Bidang Kesiswaan)  
**Pengembang**: [jejakawan.com](https://jejakawan.com)  
**GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)  
**Supported by**: **K2NET** - PT. Kirana Karina Network  
*"Provide Different IT Solutions"*

## 🎯 **OVERVIEW**

Shared Components adalah komponen yang dapat digunakan bersama oleh semua modul dalam sistem SISKA. Komponen ini mencakup utilities, styles, assets, dan komponen UI yang dapat di-reuse di seluruh aplikasi.

## 🏗️ **STRUKTUR SHARED COMPONENTS**

```
shared/
├── components/                 # Shared UI components
│   ├── Layout/
│   │   ├── Header.vue
│   │   ├── Sidebar.vue
│   │   ├── Footer.vue
│   │   └── Navigation.vue
│   ├── Forms/
│   │   ├── InputField.vue
│   │   ├── SelectField.vue
│   │   ├── TextAreaField.vue
│   │   ├── DatePicker.vue
│   │   └── FileUpload.vue
│   ├── Tables/
│   │   ├── DataTable.vue
│   │   ├── Pagination.vue
│   │   └── TableActions.vue
│   ├── Modals/
│   │   ├── ConfirmModal.vue
│   │   ├── FormModal.vue
│   │   └── ImageModal.vue
│   ├── Cards/
│   │   ├── StatCard.vue
│   │   ├── InfoCard.vue
│   │   └── ActionCard.vue
│   └── Charts/
│       ├── LineChart.vue
│       ├── BarChart.vue
│       └── PieChart.vue
├── utilities/                  # Utility functions
│   ├── helpers.js
│   ├── validators.js
│   ├── formatters.js
│   ├── constants.js
│   └── api.js
├── styles/                     # Shared styles
│   ├── main.css
│   ├── components.css
│   ├── utilities.css
│   └── themes/
│       ├── light.css
│       └── dark.css
└── assets/                     # Shared assets
    ├── images/
    ├── icons/
    └── fonts/
```

## 🧩 **SHARED COMPONENTS**

### **1. Layout Components**

#### **Header Component**
```vue
<!-- components/Layout/Header.vue -->
<template>
  <header class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center">
          <img class="h-8 w-auto" src="/logo.png" alt="SISKA" />
          <h1 class="ml-3 text-xl font-semibold text-gray-900">SISKA</h1>
        </div>
        
        <div class="flex items-center space-x-4">
          <NotificationBell />
          <UserMenu />
        </div>
      </div>
    </div>
  </header>
</template>
```

#### **Sidebar Component**
```vue
<!-- components/Layout/Sidebar.vue -->
<template>
  <aside class="w-64 bg-gray-900 text-white min-h-screen">
    <nav class="mt-8">
      <div class="px-4 space-y-2">
        <SidebarItem 
          v-for="item in menuItems" 
          :key="item.name"
          :item="item"
        />
      </div>
    </nav>
  </aside>
</template>
```

### **2. Form Components**

#### **Input Field Component**
```vue
<!-- components/Forms/InputField.vue -->
<template>
  <div class="form-group">
    <label v-if="label" :for="id" class="block text-sm font-medium text-gray-700">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>
    
    <input
      :id="id"
      :type="type"
      :value="modelValue"
      :placeholder="placeholder"
      :required="required"
      :disabled="disabled"
      :class="inputClasses"
      @input="$emit('update:modelValue', $event.target.value)"
      @blur="$emit('blur')"
      @focus="$emit('focus')"
    />
    
    <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
    <p v-if="help" class="mt-1 text-sm text-gray-500">{{ help }}</p>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: [String, Number],
  type: { type: String, default: 'text' },
  label: String,
  placeholder: String,
  required: Boolean,
  disabled: Boolean,
  error: String,
  help: String,
  id: String,
})

const emit = defineEmits(['update:modelValue', 'blur', 'focus'])

const inputClasses = computed(() => {
  const baseClasses = 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm'
  const errorClasses = props.error ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : ''
  const disabledClasses = props.disabled ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : ''
  
  return `${baseClasses} ${errorClasses} ${disabledClasses}`
})
</script>
```

### **3. Table Components**

#### **Data Table Component**
```vue
<!-- components/Tables/DataTable.vue -->
<template>
  <div class="data-table">
    <div class="table-header">
      <div class="flex justify-between items-center">
        <h3 class="text-lg font-medium">{{ title }}</h3>
        <div class="flex space-x-2">
          <SearchInput v-model="searchQuery" />
          <button @click="$emit('add')" class="btn-primary">
            Tambah Data
          </button>
        </div>
      </div>
    </div>
    
    <div class="table-container">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th v-for="column in columns" :key="column.key" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              {{ column.label }}
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Aksi
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="item in paginatedData" :key="item.id">
            <td v-for="column in columns" :key="column.key" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              <slot :name="column.key" :item="item">
                {{ item[column.key] }}
              </slot>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <TableActions 
                :item="item"
                @edit="$emit('edit', item)"
                @delete="$emit('delete', item)"
                @view="$emit('view', item)"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <Pagination 
      :current-page="currentPage"
      :total-pages="totalPages"
      :total-items="totalItems"
      @page-change="handlePageChange"
    />
  </div>
</template>
```

### **4. Modal Components**

#### **Confirm Modal Component**
```vue
<!-- components/Modals/ConfirmModal.vue -->
<template>
  <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity" @click="$emit('close')">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
      </div>
      
      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
              <ExclamationTriangleIcon class="h-6 w-6 text-red-600" />
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ title }}
              </h3>
              <div class="mt-2">
                <p class="text-sm text-gray-500">
                  {{ message }}
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button @click="$emit('confirm')" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
            {{ confirmText }}
          </button>
          <button @click="$emit('close')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            {{ cancelText }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
```

## 🛠️ **UTILITY FUNCTIONS**

### **Helpers**
```javascript
// utilities/helpers.js
export const formatDate = (date, format = 'DD/MM/YYYY') => {
  if (!date) return ''
  
  const d = new Date(date)
  const day = String(d.getDate()).padStart(2, '0')
  const month = String(d.getMonth() + 1).padStart(2, '0')
  const year = d.getFullYear()
  
  return format
    .replace('DD', day)
    .replace('MM', month)
    .replace('YYYY', year)
}

export const formatCurrency = (amount) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR'
  }).format(amount)
}

export const formatNumber = (number) => {
  return new Intl.NumberFormat('id-ID').format(number)
}

export const truncateText = (text, length = 100) => {
  if (!text) return ''
  return text.length > length ? text.substring(0, length) + '...' : text
}

export const generateId = () => {
  return Math.random().toString(36).substr(2, 9)
}

export const debounce = (func, wait) => {
  let timeout
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout)
      func(...args)
    }
    clearTimeout(timeout)
    timeout = setTimeout(later, wait)
  }
}
```

### **Validators**
```javascript
// utilities/validators.js
export const required = (value) => {
  return value !== null && value !== undefined && value !== ''
}

export const email = (value) => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return emailRegex.test(value)
}

export const phone = (value) => {
  const phoneRegex = /^(\+62|62|0)[0-9]{9,13}$/
  return phoneRegex.test(value)
}

export const minLength = (value, min) => {
  return value && value.length >= min
}

export const maxLength = (value, max) => {
  return value && value.length <= max
}

export const numeric = (value) => {
  return !isNaN(value) && !isNaN(parseFloat(value))
}

export const positive = (value) => {
  return numeric(value) && parseFloat(value) > 0
}

export const validateForm = (data, rules) => {
  const errors = {}
  
  Object.keys(rules).forEach(field => {
    const fieldRules = rules[field]
    const value = data[field]
    
    fieldRules.forEach(rule => {
      if (!rule.validator(value)) {
        errors[field] = rule.message
      }
    })
  })
  
  return {
    isValid: Object.keys(errors).length === 0,
    errors
  }
}
```

### **Formatters**
```javascript
// utilities/formatters.js
export const formatPhoneNumber = (phone) => {
  if (!phone) return ''
  
  // Remove all non-numeric characters
  const cleaned = phone.replace(/\D/g, '')
  
  // Format Indonesian phone number
  if (cleaned.startsWith('62')) {
    return `+${cleaned}`
  } else if (cleaned.startsWith('0')) {
    return `+62${cleaned.substring(1)}`
  }
  
  return cleaned
}

export const formatNIS = (nis) => {
  if (!nis) return ''
  return nis.toString().padStart(8, '0')
}

export const formatNISN = (nisn) => {
  if (!nisn) return ''
  return nisn.toString().padStart(10, '0')
}

export const formatPercentage = (value, decimals = 2) => {
  if (value === null || value === undefined) return '0%'
  return `${parseFloat(value).toFixed(decimals)}%`
}

export const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes'
  
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}
```

## 🎨 **SHARED STYLES**

### **Main Styles**
```css
/* styles/main.css */
@import 'tailwindcss/base';
@import 'tailwindcss/components';
@import 'tailwindcss/utilities';

/* Custom CSS Variables */
:root {
  --primary-color: #3b82f6;
  --secondary-color: #22c55e;
  --accent-color: #f59e0b;
  --danger-color: #ef4444;
  --warning-color: #f59e0b;
  --success-color: #22c55e;
  --info-color: #06b6d4;
  
  --text-primary: #111827;
  --text-secondary: #6b7280;
  --text-muted: #9ca3af;
  
  --bg-primary: #ffffff;
  --bg-secondary: #f9fafb;
  --bg-muted: #f3f4f6;
  
  --border-color: #e5e7eb;
  --border-light: #f3f4f6;
  
  --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
  --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
  --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
}

/* Base Styles */
body {
  font-family: 'Inter', sans-serif;
  color: var(--text-primary);
  background-color: var(--bg-secondary);
}

/* Component Styles */
.btn {
  @apply inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2;
}

.btn-primary {
  @apply btn bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500;
}

.btn-secondary {
  @apply btn bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500;
}

.btn-success {
  @apply btn bg-green-600 text-white hover:bg-green-700 focus:ring-green-500;
}

.btn-danger {
  @apply btn bg-red-600 text-white hover:bg-red-700 focus:ring-red-500;
}

.btn-warning {
  @apply btn bg-yellow-600 text-white hover:bg-yellow-700 focus:ring-yellow-500;
}

/* Form Styles */
.form-group {
  @apply mb-4;
}

.form-label {
  @apply block text-sm font-medium text-gray-700 mb-1;
}

.form-input {
  @apply block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm;
}

.form-input-error {
  @apply border-red-300 focus:ring-red-500 focus:border-red-500;
}

.form-error {
  @apply mt-1 text-sm text-red-600;
}

.form-help {
  @apply mt-1 text-sm text-gray-500;
}

/* Table Styles */
.table {
  @apply min-w-full divide-y divide-gray-200;
}

.table-header {
  @apply bg-gray-50;
}

.table-header-cell {
  @apply px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider;
}

.table-body {
  @apply bg-white divide-y divide-gray-200;
}

.table-cell {
  @apply px-6 py-4 whitespace-nowrap text-sm text-gray-900;
}

/* Card Styles */
.card {
  @apply bg-white overflow-hidden shadow rounded-lg;
}

.card-header {
  @apply px-4 py-5 sm:px-6 border-b border-gray-200;
}

.card-body {
  @apply px-4 py-5 sm:p-6;
}

.card-footer {
  @apply px-4 py-4 sm:px-6 border-t border-gray-200;
}

/* Modal Styles */
.modal-overlay {
  @apply fixed inset-0 z-50 overflow-y-auto;
}

.modal-container {
  @apply flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0;
}

.modal-backdrop {
  @apply fixed inset-0 transition-opacity;
}

.modal-content {
  @apply inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full;
}
```

## 📞 **SUPPORT**

- **GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)
- **Website**: [jejakawan.com](https://jejakawan.com)
- **Company**: K2NET - PT. Kirana Karina Network

---

**SISKA Shared Components** - Komponen yang dapat digunakan bersama untuk efisiensi development! 🔧✨
