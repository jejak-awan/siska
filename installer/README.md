# 🧙‍♂️ **INSTALLER WIZARD SISKA**

## 📋 **INFORMASI PROYEK**

**SISKA** (Sistem Informasi Sekolah Bidang Kesiswaan)  
**Pengembang**: [jejakawan.com](https://jejakawan.com)  
**GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)  
**Supported by**: **K2NET** - PT. Kirana Karina Network  
*"Provide Different IT Solutions"*

## 🎯 **OVERVIEW**

Installer Wizard adalah komponen yang memungkinkan pengguna untuk menginstall SISKA secara dinamis berdasarkan kebutuhan sekolah. Wizard ini akan memandu pengguna melalui proses instalasi yang disesuaikan dengan jenjang pendidikan dan fitur yang dibutuhkan.

## 🏗️ **STRUKTUR INSTALLER**

```
installer/
├── app/
│   ├── Controllers/
│   │   ├── InstallationController.php
│   │   ├── WizardController.php
│   │   └── LicenseController.php
│   ├── Services/
│   │   ├── InstallationService.php
│   │   ├── DatabaseService.php
│   │   └── LicenseService.php
│   └── Models/
│       ├── Installation.php
│       └── License.php
├── config/
│   └── installer.php
├── resources/
│   ├── views/
│   │   ├── wizard/
│   │   │   ├── step1-sekolah-info.blade.php
│   │   │   ├── step2-jenjang-selection.blade.php
│   │   │   ├── step3-module-config.blade.php
│   │   │   ├── step4-database-config.blade.php
│   │   │   └── step5-installation.blade.php
│   │   └── layouts/
│   │       └── installer.blade.php
│   └── assets/
│       ├── css/
│       │   └── installer.css
│       └── js/
│           └── installer.js
└── routes/
    └── web.php
```

## 🎯 **FITUR INSTALLER**

### **1. Wizard Steps**
- **Step 1**: Informasi Sekolah
- **Step 2**: Pilihan Jenjang
- **Step 3**: Konfigurasi Modul
- **Step 4**: Konfigurasi Database
- **Step 5**: Proses Instalasi

### **2. Validasi**
- **License Validation**: Validasi lisensi sebelum instalasi
- **Database Connection**: Test koneksi database
- **System Requirements**: Cek requirement sistem
- **File Permissions**: Cek permission file/folder

### **3. Dynamic Installation**
- **Jenjang Selection**: Install hanya jenjang yang dipilih
- **Module Selection**: Install hanya modul yang dibutuhkan
- **Database Creation**: Buat database sesuai kebutuhan
- **Configuration**: Generate konfigurasi dinamis

## 🚀 **INSTALASI WIZARD**

### **1. Setup Database**
```bash
# Create installer database
mysql -u root -p -e "CREATE DATABASE siska_installer CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### **2. Run Migrations**
```bash
php artisan migrate --database=installer
```

### **3. Access Wizard**
```
http://localhost:8000/installer
```

## 📋 **WIZARD FLOW**

### **Step 1: Informasi Sekolah**
```php
// Data yang dikumpulkan:
[
    'nama_sekolah' => 'required|string|max:255',
    'jenis_sekolah' => 'required|in:negeri,swasta,yayasan',
    'alamat' => 'required|string',
    'telepon' => 'required|string',
    'email' => 'required|email',
    'website' => 'nullable|url',
]
```

### **Step 2: Pilihan Jenjang**
```php
// Jenjang yang tersedia:
[
    'sd' => 'Sekolah Dasar',
    'smp' => 'Sekolah Menengah Pertama',
    'sma' => 'Sekolah Menengah Atas',
    'smk' => 'Sekolah Menengah Kejuruan',
]

// Konfigurasi:
[
    'single_jenjang' => true, // atau false untuk multi jenjang
    'jenjang_aktif' => ['sd'], // array jenjang yang dipilih
]
```

### **Step 3: Konfigurasi Modul**
```php
// Modul yang tersedia:
[
    'presensi' => 'Sistem Presensi',
    'kredit_poin' => 'Sistem Kredit Poin',
    'penilaian_karakter' => 'Penilaian Karakter',
    'ekstrakurikuler' => 'Ekstrakurikuler',
    'osis' => 'OSIS',
    'galeri' => 'Galeri',
    'berita' => 'Berita & Pengumuman',
]

// Konfigurasi per jenjang:
[
    'sd' => ['presensi', 'kredit_poin', 'penilaian_karakter'],
    'smp' => ['presensi', 'kredit_poin', 'penilaian_karakter', 'ekstrakurikuler'],
    'sma' => ['presensi', 'kredit_poin', 'penilaian_karakter', 'ekstrakurikuler', 'osis'],
    'smk' => ['presensi', 'kredit_poin', 'penilaian_karakter', 'ekstrakurikuler', 'osis', 'kejuruan'],
]
```

### **Step 4: Konfigurasi Database**
```php
// Database configuration:
[
    'host' => 'localhost',
    'port' => '3306',
    'username' => 'root',
    'password' => '',
    'create_database' => true,
    'import_sample' => true,
]
```

### **Step 5: Proses Instalasi**
```php
// Proses instalasi:
1. Create database schema
2. Create sekolah profile
3. Create jenjang configuration
4. Create module configuration
5. Create default data
6. Create admin user
7. Generate configuration files
8. Set file permissions
```

## 🔧 **KONFIGURASI**

### **File**: `config/installer.php`
```php
<?php

return [
    'version' => '1.0.0',
    'min_php_version' => '8.3',
    'min_mysql_version' => '8.0',
    'required_extensions' => [
        'pdo',
        'pdo_mysql',
        'mbstring',
        'openssl',
        'tokenizer',
        'xml',
        'ctype',
        'json',
        'bcmath',
        'fileinfo',
    ],
    'writable_directories' => [
        'storage',
        'bootstrap/cache',
        'public/uploads',
    ],
    'default_modules' => [
        'sd' => ['presensi', 'kredit_poin', 'penilaian_karakter'],
        'smp' => ['presensi', 'kredit_poin', 'penilaian_karakter', 'ekstrakurikuler'],
        'sma' => ['presensi', 'kredit_poin', 'penilaian_karakter', 'ekstrakurikuler', 'osis'],
        'smk' => ['presensi', 'kredit_poin', 'penilaian_karakter', 'ekstrakurikuler', 'osis', 'kejuruan'],
    ],
];
```

## 🎨 **FRONTEND WIZARD**

### **Vue.js Components**
```vue
<!-- components/installation/InstallationWizard.vue -->
<template>
    <div class="installation-wizard">
        <div class="wizard-header">
            <h1>🧙‍♂️ Wizard Installasi SISKA</h1>
            <div class="progress-bar">
                <div class="progress" :style="{ width: progress + '%' }"></div>
            </div>
            <p>Langkah {{ currentStep }} dari {{ totalSteps }}</p>
        </div>
        
        <div class="wizard-content">
            <!-- Step Components -->
        </div>
    </div>
</template>
```

## 🔐 **LICENSE INTEGRATION**

### **License Validation**
```php
// Validasi lisensi sebelum instalasi
public function validateLicense($licenseKey)
{
    $licenseService = new LicenseService();
    return $licenseService->validateLicense($licenseKey);
}
```

### **License Activation**
```php
// Aktivasi lisensi setelah instalasi
public function activateLicense($licenseKey, $installationId, $sekolahData)
{
    $licenseService = new LicenseService();
    return $licenseService->activateLicense($licenseKey, $installationId, $sekolahData);
}
```

## 📊 **INSTALLATION LOG**

### **Log File**: `storage/logs/installation.log`
```
[2024-01-01 10:00:00] Installation started
[2024-01-01 10:00:01] License validated successfully
[2024-01-01 10:00:02] Database connection established
[2024-01-01 10:00:03] Core database created
[2024-01-01 10:00:04] SD database created
[2024-01-01 10:00:05] Migrations executed
[2024-01-01 10:00:06] sekolah profile created
[2024-01-01 10:00:07] Admin user created
[2024-01-01 10:00:08] Installation completed successfully
```

## 🚨 **ERROR HANDLING**

### **Common Errors**
- **License Invalid**: Lisensi tidak valid atau expired
- **Database Connection Failed**: Koneksi database gagal
- **Insufficient Permissions**: Permission file/folder tidak cukup
- **PHP Version Too Low**: Versi PHP terlalu rendah
- **Missing Extensions**: Extension PHP yang diperlukan tidak ada

### **Error Recovery**
- **Rollback**: Rollback perubahan jika instalasi gagal
- **Retry**: Opsi retry untuk step yang gagal
- **Skip**: Skip step yang tidak kritis
- **Manual Fix**: Panduan perbaikan manual

## 📞 **SUPPORT**

- **GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)
- **Website**: [jejakawan.com](https://jejakawan.com)
- **Company**: K2NET - PT. Kirana Karina Network

---

**SISKA Installer** - Memudahkan instalasi dengan wizard yang intuitif! 🧙‍♂️✨
