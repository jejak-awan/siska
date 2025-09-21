# 🗄️ **SKEMA DATABASE ISOLATED MULTI-JENJANG**

## 📋 **INFORMASI PROYEK**

**SISKA** (Sistem Informasi Sekolah Bidang Kesiswaan)  
**Pengembang**: [jejakawan.com](https://jejakawan.com)  
**GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)  
**Supported by**: **K2NET** - PT. Kirana Karina Network  
*"Provide Different IT Solutions"*

## 🎯 **OVERVIEW STRATEGI DATABASE ISOLATED**

### **PRINSIP DASAR:**
1. **Complete Isolation**: Setiap jenjang memiliki database terpisah
2. **Independent Schema**: Schema database per jenjang tidak saling bergantung
3. **License-Based Access**: Akses database berdasarkan lisensi
4. **Modular Design**: Database dapat diinstall per modul
5. **Data Integrity**: Konsistensi data dalam setiap database

---

## 📊 **STRUKTUR DATABASE ISOLATED**

### **A. DATABASE TERPISAH PER JENJANG:**

```sql
-- Database SD (Isolated)
CREATE DATABASE siska_sd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Database SMP (Isolated)
CREATE DATABASE siska_smp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Database SMA (Isolated)
CREATE DATABASE siska_sma CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Database SMK (Isolated)
CREATE DATABASE siska_smk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Database Core (Shared - License, sekolah Profile, etc.)
CREATE DATABASE siska_core CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Database Public (Shared - News, Programs, Gallery, etc.)
CREATE DATABASE siska_public CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### **B. ALASAN DATABASE PUBLIC SHARED (BUKAN PER JENJANG):**

#### **1. Konten Publik Bersifat Universal:**
- **Berita Sekolah**: Berita sekolah berlaku untuk semua jenjang
- **Program Sekolah**: Program sekolah bisa melibatkan multiple jenjang
- **Galeri**: Galeri foto kegiatan sekolah (bisa multi-jenjang)
- **Pengumuman**: Pengumuman sekolah untuk semua jenjang

#### **2. SEO dan Website Publik:**
- **Single Domain**: Website sekolah biasanya 1 domain untuk semua jenjang
- **SEO Optimization**: Lebih mudah optimize SEO dengan 1 database
- **Content Management**: Lebih mudah manage konten publik

#### **3. Performance dan Maintenance:**
- **Single Database**: Lebih mudah maintain 1 database public
- **Shared Resources**: Bisa share resources untuk konten publik
- **Caching**: Lebih mudah implement caching untuk konten publik

#### **4. User Experience:**
- **Unified Content**: User bisa lihat semua konten sekolah di 1 tempat
- **Cross-Jenjang Content**: Konten yang melibatkan multiple jenjang
- **Consistent Interface**: Interface yang konsisten untuk konten publik

---

## 🎒 **DATABASE SD (SEKOLAH DASAR)**

### **A. TABEL UTAMA:**
```sql
USE siska_sd;

-- Tabel Users SD
CREATE TABLE users_sd (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    jenis_user ENUM('admin', 'guru', 'siswa', 'orang_tua') NOT NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Siswa SD
CREATE TABLE siswa_sd (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_user BIGINT NOT NULL,
    nis VARCHAR(20) UNIQUE,
    nisn VARCHAR(20) UNIQUE,
    nama VARCHAR(255) NOT NULL,
    kelas ENUM('1', '2', '3', '4', '5', '6') NOT NULL,
    tanggal_lahir DATE,
    jenis_kelamin ENUM('L', 'P'),
    alamat TEXT,
    telepon VARCHAR(20),
    nama_orang_tua VARCHAR(255),
    telepon_orang_tua VARCHAR(20),
    status ENUM('active', 'inactive', 'lulus', 'pindah') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users_sd(id) ON DELETE CASCADE
);

-- Tabel Presensi SD
CREATE TABLE presensi_sd (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_siswa BIGINT NOT NULL,
    tanggal DATE NOT NULL,
    jam_masuk TIME,
    jam_keluar TIME,
    status ENUM('hadir', 'izin', 'sakit', 'alpa') DEFAULT 'hadir',
    keterangan TEXT,
    semester ENUM('1', '2') NOT NULL,
    tahun_akademik VARCHAR(9) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa_sd(id) ON DELETE CASCADE
);

-- Tabel Kredit Poin SD
CREATE TABLE kredit_poin_sd (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_siswa BIGINT NOT NULL,
    kategori ENUM('positif', 'negatif') NOT NULL,
    poin INT NOT NULL,
    deskripsi TEXT NOT NULL,
    tanggal DATE NOT NULL,
    pemberi_poin_id BIGINT NOT NULL,
    semester ENUM('1', '2') NOT NULL,
    tahun_akademik VARCHAR(9) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa_sd(id) ON DELETE CASCADE,
    FOREIGN KEY (pemberi_poin_id) REFERENCES users_sd(id) ON DELETE CASCADE
);

-- Tabel Program Kesiswaan SD
CREATE TABLE program_kesiswaan_sd (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_program VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    kategori ENUM('karakter_dasar', 'kebersihan', 'kedisiplinan') NOT NULL,
    target_siswa JSON,
    durasi INT,
    penanggung_jawab_id BIGINT,
    status ENUM('active', 'inactive', 'completed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (penanggung_jawab_id) REFERENCES users_sd(id) ON DELETE SET NULL
);

-- Tabel Penilaian Karakter SD
CREATE TABLE penilaian_karakter_sd (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_siswa BIGINT NOT NULL,
    id_program_kesiswaan BIGINT,
    aspek_karakter ENUM('jujur', 'disiplin', 'tanggung_jawab', 'santun') NOT NULL,
    nilai_karakter ENUM('1', '2', '3', '4') NOT NULL,
    deskripsi TEXT,
    tanggal_penilaian DATE NOT NULL,
    penilai_id BIGINT NOT NULL,
    semester ENUM('1', '2') NOT NULL,
    tahun_akademik VARCHAR(9) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa_sd(id) ON DELETE CASCADE,
    FOREIGN KEY (id_program_kesiswaan) REFERENCES program_kesiswaan_sd(id) ON DELETE SET NULL,
    FOREIGN KEY (penilai_id) REFERENCES users_sd(id) ON DELETE CASCADE
);
```

### **B. INDEXES SD:**
```sql
-- Indexes untuk performa optimal
CREATE INDEX idx_siswa_sd_status ON siswa_sd(status);
CREATE INDEX idx_siswa_sd_kelas ON siswa_sd(kelas);
CREATE INDEX idx_presensi_sd_tanggal ON presensi_sd(tanggal);
CREATE INDEX idx_presensi_sd_siswa_tanggal ON presensi_sd(id_siswa, tanggal);
CREATE INDEX idx_kredit_poin_sd_siswa ON kredit_poin_sd(id_siswa, tanggal);
CREATE INDEX idx_penilaian_karakter_sd_siswa ON penilaian_karakter_sd(id_siswa, semester, tahun_akademik);

-- Partial indexes
CREATE INDEX idx_siswa_sd_aktif ON siswa_sd(id_user) WHERE status = 'active';
CREATE INDEX idx_presensi_sd_hadir ON presensi_sd(id_siswa, tanggal) WHERE status = 'hadir';
```

---

## 📚 **DATABASE SMP (SEKOLAH MENENGAH PERTAMA)**

### **A. TABEL UTAMA:**
```sql
USE siska_smp;

-- Tabel Users SMP
CREATE TABLE users_smp (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    jenis_user ENUM('admin', 'guru', 'siswa', 'orang_tua') NOT NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Siswa SMP
CREATE TABLE siswa_smp (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_user BIGINT NOT NULL,
    nis VARCHAR(20) UNIQUE,
    nisn VARCHAR(20) UNIQUE,
    nama VARCHAR(255) NOT NULL,
    kelas ENUM('7', '8', '9') NOT NULL,
    tanggal_lahir DATE,
    jenis_kelamin ENUM('L', 'P'),
    alamat TEXT,
    telepon VARCHAR(20),
    nama_orang_tua VARCHAR(255),
    telepon_orang_tua VARCHAR(20),
    status ENUM('active', 'inactive', 'lulus', 'pindah') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users_smp(id) ON DELETE CASCADE
);

-- Tabel Presensi SMP
CREATE TABLE presensi_smp (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_siswa BIGINT NOT NULL,
    tanggal DATE NOT NULL,
    jam_masuk TIME,
    jam_keluar TIME,
    status ENUM('hadir', 'izin', 'sakit', 'alpa') DEFAULT 'hadir',
    keterangan TEXT,
    semester ENUM('1', '2') NOT NULL,
    tahun_akademik VARCHAR(9) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa_smp(id) ON DELETE CASCADE
);

-- Tabel Ekstrakurikuler SMP
CREATE TABLE ekstrakurikuler_smp (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_ekstrakurikuler VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    pembina_id BIGINT,
    jadwal JSON,
    kapasitas INT DEFAULT 30,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pembina_id) REFERENCES users_smp(id) ON DELETE SET NULL
);

-- Tabel Ekstrakurikuler Siswa SMP
CREATE TABLE ekstrakurikuler_siswa_smp (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_ekstrakurikuler BIGINT NOT NULL,
    id_siswa BIGINT NOT NULL,
    tanggal_daftar DATE NOT NULL,
    status ENUM('active', 'inactive', 'lulus') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ekstrakurikuler) REFERENCES ekstrakurikuler_smp(id) ON DELETE CASCADE,
    FOREIGN KEY (id_siswa) REFERENCES siswa_smp(id) ON DELETE CASCADE
);

-- Tabel Program Kesiswaan SMP
CREATE TABLE program_kesiswaan_smp (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_program VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    kategori ENUM('osis', 'ekstrakurikuler', 'kepemimpinan') NOT NULL,
    target_siswa JSON,
    durasi INT,
    penanggung_jawab_id BIGINT,
    status ENUM('active', 'inactive', 'completed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (penanggung_jawab_id) REFERENCES users_smp(id) ON DELETE SET NULL
);

-- Tabel Penilaian Karakter SMP
CREATE TABLE penilaian_karakter_smp (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_siswa BIGINT NOT NULL,
    id_program_kesiswaan BIGINT,
    aspek_karakter ENUM('jujur', 'disiplin', 'tanggung_jawab', 'santun', 'peduli', 'percaya_diri') NOT NULL,
    nilai_karakter ENUM('A', 'B', 'C', 'D') NOT NULL,
    deskripsi TEXT,
    tanggal_penilaian DATE NOT NULL,
    penilai_id BIGINT NOT NULL,
    semester ENUM('1', '2') NOT NULL,
    tahun_akademik VARCHAR(9) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa_smp(id) ON DELETE CASCADE,
    FOREIGN KEY (id_program_kesiswaan) REFERENCES program_kesiswaan_smp(id) ON DELETE SET NULL,
    FOREIGN KEY (penilai_id) REFERENCES users_smp(id) ON DELETE CASCADE
);
```

### **B. INDEXES SMP:**
```sql
-- Indexes untuk performa optimal
CREATE INDEX idx_siswa_smp_status ON siswa_smp(status);
CREATE INDEX idx_siswa_smp_kelas ON siswa_smp(kelas);
CREATE INDEX idx_presensi_smp_tanggal ON presensi_smp(tanggal);
CREATE INDEX idx_presensi_smp_siswa_tanggal ON presensi_smp(id_siswa, tanggal);
CREATE INDEX idx_ekstrakurikuler_smp_status ON ekstrakurikuler_smp(status);
CREATE INDEX idx_ekstrakurikuler_siswa_smp_siswa ON ekstrakurikuler_siswa_smp(id_siswa);
CREATE INDEX idx_penilaian_karakter_smp_siswa ON penilaian_karakter_smp(id_siswa, semester, tahun_akademik);

-- Partial indexes
CREATE INDEX idx_siswa_smp_aktif ON siswa_smp(id_user) WHERE status = 'active';
CREATE INDEX idx_presensi_smp_hadir ON presensi_smp(id_siswa, tanggal) WHERE status = 'hadir';
```

---

## 🎓 **DATABASE SMA (SEKOLAH MENENGAH ATAS)**

### **A. TABEL UTAMA:**
```sql
USE siska_sma;

-- Tabel Users SMA
CREATE TABLE users_sma (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    jenis_user ENUM('admin', 'guru', 'siswa', 'orang_tua') NOT NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Siswa SMA
CREATE TABLE siswa_sma (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_user BIGINT NOT NULL,
    nis VARCHAR(20) UNIQUE,
    nisn VARCHAR(20) UNIQUE,
    nama VARCHAR(255) NOT NULL,
    kelas ENUM('X', 'XI', 'XII') NOT NULL,
    tanggal_lahir DATE,
    jenis_kelamin ENUM('L', 'P'),
    alamat TEXT,
    telepon VARCHAR(20),
    nama_orang_tua VARCHAR(255),
    telepon_orang_tua VARCHAR(20),
    status ENUM('active', 'inactive', 'lulus', 'pindah') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users_sma(id) ON DELETE CASCADE
);

-- Tabel Presensi SMA
CREATE TABLE presensi_sma (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_siswa BIGINT NOT NULL,
    tanggal DATE NOT NULL,
    jam_masuk TIME,
    jam_keluar TIME,
    status ENUM('hadir', 'izin', 'sakit', 'alpa') DEFAULT 'hadir',
    keterangan TEXT,
    semester ENUM('1', '2') NOT NULL,
    tahun_akademik VARCHAR(9) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa_sma(id) ON DELETE CASCADE
);

-- Tabel Organisasi Siswa SMA
CREATE TABLE organisasi_sma (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_organisasi VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    ketua_id BIGINT,
    wakil_ketua_id BIGINT,
    sekretaris_id BIGINT,
    bendahara_id BIGINT,
    anggota JSON,
    program_kerja JSON,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ketua_id) REFERENCES siswa_sma(id) ON DELETE SET NULL,
    FOREIGN KEY (wakil_ketua_id) REFERENCES siswa_sma(id) ON DELETE SET NULL,
    FOREIGN KEY (sekretaris_id) REFERENCES siswa_sma(id) ON DELETE SET NULL,
    FOREIGN KEY (bendahara_id) REFERENCES siswa_sma(id) ON DELETE SET NULL
);

-- Tabel Program Kesiswaan SMA
CREATE TABLE program_kesiswaan_sma (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_program VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    kategori ENUM('organisasi_siswa', 'persiapan_kuliah', 'kepemimpinan_lanjutan') NOT NULL,
    target_siswa JSON,
    durasi INT,
    penanggung_jawab_id BIGINT,
    status ENUM('active', 'inactive', 'completed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (penanggung_jawab_id) REFERENCES users_sma(id) ON DELETE SET NULL
);

-- Tabel Penilaian Karakter SMA
CREATE TABLE penilaian_karakter_sma (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_siswa BIGINT NOT NULL,
    id_program_kesiswaan BIGINT,
    aspek_karakter ENUM('jujur', 'disiplin', 'tanggung_jawab', 'santun', 'peduli', 'percaya_diri', 'kreatif', 'mandiri') NOT NULL,
    nilai_karakter ENUM('A', 'B', 'C', 'D') NOT NULL,
    deskripsi TEXT,
    tanggal_penilaian DATE NOT NULL,
    penilai_id BIGINT NOT NULL,
    semester ENUM('1', '2') NOT NULL,
    tahun_akademik VARCHAR(9) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa_sma(id) ON DELETE CASCADE,
    FOREIGN KEY (id_program_kesiswaan) REFERENCES program_kesiswaan_sma(id) ON DELETE SET NULL,
    FOREIGN KEY (penilai_id) REFERENCES users_sma(id) ON DELETE CASCADE
);
```

### **B. INDEXES SMA:**
```sql
-- Indexes untuk performa optimal
CREATE INDEX idx_siswa_sma_status ON siswa_sma(status);
CREATE INDEX idx_siswa_sma_kelas ON siswa_sma(kelas);
CREATE INDEX idx_presensi_sma_tanggal ON presensi_sma(tanggal);
CREATE INDEX idx_presensi_sma_siswa_tanggal ON presensi_sma(id_siswa, tanggal);
CREATE INDEX idx_organisasi_sma_status ON organisasi_sma(status);
CREATE INDEX idx_penilaian_karakter_sma_siswa ON penilaian_karakter_sma(id_siswa, semester, tahun_akademik);

-- Partial indexes
CREATE INDEX idx_siswa_sma_aktif ON siswa_sma(id_user) WHERE status = 'active';
CREATE INDEX idx_presensi_sma_hadir ON presensi_sma(id_siswa, tanggal) WHERE status = 'hadir';
```

---

## 🔧 **DATABASE SMK (SEKOLAH MENENGAH KEJURUAN)**

### **A. TABEL UTAMA:**
```sql
USE siska_smk;

-- Tabel Users SMK
CREATE TABLE users_smk (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    jenis_user ENUM('admin', 'guru', 'siswa', 'orang_tua') NOT NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Siswa SMK
CREATE TABLE siswa_smk (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_user BIGINT NOT NULL,
    nis VARCHAR(20) UNIQUE,
    nisn VARCHAR(20) UNIQUE,
    nama VARCHAR(255) NOT NULL,
    kelas ENUM('X', 'XI', 'XII') NOT NULL,
    tanggal_lahir DATE,
    jenis_kelamin ENUM('L', 'P'),
    alamat TEXT,
    telepon VARCHAR(20),
    nama_orang_tua VARCHAR(255),
    telepon_orang_tua VARCHAR(20),
    status ENUM('active', 'inactive', 'lulus', 'pindah') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users_smk(id) ON DELETE CASCADE
);

-- Tabel Presensi SMK
CREATE TABLE presensi_smk (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_siswa BIGINT NOT NULL,
    tanggal DATE NOT NULL,
    jam_masuk TIME,
    jam_keluar TIME,
    status ENUM('hadir', 'izin', 'sakit', 'alpa') DEFAULT 'hadir',
    keterangan TEXT,
    semester ENUM('1', '2') NOT NULL,
    tahun_akademik VARCHAR(9) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa_smk(id) ON DELETE CASCADE
);

-- Tabel Program Kejuruan SMK
CREATE TABLE kejuruan_smk (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_kejuruan VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    kompetensi JSON,
    magang_industri JSON,
    sertifikasi JSON,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Siswa Kejuruan SMK
CREATE TABLE siswa_kejuruan_smk (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_siswa BIGINT NOT NULL,
    id_kejuruan BIGINT NOT NULL,
    tanggal_daftar DATE NOT NULL,
    status ENUM('active', 'inactive', 'lulus') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa_smk(id) ON DELETE CASCADE,
    FOREIGN KEY (id_kejuruan) REFERENCES kejuruan_smk(id) ON DELETE CASCADE
);

-- Tabel Program Kesiswaan SMK
CREATE TABLE program_kesiswaan_smk (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_program VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    kategori ENUM('kejuruan', 'magang_industri', 'sertifikasi') NOT NULL,
    target_siswa JSON,
    durasi INT,
    penanggung_jawab_id BIGINT,
    status ENUM('active', 'inactive', 'completed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (penanggung_jawab_id) REFERENCES users_smk(id) ON DELETE SET NULL
);

-- Tabel Penilaian Karakter SMK
CREATE TABLE penilaian_karakter_smk (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_siswa BIGINT NOT NULL,
    id_program_kesiswaan BIGINT,
    aspek_karakter ENUM('jujur', 'disiplin', 'tanggung_jawab', 'santun', 'peduli', 'percaya_diri', 'kreatif', 'mandiri', 'kerja_sama') NOT NULL,
    nilai_karakter ENUM('A', 'B', 'C', 'D') NOT NULL,
    deskripsi TEXT,
    tanggal_penilaian DATE NOT NULL,
    penilai_id BIGINT NOT NULL,
    semester ENUM('1', '2') NOT NULL,
    tahun_akademik VARCHAR(9) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa_smk(id) ON DELETE CASCADE,
    FOREIGN KEY (id_program_kesiswaan) REFERENCES program_kesiswaan_smk(id) ON DELETE SET NULL,
    FOREIGN KEY (penilai_id) REFERENCES users_smk(id) ON DELETE CASCADE
);
```

### **B. INDEXES SMK:**
```sql
-- Indexes untuk performa optimal
CREATE INDEX idx_siswa_smk_status ON siswa_smk(status);
CREATE INDEX idx_siswa_smk_kelas ON siswa_smk(kelas);
CREATE INDEX idx_presensi_smk_tanggal ON presensi_smk(tanggal);
CREATE INDEX idx_presensi_smk_siswa_tanggal ON presensi_smk(id_siswa, tanggal);
CREATE INDEX idx_kejuruan_smk_status ON kejuruan_smk(status);
CREATE INDEX idx_siswa_kejuruan_smk_siswa ON siswa_kejuruan_smk(id_siswa);
CREATE INDEX idx_penilaian_karakter_smk_siswa ON penilaian_karakter_smk(id_siswa, semester, tahun_akademik);

-- Partial indexes
CREATE INDEX idx_siswa_smk_aktif ON siswa_smk(id_user) WHERE status = 'active';
CREATE INDEX idx_presensi_smk_hadir ON presensi_smk(id_siswa, tanggal) WHERE status = 'hadir';
```

---

## 🔧 **DATABASE CORE (SHARED)**

### **A. TABEL UTAMA:**
```sql
USE siska_core;

-- Tabel License Management
CREATE TABLE license_management (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    license_key VARCHAR(255) UNIQUE NOT NULL,
    license_type ENUM('single', 'multi') NOT NULL,
    jenjang_aktif JSON,
    expiry_date DATE NOT NULL,
    status ENUM('active', 'inactive', 'expired') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel sekolah Profile
CREATE TABLE sekolah_profile (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_sekolah VARCHAR(255) NOT NULL,
    jenis_sekolah ENUM('negeri', 'swasta', 'yayasan') NOT NULL,
    alamat TEXT,
    telepon VARCHAR(20),
    email VARCHAR(255),
    website VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Tahun Akademik
CREATE TABLE tahun_akademik (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    tahun_akademik VARCHAR(9) NOT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    semester_aktif ENUM('1', '2') DEFAULT '1',
    status ENUM('active', 'inactive', 'closed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Semester
CREATE TABLE semester (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_tahun_akademik BIGINT NOT NULL,
    semester ENUM('1', '2') NOT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    status ENUM('active', 'inactive', 'closed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_tahun_akademik) REFERENCES tahun_akademik(id) ON DELETE CASCADE
);
```

### **B. INDEXES CORE:**
```sql
-- Indexes untuk performa optimal
CREATE INDEX idx_license_management_status ON license_management(status);
CREATE INDEX idx_license_management_type ON license_management(license_type);
CREATE INDEX idx_sekolah_profile_status ON sekolah_profile(status);
CREATE INDEX idx_tahun_akademik_status ON tahun_akademik(status);
CREATE INDEX idx_semester_tahun_akademik ON semester(id_tahun_akademik);

-- Partial indexes
CREATE INDEX idx_license_management_aktif ON license_management(license_key) WHERE status = 'active';
CREATE INDEX idx_tahun_akademik_aktif ON tahun_akademik(tahun_akademik) WHERE status = 'active';
```

---

## 🌐 **DATABASE PUBLIC/CONTENT (SHARED)**

### **A. TABEL UTAMA:**
```sql
USE siska_public;

-- Tabel Postingan Umum
CREATE TABLE postingan_umum (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    konten LONGTEXT NOT NULL,
    kategori ENUM('admin', 'guru', 'siswa', 'umum') NOT NULL,
    subkategori VARCHAR(100),
    tag JSON,
    lampiran JSON,
    peran_penulis ENUM('admin', 'guru', 'siswa') NOT NULL,
    id_penulis BIGINT NOT NULL,
    tanggal_publikasi TIMESTAMP NULL,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Program
CREATE TABLE program (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    kategori ENUM('akademik', 'non_akademik', 'organisasi', 'kejuruan') NOT NULL,
    tanggal_mulai DATE,
    tanggal_selesai DATE,
    tujuan JSON,
    peran_penanggung_jawab ENUM('admin', 'guru', 'siswa') NOT NULL,
    id_penanggung_jawab BIGINT NOT NULL,
    komponen JSON,
    status_penyelesaian ENUM('pending', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    persentase_penyelesaian INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Komponen Program
CREATE TABLE komponen_program (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    program_id BIGINT NOT NULL,
    nama VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    status ENUM('pending', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    tanggal_mulai DATE,
    tanggal_selesai DATE,
    is_required BOOLEAN DEFAULT TRUE,
    is_completed BOOLEAN DEFAULT FALSE,
    persentase_penyelesaian INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (program_id) REFERENCES program(id) ON DELETE CASCADE
);

-- Tabel Kegiatan Publik
CREATE TABLE kegiatan_publik (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_kegiatan VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    tempat VARCHAR(255) NOT NULL,
    penanggung_jawab VARCHAR(255) NOT NULL,
    target_peserta JSON,
    status ENUM('upcoming', 'ongoing', 'completed', 'cancelled') DEFAULT 'upcoming',
    gambar_utama VARCHAR(255),
    galeri_gambar JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Audit Konten
CREATE TABLE audit_konten (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT NOT NULL,
    event ENUM('created', 'updated', 'deleted', 'reviewed', 'published') NOT NULL,
    user_id BIGINT,
    old_values JSON,
    new_values JSON,
    catatan TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Galeri
CREATE TABLE galeri (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_galeri VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    kategori ENUM('kegiatan', 'prestasi', 'sekolah', 'umum') NOT NULL,
    gambar_utama VARCHAR(255),
    gambar_galeri JSON,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Pengumuman
CREATE TABLE pengumuman (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    konten LONGTEXT NOT NULL,
    kategori ENUM('penting', 'umum', 'kegiatan', 'akademik') NOT NULL,
    target_audience JSON,
    tanggal_mulai TIMESTAMP,
    tanggal_selesai TIMESTAMP,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    peran_penulis ENUM('admin', 'guru', 'siswa') NOT NULL,
    id_penulis BIGINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### **B. INDEXES PUBLIC:**
```sql
-- Indexes untuk performa optimal
CREATE INDEX idx_postingan_umum_status ON postingan_umum(status);
CREATE INDEX idx_postingan_umum_kategori ON postingan_umum(kategori);
CREATE INDEX idx_postingan_umum_tanggal ON postingan_umum(tanggal_publikasi);
CREATE INDEX idx_program_status ON program(status_penyelesaian);
CREATE INDEX idx_program_kategori ON program(kategori);
CREATE INDEX idx_komponen_program_program ON komponen_program(program_id);
CREATE INDEX idx_kegiatan_publik_status ON kegiatan_publik(status);
CREATE INDEX idx_kegiatan_publik_tanggal ON kegiatan_publik(tanggal_mulai);
CREATE INDEX idx_audit_konten_model ON audit_konten(model_type, model_id);
CREATE INDEX idx_galeri_status ON galeri(status);
CREATE INDEX idx_galeri_kategori ON galeri(kategori);
CREATE INDEX idx_pengumuman_status ON pengumuman(status);
CREATE INDEX idx_pengumuman_kategori ON pengumuman(kategori);

-- Partial indexes
CREATE INDEX idx_postingan_umum_published ON postingan_umum(tanggal_publikasi) WHERE status = 'published';
CREATE INDEX idx_program_active ON program(id) WHERE status_penyelesaian = 'in_progress';
CREATE INDEX idx_kegiatan_publik_upcoming ON kegiatan_publik(tanggal_mulai) WHERE status = 'upcoming';
CREATE INDEX idx_pengumuman_published ON pengumuman(tanggal_mulai) WHERE status = 'published';
```

---

## 🔗 **KONFIGURASI DATABASE CONNECTION**

### **A. Laravel Database Configuration:**
```php
// config/database.php
'connections' => [
    'mysql_sd' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE_SD', 'siska_sd'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ],
    
    'mysql_smp' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE_SMP', 'siska_smp'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ],
    
    'mysql_sma' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE_SMA', 'siska_sma'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ],
    
    'mysql_smk' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE_SMK', 'siska_smk'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ],
    
    'mysql_core' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE_CORE', 'siska_core'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ],
    
    'mysql_public' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE_PUBLIC', 'siska_public'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ],
],
```

---

## 🎯 **KEUNTUNGAN SKEMA ISOLATED:**

1. **Complete Isolation**: Tidak ada konflik antar jenjang
2. **Independent Scaling**: Setiap jenjang dapat di-scale secara independen
3. **License-Based Access**: Akses database berdasarkan lisensi
4. **Modular Installation**: Install hanya database yang diperlukan
5. **Data Integrity**: Konsistensi data dalam setiap database
6. **Performance**: Query lebih cepat karena data terpisah
7. **Security**: Isolasi data per jenjang
8. **Maintenance**: Maintenance per database terpisah
9. **Content Separation**: Pemisahan konten publik dari data internal
10. **Public Access**: Database public dapat diakses tanpa autentikasi

---

## 🚀 **IMPLEMENTASI BERKELANJUTAN:**

1. **Phase 1**: Buat database terpisah per jenjang (SD, SMP, SMA, SMK, Core, Public)
2. **Phase 2**: Implementasi migration per jenjang dan database public
3. **Phase 3**: Buat model per jenjang dan model public
4. **Phase 4**: Implementasi service per jenjang dan service public
5. **Phase 5**: Implementasi API public untuk konten
6. **Phase 6**: Testing dan optimisasi
