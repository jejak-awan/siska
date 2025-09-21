# 🧙‍♂️ **STRATEGI WIZARD INSTALLASI ISOLATED JENJANG**

## 📋 **INFORMASI PROYEK**

**SISKA** (Sistem Informasi Sekolah Bidang Kesiswaan)  
**Pengembang**: [jejakawan.com](https://jejakawan.com)  
**GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)  
**Supported by**: **K2NET** - PT. Kirana Karina Network  
*"Provide Different IT Solutions"*

## 🎯 **ANALISIS KONTRADIKSI DENGAN DOKUMENTASI SEBELUMNYA**

### **❌ KONTRADIKSI YANG DITEMUKAN:**

1. **Dokumentasi Sebelumnya**: Shared database dengan kolom `jenjang`
2. **Wizard Strategy**: Isolated installation per jenjang
3. **Dokumentasi Sebelumnya**: Conditional loading berdasarkan konfigurasi
4. **Wizard Strategy**: Separate installation tanpa dependensi

### **✅ SOLUSI: ISOLATED JENJANG ARCHITECTURE**

---

## 🏗️ **ARSITEKTUR ISOLATED JENJANG**

### **A. PRINSIP DASAR:**
1. **Complete Isolation**: Setiap jenjang adalah aplikasi terpisah
2. **Shared Core Only**: Hanya core system yang shared
3. **Independent Database**: Database terpisah per jenjang
4. **Modular Installation**: Install hanya yang diperlukan
5. **License-Based**: Upgrade berdasarkan lisensi

### **B. STRUKTUR APLIKASI ISOLATED:**
```
kesiswaan/
├── core/                          # Shared core system
│   ├── app/
│   │   ├── Http/Controllers/Core/
│   │   ├── Models/Core/
│   │   ├── Services/Core/
│   │   └── Middleware/Core/
│   ├── database/migrations/core/
│   └── config/core.php
├── jenjang/                       # Isolated jenjang modules
│   ├── sd/                        # SD Module (Complete)
│   │   ├── app/
│   │   │   ├── Http/Controllers/
│   │   │   ├── Models/
│   │   │   ├── Services/
│   │   │   └── Resources/
│   │   ├── database/
│   │   │   ├── migrations/
│   │   │   └── seeders/
│   │   ├── routes/
│   │   └── config/
│   ├── smp/                       # SMP Module (Complete)
│   ├── sma/                       # SMA Module (Complete)
│   └── smk/                       # SMK Module (Complete)
├── installer/                     # Installation wizard
│   ├── app/
│   ├── resources/views/
│   └── routes/
└── shared/                        # Shared resources
    ├── assets/
    ├── translations/
    └── templates/
```

---

## 🧙‍♂️ **WIZARD INSTALLASI BEST PRACTICE**

### **A. FLOW WIZARD YANG DIREVISI:**

#### **Step 1: License & sekolah Information**
```vue
<template>
    <div class="wizard-step">
        <h2>📋 Informasi Lisensi & Sekolah</h2>
        
        <!-- License Information -->
        <div class="license-section">
            <h3>Lisensi Aplikasi</h3>
            <div class="license-options">
                <label class="license-option">
                    <input type="radio" v-model="license.type" value="single">
                    <div class="license-card">
                        <h4>Single Jenjang</h4>
                        <p>Untuk sekolah dengan 1 jenjang pendidikan</p>
                        <span class="price">Rp 2.500.000/tahun</span>
                    </div>
                </label>
                
                <label class="license-option">
                    <input type="radio" v-model="license.type" value="multi">
                    <div class="license-card">
                        <h4>Multi Jenjang</h4>
                        <p>Untuk sekolah dengan 2+ jenjang pendidikan</p>
                        <span class="price">Rp 5.000.000/tahun</span>
                    </div>
                </label>
            </div>
        </div>
        
        <!-- sekolah Information -->
        <div class="sekolah-section">
            <h3>Informasi Sekolah</h3>
            <form @submit.prevent="validatesekolahInfo">
                <div class="form-group">
                    <label>Nama Sekolah *</label>
                    <input 
                        type="text" 
                        v-model="sekolah.nama_sekolah"
                        :class="{ 'error': errors.nama_sekolah }"
                        required
                    >
                    <span v-if="errors.nama_sekolah" class="error-message">
                        {{ errors.nama_sekolah }}
                    </span>
                </div>
                
                <div class="form-group">
                    <label>Jenis Sekolah *</label>
                    <select v-model="sekolah.jenis_sekolah" required>
                        <option value="">Pilih Jenis Sekolah</option>
                        <option value="negeri">Sekolah Negeri</option>
                        <option value="swasta">Sekolah Swasta</option>
                        <option value="yayasan">Sekolah Yayasan</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Alamat Lengkap *</label>
                    <textarea 
                        v-model="sekolah.alamat"
                        :class="{ 'error': errors.alamat }"
                        required
                    ></textarea>
                    <span v-if="errors.alamat" class="error-message">
                        {{ errors.alamat }}
                    </span>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Telepon *</label>
                        <input 
                            type="tel" 
                            v-model="sekolah.telepon"
                            :class="{ 'error': errors.telepon }"
                            required
                        >
                        <span v-if="errors.telepon" class="error-message">
                            {{ errors.telepon }}
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label>Email *</label>
                        <input 
                            type="email" 
                            v-model="sekolah.email"
                            :class="{ 'error': errors.email }"
                            required
                        >
                        <span v-if="errors.email" class="error-message">
                            {{ errors.email }}
                        </span>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="wizard-actions">
            <button type="button" @click="prevStep" class="btn-secondary">
                Kembali
            </button>
            <button type="button" @click="nextStep" class="btn-primary" :disabled="!isStepValid">
                Lanjut
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { useFormValidation } from '@/composables/useFormValidation'

const emit = defineEmits(['next', 'prev', 'update:modelValue'])
const props = defineProps(['modelValue'])

const { validateField, errors, clearErrors } = useFormValidation()

const license = ref({
    type: '',
    key: '',
    expiry_date: null
})

const sekolah = ref({
    nama_sekolah: '',
    jenis_sekolah: '',
    alamat: '',
    telepon: '',
    email: ''
})

const isStepValid = computed(() => {
    return license.value.type && 
           sekolah.value.nama_sekolah && 
           sekolah.value.jenis_sekolah && 
           sekolah.value.alamat && 
           sekolah.value.telepon && 
           sekolah.value.email &&
           Object.keys(errors.value).length === 0
})

const validatesekolahInfo = async () => {
    clearErrors()
    
    // Validate nama sekolah
    if (!sekolah.value.nama_sekolah.trim()) {
        errors.value.nama_sekolah = 'Nama sekolah wajib diisi'
    } else if (sekolah.value.nama_sekolah.length < 3) {
        errors.value.nama_sekolah = 'Nama sekolah minimal 3 karakter'
    }
    
    // Validate alamat
    if (!sekolah.value.alamat.trim()) {
        errors.value.alamat = 'Alamat wajib diisi'
    } else if (sekolah.value.alamat.length < 10) {
        errors.value.alamat = 'Alamat minimal 10 karakter'
    }
    
    // Validate telepon
    if (!sekolah.value.telepon.trim()) {
        errors.value.telepon = 'Telepon wajib diisi'
    } else if (!/^[0-9+\-\s()]+$/.test(sekolah.value.telepon)) {
        errors.value.telepon = 'Format telepon tidak valid'
    }
    
    // Validate email
    if (!sekolah.value.email.trim()) {
        errors.value.email = 'Email wajib diisi'
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(sekolah.value.email)) {
        errors.value.email = 'Format email tidak valid'
    }
}

const nextStep = () => {
    if (isStepValid.value) {
        emit('update:modelValue', {
            license: license.value,
            sekolah: sekolah.value
        })
        emit('next')
    }
}

const prevStep = () => {
    emit('prev')
}

// Watch for changes to validate in real-time
watch([sekolah, license], () => {
    validatesekolahInfo()
}, { deep: true })
</script>
```

#### **Step 2: Jenjang Selection (Based on License)**
```vue
<template>
    <div class="wizard-step">
        <h2>📚 Pilihan Jenjang Pendidikan</h2>
        
        <div class="license-info">
            <p>Lisensi: <strong>{{ licenseType }}</strong></p>
            <p v-if="licenseType === 'single'">
                Pilih <strong>satu jenjang</strong> yang akan digunakan
            </p>
            <p v-else>
                Pilih <strong>satu atau lebih jenjang</strong> yang akan digunakan
            </p>
        </div>
        
        <div class="jenjang-selection">
            <div 
                v-for="jenjang in availableJenjang" 
                :key="jenjang.value"
                class="jenjang-option"
                :class="{ 
                    'selected': selectedJenjang.includes(jenjang.value),
                    'disabled': licenseType === 'single' && selectedJenjang.length > 0 && !selectedJenjang.includes(jenjang.value)
                }"
                @click="toggleJenjang(jenjang.value)"
            >
                <div class="jenjang-icon">
                    {{ jenjang.icon }}
                </div>
                <div class="jenjang-info">
                    <h3>{{ jenjang.label }}</h3>
                    <p>{{ jenjang.description }}</p>
                    <ul class="jenjang-features">
                        <li v-for="feature in jenjang.features" :key="feature">
                            {{ feature }}
                        </li>
                    </ul>
                </div>
                <div class="jenjang-checkbox">
                    <input 
                        type="checkbox" 
                        :checked="selectedJenjang.includes(jenjang.value)"
                        :disabled="licenseType === 'single' && selectedJenjang.length > 0 && !selectedJenjang.includes(jenjang.value)"
                    >
                </div>
            </div>
        </div>
        
        <div v-if="selectedJenjang.length > 0" class="selected-summary">
            <h3>Jenjang yang Dipilih:</h3>
            <div class="selected-list">
                <span 
                    v-for="jenjang in selectedJenjang" 
                    :key="jenjang"
                    class="selected-item"
                >
                    {{ getJenjangLabel(jenjang) }}
                    <button @click="removeJenjang(jenjang)" class="remove-btn">×</button>
                </span>
            </div>
        </div>
        
        <div class="wizard-actions">
            <button type="button" @click="prevStep" class="btn-secondary">
                Kembali
            </button>
            <button 
                type="button" 
                @click="nextStep" 
                class="btn-primary" 
                :disabled="selectedJenjang.length === 0"
            >
                Lanjut
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const emit = defineEmits(['next', 'prev', 'update:modelValue'])
const props = defineProps(['modelValue'])

const licenseType = computed(() => props.modelValue.license.type)

const availableJenjang = [
    {
        value: 'sd',
        label: 'Sekolah Dasar (SD)',
        icon: '🎒',
        description: 'Jenjang pendidikan dasar untuk kelas 1-6',
        features: [
            'Program karakter dasar',
            'Kebersihan dan kedisiplinan',
            'Penilaian karakter sederhana',
            'Presensi harian'
        ]
    },
    {
        value: 'smp',
        label: 'Sekolah Menengah Pertama (SMP)',
        icon: '📚',
        description: 'Jenjang pendidikan menengah untuk kelas 7-9',
        features: [
            'Program OSIS',
            'Ekstrakurikuler',
            'Kepemimpinan dasar',
            'Penilaian karakter lanjutan'
        ]
    },
    {
        value: 'sma',
        label: 'Sekolah Menengah Atas (SMA)',
        icon: '🎓',
        description: 'Jenjang pendidikan menengah atas untuk kelas X-XII',
        features: [
            'Organisasi siswa',
            'Persiapan kuliah',
            'Kepemimpinan lanjutan',
            'Penilaian karakter komprehensif'
        ]
    },
    {
        value: 'smk',
        label: 'Sekolah Menengah Kejuruan (SMK)',
        icon: '🔧',
        description: 'Jenjang pendidikan kejuruan untuk kelas X-XII',
        features: [
            'Program kejuruan',
            'Magang industri',
            'Sertifikasi kompetensi',
            'Penilaian karakter kejuruan'
        ]
    }
]

const selectedJenjang = ref([])

const toggleJenjang = (jenjang) => {
    if (licenseType.value === 'single') {
        // Single license: hanya bisa pilih satu
        selectedJenjang.value = [jenjang]
    } else {
        // Multi license: bisa pilih multiple
        const index = selectedJenjang.value.indexOf(jenjang)
        if (index > -1) {
            selectedJenjang.value.splice(index, 1)
        } else {
            selectedJenjang.value.push(jenjang)
        }
    }
}

const removeJenjang = (jenjang) => {
    const index = selectedJenjang.value.indexOf(jenjang)
    if (index > -1) {
        selectedJenjang.value.splice(index, 1)
    }
}

const getJenjangLabel = (jenjang) => {
    const found = availableJenjang.find(j => j.value === jenjang)
    return found ? found.label : jenjang
}

const nextStep = () => {
    if (selectedJenjang.value.length > 0) {
        emit('update:modelValue', {
            ...props.modelValue,
            jenjang: selectedJenjang.value
        })
        emit('next')
    }
}

const prevStep = () => {
    emit('prev')
}
</script>
```

### **B. VALIDASI & ERROR HANDLING BEST PRACTICE:**

#### **Composable untuk Form Validation:**
```javascript
// composables/useFormValidation.js
import { ref, reactive } from 'vue'

export function useFormValidation() {
    const errors = ref({})
    const isValidating = ref(false)
    
    const validateField = async (field, value, rules) => {
        isValidating.value = true
        
        try {
            for (const rule of rules) {
                const result = await rule(value)
                if (result !== true) {
                    errors.value[field] = result
                    return false
                }
            }
            
            // Clear error if validation passes
            delete errors.value[field]
            return true
        } catch (error) {
            errors.value[field] = 'Terjadi kesalahan saat validasi'
            return false
        } finally {
            isValidating.value = false
        }
    }
    
    const validateForm = async (formData, validationRules) => {
        clearErrors()
        isValidating.value = true
        
        try {
            const promises = Object.keys(validationRules).map(async (field) => {
                const value = formData[field]
                const rules = validationRules[field]
                return await validateField(field, value, rules)
            })
            
            const results = await Promise.all(promises)
            return results.every(result => result === true)
        } catch (error) {
            console.error('Form validation error:', error)
            return false
        } finally {
            isValidating.value = false
        }
    }
    
    const clearErrors = () => {
        errors.value = {}
    }
    
    const clearFieldError = (field) => {
        delete errors.value[field]
    }
    
    return {
        errors,
        isValidating,
        validateField,
        validateForm,
        clearErrors,
        clearFieldError
    }
}

// Validation rules
export const validationRules = {
    required: (value) => {
        if (!value || (typeof value === 'string' && !value.trim())) {
            return 'Field ini wajib diisi'
        }
        return true
    },
    
    email: (value) => {
        if (!value) return true // Allow empty if not required
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        if (!emailRegex.test(value)) {
            return 'Format email tidak valid'
        }
        return true
    },
    
    phone: (value) => {
        if (!value) return true
        const phoneRegex = /^[0-9+\-\s()]+$/
        if (!phoneRegex.test(value)) {
            return 'Format telepon tidak valid'
        }
        return true
    },
    
    minLength: (min) => (value) => {
        if (!value) return true
        if (value.length < min) {
            return `Minimal ${min} karakter`
        }
        return true
    },
    
    maxLength: (max) => (value) => {
        if (!value) return true
        if (value.length > max) {
            return `Maksimal ${max} karakter`
        }
        return true
    }
}
```

#### **Error Handling Service:**
```javascript
// services/ErrorHandlingService.js
class ErrorHandlingService {
    static handleInstallationError(error) {
        const errorMap = {
            'database_connection_failed': {
                title: 'Koneksi Database Gagal',
                message: 'Tidak dapat terhubung ke database. Periksa konfigurasi database Anda.',
                type: 'error',
                actions: [
                    { label: 'Periksa Konfigurasi', action: 'check_database_config' },
                    { label: 'Coba Lagi', action: 'retry' }
                ]
            },
            'database_creation_failed': {
                title: 'Pembuatan Database Gagal',
                message: 'Tidak dapat membuat database. Pastikan user memiliki permission yang cukup.',
                type: 'error',
                actions: [
                    { label: 'Periksa Permission', action: 'check_permissions' },
                    { label: 'Gunakan Database Existing', action: 'use_existing_db' }
                ]
            },
            'migration_failed': {
                title: 'Migrasi Database Gagal',
                message: 'Terjadi kesalahan saat menjalankan migrasi database.',
                type: 'error',
                actions: [
                    { label: 'Lihat Log Error', action: 'show_logs' },
                    { label: 'Rollback', action: 'rollback' }
                ]
            },
            'license_validation_failed': {
                title: 'Validasi Lisensi Gagal',
                message: 'Lisensi tidak valid atau sudah expired.',
                type: 'error',
                actions: [
                    { label: 'Periksa Lisensi', action: 'check_license' },
                    { label: 'Hubungi Support', action: 'contact_support' }
                ]
            }
        }
        
        return errorMap[error.code] || {
            title: 'Terjadi Kesalahan',
            message: error.message || 'Terjadi kesalahan yang tidak diketahui.',
            type: 'error',
            actions: [
                { label: 'Coba Lagi', action: 'retry' },
                { label: 'Hubungi Support', action: 'contact_support' }
            ]
        }
    }
    
    static async logError(error, context = {}) {
        try {
            await fetch('/api/installer/log-error', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    error: {
                        message: error.message,
                        stack: error.stack,
                        code: error.code
                    },
                    context,
                    timestamp: new Date().toISOString()
                })
            })
        } catch (logError) {
            console.error('Failed to log error:', logError)
        }
    }
}

export default ErrorHandlingService
```

---

## 🔄 **FITUR UPGRADE SINGLE KE MULTI JENJANG**

### **A. License Management System:**
```php
// app/Services/LicenseService.php
class LicenseService
{
    public function validateLicense($licenseKey, $requestedFeatures = [])
    {
        $license = $this->getLicenseInfo($licenseKey);
        
        if (!$license) {
            throw new LicenseException('License key tidak valid');
        }
        
        if ($license['expiry_date'] < now()) {
            throw new LicenseException('License sudah expired');
        }
        
        if (!$this->checkFeatureAccess($license, $requestedFeatures)) {
            throw new LicenseException('License tidak memiliki akses ke fitur yang diminta');
        }
        
        return $license;
    }
    
    public function upgradeLicense($currentLicenseKey, $newLicenseType)
    {
        $currentLicense = $this->getLicenseInfo($currentLicenseKey);
        $newLicense = $this->createUpgradeLicense($currentLicense, $newLicenseType);
        
        // Update license in database
        $this->updateLicense($currentLicenseKey, $newLicense);
        
        // Enable new features
        $this->enableNewFeatures($newLicense);
        
        return $newLicense;
    }
    
    private function checkFeatureAccess($license, $requestedFeatures)
    {
        $allowedFeatures = $license['features'] ?? [];
        
        foreach ($requestedFeatures as $feature) {
            if (!in_array($feature, $allowedFeatures)) {
                return false;
            }
        }
        
        return true;
    }
}
```

### **B. Upgrade Wizard:**
```vue
<!-- components/upgrade/UpgradeWizard.vue -->
<template>
    <div class="upgrade-wizard">
        <div class="upgrade-header">
            <h1>🚀 Upgrade Lisensi SISKA</h1>
            <p>Upgrade dari Single Jenjang ke Multi Jenjang</p>
        </div>
        
        <div class="current-license">
            <h3>Lisensi Saat Ini</h3>
            <div class="license-card current">
                <h4>Single Jenjang</h4>
                <p>Jenjang: {{ currentJenjang }}</p>
                <p>Expiry: {{ currentExpiry }}</p>
            </div>
        </div>
        
        <div class="upgrade-options">
            <h3>Pilihan Upgrade</h3>
            <div class="upgrade-option" @click="selectUpgrade('multi')">
                <div class="upgrade-card">
                    <h4>Multi Jenjang</h4>
                    <p>Dapat menggunakan semua jenjang pendidikan</p>
                    <span class="price">Rp 2.500.000/tahun</span>
                    <div class="features">
                        <ul>
                            <li>✅ Semua jenjang (SD, SMP, SMA, SMK)</li>
                            <li>✅ Fitur lengkap per jenjang</li>
                            <li>✅ Support prioritas</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="upgrade-process" v-if="isUpgrading">
            <h3>Proses Upgrade</h3>
            <div class="progress-steps">
                <div 
                    v-for="(step, index) in upgradeSteps" 
                    :key="index"
                    class="step"
                    :class="{ 
                        'active': currentStep === index,
                        'completed': currentStep > index,
                        'error': step.error
                    }"
                >
                    <div class="step-icon">
                        <span v-if="step.error">❌</span>
                        <span v-else-if="currentStep > index">✅</span>
                        <span v-else>{{ index + 1 }}</span>
                    </div>
                    <div class="step-content">
                        <h4>{{ step.title }}</h4>
                        <p>{{ step.description }}</p>
                        <div v-if="step.error" class="error-message">
                            {{ step.error }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="upgrade-actions">
            <button 
                v-if="!isUpgrading" 
                @click="startUpgrade" 
                class="btn-primary"
                :disabled="!selectedUpgrade"
            >
                Mulai Upgrade
            </button>
            <button 
                v-if="isUpgrading" 
                @click="cancelUpgrade" 
                class="btn-secondary"
            >
                Batalkan
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useUpgradeService } from '@/services/useUpgradeService'

const { 
    currentLicense, 
    upgradeLicense, 
    upgradeProgress,
    isUpgrading,
    error 
} = useUpgradeService()

const selectedUpgrade = ref('')
const currentStep = ref(0)
const upgradeSteps = ref([
    {
        title: 'Validasi Lisensi',
        description: 'Memvalidasi lisensi baru...',
        error: null
    },
    {
        title: 'Backup Data',
        description: 'Membuat backup data saat ini...',
        error: null
    },
    {
        title: 'Install Modul Baru',
        description: 'Menginstall modul jenjang tambahan...',
        error: null
    },
    {
        title: 'Konfigurasi Sistem',
        description: 'Mengkonfigurasi sistem untuk multi jenjang...',
        error: null
    },
    {
        title: 'Testing',
        description: 'Melakukan testing sistem...',
        error: null
    },
    {
        title: 'Selesai',
        description: 'Upgrade berhasil diselesaikan!',
        error: null
    }
])

const startUpgrade = async () => {
    isUpgrading.value = true
    currentStep.value = 0
    
    try {
        for (let i = 0; i < upgradeSteps.value.length; i++) {
            currentStep.value = i
            upgradeSteps.value[i].error = null
            
            await executeUpgradeStep(i)
            
            // Simulate step completion
            await new Promise(resolve => setTimeout(resolve, 1000))
        }
        
        // Upgrade completed
        await upgradeLicense(selectedUpgrade.value)
        
    } catch (error) {
        upgradeSteps.value[currentStep.value].error = error.message
        console.error('Upgrade failed:', error)
    } finally {
        isUpgrading.value = false
    }
}

const executeUpgradeStep = async (stepIndex) => {
    switch (stepIndex) {
        case 0:
            // Validate license
            break
        case 1:
            // Backup data
            break
        case 2:
            // Install new modules
            break
        case 3:
            // Configure system
            break
        case 4:
            // Testing
            break
        case 5:
            // Complete
            break
    }
}

const cancelUpgrade = () => {
    isUpgrading.value = false
    currentStep.value = 0
    upgradeSteps.value.forEach(step => {
        step.error = null
    })
}

onMounted(() => {
    // Load current license info
})
</script>
```

---

## 🎯 **KEUNTUNGAN STRATEGI ISOLATED:**

1. **Complete Isolation**: Tidak ada konflik antar jenjang
2. **License-Based**: Upgrade berdasarkan lisensi
3. **Modular Installation**: Install hanya yang diperlukan
4. **Easy Maintenance**: Maintenance per jenjang terpisah
5. **Scalable**: Mudah menambah jenjang baru
6. **Secure**: Isolasi data per jenjang

---

## 🚀 **IMPLEMENTASI BERKELANJUTAN:**

1. **Phase 1**: Redesign arsitektur isolated
2. **Phase 2**: Implementasi wizard installasi
3. **Phase 3**: Buat license management system
4. **Phase 4**: Implementasi upgrade wizard
5. **Phase 5**: Testing dan deployment
