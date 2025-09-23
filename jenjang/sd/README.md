# 🎒 **SD MODULE - SEKOLAH DASAR**

## 📋 **INFORMASI MODULE**

**Nama**: SD Module  
**Display Name**: Sekolah Dasar  
**Versi**: 1.0.0  
**Database**: `siska_sd`  
**Namespace**: `App\Jenjang\SD`

## 🎯 **DESKRIPSI**

Module SD (Sekolah Dasar) adalah modul khusus untuk manajemen siswa SD dengan fokus pada:
- Karakter dasar
- Kebersihan
- Kedisiplinan
- Penilaian karakter
- Kredit poin

## 🏗️ **STRUKTUR MODULE**

```
sd/
├── app/
│   ├── Http/
│   │   ├── Controllers/           # Controllers untuk SD
│   │   ├── Requests/              # Form requests
│   │   └── Resources/             # API resources
│   ├── Models/                    # Models untuk SD
│   ├── Services/                  # Business logic
│   └── Providers/                 # Service providers
├── database/
│   ├── migrations/                # Database migrations
│   └── seeders/                   # Database seeders
├── routes/
│   └── api.php                    # API routes
├── config/
│   └── sd.php                     # Module configuration
└── README.md                      # Documentation
```

## 🔧 **FITUR MODULE**

### **1. Manajemen Siswa**
- CRUD siswa SD
- Data pribadi siswa
- Data orang tua
- Kelas dan NIS/NISN

### **2. Presensi Siswa**
- Presensi harian
- Status presensi (hadir, izin, sakit, alpha)
- Bulk presensi
- Statistik presensi

### **3. Kredit Poin**
- Sistem kredit poin positif/negatif
- Penilaian karakter
- Semester dan tahun akademik
- Statistik kredit poin

### **4. Program Kesiswaan**
- Program khusus SD
- Kategori: karakter dasar, kebersihan, kedisiplinan
- Manajemen peserta
- Statistik program

### **5. Penilaian Karakter**
- Penilaian aspek karakter
- Nilai karakter
- Catatan penilaian
- Statistik penilaian

## 🗄️ **DATABASE TABLES**

| Table | Description |
|-------|-------------|
| `users_sd` | User accounts untuk SD |
| `siswa_sd` | Data siswa SD |
| `presensi_sd` | Data presensi siswa |
| `kredit_poin_sd` | Data kredit poin |
| `program_kesiswaan_sd` | Program kesiswaan SD |
| `penilaian_karakter_sd` | Penilaian karakter siswa |

## 🚀 **INSTALLATION**

### **1. Register Service Provider**
```php
// config/app.php
'providers' => [
    // ...
    App\Jenjang\SD\Providers\SDServiceProvider::class,
],
```

### **2. Publish Configuration**
```bash
php artisan vendor:publish --tag=sd-config
```

### **3. Run Migrations**
```bash
php artisan migrate --path=database/migrations/sd
```

### **4. Seed Database (Optional)**
```bash
php artisan db:seed --class=SDDatabaseSeeder
```

## 📡 **API ENDPOINTS**

### **Siswa**
- `GET /api/jenjang/sd/siswa` - List siswa
- `POST /api/jenjang/sd/siswa` - Create siswa
- `GET /api/jenjang/sd/siswa/{id}` - Get siswa
- `PUT /api/jenjang/sd/siswa/{id}` - Update siswa
- `DELETE /api/jenjang/sd/siswa/{id}` - Delete siswa
- `GET /api/jenjang/sd/siswa/statistics` - Statistics

### **Presensi**
- `GET /api/jenjang/sd/presensi` - List presensi
- `POST /api/jenjang/sd/presensi` - Create presensi
- `POST /api/jenjang/sd/presensi/bulk` - Bulk create presensi
- `GET /api/jenjang/sd/presensi/statistics` - Statistics

### **Kredit Poin**
- `GET /api/jenjang/sd/kredit-poin` - List kredit poin
- `POST /api/jenjang/sd/kredit-poin` - Create kredit poin
- `GET /api/jenjang/sd/kredit-poin/statistics` - Statistics

### **Program Kesiswaan**
- `GET /api/jenjang/sd/program-kesiswaan` - List program
- `POST /api/jenjang/sd/program-kesiswaan` - Create program
- `GET /api/jenjang/sd/program-kesiswaan/{id}/participants` - Get participants

## ⚙️ **CONFIGURATION**

### **Module Settings**
```php
// config/sd.php
'settings' => [
    'max_siswa_per_kelas' => 30,
    'max_poin_per_semester' => 100,
    'auto_presensi_timeout' => 30,
    'enable_kredit_poin' => true,
    'enable_penilaian_karakter' => true,
]
```

### **Database Connection**
```php
// config/database.php
'connections' => [
    'sd' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_SD_DATABASE', 'siska_sd'),
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
| Guru | Read siswa, Full presensi, Full kredit poin, Read program |
| Wali Kelas | Read siswa, Full presensi, Full kredit poin, Read program |
| Siswa | Read own data only |

## 🧪 **TESTING**

```bash
# Run SD module tests
php artisan test --path=jenjang/sd/tests

# Run specific test
php artisan test --path=jenjang/sd/tests/Feature/SiswaSDTest.php
```

## 📝 **CHANGELOG**

### **v1.0.0** (2024-01-01)
- Initial release
- Basic CRUD operations
- Presensi system
- Kredit poin system
- Program kesiswaan
- Penilaian karakter

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