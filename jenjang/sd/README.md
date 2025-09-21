# 🎒 **MODUL SD (SEKOLAH DASAR)**

## 📋 **INFORMASI PROYEK**

**SISKA** (Sistem Informasi Sekolah Bidang Kesiswaan)  
**Pengembang**: [jejakawan.com](https://jejakawan.com)  
**GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)  
**Supported by**: **K2NET** - PT. Kirana Karina Network  
*"Provide Different IT Solutions"*

## 🎯 **OVERVIEW**

Modul SD adalah bagian dari sistem SISKA yang khusus dirancang untuk mengelola kesiswaan di tingkat Sekolah Dasar (SD). Modul ini memiliki database terpisah (`siska_sd`) dan fitur-fitur yang disesuaikan dengan karakteristik siswa SD.

## 🏗️ **STRUKTUR MODUL SD**

```
sd/
├── app/
│   ├── Controllers/
│   │   ├── SiswaController.php
│   │   ├── PresensiController.php
│   │   ├── KreditPoinController.php
│   │   └── PenilaianKarakterController.php
│   ├── Models/
│   │   ├── Siswa.php
│   │   ├── Presensi.php
│   │   ├── KreditPoin.php
│   │   └── PenilaianKarakter.php
│   └── Services/
│       ├── SiswaService.php
│       ├── PresensiService.php
│       └── KreditPoinService.php
├── config/
│   └── sd.php
├── database/
│   ├── migrations/
│   │   ├── create_siswa_table.php
│   │   ├── create_presensi_table.php
│   │   ├── create_kredit_poin_table.php
│   │   └── create_penilaian_karakter_table.php
│   └── seeders/
│       ├── SiswaSeeder.php
│       └── SDSeeder.php
└── routes/
    └── api.php
```

## 📊 **DATABASE SD**

### **Database**: `siska_sd`

### **Tabel Utama**:
- `siswa_sd` - Data siswa SD
- `presensi_sd` - Presensi siswa SD
- `kredit_poin_sd` - Kredit poin siswa SD
- `penilaian_karakter_sd` - Penilaian karakter siswa SD
- `kelas_sd` - Data kelas SD
- `guru_sd` - Data guru SD

## 🎯 **FITUR KHUSUS SD**

### **1. Manajemen Siswa**
- **Kelas**: 1, 2, 3, 4, 5, 6
- **Usia**: 6-12 tahun
- **Karakteristik**: Fokus pada pengembangan karakter dasar

### **2. Presensi**
- **QR Code**: Presensi dengan QR code
- **Notifikasi**: Notifikasi ke orang tua via WhatsApp
- **Laporan**: Laporan presensi harian/mingguan/bulanan

### **3. Kredit Poin**
- **Kategori**: Disiplin, Kerapihan, Kerjasama, Tanggung Jawab
- **Skala**: 1-4 (Sangat Baik, Baik, Cukup, Kurang)
- **Reward**: Sistem reward sederhana

### **4. Penilaian Karakter**
- **Aspek**: Jujur, Disiplin, Tanggung Jawab, Santun
- **Metode**: Observasi, Portofolio, Self Assessment
- **Laporan**: Laporan perkembangan karakter

## 🔧 **KONFIGURASI SD**

### **Kelas**:
```php
'kelas' => ['1', '2', '3', '4', '5', '6']
```

### **Mata Pelajaran**:
```php
'mata_pelajaran' => [
    'Matematika',
    'Bahasa Indonesia', 
    'IPA',
    'IPS',
    'PKn',
    'Seni',
    'Olahraga'
]
```

### **Program Kesiswaan**:
```php
'program' => [
    'karakter_dasar',
    'kebersihan',
    'kedisiplinan'
]
```

### **Aspek Karakter**:
```php
'aspek' => [
    'jujur',
    'disiplin', 
    'tanggung_jawab',
    'santun'
]
```

## 🚀 **INSTALASI**

```bash
# Setup database SD
mysql -u root -p -e "CREATE DATABASE siska_sd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run migrations
php artisan migrate --database=sd

# Run seeders
php artisan db:seed --class=SDSeeder --database=sd
```

## 📚 **API ENDPOINTS**

### **Siswa**:
- `GET /api/sd/siswa` - List siswa
- `POST /api/sd/siswa` - Create siswa
- `PUT /api/sd/siswa/{id}` - Update siswa
- `DELETE /api/sd/siswa/{id}` - Delete siswa

### **Presensi**:
- `GET /api/sd/presensi` - List presensi
- `POST /api/sd/presensi` - Create presensi
- `GET /api/sd/presensi/laporan` - Laporan presensi

### **Kredit Poin**:
- `GET /api/sd/kredit-poin` - List kredit poin
- `POST /api/sd/kredit-poin` - Create kredit poin
- `GET /api/sd/kredit-poin/siswa/{id}` - Kredit poin siswa

## 🔐 **PERMISSIONS**

### **Admin**:
- Full access ke semua fitur SD

### **Guru**:
- Access ke kelas yang diampu
- Input presensi dan kredit poin
- View laporan siswa

### **Wali Kelas**:
- Access ke kelas yang diampu
- Input presensi dan kredit poin
- View laporan kelas

### **Orang Tua**:
- View data anak
- View presensi dan kredit poin
- Terima notifikasi

## 📞 **SUPPORT**

- **GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)
- **Website**: [jejakawan.com](https://jejakawan.com)
- **Company**: K2NET - PT. Kirana Karina Network

---

**SISKA SD** - Mengembangkan karakter siswa SD dengan teknologi modern! 🎒✨
