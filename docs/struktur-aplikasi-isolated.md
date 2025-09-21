# 🏗️ **STRUKTUR APLIKASI ISOLATED MULTI-JENJANG**

## 📋 **INFORMASI PROYEK**

**SISKA** (Sistem Informasi Sekolah Bidang Kesiswaan)  
**Pengembang**: [jejakawan.com](https://jejakawan.com)  
**GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)  
**Supported by**: **K2NET** - PT. Kirana Karina Network  
*"Provide Different IT Solutions"*

## 🎯 **OVERVIEW STRATEGI STRUKTUR ISOLATED**

### **PRINSIP DASAR:**
1. **Complete Isolation**: Setiap jenjang adalah aplikasi terpisah
2. **Shared Core Only**: Hanya core system yang shared
3. **License-Based Modules**: Modul diaktifkan berdasarkan lisensi
4. **Modular Installation**: Install hanya yang diperlukan
5. **Independent Deployment**: Deploy per jenjang secara independen

---

## 🔧 **STRUKTUR APLIKASI ISOLATED**

### **A. STRUKTUR FOLDER UTAMA:**
```
kesiswaan/
├── core/                          # Shared core system
│   ├── app/
│   │   ├── Console/
│   │   ├── Events/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── Core/          # Core controllers
│   │   │   │   ├── License/       # License management
│   │   │   │   └── Public/        # Public content controllers
│   │   │   ├── Middleware/
│   │   │   │   ├── Core/          # Core middleware
│   │   │   │   ├── License/       # License middleware
│   │   │   │   └── Public/        # Public middleware
│   │   │   ├── Requests/
│   │   │   │   ├── Core/          # Core requests
│   │   │   │   └── Public/        # Public requests
│   │   │   └── Resources/
│   │   │       ├── Core/          # Core resources
│   │   │       └── Public/        # Public resources
│   │   ├── Models/
│   │   │   ├── Core/              # Core models
│   │   │   └── Public/            # Public models
│   │   ├── Services/
│   │   │   ├── Core/              # Core services
│   │   │   ├── License/           # License services
│   │   │   └── Public/            # Public services
│   │   └── Traits/
│   │       ├── Core/              # Core traits
│   │       └── Public/            # Public traits
│   ├── config/
│   │   ├── core.php               # Core configuration
│   │   ├── license.php            # License configuration
│   │   ├── public.php             # Public configuration
│   │   └── database.php           # Database configuration
│   ├── database/
│   │   ├── migrations/
│   │   │   ├── core/              # Core migrations
│   │   │   └── public/            # Public migrations
│   │   └── seeders/
│   │       ├── core/              # Core seeders
│   │       └── public/            # Public seeders
│   └── routes/
│       ├── api.php
│       ├── web.php
│       ├── license.php            # License routes
│       └── public.php             # Public routes
├── jenjang/                       # Isolated jenjang modules
│   ├── sd/                        # SD Module (Complete)
│   │   ├── app/
│   │   │   ├── Http/
│   │   │   │   ├── Controllers/
│   │   │   │   │   ├── SiswaController.php
│   │   │   │   │   ├── PresensiController.php
│   │   │   │   │   ├── KreditPoinController.php
│   │   │   │   │   └── ProgramKesiswaanController.php
│   │   │   │   ├── Requests/
│   │   │   │   │   ├── SiswaRequest.php
│   │   │   │   │   ├── PresensiRequest.php
│   │   │   │   │   └── KreditPoinRequest.php
│   │   │   │   └── Resources/
│   │   │   │       ├── SiswaResource.php
│   │   │   │       ├── PresensiResource.php
│   │   │   │       └── KreditPoinResource.php
│   │   │   ├── Models/
│   │   │   │   ├── SiswaSD.php
│   │   │   │   ├── PresensiSD.php
│   │   │   │   ├── KreditPoinSD.php
│   │   │   │   └── ProgramKesiswaanSD.php
│   │   │   ├── Services/
│   │   │   │   ├── SiswaSDService.php
│   │   │   │   ├── PresensiSDService.php
│   │   │   │   ├── KreditPoinSDService.php
│   │   │   │   └── ProgramKesiswaanSDService.php
│   │   │   └── Traits/
│   │   │       └── SDTrait.php
│   │   ├── config/
│   │   │   └── sd.php             # SD configuration
│   │   ├── database/
│   │   │   ├── migrations/
│   │   │   │   ├── create_users_sd_table.php
│   │   │   │   ├── create_siswa_sd_table.php
│   │   │   │   ├── create_presensi_sd_table.php
│   │   │   │   ├── create_kredit_poin_sd_table.php
│   │   │   │   └── create_program_kesiswaan_sd_table.php
│   │   │   └── seeders/
│   │   │       ├── SDSeeder.php
│   │   │       ├── SiswaSDSeeder.php
│   │   │       └── ProgramKesiswaanSDSeeder.php
│   │   ├── routes/
│   │   │   ├── api.php
│   │   │   └── web.php
│   │   └── resources/
│   │       ├── views/
│   │       │   ├── siswa/
│   │       │   ├── presensi/
│   │       │   ├── kredit-poin/
│   │       │   └── program-kesiswaan/
│   │       └── assets/
│   │           ├── css/
│   │           ├── js/
│   │           └── images/
│   ├── smp/                       # SMP Module (Complete)
│   │   ├── app/
│   │   │   ├── Http/
│   │   │   │   ├── Controllers/
│   │   │   │   │   ├── SiswaController.php
│   │   │   │   │   ├── PresensiController.php
│   │   │   │   │   ├── EkstrakurikulerController.php
│   │   │   │   │   └── ProgramKesiswaanController.php
│   │   │   │   ├── Requests/
│   │   │   │   │   ├── SiswaRequest.php
│   │   │   │   │   ├── PresensiRequest.php
│   │   │   │   │   └── EkstrakurikulerRequest.php
│   │   │   │   └── Resources/
│   │   │   │       ├── SiswaResource.php
│   │   │   │       ├── PresensiResource.php
│   │   │   │       └── EkstrakurikulerResource.php
│   │   │   ├── Models/
│   │   │   │   ├── SiswaSMP.php
│   │   │   │   ├── PresensiSMP.php
│   │   │   │   ├── EkstrakurikulerSMP.php
│   │   │   │   └── ProgramKesiswaanSMP.php
│   │   │   ├── Services/
│   │   │   │   ├── SiswaSMPService.php
│   │   │   │   ├── PresensiSMPService.php
│   │   │   │   ├── EkstrakurikulerSMPService.php
│   │   │   │   └── ProgramKesiswaanSMPService.php
│   │   │   └── Traits/
│   │   │       └── SMPTrait.php
│   │   ├── config/
│   │   │   └── smp.php            # SMP configuration
│   │   ├── database/
│   │   │   ├── migrations/
│   │   │   │   ├── create_users_smp_table.php
│   │   │   │   ├── create_siswa_smp_table.php
│   │   │   │   ├── create_presensi_smp_table.php
│   │   │   │   ├── create_ekstrakurikuler_smp_table.php
│   │   │   │   └── create_program_kesiswaan_smp_table.php
│   │   │   └── seeders/
│   │   │       ├── SMPSeeder.php
│   │   │       ├── SiswaSMPSeeder.php
│   │   │       └── EkstrakurikulerSMPSeeder.php
│   │   ├── routes/
│   │   │   ├── api.php
│   │   │   └── web.php
│   │   └── resources/
│   │       ├── views/
│   │       │   ├── siswa/
│   │       │   ├── presensi/
│   │       │   ├── ekstrakurikuler/
│   │       │   └── program-kesiswaan/
│   │       └── assets/
│   │           ├── css/
│   │           ├── js/
│   │           └── images/
│   ├── sma/                       # SMA Module (Complete)
│   │   ├── app/
│   │   │   ├── Http/
│   │   │   │   ├── Controllers/
│   │   │   │   │   ├── SiswaController.php
│   │   │   │   │   ├── PresensiController.php
│   │   │   │   │   ├── OrganisasiController.php
│   │   │   │   │   └── ProgramKesiswaanController.php
│   │   │   │   ├── Requests/
│   │   │   │   │   ├── SiswaRequest.php
│   │   │   │   │   ├── PresensiRequest.php
│   │   │   │   │   └── OrganisasiRequest.php
│   │   │   │   └── Resources/
│   │   │   │       ├── SiswaResource.php
│   │   │   │       ├── PresensiResource.php
│   │   │   │       └── OrganisasiResource.php
│   │   │   ├── Models/
│   │   │   │   ├── SiswaSMA.php
│   │   │   │   ├── PresensiSMA.php
│   │   │   │   ├── OrganisasiSMA.php
│   │   │   │   └── ProgramKesiswaanSMA.php
│   │   │   ├── Services/
│   │   │   │   ├── SiswaSMAService.php
│   │   │   │   ├── PresensiSMAService.php
│   │   │   │   ├── OrganisasiSMAService.php
│   │   │   │   └── ProgramKesiswaanSMAService.php
│   │   │   └── Traits/
│   │   │       └── SMATrait.php
│   │   ├── config/
│   │   │   └── sma.php            # SMA configuration
│   │   ├── database/
│   │   │   ├── migrations/
│   │   │   │   ├── create_users_sma_table.php
│   │   │   │   ├── create_siswa_sma_table.php
│   │   │   │   ├── create_presensi_sma_table.php
│   │   │   │   ├── create_organisasi_sma_table.php
│   │   │   │   └── create_program_kesiswaan_sma_table.php
│   │   │   └── seeders/
│   │   │       ├── SMASeeder.php
│   │   │       ├── SiswaSMASeeder.php
│   │   │       └── OrganisasiSMASeeder.php
│   │   ├── routes/
│   │   │   ├── api.php
│   │   │   └── web.php
│   │   └── resources/
│   │       ├── views/
│   │       │   ├── siswa/
│   │       │   ├── presensi/
│   │       │   ├── organisasi/
│   │       │   └── program-kesiswaan/
│   │       └── assets/
│   │           ├── css/
│   │           ├── js/
│   │           └── images/
│   └── smk/                       # SMK Module (Complete)
│       ├── app/
│       │   ├── Http/
│       │   │   ├── Controllers/
│       │   │   │   ├── SiswaController.php
│       │   │   │   ├── PresensiController.php
│       │   │   │   ├── KejuruanController.php
│       │   │   │   └── ProgramKesiswaanController.php
│       │   │   ├── Requests/
│       │   │   │   ├── SiswaRequest.php
│       │   │   │   ├── PresensiRequest.php
│       │   │   │   └── KejuruanRequest.php
│       │   │   └── Resources/
│       │   │       ├── SiswaResource.php
│       │   │       ├── PresensiResource.php
│       │   │       └── KejuruanResource.php
│       │   ├── Models/
│       │   │   ├── SiswaSMK.php
│       │   │   ├── PresensiSMK.php
│       │   │   ├── KejuruanSMK.php
│       │   │   └── ProgramKesiswaanSMK.php
│       │   ├── Services/
│       │   │   ├── SiswaSMKService.php
│       │   │   ├── PresensiSMKService.php
│       │   │   ├── KejuruanSMKService.php
│       │   │   └── ProgramKesiswaanSMKService.php
│       │   └── Traits/
│       │       └── SMKTrait.php
│       ├── config/
│       │   └── smk.php            # SMK configuration
│       ├── database/
│       │   ├── migrations/
│       │   │   ├── create_users_smk_table.php
│       │   │   ├── create_siswa_smk_table.php
│       │   │   ├── create_presensi_smk_table.php
│       │   │   ├── create_kejuruan_smk_table.php
│       │   │   └── create_program_kesiswaan_smk_table.php
│       │   └── seeders/
│       │       ├── SMKSeeder.php
│       │       ├── SiswaSMKSeeder.php
│       │       └── KejuruanSMKSeeder.php
│       ├── routes/
│       │   ├── api.php
│       │   └── web.php
│       └── resources/
│           ├── views/
│           │   ├── siswa/
│           │   ├── presensi/
│           │   ├── kejuruan/
│           │   └── program-kesiswaan/
│           └── assets/
│               ├── css/
│               ├── js/
│               └── images/
├── installer/                     # Installation wizard
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── InstallationController.php
│   │   │   │   ├── LicenseController.php
│   │   │   │   └── WizardController.php
│   │   │   ├── Requests/
│   │   │   │   ├── InstallationRequest.php
│   │   │   │   └── LicenseRequest.php
│   │   │   └── Resources/
│   │   │       └── InstallationResource.php
│   │   ├── Models/
│   │   │   ├── Installation.php
│   │   │   └── License.php
│   │   └── Services/
│   │       ├── InstallationService.php
│   │       ├── LicenseService.php
│   │       └── WizardService.php
│   ├── config/
│   │   └── installer.php          # Installer configuration
│   ├── database/
│   │   ├── migrations/
│   │   │   ├── create_installations_table.php
│   │   │   └── create_licenses_table.php
│   │   └── seeders/
│   │       └── InstallerSeeder.php
│   ├── routes/
│   │   ├── api.php
│   │   └── web.php
│   └── resources/
│       ├── views/
│       │   ├── wizard/
│       │   │   ├── step1.blade.php
│       │   │   ├── step2.blade.php
│       │   │   ├── step3.blade.php
│       │   │   ├── step4.blade.php
│       │   │   └── step5.blade.php
│       │   └── layouts/
│       │       └── installer.blade.php
│       └── assets/
│           ├── css/
│           ├── js/
│           └── images/
├── shared/                        # Shared resources
│   ├── assets/
│   │   ├── css/
│   │   │   ├── core.css
│   │   │   └── components.css
│   │   ├── js/
│   │   │   ├── core.js
│   │   │   └── components.js
│   │   └── images/
│   │       ├── logos/
│   │       └── icons/
│   ├── translations/
│   │   ├── id/
│   │   │   ├── core.php
│   │   │   ├── sd.php
│   │   │   ├── smp.php
│   │   │   ├── sma.php
│   │   │   └── smk.php
│   │   └── en/
│   │       ├── core.php
│   │       ├── sd.php
│   │       ├── smp.php
│   │       ├── sma.php
│   │       └── smk.php
│   └── templates/
│       ├── email/
│       │   ├── welcome.blade.php
│       │   ├── notification.blade.php
│       │   └── report.blade.php
│       └── pdf/
│           ├── report.blade.php
│           └── certificate.blade.php
└── frontend/                      # Frontend application
    ├── src/
    │   ├── components/
    │   │   ├── core/              # Core components
    │   │   │   ├── layout/
    │   │   │   ├── forms/
    │   │   │   └── ui/
    │   │   ├── jenjang/           # Jenjang-specific components
    │   │   │   ├── sd/
    │   │   │   ├── smp/
    │   │   │   ├── sma/
    │   │   │   └── smk/
    │   │   └── installer/         # Installer components
    │   │       ├── wizard/
    │   │       └── steps/
    │   ├── views/
    │   │   ├── core/              # Core views
    │   │   ├── jenjang/           # Jenjang-specific views
    │   │   │   ├── sd/
    │   │   │   ├── smp/
    │   │   │   ├── sma/
    │   │   │   └── smk/
    │   │   └── installer/         # Installer views
    │   ├── stores/
    │   │   ├── core/              # Core stores
    │   │   ├── jenjang/           # Jenjang-specific stores
    │   │   └── license/           # License stores
    │   ├── services/
    │   │   ├── core/              # Core services
    │   │   ├── jenjang/           # Jenjang-specific services
    │   │   └── license/           # License services
    │   ├── composables/
    │   │   ├── core/              # Core composables
    │   │   ├── jenjang/           # Jenjang-specific composables
    │   │   └── license/           # License composables
    │   └── utils/
    │       ├── core/              # Core utilities
    │       ├── jenjang/           # Jenjang-specific utilities
    │       └── license/           # License utilities
    ├── public/
    │   ├── index.html
    │   ├── favicon.ico
    │   └── assets/
    └── package.json
```

---

## 🔧 **IMPLEMENTASI STRUKTUR ISOLATED**

### **A. Core System (Shared):**

#### **Core Models:**
```php
// core/app/Models/Core/BaseModel.php
<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $connection = 'mysql_core';
    
    protected $guarded = [];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

// core/app/Models/Core/License.php
<?php

namespace App\Models\Core;

class License extends BaseModel
{
    protected $table = 'license_management';
    
    protected $fillable = [
        'license_key',
        'license_type',
        'jenjang_aktif',
        'expiry_date',
        'status',
    ];
    
    protected $casts = [
        'jenjang_aktif' => 'array',
        'expiry_date' => 'date',
    ];
    
    public function isActive()
    {
        return $this->status === 'active' && $this->expiry_date > now();
    }
    
    public function isSingle()
    {
        return $this->license_type === 'single';
    }
    
    public function isMulti()
    {
        return $this->license_type === 'multi';
    }
    
    public function hasAccessTo($jenjang)
    {
        if ($this->isSingle()) {
            return $this->jenjang_aktif === $jenjang;
        }
        
        return in_array($jenjang, $this->jenjang_aktif);
    }
}

// core/app/Models/Core/sekolahProfile.php
<?php

namespace App\Models\Core;

class sekolahProfile extends BaseModel
{
    protected $table = 'sekolah_profile';
    
    protected $fillable = [
        'nama_sekolah',
        'jenis_sekolah',
        'alamat',
        'telepon',
        'email',
        'website',
        'status',
    ];
    
    public function isActive()
    {
        return $this->status === 'active';
    }
}

// core/app/Models/Public/PostinganUmum.php
<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Model;

class PostinganUmum extends Model
{
    protected $connection = 'mysql_public';
    protected $table = 'postingan_umum';
    
    protected $fillable = [
        'judul',
        'konten',
        'kategori',
        'subkategori',
        'tag',
        'lampiran',
        'peran_penulis',
        'id_penulis',
        'tanggal_publikasi',
        'status',
    ];
    
    protected $casts = [
        'tag' => 'array',
        'lampiran' => 'array',
        'tanggal_publikasi' => 'datetime',
    ];
    
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('tanggal_publikasi')
                    ->where('tanggal_publikasi', '<=', now());
    }
    
    public function scopeByCategory($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
    
    public function getExcerptAttribute()
    {
        return \Str::limit(strip_tags($this->konten), 150);
    }
    
    public function getFormattedTagsAttribute()
    {
        return is_array($this->tag) ? implode(', ', $this->tag) : $this->tag;
    }
    
    public function isPublished()
    {
        return $this->status === 'published' && 
               $this->tanggal_publikasi && 
               $this->tanggal_publikasi <= now();
    }
}

// core/app/Models/Public/Program.php
<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $connection = 'mysql_public';
    protected $table = 'program';
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'kategori',
        'tanggal_mulai',
        'tanggal_selesai',
        'tujuan',
        'peran_penanggung_jawab',
        'id_penanggung_jawab',
        'komponen',
        'status_penyelesaian',
        'persentase_penyelesaian',
    ];
    
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tujuan' => 'array',
        'komponen' => 'array',
        'status_penyelesaian' => 'array',
    ];
    
    public function scopeByCategory($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
    
    public function scopeByResponsible($query, $peran, $id)
    {
        return $query->where('peran_penanggung_jawab', $peran)
                    ->where('id_penanggung_jawab', $id);
    }
    
    public function getDurationAttribute()
    {
        if ($this->tanggal_mulai && $this->tanggal_selesai) {
            return $this->tanggal_mulai->diffInDays($this->tanggal_selesai);
        }
        return null;
    }
    
    public function getIsActiveAttribute()
    {
        $now = now();
        return $this->tanggal_mulai <= $now && $this->tanggal_selesai >= $now;
    }
    
    public function getFormattedObjectivesAttribute()
    {
        return is_array($this->tujuan) ? implode(', ', $this->tujuan) : $this->tujuan;
    }
    
    public function updateCompletionStatus()
    {
        $totalKomponen = count($this->komponen ?? []);
        if ($totalKomponen > 0) {
            $completedKomponen = collect($this->komponen)
                ->where('status', 'completed')
                ->count();
            
            $this->persentase_penyelesaian = round(($completedKomponen / $totalKomponen) * 100);
            $this->save();
        }
    }
}
```

#### **Core Services:**
```php
// core/app/Services/Core/LicenseService.php
<?php

namespace App\Services\Core;

use App\Models\Core\License;
use Illuminate\Support\Facades\Cache;

class LicenseService
{
    public function getActiveLicense()
    {
        return Cache::remember('active_license', 3600, function () {
            return License::where('status', 'active')
                ->where('expiry_date', '>', now())
                ->first();
        });
    }
    
    public function validateLicense($licenseKey)
    {
        $license = License::where('license_key', $licenseKey)->first();
        
        if (!$license) {
            throw new \Exception('License key tidak valid');
        }
        
        if (!$license->isActive()) {
            throw new \Exception('License sudah expired atau tidak aktif');
        }
        
        return $license;
    }
    
    public function getActiveModules()
    {
        $license = $this->getActiveLicense();
        
        if (!$license) {
            return [];
        }
        
        if ($license->isSingle()) {
            return [$license->jenjang_aktif];
        }
        
        return $license->jenjang_aktif;
    }
    
    public function hasAccessTo($jenjang)
    {
        $license = $this->getActiveLicense();
        
        if (!$license) {
            return false;
        }
        
        return $license->hasAccessTo($jenjang);
    }
    
    public function clearCache()
    {
        Cache::forget('active_license');
    }
}

// core/app/Services/Public/PublicContentService.php
<?php

namespace App\Services\Public;

use App\Models\Public\PostinganUmum;
use App\Models\Public\Program;
use App\Models\Public\KegiatanPublik;
use App\Models\Public\Galeri;
use App\Models\Public\Pengumuman;
use Illuminate\Support\Facades\Cache;

class PublicContentService
{
    public function getFeaturedContent($limit = 5)
    {
        return Cache::remember('featured_content', 1800, function () use ($limit) {
            return [
                'postingan' => PostinganUmum::published()
                    ->orderBy('tanggal_publikasi', 'desc')
                    ->limit($limit)
                    ->get(),
                'program' => Program::where('status_penyelesaian', 'in_progress')
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get(),
                'kegiatan' => KegiatanPublik::where('status', 'upcoming')
                    ->orderBy('tanggal_mulai', 'asc')
                    ->limit($limit)
                    ->get(),
            ];
        });
    }
    
    public function getNewsByCategory($kategori, $limit = 10)
    {
        return PostinganUmum::published()
            ->byCategory($kategori)
            ->orderBy('tanggal_publikasi', 'desc')
            ->paginate($limit);
    }
    
    public function getActivePrograms($kategori = null)
    {
        $query = Program::where('status_penyelesaian', 'in_progress');
        
        if ($kategori) {
            $query->byCategory($kategori);
        }
        
        return $query->orderBy('tanggal_mulai', 'desc')->get();
    }
    
    public function getUpcomingEvents($limit = 5)
    {
        return KegiatanPublik::where('status', 'upcoming')
            ->where('tanggal_mulai', '>=', now())
            ->orderBy('tanggal_mulai', 'asc')
            ->limit($limit)
            ->get();
    }
    
    public function getGalleryByCategory($kategori, $limit = 12)
    {
        return Galeri::where('status', 'active')
            ->where('kategori', $kategori)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
    
    public function getActiveAnnouncements($limit = 5)
    {
        return Pengumuman::where('status', 'published')
            ->where('tanggal_mulai', '<=', now())
            ->where(function($query) {
                $query->whereNull('tanggal_selesai')
                      ->orWhere('tanggal_selesai', '>=', now());
            })
            ->orderBy('tanggal_mulai', 'desc')
            ->limit($limit)
            ->get();
    }
    
    public function searchContent($keyword, $type = 'all')
    {
        $results = [];
        
        if ($type === 'all' || $type === 'postingan') {
            $results['postingan'] = PostinganUmum::published()
                ->where(function($query) use ($keyword) {
                    $query->where('judul', 'like', "%{$keyword}%")
                          ->orWhere('konten', 'like', "%{$keyword}%");
                })
                ->orderBy('tanggal_publikasi', 'desc')
                ->get();
        }
        
        if ($type === 'all' || $type === 'program') {
            $results['program'] = Program::where(function($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%")
                      ->orWhere('deskripsi', 'like', "%{$keyword}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
        }
        
        if ($type === 'all' || $type === 'kegiatan') {
            $results['kegiatan'] = KegiatanPublik::where(function($query) use ($keyword) {
                $query->where('nama_kegiatan', 'like', "%{$keyword}%")
                      ->orWhere('deskripsi', 'like', "%{$keyword}%");
            })
            ->orderBy('tanggal_mulai', 'desc')
            ->get();
        }
        
        return $results;
    }
    
    public function clearCache()
    {
        Cache::forget('featured_content');
    }
}
```

### **B. Jenjang Modules (Isolated):**

#### **SD Module Example:**
```php
// jenjang/sd/app/Models/SiswaSD.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaSD extends Model
{
    protected $connection = 'mysql_sd';
    protected $table = 'siswa_sd';
    
    protected $fillable = [
        'id_user',
        'nis',
        'nisn',
        'nama',
        'kelas',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'telepon',
        'nama_orang_tua',
        'telepon_orang_tua',
        'status',
    ];
    
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
    
    public function user()
    {
        return $this->belongsTo(UserSD::class, 'id_user');
    }
    
    public function presensi()
    {
        return $this->hasMany(PresensiSD::class, 'id_siswa');
    }
    
    public function kreditPoin()
    {
        return $this->hasMany(KreditPoinSD::class, 'id_siswa');
    }
    
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    
    public function scopeByKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }
}

// jenjang/sd/app/Services/SiswaSDService.php
<?php

namespace App\Services;

use App\Models\SiswaSD;
use App\Models\UserSD;
use Illuminate\Support\Facades\DB;

class SiswaSDService
{
    public function createSiswa($data)
    {
        return DB::connection('mysql_sd')->transaction(function () use ($data) {
            // Create user first
            $user = UserSD::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'jenis_user' => 'siswa',
                'status' => 'active',
            ]);
            
            // Create siswa
            $siswa = SiswaSD::create([
                'id_user' => $user->id,
                'nis' => $data['nis'],
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'kelas' => $data['kelas'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'alamat' => $data['alamat'],
                'telepon' => $data['telepon'],
                'nama_orang_tua' => $data['nama_orang_tua'],
                'telepon_orang_tua' => $data['telepon_orang_tua'],
                'status' => 'active',
            ]);
            
            return $siswa->load('user');
        });
    }
    
    public function getSiswa($filters = [])
    {
        $query = SiswaSD::with('user');
        
        if (isset($filters['kelas'])) {
            $query->byKelas($filters['kelas']);
        }
        
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        } else {
            $query->active();
        }
        
        return $query->paginate(20);
    }
    
    public function updateSiswa($id, $data)
    {
        $siswa = SiswaSD::findOrFail($id);
        
        $siswa->update($data);
        
        // Update user if needed
        if (isset($data['nama']) || isset($data['email'])) {
            $siswa->user->update([
                'nama' => $data['nama'] ?? $siswa->user->nama,
                'email' => $data['email'] ?? $siswa->user->email,
            ]);
        }
        
        return $siswa->load('user');
    }
    
    public function deleteSiswa($id)
    {
        $siswa = SiswaSD::findOrFail($id);
        
        // Delete user (cascade will handle siswa)
        $siswa->user->delete();
        
        return true;
    }
}
```

### **C. Frontend Structure (Isolated):**

#### **Vue Components:**
```vue
<!-- frontend/src/components/jenjang/sd/SiswaSD.vue -->
<template>
    <div class="siswa-sd">
        <div class="header">
            <h2>Data Siswa SD</h2>
            <button @click="showCreateModal = true" class="btn-primary">
                Tambah Siswa
            </button>
        </div>
        
        <div class="filters">
            <select v-model="filters.kelas" @change="loadSiswa">
                <option value="">Semua Kelas</option>
                <option value="1">Kelas 1</option>
                <option value="2">Kelas 2</option>
                <option value="3">Kelas 3</option>
                <option value="4">Kelas 4</option>
                <option value="5">Kelas 5</option>
                <option value="6">Kelas 6</option>
            </select>
        </div>
        
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jenis Kelamin</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="siswa in siswaList" :key="siswa.id">
                        <td>{{ siswa.nis }}</td>
                        <td>{{ siswa.nama }}</td>
                        <td>{{ siswa.kelas }}</td>
                        <td>{{ siswa.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>
                            <span :class="['status', siswa.status]">
                                {{ siswa.status }}
                            </span>
                        </td>
                        <td>
                            <button @click="editSiswa(siswa)" class="btn-edit">
                                Edit
                            </button>
                            <button @click="deleteSiswa(siswa.id)" class="btn-delete">
                                Hapus
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Create/Edit Modal -->
        <SiswaSDModal
            v-if="showCreateModal || showEditModal"
            :siswa="selectedSiswa"
            :is-edit="showEditModal"
            @close="closeModal"
            @save="saveSiswa"
        />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useSiswaSDStore } from '@/stores/jenjang/sd/siswaSDStore'
import SiswaSDModal from './SiswaSDModal.vue'

const siswaSDStore = useSiswaSDStore()

const siswaList = ref([])
const filters = ref({
    kelas: '',
    status: 'active'
})
const showCreateModal = ref(false)
const showEditModal = ref(false)
const selectedSiswa = ref(null)

const loadSiswa = async () => {
    try {
        siswaList.value = await siswaSDStore.getSiswa(filters.value)
    } catch (error) {
        console.error('Error loading siswa:', error)
    }
}

const editSiswa = (siswa) => {
    selectedSiswa.value = siswa
    showEditModal.value = true
}

const deleteSiswa = async (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus siswa ini?')) {
        try {
            await siswaSDStore.deleteSiswa(id)
            await loadSiswa()
        } catch (error) {
            console.error('Error deleting siswa:', error)
        }
    }
}

const saveSiswa = async (siswaData) => {
    try {
        if (showEditModal.value) {
            await siswaSDStore.updateSiswa(selectedSiswa.value.id, siswaData)
        } else {
            await siswaSDStore.createSiswa(siswaData)
        }
        await loadSiswa()
        closeModal()
    } catch (error) {
        console.error('Error saving siswa:', error)
    }
}

const closeModal = () => {
    showCreateModal.value = false
    showEditModal.value = false
    selectedSiswa.value = null
}

onMounted(() => {
    loadSiswa()
})
</script>
```

#### **Pinia Store:**
```javascript
// frontend/src/stores/jenjang/sd/siswaSDStore.js
import { defineStore } from 'pinia'
import { useSiswaSDService } from '@/services/jenjang/sd/siswaSDService'

export const useSiswaSDStore = defineStore('siswaSD', {
    state: () => ({
        siswaList: [],
        currentSiswa: null,
        loading: false,
        error: null
    }),
    
    actions: {
        async getSiswa(filters = {}) {
            this.loading = true
            this.error = null
            
            try {
                const service = useSiswaSDService()
                this.siswaList = await service.getSiswa(filters)
                return this.siswaList
            } catch (error) {
                this.error = error.message
                throw error
            } finally {
                this.loading = false
            }
        },
        
        async createSiswa(siswaData) {
            this.loading = true
            this.error = null
            
            try {
                const service = useSiswaSDService()
                const newSiswa = await service.createSiswa(siswaData)
                this.siswaList.push(newSiswa)
                return newSiswa
            } catch (error) {
                this.error = error.message
                throw error
            } finally {
                this.loading = false
            }
        },
        
        async updateSiswa(id, siswaData) {
            this.loading = true
            this.error = null
            
            try {
                const service = useSiswaSDService()
                const updatedSiswa = await service.updateSiswa(id, siswaData)
                const index = this.siswaList.findIndex(s => s.id === id)
                if (index !== -1) {
                    this.siswaList[index] = updatedSiswa
                }
                return updatedSiswa
            } catch (error) {
                this.error = error.message
                throw error
            } finally {
                this.loading = false
            }
        },
        
        async deleteSiswa(id) {
            this.loading = true
            this.error = null
            
            try {
                const service = useSiswaSDService()
                await service.deleteSiswa(id)
                this.siswaList = this.siswaList.filter(s => s.id !== id)
                return true
            } catch (error) {
                this.error = error.message
                throw error
            } finally {
                this.loading = false
            }
        }
    }
})
```

---

## 🎯 **KEUNTUNGAN STRUKTUR ISOLATED:**

1. **Complete Isolation**: Tidak ada konflik antar jenjang
2. **Independent Development**: Develop per jenjang secara independen
3. **License-Based Access**: Akses modul berdasarkan lisensi
4. **Modular Installation**: Install hanya yang diperlukan
5. **Easy Maintenance**: Maintenance per jenjang terpisah
6. **Scalable**: Mudah menambah jenjang baru
7. **Secure**: Isolasi data per jenjang
8. **Performance**: Tidak ada overhead dari jenjang lain
9. **Content Separation**: Pemisahan konten publik dari data internal
10. **Public Access**: API public dapat diakses tanpa autentikasi
11. **SEO Friendly**: Konten publik dapat dioptimasi untuk SEO

---

## 🚀 **IMPLEMENTASI BERKELANJUTAN:**

1. **Phase 1**: Setup struktur folder isolated
2. **Phase 2**: Implementasi core system dan public system
3. **Phase 3**: Buat jenjang modules (SD, SMP, SMA, SMK)
4. **Phase 4**: Implementasi installer wizard
5. **Phase 5**: Buat frontend components per jenjang dan public
6. **Phase 6**: Implementasi API public untuk konten
7. **Phase 7**: Testing dan deployment
