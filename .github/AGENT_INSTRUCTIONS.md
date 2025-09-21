# Agent Instructions - Sistem Informasi Sekolah Bidang Kesiswaan (SISKA)

## 📋 **INFORMASI PROYEK**

**SISKA** (Sistem Informasi Sekolah Bidang Kesiswaan) adalah sistem manajemen kesiswaan terintegrasi yang dibangun dengan Laravel (Backend) dan Vue.js (Frontend). Sistem ini dirancang untuk mengelola seluruh aspek kesiswaan sekolah mulai dari manajemen siswa, guru, presensi, penilaian karakter, hingga ekstrakurikuler dan OSIS.

### 🏢 **PENGEMBANG & DUKUNGAN**

**Pengembang**: [jejakawan.com](https://jejakawan.com)  
**GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)

**Supported by**:  
**K2NET**  
**PT. Kirana Karina Network**  
*"Provide Different IT Solutions"*

## 🎯 Project Overview

### **Key Information:**
- **Project Path**: `/opt/kesiswaan/siska`
- **Architecture**: Isolated Jenjang Architecture
- **Backend**: Laravel 11.35 (PHP 8.3+)
- **Frontend**: Vue.js 3.5.21 dengan Composition API
- **Database**: MySQL 8.0 dengan multiple databases per jenjang
- **Authentication**: Laravel Sanctum
- **API Documentation**: Swagger/OpenAPI
- **Status**: READY FOR IMPLEMENTATION
- **Timeline**: 10 weeks implementation

## 🏗️ **ISOLATED ARCHITECTURE OVERVIEW**

### **Workspace Structure:**
```
/opt/kesiswaan/siska/
├── core/                    # Core system (License, Profil Sekolah, etc.)
├── jenjang/                 # Jenjang-specific modules
│   ├── sd/                 # SD module
│   ├── smp/                # SMP module
│   ├── sma/                # SMA module
│   └── smk/                # SMK module
├── public/                  # Public content system
├── installer/               # Installation wizard
├── shared/                  # Shared components
├── frontend/                # Frontend application
└── docs/                    # Documentation
```

### **Database Architecture:**
- **siska_core**: Core database (license, profil sekolah, tahun akademik, semester)
- **siska_public**: Public database (postingan umum, program, kegiatan publik)
- **siska_sd**: SD-specific database
- **siska_smp**: SMP-specific database
- **siska_sma**: SMA-specific database
- **siska_smk**: SMK-specific database

### **Isolated Architecture Principles:**
- **Core System**: Shared across all jenjang
- **Jenjang Modules**: Isolated per jenjang (SD, SMP, SMA, SMK)
- **Public System**: Shared content management
- **Installer Wizard**: Dynamic installation based on needs
- **Shared Components**: Reusable components across modules

## 👥 User Roles & Permissions

### 1. **Admin**
- Full system access
- User management
- System configuration
- School profile management

### 2. **Guru**
- Student management
- Attendance tracking
- Character assessment
- Class management

### 3. **Siswa**
- Personal profile
- Attendance view
- Credit point tracking
- Academic progress

### 4. **Wali Kelas**
- Class student management
- Attendance monitoring
- Parent communication

### 5. **BK (Bimbingan Konseling)**
- Student counseling
- Character assessment
- Home visit management

### 6. **OSIS**
- OSIS member management
- Activity organization
- Achievement tracking

### 7. **Ekstrakurikuler**
- Extracurricular management
- Schedule management
- Member management

### 8. **Orang Tua**
- Child's academic progress
- Attendance monitoring
- Communication with school

## 🎯 Core Features

### 1. **User Management System**
- Multi-role authentication
- User profile management
- Role-based access control

### 2. **Student Management**
- Student registration and profiles
- Class assignment
- Academic year management

### 3. **Attendance System**
- Daily attendance tracking
- QR code attendance
- Attendance reports

### 4. **Credit Point System**
- Point-based behavior tracking
- Category management
- Point history

### 5. **Character Assessment**
- Multi-dimensional character evaluation
- Assessment indicators
- Progress tracking

### 6. **Academic Management**
- Class scheduling
- Subject management
- Academic year configuration

### 7. **Extracurricular Management**
- Activity organization
- Member management
- Schedule coordination

### 8. **OSIS Management**
- Member management
- Activity planning
- Leadership tracking

### 9. **School Profile**
- School information management
- Logo and branding
- Organizational structure

### 10. **Content Management**
- Gallery management
- Content publishing
- Media upload

### 11. **Communication**
- WhatsApp integration
- Notification system
- Parent communication

### 12. **Reporting & Analytics**
- Dashboard analytics
- Role-based reports
- Data visualization

## 🔧 Development Guidelines

### **Code Standards:**
- **Laravel**: PSR-12 coding standards
- **Vue.js**: Composition API dengan TypeScript (optional)
- **Database**: Eloquent ORM dengan relationships
- **API**: RESTful API design

### **Testing:**
- **Backend**: PHPUnit tests
- **Frontend**: Vue Test Utils
- **Integration**: API testing
- **E2E**: Cypress atau Playwright

### **Performance:**
- **Caching**: Redis untuk caching
- **Database**: Proper indexing
- **Frontend**: Lazy loading dan code splitting
- **API**: Pagination dan filtering

## 📋 Development Standards & Conventions

### **File Naming Conventions**

#### Backend (Laravel)
- **Controllers**: PascalCase (e.g., `UserController.php`, `SiswaController.php`)
- **Models**: PascalCase (e.g., `User.php`, `Siswa.php`)
- **Migrations**: snake_case with timestamp (e.g., `2024_01_15_000001_create_users_table.php`)
- **Seeders**: PascalCase (e.g., `UserSeeder.php`, `SiswaSeeder.php`)
- **Services**: PascalCase (e.g., `UserService.php`, `PresensiService.php`)
- **Requests**: PascalCase (e.g., `CreateUserRequest.php`, `UpdateSiswaRequest.php`)
- **Resources**: PascalCase (e.g., `UserResource.php`, `SiswaResource.php`)
- **Middleware**: PascalCase (e.g., `RoleMiddleware.php`, `AuthMiddleware.php`)

#### Frontend (Vue.js)
- **Components**: PascalCase (e.g., `UserForm.vue`, `SiswaCard.vue`)
- **Views**: PascalCase (e.g., `UsersView.vue`, `SiswaView.vue`)
- **Stores**: camelCase (e.g., `userStore.js`, `siswaStore.js`)
- **Services**: camelCase (e.g., `userService.js`, `presensiService.js`)
- **Utils**: camelCase (e.g., `helpers.js`, `constants.js`)
- **Assets**: kebab-case (e.g., `user-avatar.png`, `school-logo.svg`)

#### Database
- **Tables**: snake_case (e.g., `users`, `user_roles`, `kredit_poin`)
- **Columns**: snake_case (e.g., `created_at`, `user_id`, `kredit_poin_id`)
- **Indexes**: snake_case (e.g., `idx_users_email`, `idx_siswa_kelas_id`)

#### Routes & URLs
- **API Routes**: kebab-case (e.g., `/api/user-management`, `/api/kredit-poin`)
- **Frontend Routes**: kebab-case (e.g., `/user-management`, `/kredit-poin`)
- **Route Names**: kebab-case (e.g., `user-management`, `kredit-poin`)

### **Database Migration Naming Conventions (Bahasa Indonesia)**

#### Migration File Naming
- **Format**: `YYYY_MM_DD_HHMMSS_create_[nama_tabel]_table.php`
- **Contoh**: 
  - `2024_01_15_000001_create_siswa_table.php`
  - `2024_01_15_000002_create_presensi_table.php`
  - `2024_01_15_000003_create_kredit_poin_table.php`
  - `2024_01_15_000004_create_ekstrakurikuler_table.php`

#### Migration Class Naming
- **Format**: `Create[NamaTabel]Table`
- **Contoh**:
  - `CreateSiswaTable`
  - `CreatePresensiTable`
  - `CreateKreditPoinTable`
  - `CreateEkstrakurikulerTable`

#### Table Naming (snake_case - Bahasa Indonesia)
- **Format**: `snake_case` dengan nama dalam bahasa Indonesia
- **Contoh**:
  - `siswa` (bukan `students`)
  - `guru` (bukan `teachers`)
  - `presensi` (bukan `attendance`)
  - `kredit_poin` (bukan `credit_points`)
  - `ekstrakurikuler` (bukan `extracurriculars`)
  - `konseling` (bukan `counseling`)
  - `orang_tua` (bukan `parents`)
  - `tahun_ajaran` (bukan `academic_years`)
  - `mata_pelajaran` (bukan `subjects`)

#### Column Naming (snake_case - Bahasa Indonesia)
- **Format**: `snake_case` dengan nama dalam bahasa Indonesia
- **Contoh**:
  - `nama_lengkap` (bukan `full_name`)
  - `tanggal_lahir` (bukan `birth_date`)
  - `jenis_kelamin` (bukan `gender`)
  - `alamat_lengkap` (bukan `full_address`)
  - `nomor_hp` (bukan `phone_number`)
  - `status_aktif` (bukan `is_active`)
  - `tanggal_masuk` (bukan `enrollment_date`)
  - `wali_kelas_id` (bukan `homeroom_teacher_id`)

### **Information, Validation & Notification Standards (Bahasa Indonesia)**

#### Form Labels & Placeholders
```javascript
// ✅ Correct - Indonesian labels
const formLabels = {
  namaLengkap: 'Nama Lengkap',
  namaPanggilan: 'Nama Panggilan',
  jenisKelamin: 'Jenis Kelamin',
  tempatLahir: 'Tempat Lahir',
  tanggalLahir: 'Tanggal Lahir',
  agama: 'Agama',
  alamatLengkap: 'Alamat Lengkap',
  nomorHp: 'Nomor HP',
  email: 'Alamat Email',
  kelas: 'Kelas',
  tahunAjaran: 'Tahun Ajaran',
  statusSiswa: 'Status Siswa'
}

// ✅ Correct - Indonesian placeholders
const placeholders = {
  namaLengkap: 'Masukkan nama lengkap',
  nomorHp: 'Contoh: 081234567890',
  email: 'contoh@email.com',
  alamatLengkap: 'Masukkan alamat lengkap'
}
```

#### Validation Messages
```javascript
// ✅ Correct - Indonesian validation messages
const validationMessages = {
  required: 'Field ini wajib diisi',
  email: 'Format email tidak valid',
  min: 'Minimal {min} karakter',
  max: 'Maksimal {max} karakter',
  numeric: 'Hanya boleh berisi angka',
  unique: 'Data sudah ada',
  confirmed: 'Konfirmasi tidak cocok',
  date: 'Format tanggal tidak valid',
  phone: 'Format nomor HP tidak valid',
  nisn: 'NISN harus 10 digit',
  nis: 'NIS harus 10 digit',
  nik: 'NIK harus 16 digit'
}
```

#### Success Messages
```javascript
// ✅ Correct - Indonesian success messages
const successMessages = {
  create: 'Data berhasil ditambahkan',
  update: 'Data berhasil diperbarui',
  delete: 'Data berhasil dihapus',
  restore: 'Data berhasil dipulihkan',
  import: 'Data berhasil diimpor',
  export: 'Data berhasil diekspor',
  login: 'Login berhasil',
  logout: 'Logout berhasil',
  passwordChange: 'Password berhasil diubah',
  profileUpdate: 'Profil berhasil diperbarui'
}
```

#### Error Messages
```javascript
// ✅ Correct - Indonesian error messages
const errorMessages = {
  general: 'Terjadi kesalahan. Silakan coba lagi.',
  network: 'Koneksi internet bermasalah',
  server: 'Server sedang bermasalah',
  unauthorized: 'Anda tidak memiliki akses',
  forbidden: 'Akses ditolak',
  notFound: 'Data tidak ditemukan',
  validation: 'Data yang dimasukkan tidak valid',
  fileUpload: 'Gagal mengunggah file',
  fileSize: 'Ukuran file terlalu besar',
  fileType: 'Tipe file tidak didukung'
}
```

#### Button & Action Labels
```javascript
// ✅ Correct - Indonesian button labels
const buttonLabels = {
  simpan: 'Simpan',
  batal: 'Batal',
  hapus: 'Hapus',
  edit: 'Edit',
  lihat: 'Lihat',
  tambah: 'Tambah',
  cari: 'Cari',
  filter: 'Filter',
  reset: 'Reset',
  export: 'Ekspor',
  import: 'Impor',
  download: 'Unduh',
  upload: 'Unggah',
  konfirmasi: 'Konfirmasi',
  ya: 'Ya',
  tidak: 'Tidak',
  tutup: 'Tutup',
  kembali: 'Kembali',
  lanjut: 'Lanjut',
  selesai: 'Selesai'
}
```

### **Language & Localization Standards**

#### Primary Language
- **Default**: Bahasa Indonesia
- **UI Text**: Semua teks antarmuka dalam Bahasa Indonesia
- **Comments**: Kode comments dalam Bahasa Indonesia
- **Documentation**: Dokumentasi dalam Bahasa Indonesia
- **Error Messages**: Pesan error dalam Bahasa Indonesia
- **Validation Messages**: Pesan validasi dalam Bahasa Indonesia
- **Notification Messages**: Pesan notifikasi dalam Bahasa Indonesia
- **Success Messages**: Pesan sukses dalam Bahasa Indonesia

#### Code Language (Tetap English)
- **Variables**: English (e.g., `userData`, `isLoading`, `handleSubmit`)
- **Functions**: English (e.g., `getUserData()`, `validateForm()`)
- **API Endpoints**: English (e.g., `/api/users`, `/api/students`)
- **Database Fields**: English (e.g., `created_at`, `updated_at`)
- **Class Names**: English (e.g., `UserController`, `StudentService`)
- **Method Names**: English (e.g., `getUserById()`, `createStudent()`)

## 🌿 **GIT STRATEGY**

### **Repository Information:**
- **Main Repository**: [https://github.com/jejak-awan/siska](https://github.com/jejak-awan/siska)
- **Legacy Repository**: [https://github.com/jejak-awan/siska-legacy](https://github.com/jejak-awan/siska-legacy)
- **SSH Host**: `github-siska`

### **Branch Strategy:**
```bash
main                    # Production-ready (all modules)
develop                 # Development integration
core                    # Core system development
sd                      # SD module development
smp                     # SMP module development
sma                     # SMA module development
smk                     # SMK module development
public                  # Public system development
installer               # Installer wizard development
shared                  # Shared components development
```

### **Development Workflow:**
```bash
# 1. Switch to module branch
git checkout core

# 2. Develop features
git add .
git commit -m "feat(core): add license validation"

# 3. Push to remote
git push origin core

# 4. Create Pull Request
# 5. Merge to develop
# 6. Deploy to main
```

## 👥 **USER ROLES & PERMISSIONS**

### **Core System Roles:**
- **Super Admin**: Full system access across all jenjang
- **Admin**: System configuration and user management
- **License Manager**: License validation and management

### **Jenjang-Specific Roles:**
- **Kepala Sekolah**: sekolah-level management
- **Guru**: Teacher management and student oversight
- **Siswa**: Student self-service
- **Wali Kelas**: Class management
- **BK**: Guidance and counseling
- **OSIS**: Student organization management
- **Ekstrakurikuler**: Extracurricular management
- **Orang Tua**: Parent monitoring

## 🔧 **DEVELOPMENT GUIDELINES**

### **Code Standards:**
- **Laravel**: PSR-12 coding standards
- **Vue.js**: Composition API dengan TypeScript
- **Database**: Eloquent ORM dengan relationships
- **API**: RESTful API design

### **Architecture Standards:**
- **Isolation**: Each jenjang module is independent
- **Shared Core**: Common functionality in core system
- **Database Isolation**: Separate databases per jenjang
- **API Versioning**: Versioned APIs for compatibility

### **Testing:**
- **Backend**: PHPUnit tests per module
- **Frontend**: Vue Test Utils
- **Integration**: API testing across modules
- **E2E**: Cypress atau Playwright

### **Performance:**
- **Caching**: Redis untuk caching
- **Database**: Proper indexing per database
- **Frontend**: Lazy loading dan code splitting
- **API**: Pagination dan filtering

## 📋 **DEVELOPMENT STANDARDS & CONVENTIONS**

### **File Naming Conventions**

#### Backend (Laravel)
- **Controllers**: PascalCase (e.g., `UserController.php`, `SiswaController.php`)
- **Models**: PascalCase (e.g., `User.php`, `Siswa.php`)
- **Migrations**: snake_case dengan timestamp (e.g., `2024_01_01_000001_create_users_table.php`)
- **Seeders**: PascalCase (e.g., `UserSeeder.php`)
- **Services**: PascalCase dengan suffix Service (e.g., `UserService.php`)
- **Requests**: PascalCase dengan suffix Request (e.g., `CreateUserRequest.php`)
- **Resources**: PascalCase dengan suffix Resource (e.g., `UserResource.php`)

#### Frontend (Vue.js)
- **Components**: PascalCase (e.g., `UserProfile.vue`, `SiswaList.vue`)
- **Views**: PascalCase (e.g., `Dashboard.vue`, `SiswaManagement.vue`)
- **Stores**: camelCase dengan suffix Store (e.g., `userStore.js`, `siswaStore.js`)
- **Services**: camelCase dengan suffix Service (e.g., `userService.js`, `siswaService.js`)
- **Utils**: camelCase (e.g., `dateUtils.js`, `validationUtils.js`)

#### Database
- **Tables**: snake_case (e.g., `users`, `siswa`, `presensi`)
- **Columns**: snake_case (e.g., `nama_lengkap`, `tanggal_lahir`, `alamat`)
- **Foreign Keys**: snake_case dengan suffix `_id` (e.g., `user_id`, `siswa_id`)
- **Indexes**: snake_case dengan prefix `idx_` (e.g., `idx_users_email`)

### **Language Conventions**

#### Bahasa Indonesia (UI & Database)
- **Informasi**: Semua pesan informasi menggunakan Bahasa Indonesia
- **Validasi**: Pesan error dan validasi dalam Bahasa Indonesia
- **Notifikasi**: Notifikasi sistem dalam Bahasa Indonesia
- **Database**: Nama tabel dan kolom menggunakan Bahasa Indonesia
- **Dokumentasi**: Dokumentasi teknis dalam Bahasa Indonesia

#### English (Code & Technical)
- **Variables**: Nama variabel dalam Bahasa Inggris
- **Functions**: Nama fungsi dalam Bahasa Inggris
- **Classes**: Nama class dalam Bahasa Inggris
- **API Endpoints**: Endpoint API dalam Bahasa Inggris
- **Comments**: Komentar kode dalam Bahasa Inggris

### **Database Naming Conventions**

#### Tables
- **Core Tables**: `users`, `roles`, `permissions`, `sekolah_profile`
- **Jenjang Tables**: `siswa`, `guru`, `kelas`, `presensi`, `kredit_poin`
- **Public Tables**: `postingan_umum`, `program`, `kegiatan_publik`

#### Columns
- **Primary Keys**: `id` (auto-increment)
- **Foreign Keys**: `{table}_id` (e.g., `user_id`, `siswa_id`)
- **Timestamps**: `created_at`, `updated_at`
- **Soft Deletes**: `deleted_at`
- **Status**: `status` (enum atau boolean)

### **API Naming Conventions**

#### Endpoints
- **Core APIs**: `/api/core/{resource}`
- **Jenjang APIs**: `/api/{jenjang}/{resource}`
- **Public APIs**: `/api/public/{resource}`

#### Examples
```bash
# Core APIs
GET /api/core/users
POST /api/core/users
PUT /api/core/users/{id}
DELETE /api/core/users/{id}

# Jenjang APIs
GET /api/sd/siswa
POST /api/sd/siswa
PUT /api/sd/siswa/{id}
DELETE /api/sd/siswa/{id}

# Public APIs
GET /api/public/postingan
POST /api/public/postingan
```

## 🚀 **QUICK START**

### Prerequisites
- PHP 8.3+
- Node.js 18+
- MySQL 8.0+
- Composer
- NPM

### Installation
```bash
# Clone repository
git clone github-siska:jejak-awan/siska.git
cd siska

# Core system setup
cd core
composer install
cp env.example .env
php artisan key:generate
php artisan migrate --seed

# Frontend setup
cd ../frontend
npm install
npm run dev

# Start development
cd ..
./scripts/start-dev.sh
```

### Access Application
- **Frontend**: http://localhost:3000
- **Backend API**: http://localhost:8000
- **API Documentation**: http://localhost:8080/api/documentation

## 📚 **DOCUMENTATION**

### **Architecture Documentation:**
- **[Database Schema](docs/skema-database-isolated.md)**
- **[Application Structure](docs/struktur-aplikasi-isolated.md)**
- **[Git Integration](docs/strategi-git-integration.md)**
- **[Migration Strategy](docs/strategi-migrasi-folder-structure.md)**
- **[Multi-Jenjang Flow](docs/strategi-multi-jenjang-flow.md)**
- **[Performance & Backup](docs/strategi-performa-backup-multi-jenjang.md)**
- **[Installation Wizard](docs/strategi-wizard-installasi-isolated.md)**

### **Technical Documentation:**
- **[Core System](core/README.md)**
- **[SD Module](jenjang/sd/README.md)**
- **[Public System](public/README.md)**
- **[Installer](installer/README.md)**
- **[Shared Components](shared/README.md)**
- **[Frontend](frontend/README.md)**

## 🔐 **SECURITY FEATURES**

### **Authentication & Authorization**
- **Multi-role Authentication**: Sistem login berdasarkan peran
- **Token-based Security**: Keamanan berbasis token
- **Role-based Access Control**: Kontrol akses berdasarkan peran
- **Session Management**: Manajemen sesi yang aman

### **Data Protection**
- **Input Validation**: Validasi input yang ketat
- **SQL Injection Prevention**: Perlindungan dari SQL injection
- **XSS Protection**: Perlindungan dari cross-site scripting
- **CSRF Protection**: Perlindungan dari CSRF attacks

## 📊 **DATA MANAGEMENT**

### **Import/Export**
- **Excel Import**: Import data dari file Excel
- **Data Export**: Ekspor data dalam berbagai format
- **Template Download**: Template untuk import data
- **Data Validation**: Validasi data sebelum import

### **Backup & Recovery**
- **Database Backup**: Backup otomatis per database
- **File Backup**: Backup file dan media
- **Recovery System**: Sistem pemulihan data
- **Version Control**: Kontrol versi data

## 🌐 **INTEGRATION**

### **WhatsApp Integration**
- **Notification Service**: Notifikasi via WhatsApp
- **Bulk Messaging**: Pengiriman pesan massal
- **Template Messages**: Template pesan yang dapat dikustomisasi
- **Delivery Status**: Status pengiriman pesan

### **API Integration**
- **RESTful API**: API yang mengikuti standar REST
- **API Documentation**: Dokumentasi API yang lengkap
- **Rate Limiting**: Pembatasan rate API
- **API Versioning**: Versioning untuk kompatibilitas

## 📈 **PERFORMANCE**

### **Optimization**
- **Database Indexing**: Optimasi database dengan indexing
- **Caching System**: Sistem cache untuk performa
- **Lazy Loading**: Loading komponen yang efisien
- **Bundle Optimization**: Optimasi bundle frontend

### **Monitoring**
- **Performance Metrics**: Metrik performa aplikasi
- **Error Tracking**: Tracking error dan debugging
- **Usage Analytics**: Analisis penggunaan sistem
- **Health Checks**: Monitoring kesehatan sistem

## 🎯 **TARGET USERS**

### **Sekolah**
- **SD/MI**: Sekolah dasar dan madrasah ibtidaiyah
- **SMP/MTs**: Sekolah menengah pertama dan madrasah tsanawiyah
- **SMA/MA**: Sekolah menengah atas dan madrasah aliyah
- **SMK**: Sekolah menengah kejuruan

### **Stakeholders**
- **Kepala Sekolah**: Monitoring dan evaluasi sekolah
- **Guru**: Manajemen pembelajaran dan siswa
- **Siswa**: Akses informasi akademik dan non-akademik
- **Orang Tua**: Monitoring kemajuan anak
- **Admin**: Manajemen sistem dan data

## 📞 **SUPPORT & DOCUMENTATION**

### **Documentation**
- **User Manual**: Panduan penggunaan untuk setiap role
- **API Documentation**: Dokumentasi API yang lengkap
- **Developer Guide**: Panduan untuk developer
- **FAQ**: Frequently Asked Questions

### **Support**
- **GitHub Issues**: Laporan bug dan feature request
- **Email Support**: Dukungan via email
- **Community Forum**: Forum komunitas pengguna
- **Training Materials**: Materi pelatihan dan tutorial

## 🤝 **CONTRIBUTING**

Kami menyambut kontribusi dari komunitas! Silakan lihat Contributing Guidelines untuk informasi lebih lanjut.

### **Development**
- Fork repository
- Create feature branch
- Make changes
- Submit pull request

### **Reporting Issues**
- Gunakan GitHub Issues
- Berikan detail yang jelas
- Sertakan screenshot jika perlu
- Jelaskan langkah reproduksi

## 📄 **LICENSE**

Proyek ini dilisensikan di bawah MIT License.

## 🙏 **ACKNOWLEDGMENTS**

- **Laravel Community** - Framework dan ekosistem yang luar biasa
- **Vue.js Community** - Framework frontend yang powerful
- **Tailwind CSS** - Utility-first CSS framework
- **Contributors** - Semua kontributor yang telah membantu

---

**SISKA** - Membangun masa depan pendidikan Indonesia yang lebih baik! 🎓✨

_Dibuat dengan ❤️ untuk pendidikan Indonesia_
