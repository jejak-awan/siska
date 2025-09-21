# ⚡ **STRATEGI PERFORMA & BACKUP MULTI-JENJANG**

## 📋 **INFORMASI PROYEK**

**SISKA** (Sistem Informasi Sekolah Bidang Kesiswaan)  
**Pengembang**: [jejakawan.com](https://jejakawan.com)  
**GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)  
**Supported by**: **K2NET** - PT. Kirana Karina Network  
*"Provide Different IT Solutions"*

## 🎯 **OVERVIEW STRATEGI OPTIMISASI**

### **PRINSIP DASAR:**
1. **Conditional Loading**: Load modul hanya yang diperlukan per jenjang
2. **Smart Indexing**: Index yang optimal untuk query pattern
3. **Lazy Loading**: Load data hanya saat diperlukan
4. **Caching Strategy**: Cache yang efisien per jenjang
5. **Backup Granular**: Backup per jenjang atau full system

---

## ⚡ **STRATEGI PERFORMA & INDEXING ISOLATED**

### **A. ISOLATED MODULE LOADING:**

#### **Backend - Isolated Service Provider:**
```php
// app/Providers/IsolatedModuleServiceProvider.php
class IsolatedModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $license = $this->getLicenseInfo();
        $activeModules = $this->getActiveModules($license);
        
        // Load hanya modul yang diizinkan oleh lisensi
        foreach ($activeModules as $module) {
            $this->loadIsolatedModule($module);
        }
    }
    
    private function getLicenseInfo()
    {
        return Cache::remember('license_info', 3600, function () {
            return DB::table('license_management')
                ->where('status', 'active')
                ->first();
        });
    }
    
    private function getActiveModules($license)
    {
        $modules = [];
        
        if ($license->type === 'single') {
            $modules[] = $license->jenjang_aktif;
        } else {
            $modules = json_decode($license->jenjang_aktif, true);
        }
        
        return $modules;
    }
    
    private function loadIsolatedModule($jenjang)
    {
        switch ($jenjang) {
            case 'sd':
                $this->app->bind(SDServiceInterface::class, SDService::class);
                $this->app->bind(SDPresensiServiceInterface::class, SDPresensiService::class);
                $this->app->bind(SDKreditPoinServiceInterface::class, SDKreditPoinService::class);
                break;
            case 'smp':
                $this->app->bind(SMPServiceInterface::class, SMPService::class);
                $this->app->bind(SMPPresensiServiceInterface::class, SMPPresensiService::class);
                $this->app->bind(SMPEkstrakurikulerServiceInterface::class, SMPEkstrakurikulerService::class);
                break;
            case 'sma':
                $this->app->bind(SMAServiceInterface::class, SMAService::class);
                $this->app->bind(SMAPresensiServiceInterface::class, SMAPresensiService::class);
                $this->app->bind(SMAOrganisasiServiceInterface::class, SMAOrganisasiService::class);
                break;
            case 'smk':
                $this->app->bind(SMKServiceInterface::class, SMKService::class);
                $this->app->bind(SMKPresensiServiceInterface::class, SMKPresensiService::class);
                $this->app->bind(SMKKejuruanServiceInterface::class, SMKKejuruanService::class);
                break;
        }
    }
}
```

#### **Frontend - Isolated Component Loading:**
```javascript
// composables/useIsolatedModules.js
export function useIsolatedModules() {
    const { license } = useAuth()
    const activeModules = ref([])
    
    const loadActiveModules = async () => {
        const response = await api.get('/api/license/active-modules')
        activeModules.value = response.data.modules
    }
    
    const isModuleActive = (moduleName) => {
        return activeModules.value.includes(moduleName)
    }
    
    const getModuleRoute = (moduleName) => {
        return `/modules/${moduleName}`
    }
    
    return {
        activeModules,
        loadActiveModules,
        isModuleActive,
        getModuleRoute
    }
}

// components/isolated/ModuleLoader.vue
<template>
    <div class="module-loader">
        <!-- Load komponen berdasarkan lisensi -->
        <SDModule v-if="isModuleActive('sd')" />
        <SMPModule v-if="isModuleActive('smp')" />
        <SMAModule v-if="isModuleActive('sma')" />
        <SMKModule v-if="isModuleActive('smk')" />
        
        <!-- Module tidak aktif -->
        <div v-if="!hasActiveModules" class="no-modules">
            <h3>Tidak ada modul yang aktif</h3>
            <p>Silakan hubungi administrator untuk mengaktifkan modul</p>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { useIsolatedModules } from '@/composables/useIsolatedModules'

const { activeModules, isModuleActive } = useIsolatedModules()

const hasActiveModules = computed(() => {
    return activeModules.value.length > 0
})
</script>
```

### **B. SMART INDEXING STRATEGY ISOLATED:**

#### **Indexes untuk Database Terpisah:**
```sql
-- Database SD
USE siska_sd;
CREATE INDEX idx_siswa_sd_status ON siswa_sd(status);
CREATE INDEX idx_presensi_sd_tanggal ON presensi_sd(tanggal);
CREATE INDEX idx_kredit_poin_sd_siswa ON kredit_poin_sd(id_siswa, tanggal);
CREATE INDEX idx_users_sd_type ON users_sd(jenis_user, status);

-- Database SMP
USE siska_smp;
CREATE INDEX idx_siswa_smp_status ON siswa_smp(status);
CREATE INDEX idx_presensi_smp_tanggal ON presensi_smp(tanggal);
CREATE INDEX idx_ekstrakurikuler_smp_status ON ekstrakurikuler_smp(status);
CREATE INDEX idx_users_smp_type ON users_smp(jenis_user, status);

-- Database SMA
USE siska_sma;
CREATE INDEX idx_siswa_sma_status ON siswa_sma(status);
CREATE INDEX idx_presensi_sma_tanggal ON presensi_sma(tanggal);
CREATE INDEX idx_organisasi_sma_status ON organisasi_sma(status);
CREATE INDEX idx_users_sma_type ON users_sma(jenis_user, status);

-- Database SMK
USE siska_smk;
CREATE INDEX idx_siswa_smk_status ON siswa_smk(status);
CREATE INDEX idx_presensi_smk_tanggal ON presensi_smk(tanggal);
CREATE INDEX idx_kejuruan_smk_status ON kejuruan_smk(status);
CREATE INDEX idx_users_smk_type ON users_smk(jenis_user, status);

-- Database Public
USE siska_public;
CREATE INDEX idx_postingan_umum_status ON postingan_umum(status);
CREATE INDEX idx_postingan_umum_kategori ON postingan_umum(kategori);
CREATE INDEX idx_postingan_umum_tanggal ON postingan_umum(tanggal_publikasi);
CREATE INDEX idx_program_status ON program(status_penyelesaian);
CREATE INDEX idx_kegiatan_publik_status ON kegiatan_publik(status);
CREATE INDEX idx_galeri_status ON galeri(status);
CREATE INDEX idx_pengumuman_status ON pengumuman(status);

-- Partial Indexes untuk performa optimal
USE siska_sd;
CREATE INDEX idx_siswa_sd_aktif ON siswa_sd(id_user) WHERE status = 'active';
CREATE INDEX idx_presensi_sd_hadir ON presensi_sd(id_siswa, tanggal) WHERE status = 'hadir';

USE siska_smp;
CREATE INDEX idx_siswa_smp_aktif ON siswa_smp(id_user) WHERE status = 'active';
CREATE INDEX idx_presensi_smp_hadir ON presensi_smp(id_siswa, tanggal) WHERE status = 'hadir';

USE siska_sma;
CREATE INDEX idx_siswa_sma_aktif ON siswa_sma(id_user) WHERE status = 'active';
CREATE INDEX idx_presensi_sma_hadir ON presensi_sma(id_siswa, tanggal) WHERE status = 'hadir';

USE siska_smk;
CREATE INDEX idx_siswa_smk_aktif ON siswa_smk(id_user) WHERE status = 'active';
CREATE INDEX idx_presensi_smk_hadir ON presensi_smk(id_siswa, tanggal) WHERE status = 'hadir';

USE siska_public;
CREATE INDEX idx_postingan_umum_published ON postingan_umum(tanggal_publikasi) WHERE status = 'published';
CREATE INDEX idx_program_active ON program(id) WHERE status_penyelesaian = 'in_progress';
CREATE INDEX idx_kegiatan_publik_upcoming ON kegiatan_publik(tanggal_mulai) WHERE status = 'upcoming';
CREATE INDEX idx_pengumuman_published ON pengumuman(tanggal_mulai) WHERE status = 'published';
```

#### **Query Optimization untuk Database Terpisah:**
```php
// Model untuk database terpisah
class SiswaSD extends Model
{
    protected $connection = 'mysql_sd';
    protected $table = 'siswa_sd';
    
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    
    public function scopeByKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }
}

class SiswaSMP extends Model
{
    protected $connection = 'mysql_smp';
    protected $table = 'siswa_smp';
    
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    
    public function scopeByKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }
}

// Service dengan query optimization per database
class IsolatedSiswaService
{
    public function getSiswa($jenjang, $filters = [])
    {
        $model = $this->getModelByJenjang($jenjang);
        
        $query = $model::active()->with(['user']);
        
        // Apply filters hanya jika diperlukan
        if (isset($filters['kelas'])) {
            $query->byKelas($filters['kelas']);
        }
        
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        return $query->paginate(20);
    }
    
    private function getModelByJenjang($jenjang)
    {
        switch ($jenjang) {
            case 'sd':
                return SiswaSD::class;
            case 'smp':
                return SiswaSMP::class;
            case 'sma':
                return SiswaSMA::class;
            case 'smk':
                return SiswaSMK::class;
            default:
                throw new InvalidArgumentException("Jenjang tidak valid: {$jenjang}");
        }
    }
}
```

### **C. CACHING STRATEGY ISOLATED:**

#### **Redis Cache dengan Module Key:**
```php
// Cache service untuk isolated modules
class IsolatedModuleCacheService
{
    private $redis;
    
    public function __construct()
    {
        $this->redis = Redis::connection();
    }
    
    public function getLicenseInfo()
    {
        $key = "license:info";
        
        $license = $this->redis->get($key);
        
        if (!$license) {
            $license = DB::table('license_management')
                ->where('status', 'active')
                ->first();
                
            $this->redis->setex($key, 3600, json_encode($license)); // Cache 1 jam
        }
        
        return json_decode($license, true);
    }
    
    public function getActiveModules()
    {
        $key = "modules:active";
        
        $modules = $this->redis->get($key);
        
        if (!$modules) {
            $license = $this->getLicenseInfo();
            $modules = $license['type'] === 'single' 
                ? [$license['jenjang_aktif']]
                : json_decode($license['jenjang_aktif'], true);
                
            $this->redis->setex($key, 1800, json_encode($modules)); // Cache 30 menit
        }
        
        return json_decode($modules, true);
    }
    
    public function getModuleData($jenjang, $dataType)
    {
        $key = "module:{$jenjang}:{$dataType}";
        
        $data = $this->redis->get($key);
        
        if (!$data) {
            $data = $this->loadModuleData($jenjang, $dataType);
            $this->redis->setex($key, 1800, json_encode($data)); // Cache 30 menit
        }
        
        return json_decode($data, true);
    }
    
    private function loadModuleData($jenjang, $dataType)
    {
        switch ($dataType) {
            case 'config':
                return $this->loadModuleConfig($jenjang);
            case 'users':
                return $this->loadModuleUsers($jenjang);
            case 'siswa':
                return $this->loadModuleSiswa($jenjang);
            default:
                return [];
        }
    }
    
    public function clearModuleCache($jenjang = null)
    {
        if ($jenjang) {
            $pattern = "module:{$jenjang}:*";
        } else {
            $pattern = "module:*";
        }
        
        $keys = $this->redis->keys($pattern);
        if (!empty($keys)) {
            $this->redis->del($keys);
        }
        
        // Clear license cache
        $this->redis->del(['license:info', 'modules:active']);
    }
}
```

#### **Frontend Cache dengan Pinia:**
```javascript
// stores/jenjangConfigStore.js
export const useJenjangConfigStore = defineStore('jenjangConfig', {
    state: () => ({
        config: null,
        modules: [],
        aspekKarakter: [],
        lastUpdated: null
    }),
    
    actions: {
        async loadConfig(sekolahId, jenjang) {
            const cacheKey = `config_${sekolahId}_${jenjang}`
            const cached = localStorage.getItem(cacheKey)
            const cacheTime = localStorage.getItem(`${cacheKey}_time`)
            
            // Check cache validity (30 minutes)
            if (cached && cacheTime && (Date.now() - cacheTime < 1800000)) {
                this.config = JSON.parse(cached)
                return this.config
            }
            
            // Load from API
            const response = await api.get(`/api/konfigurasi/jenjang/${sekolahId}/${jenjang}`)
            this.config = response.data
            
            // Update cache
            localStorage.setItem(cacheKey, JSON.stringify(this.config))
            localStorage.setItem(`${cacheKey}_time`, Date.now())
            
            return this.config
        },
        
        async loadActiveModules(sekolahId, jenjang) {
            const cacheKey = `modules_${sekolahId}_${jenjang}`
            const cached = localStorage.getItem(cacheKey)
            const cacheTime = localStorage.getItem(`${cacheKey}_time`)
            
            if (cached && cacheTime && (Date.now() - cacheTime < 1800000)) {
                this.modules = JSON.parse(cached)
                return this.modules
            }
            
            const response = await api.get(`/api/konfigurasi/modul/${sekolahId}/${jenjang}`)
            this.modules = response.data.modules
            
            localStorage.setItem(cacheKey, JSON.stringify(this.modules))
            localStorage.setItem(`${cacheKey}_time`, Date.now())
            
            return this.modules
        }
    }
})
```

---

## 💾 **STRATEGI BACKUP & RECOVERY**

### **A. BACKUP STRATEGY BERDASARKAN JENJANG:**

#### **Full System Backup:**
```bash
#!/bin/bash
# scripts/backup-full-system.sh

BACKUP_DIR="/opt/backups/kesiswaan"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="kesiswaan"

# Create backup directory
mkdir -p $BACKUP_DIR/$DATE

# Database backup
mysqldump -u root -p$DB_PASSWORD $DB_NAME > $BACKUP_DIR/$DATE/database_full.sql

# Application files backup
tar -czf $BACKUP_DIR/$DATE/application_files.tar.gz /opt/kesiswaan/backend /opt/kesiswaan/frontend

# Configuration backup
cp -r /opt/kesiswaan/backend/config $BACKUP_DIR/$DATE/
cp -r /opt/kesiswaan/backend/.env $BACKUP_DIR/$DATE/

# Upload to cloud storage (optional)
aws s3 cp $BACKUP_DIR/$DATE/ s3://kesiswaan-backups/$DATE/ --recursive

echo "Full system backup completed: $BACKUP_DIR/$DATE"
```

#### **Jenjang-Specific Backup:**
```bash
#!/bin/bash
# scripts/backup-jenjang.sh

JENJANG=$1
SEKOLAH_ID=$2
BACKUP_DIR="/opt/backups/kesiswaan/jenjang"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="kesiswaan"

if [ -z "$JENJANG" ] || [ -z "$SEKOLAH_ID" ]; then
    echo "Usage: $0 <jenjang> <sekolah_id>"
    echo "Example: $0 sd 1"
    exit 1
fi

mkdir -p $BACKUP_DIR/$JENJANG/$SEKOLAH_ID/$DATE

# Backup data specific to jenjang and sekolah
mysqldump -u root -p$DB_PASSWORD $DB_NAME \
    --where="id_sekolah=$SEKOLAH_ID AND jenjang='$JENJANG'" \
    siswa presensi kredit_poin penilaian_karakter \
    > $BACKUP_DIR/$JENJANG/$SEKOLAH_ID/$DATE/data_jenjang.sql

# Backup configuration for specific jenjang
mysqldump -u root -p$DB_PASSWORD $DB_NAME \
    --where="id_sekolah=$SEKOLAH_ID AND jenjang='$JENJANG'" \
    konfigurasi_jenjang konfigurasi_modul \
    > $BACKUP_DIR/$JENJANG/$SEKOLAH_ID/$DATE/config_jenjang.sql

# Backup aspek karakter for jenjang
mysqldump -u root -p$DB_PASSWORD $DB_NAME \
    --where="jenjang='$JENJANG'" \
    aspek_karakter kategori_program_kesiswaan \
    > $BACKUP_DIR/$JENJANG/$SEKOLAH_ID/$DATE/aspek_karakter.sql

echo "Jenjang backup completed: $BACKUP_DIR/$JENJANG/$SEKOLAH_ID/$DATE"
```

#### **Incremental Backup:**
```bash
#!/bin/bash
# scripts/backup-incremental.sh

BACKUP_DIR="/opt/backups/kesiswaan/incremental"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="kesiswaan"
LAST_BACKUP=$(ls -t $BACKUP_DIR | head -n1)

mkdir -p $BACKUP_DIR/$DATE

# Get last backup timestamp
if [ -n "$LAST_BACKUP" ]; then
    LAST_TIMESTAMP=$(mysql -u root -p$DB_PASSWORD -e "SELECT MAX(updated_at) FROM information_schema.tables WHERE table_schema='$DB_NAME'" | tail -n1)
    
    # Backup only changed data
    mysqldump -u root -p$DB_PASSWORD $DB_NAME \
        --where="updated_at > '$LAST_TIMESTAMP'" \
        siswa presensi kredit_poin penilaian_karakter \
        > $BACKUP_DIR/$DATE/incremental_data.sql
else
    # First incremental backup - backup all data
    mysqldump -u root -p$DB_PASSWORD $DB_NAME \
        siswa presensi kredit_poin penilaian_karakter \
        > $BACKUP_DIR/$DATE/incremental_data.sql
fi

echo "Incremental backup completed: $BACKUP_DIR/$DATE"
```

### **B. RECOVERY STRATEGY:**

#### **Full System Recovery:**
```bash
#!/bin/bash
# scripts/recover-full-system.sh

BACKUP_PATH=$1
DB_NAME="kesiswaan"

if [ -z "$BACKUP_PATH" ]; then
    echo "Usage: $0 <backup_path>"
    echo "Example: $0 /opt/backups/kesiswaan/20241201_120000"
    exit 1
fi

# Stop application
systemctl stop kesiswaan-backend
systemctl stop kesiswaan-frontend

# Restore database
mysql -u root -p$DB_PASSWORD $DB_NAME < $BACKUP_PATH/database_full.sql

# Restore application files
tar -xzf $BACKUP_PATH/application_files.tar.gz -C /

# Restore configuration
cp -r $BACKUP_PATH/config/* /opt/kesiswaan/backend/config/
cp $BACKUP_PATH/.env /opt/kesiswaan/backend/

# Clear cache
redis-cli FLUSHALL

# Restart application
systemctl start kesiswaan-backend
systemctl start kesiswaan-frontend

echo "Full system recovery completed"
```

#### **Jenjang-Specific Recovery:**
```bash
#!/bin/bash
# scripts/recover-jenjang.sh

JENJANG=$1
SEKOLAH_ID=$2
BACKUP_PATH=$3
DB_NAME="kesiswaan"

if [ -z "$JENJANG" ] || [ -z "$SEKOLAH_ID" ] || [ -z "$BACKUP_PATH" ]; then
    echo "Usage: $0 <jenjang> <sekolah_id> <backup_path>"
    echo "Example: $0 sd 1 /opt/backups/kesiswaan/jenjang/sd/1/20241201_120000"
    exit 1
fi

# Backup current data before recovery
mysqldump -u root -p$DB_PASSWORD $DB_NAME \
    --where="id_sekolah=$SEKOLAH_ID AND jenjang='$JENJANG'" \
    siswa presensi kredit_poin penilaian_karakter \
    > /tmp/backup_before_recovery_$DATE.sql

# Restore jenjang-specific data
mysql -u root -p$DB_PASSWORD $DB_NAME < $BACKUP_PATH/data_jenjang.sql
mysql -u root -p$DB_PASSWORD $DB_NAME < $BACKUP_PATH/config_jenjang.sql
mysql -u root -p$DB_PASSWORD $DB_NAME < $BACKUP_PATH/aspek_karakter.sql

# Clear jenjang-specific cache
redis-cli DEL "konfigurasi:jenjang:$SEKOLAH_ID:$JENJANG"
redis-cli DEL "modules:active:$SEKOLAH_ID:$JENJANG"

echo "Jenjang recovery completed for $JENJANG sekolah $SEKOLAH_ID"
```

### **C. BACKUP SCHEDULING:**

#### **Crontab Configuration:**
```bash
# /etc/crontab

# Full system backup every Sunday at 2 AM
0 2 * * 0 /opt/kesiswaan/scripts/backup-full-system.sh

# Incremental backup every day at 1 AM
0 1 * * * /opt/kesiswaan/scripts/backup-incremental.sh

# Jenjang-specific backup every 6 hours
0 */6 * * * /opt/kesiswaan/scripts/backup-jenjang.sh sd 1
0 */6 * * * /opt/kesiswaan/scripts/backup-jenjang.sh smp 1
0 */6 * * * /opt/kesiswaan/scripts/backup-jenjang.sh sma 1
0 */6 * * * /opt/kesiswaan/scripts/backup-jenjang.sh smk 1

# Cleanup old backups (keep 30 days)
0 3 * * * find /opt/backups/kesiswaan -type d -mtime +30 -exec rm -rf {} \;
```

---

## 🎯 **OPTIMISASI UNTUK SINGLE vs MULTI JENJANG**

### **A. SINGLE JENJANG OPTIMIZATION:**
```php
// Middleware untuk single jenjang
class SingleJenjangOptimization
{
    public function handle($request, Closure $next)
    {
        $sekolah = $request->attributes->get('sekolah');
        $jenjang = $sekolah->jenjang_aktif;
        
        // Skip jenjang detection untuk single jenjang
        if (!$sekolah->multi_jenjang) {
            config(['app.jenjang_aktif' => $jenjang]);
            config(['app.skip_jenjang_detection' => true]);
        }
        
        return $next($request);
    }
}

// Query optimization untuk single jenjang
class SiswaService
{
    public function getSiswa($sekolahId, $filters = [])
    {
        $query = Siswa::where('id_sekolah', $sekolahId);
        
        // Skip jenjang filter untuk single jenjang
        if (!config('app.skip_jenjang_detection')) {
            $query->where('jenjang', config('app.jenjang_aktif'));
        }
        
        return $query->active()->with(['kelas', 'user'])->paginate(20);
    }
}
```

### **B. MULTI JENJANG OPTIMIZATION:**
```php
// Service untuk multi jenjang
class MultiJenjangService
{
    public function getSiswaByJenjang($sekolahId, $jenjang, $filters = [])
    {
        // Use specific index for multi jenjang
        $query = Siswa::where('id_sekolah', $sekolahId)
            ->where('jenjang', $jenjang)
            ->active();
            
        // Load only active modules for this jenjang
        $activeModules = $this->getActiveModules($sekolahId, $jenjang);
        
        $with = ['kelas', 'user'];
        if (in_array('presensi', $activeModules)) {
            $with[] = 'presensi';
        }
        if (in_array('kredit_poin', $activeModules)) {
            $with[] = 'kreditPoin';
        }
        
        return $query->with($with)->paginate(20);
    }
}
```

---

## 📊 **MONITORING & PERFORMANCE METRICS**

### **A. Database Performance Monitoring:**
```sql
-- Query untuk monitoring performa
SELECT 
    jenjang,
    COUNT(*) as total_siswa,
    AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) as avg_response_time
FROM siswa 
WHERE id_sekolah = ? 
GROUP BY jenjang;

-- Index usage monitoring
SELECT 
    TABLE_NAME,
    INDEX_NAME,
    CARDINALITY,
    SUB_PART,
    PACKED
FROM information_schema.STATISTICS 
WHERE TABLE_SCHEMA = 'kesiswaan' 
AND TABLE_NAME IN ('siswa', 'presensi', 'kredit_poin', 'penilaian_karakter');
```

### **B. Application Performance Monitoring:**
```php
// Performance middleware
class PerformanceMonitoring
{
    public function handle($request, Closure $next)
    {
        $start = microtime(true);
        $jenjang = $request->attributes->get('jenjang');
        
        $response = $next($request);
        
        $duration = microtime(true) - $start;
        
        // Log performance metrics
        Log::info('Performance', [
            'jenjang' => $jenjang,
            'route' => $request->route()->getName(),
            'duration' => $duration,
            'memory' => memory_get_peak_usage(true)
        ]);
        
        return $response;
    }
}
```

---

## 🎯 **KEUNTUNGAN STRATEGI INI:**

1. **Optimal Performance**: Load hanya modul yang diperlukan
2. **Scalable**: Dapat menangani single dan multi jenjang
3. **Efficient Caching**: Cache yang smart per jenjang
4. **Flexible Backup**: Backup granular atau full system
5. **Quick Recovery**: Recovery per jenjang atau full system
6. **Resource Efficient**: Tidak membebani sistem dengan modul tidak aktif

---

## 🚀 **IMPLEMENTASI BERKELANJUTAN:**

1. **Phase 1**: Implementasi conditional loading dan smart indexing
2. **Phase 2**: Setup caching strategy dan performance monitoring
3. **Phase 3**: Implementasi backup dan recovery scripts
4. **Phase 4**: Testing performa dan optimisasi
5. **Phase 5**: Monitoring dan maintenance
