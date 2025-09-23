# 📚 **SMP MODULE - SEKOLAH MENENGAH PERTAMA**

## 📋 **INFORMASI MODULE**

**Nama**: SMP Module  
**Display Name**: Sekolah Menengah Pertama  
**Versi**: 1.0.0  
**Database**: `siska_smp`  
**Namespace**: `App\Jenjang\SMP`

## 🎯 **DESKRIPSI**

Module SMP (Sekolah Menengah Pertama) adalah modul khusus untuk manajemen siswa SMP dengan fokus pada:
- Ekstrakurikuler
- Program kesiswaan
- Presensi siswa
- Manajemen siswa

## 🏗️ **STRUKTUR MODULE**

```
smp/
├── app/
│   ├── Http/
│   │   ├── Controllers/           # Controllers untuk SMP
│   │   ├── Requests/              # Form requests
│   │   └── Resources/             # API resources
│   ├── Models/                    # Models untuk SMP
│   ├── Services/                  # Business logic
│   └── Providers/                 # Service providers
├── database/
│   ├── migrations/                # Database migrations
│   └── seeders/                   # Database seeders
├── routes/
│   └── api.php                    # API routes
├── config/
│   └── smp.php                    # Module configuration
└── README.md                      # Documentation
```

## 🔧 **FITUR MODULE**

### **1. Manajemen Siswa**
- CRUD siswa SMP
- Data pribadi siswa
- Data orang tua
- Kelas dan NIS/NISN

### **2. Presensi Siswa**
- Presensi harian
- Status presensi (hadir, izin, sakit, alpha)
- Bulk presensi
- Statistik presensi

### **3. Ekstrakurikuler**
- Manajemen ekstrakurikuler
- Pendaftaran siswa
- Jadwal dan lokasi
- Statistik ekstrakurikuler

### **4. Program Kesiswaan**
- Program khusus SMP
- Kategori: ekstrakurikuler, organisasi, prestasi
- Manajemen peserta
- Statistik program

## 🗄️ **DATABASE TABLES**

| Table | Description |
|-------|-------------|
| `users_smp` | User accounts untuk SMP |
| `siswa_smp` | Data siswa SMP |
| `presensi_smp` | Data presensi siswa |
| `ekstrakurikuler_smp` | Data ekstrakurikuler |
| `ekstrakurikuler_siswa_smp` | Pivot table ekstrakurikuler-siswa |
| `program_kesiswaan_smp` | Program kesiswaan SMP |

## 🚀 **INSTALLATION**

### **1. Register Service Provider**
```php
// config/app.php
'providers' => [
    // ...
    App\Jenjang\SMP\Providers\SMPServiceProvider::class,
],
```

### **2. Publish Configuration**
```bash
php artisan vendor:publish --tag=smp-config
```

### **3. Run Migrations**
```bash
php artisan migrate --path=database/migrations/smp
```

### **4. Seed Database (Optional)**
```bash
php artisan db:seed --class=SMPDatabaseSeeder
```

## 📡 **API ENDPOINTS**

### **Siswa**
- `GET /api/jenjang/smp/siswa` - List siswa
- `POST /api/jenjang/smp/siswa` - Create siswa
- `GET /api/jenjang/smp/siswa/{id}` - Get siswa
- `PUT /api/jenjang/smp/siswa/{id}` - Update siswa
- `DELETE /api/jenjang/smp/siswa/{id}` - Delete siswa
- `GET /api/jenjang/smp/siswa/statistics` - Statistics

### **Presensi**
- `GET /api/jenjang/smp/presensi` - List presensi
- `POST /api/jenjang/smp/presensi` - Create presensi
- `POST /api/jenjang/smp/presensi/bulk` - Bulk create presensi
- `GET /api/jenjang/smp/presensi/statistics` - Statistics

### **Ekstrakurikuler**
- `GET /api/jenjang/smp/ekstrakurikuler` - List ekstrakurikuler
- `POST /api/jenjang/smp/ekstrakurikuler` - Create ekstrakurikuler
- `POST /api/jenjang/smp/ekstrakurikuler/register-student` - Register student
- `POST /api/jenjang/smp/ekstrakurikuler/unregister-student` - Unregister student
- `GET /api/jenjang/smp/ekstrakurikuler/{id}/students` - Get students
- `GET /api/jenjang/smp/ekstrakurikuler/statistics` - Statistics

### **Program Kesiswaan**
- `GET /api/jenjang/smp/program-kesiswaan` - List program
- `POST /api/jenjang/smp/program-kesiswaan` - Create program
- `GET /api/jenjang/smp/program-kesiswaan/statistics` - Statistics

## ⚙️ **CONFIGURATION**

### **Module Settings**
```php
// config/smp.php
'settings' => [
    'max_siswa_per_kelas' => 32,
    'max_ekstrakurikuler_per_siswa' => 3,
    'auto_presensi_timeout' => 30,
    'enable_ekstrakurikuler' => true,
    'enable_program_kesiswaan' => true,
]
```

### **Database Connection**
```php
// config/database.php
'connections' => [
    'smp' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_SMP_DATABASE', 'siska_smp'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        // ...
    ],
],
```

## 🔐 **PERMISSIONS**

| Role | Permissions |
|------|-------------|
| Admin | All permissions |
| Guru | Read siswa, Full presensi, Full ekstrakurikuler, Read program |
| Wali Kelas | Read siswa, Full presensi, Read ekstrakurikuler, Read program |
| Siswa | Read own data only |

## 🧪 **TESTING**

```bash
# Run SMP module tests
php artisan test --path=jenjang/smp/tests

# Run specific test
php artisan test --path=jenjang/smp/tests/Feature/SiswaSMPTest.php
```

## 📝 **CHANGELOG**

### **v1.0.0** (2024-01-01)
- Initial release
- Basic CRUD operations
- Presensi system
- Ekstrakurikuler system
- Program kesiswaan

## 🤝 **CONTRIBUTING**

1. Fork the repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## 📄 **LICENSE**

This module is part of SISKA project and follows the same license terms.

---

**SISKA** - Sistem Informasi Sekolah Bidang Kesiswaan  
**Developed by**: [jejakawan.com](https://jejakawan.com)  
**Supported by**: **K2NET** - PT. Kirana Karina Network
