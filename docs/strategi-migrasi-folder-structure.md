# 📁 **STRATEGI MIGRASI FOLDER STRUCTURE**

## 📋 **INFORMASI PROYEK**

**SISKA** (Sistem Informasi Sekolah Bidang Kesiswaan)  
**Pengembang**: [jejakawan.com](https://jejakawan.com)  
**GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)  
**Supported by**: **K2NET** - PT. Kirana Karina Network  
*"Provide Different IT Solutions"*

## 🎯 **OVERVIEW STRATEGI FOLDER STRUCTURE**

### **PRINSIP DASAR:**
1. **Parallel Development**: Develop isolated architecture tanpa mengganggu proyek aktual
2. **Zero Downtime**: Proyek aktual tetap berjalan normal
3. **Easy Switch**: Mudah switch antar architecture
4. **Backward Compatibility**: Tetap support proyek aktual
5. **Gradual Migration**: Migrasi bertahap tanpa risiko

---

## 📂 **STRUKTUR FOLDER FINAL**

### **A. STRUKTUR FOLDER ROOT:**
```
/opt/kesiswaan/
├── backend/                    # Proyek aktual (Legacy)
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── routes/
│   └── ...
├── frontend/                   # Proyek aktual (Legacy)
│   ├── src/
│   ├── public/
│   └── ...
├── siska/                      # Isolated Architecture (NEW)
│   ├── core/                   # Shared core system
│   ├── jenjang/                # Isolated jenjang modules
│   ├── installer/              # Installation wizard
│   ├── shared/                 # Shared resources
│   └── frontend/               # Isolated frontend
├── scripts/                    # Shared scripts
├── docs/                       # Documentation
└── backups/                    # Backup files
```

### **B. DETAIL STRUKTUR SISKA (ISOLATED):**
```
/opt/kesiswaan/siska/
├── core/                       # Shared core system
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── Core/       # Core controllers
│   │   │   │   ├── License/    # License management
│   │   │   │   └── Public/     # Public content controllers
│   │   │   ├── Middleware/
│   │   │   ├── Requests/
│   │   │   └── Resources/
│   │   ├── Models/
│   │   │   ├── Core/           # Core models
│   │   │   └── Public/         # Public models
│   │   ├── Services/
│   │   │   ├── Core/           # Core services
│   │   │   ├── License/        # License services
│   │   │   └── Public/         # Public services
│   │   └── Traits/
│   ├── config/
│   │   ├── core.php
│   │   ├── license.php
│   │   ├── public.php
│   │   └── database.php
│   ├── database/
│   │   ├── migrations/
│   │   │   ├── core/
│   │   │   └── public/
│   │   └── seeders/
│   │       ├── core/
│   │       └── public/
│   └── routes/
│       ├── api.php
│       ├── web.php
│       ├── license.php
│       └── public.php
├── jenjang/                    # Isolated jenjang modules
│   ├── sd/                     # SD Module
│   │   ├── app/
│   │   │   ├── Http/
│   │   │   │   ├── Controllers/
│   │   │   │   ├── Requests/
│   │   │   │   └── Resources/
│   │   │   ├── Models/
│   │   │   ├── Services/
│   │   │   └── Traits/
│   │   ├── config/
│   │   │   └── sd.php
│   │   ├── database/
│   │   │   ├── migrations/
│   │   │   └── seeders/
│   │   ├── routes/
│   │   └── resources/
│   ├── smp/                    # SMP Module
│   │   └── ... (same structure as SD)
│   ├── sma/                    # SMA Module
│   │   └── ... (same structure as SD)
│   └── smk/                    # SMK Module
│       └── ... (same structure as SD)
├── installer/                  # Installation wizard
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── InstallationController.php
│   │   │   │   ├── LicenseController.php
│   │   │   │   └── WizardController.php
│   │   │   ├── Requests/
│   │   │   └── Resources/
│   │   ├── Models/
│   │   └── Services/
│   ├── config/
│   │   └── installer.php
│   ├── database/
│   ├── routes/
│   └── resources/
│       ├── views/
│       │   ├── wizard/
│       │   └── layouts/
│       └── assets/
├── shared/                     # Shared resources
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   ├── translations/
│   │   ├── id/
│   │   └── en/
│   └── templates/
│       ├── email/
│       └── pdf/
└── frontend/                   # Isolated frontend
    ├── src/
    │   ├── components/
    │   │   ├── core/           # Core components
    │   │   ├── jenjang/        # Jenjang-specific components
    │   │   └── installer/      # Installer components
    │   ├── views/
    │   │   ├── core/
    │   │   ├── jenjang/
    │   │   └── installer/
    │   ├── stores/
    │   │   ├── core/
    │   │   ├── jenjang/
    │   │   └── license/
    │   ├── services/
    │   ├── composables/
    │   └── utils/
    ├── public/
    └── package.json
```

---

## 🔄 **STRATEGI MIGRASI FOLDER STRUCTURE**

### **A. PHASE 1: SETUP FOLDER STRUCTURE (1 minggu)**

#### **1.1 Create Base Structure:**
```bash
#!/bin/bash
# scripts/setup-isolated-structure.sh

set -e

BASE_DIR="/opt/kesiswaan"
SISKA_DIR="$BASE_DIR/siska"

echo "Setting up isolated architecture structure..."

# Create main siska directory
mkdir -p "$SISKA_DIR"

# Create core structure
mkdir -p "$SISKA_DIR/core/app/Http/Controllers/{Core,License,Public}"
mkdir -p "$SISKA_DIR/core/app/Http/Middleware"
mkdir -p "$SISKA_DIR/core/app/Http/Requests"
mkdir -p "$SISKA_DIR/core/app/Http/Resources"
mkdir -p "$SISKA_DIR/core/app/Models/{Core,Public}"
mkdir -p "$SISKA_DIR/core/app/Services/{Core,License,Public}"
mkdir -p "$SISKA_DIR/core/app/Traits"
mkdir -p "$SISKA_DIR/core/config"
mkdir -p "$SISKA_DIR/core/database/migrations/{core,public}"
mkdir -p "$SISKA_DIR/core/database/seeders/{core,public}"
mkdir -p "$SISKA_DIR/core/routes"

# Create jenjang structure
for jenjang in sd smp sma smk; do
    mkdir -p "$SISKA_DIR/jenjang/$jenjang/app/Http/Controllers"
    mkdir -p "$SISKA_DIR/jenjang/$jenjang/app/Http/Requests"
    mkdir -p "$SISKA_DIR/jenjang/$jenjang/app/Http/Resources"
    mkdir -p "$SISKA_DIR/jenjang/$jenjang/app/Models"
    mkdir -p "$SISKA_DIR/jenjang/$jenjang/app/Services"
    mkdir -p "$SISKA_DIR/jenjang/$jenjang/app/Traits"
    mkdir -p "$SISKA_DIR/jenjang/$jenjang/config"
    mkdir -p "$SISKA_DIR/jenjang/$jenjang/database/migrations"
    mkdir -p "$SISKA_DIR/jenjang/$jenjang/database/seeders"
    mkdir -p "$SISKA_DIR/jenjang/$jenjang/routes"
    mkdir -p "$SISKA_DIR/jenjang/$jenjang/resources/views"
    mkdir -p "$SISKA_DIR/jenjang/$jenjang/resources/assets"
done

# Create installer structure
mkdir -p "$SISKA_DIR/installer/app/Http/Controllers"
mkdir -p "$SISKA_DIR/installer/app/Http/Requests"
mkdir -p "$SISKA_DIR/installer/app/Http/Resources"
mkdir -p "$SISKA_DIR/installer/app/Models"
mkdir -p "$SISKA_DIR/installer/app/Services"
mkdir -p "$SISKA_DIR/installer/config"
mkdir -p "$SISKA_DIR/installer/database/migrations"
mkdir -p "$SISKA_DIR/installer/database/seeders"
mkdir -p "$SISKA_DIR/installer/routes"
mkdir -p "$SISKA_DIR/installer/resources/views/wizard"
mkdir -p "$SISKA_DIR/installer/resources/views/layouts"
mkdir -p "$SISKA_DIR/installer/resources/assets"

# Create shared structure
mkdir -p "$SISKA_DIR/shared/assets/{css,js,images}"
mkdir -p "$SISKA_DIR/shared/translations/{id,en}"
mkdir -p "$SISKA_DIR/shared/templates/{email,pdf}"

# Create frontend structure
mkdir -p "$SISKA_DIR/frontend/src/components/{core,jenjang,installer}"
mkdir -p "$SISKA_DIR/frontend/src/views/{core,jenjang,installer}"
mkdir -p "$SISKA_DIR/frontend/src/stores/{core,jenjang,license}"
mkdir -p "$SISKA_DIR/frontend/src/services"
mkdir -p "$SISKA_DIR/frontend/src/composables"
mkdir -p "$SISKA_DIR/frontend/src/utils"
mkdir -p "$SISKA_DIR/frontend/public"

echo "Folder structure created successfully!"
echo "Base directory: $SISKA_DIR"
```

#### **1.2 Copy Base Files:**
```bash
#!/bin/bash
# scripts/copy-base-files.sh

set -e

BASE_DIR="/opt/kesiswaan"
SISKA_DIR="$BASE_DIR/siska"
BACKEND_DIR="$BASE_DIR/backend"

echo "Copying base files from existing project..."

# Copy Laravel base files
cp "$BACKEND_DIR/composer.json" "$SISKA_DIR/"
cp "$BACKEND_DIR/artisan" "$SISKA_DIR/"
cp "$BACKEND_DIR/.env.example" "$SISKA_DIR/"

# Copy configuration files
cp -r "$BACKEND_DIR/config" "$SISKA_DIR/core/"

# Copy shared files
cp -r "$BACKEND_DIR/bootstrap" "$SISKA_DIR/core/"
cp -r "$BACKEND_DIR/storage" "$SISKA_DIR/core/"
cp -r "$BACKEND_DIR/vendor" "$SISKA_DIR/core/"

# Copy frontend base files
cp "$BASE_DIR/frontend/package.json" "$SISKA_DIR/frontend/"
cp "$BASE_DIR/frontend/vite.config.js" "$SISKA_DIR/frontend/"
cp "$BASE_DIR/frontend/tailwind.config.js" "$SISKA_DIR/frontend/"

echo "Base files copied successfully!"
```

### **B. PHASE 2: ENVIRONMENT CONFIGURATION (1 minggu)**

#### **2.1 Create Environment Configuration:**
```bash
#!/bin/bash
# scripts/setup-environment.sh

set -e

SISKA_DIR="/opt/kesiswaan/siska"

echo "Setting up environment configuration..."

# Create .env for isolated architecture
cat > "$SISKA_DIR/.env" << 'EOF'
APP_NAME="SISKA Isolated"
APP_ENV=development
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql_core
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE_CORE=siska_core
DB_DATABASE_PUBLIC=siska_public
DB_DATABASE_SD=siska_sd
DB_DATABASE_SMP=siska_smp
DB_DATABASE_SMA=siska_sma
DB_DATABASE_SMK=siska_smk
DB_USERNAME=root
DB_PASSWORD=

# Isolated Architecture
ISOLATED_ARCHITECTURE=true
LICENSE_TYPE=single
ACTIVE_MODULES=["sd"]
WORKSPACE_PATH=/opt/kesiswaan/siska
DB_PREFIX=siska
MIGRATION_MODE=enabled

# Cache
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Session
SESSION_DRIVER=redis
SESSION_LIFETIME=120

# Mail
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
EOF

# Generate application key
cd "$SISKA_DIR"
php artisan key:generate

echo "Environment configuration created successfully!"
```

#### **2.2 Create Isolated Configuration:**
```php
<?php
// siska/config/isolated.php

return [
    'enabled' => env('ISOLATED_ARCHITECTURE', true),
    'license_type' => env('LICENSE_TYPE', 'single'), // single, multi
    'active_modules' => json_decode(env('ACTIVE_MODULES', '["sd"]'), true),
    'workspace_path' => env('WORKSPACE_PATH', '/opt/kesiswaan/siska'),
    'database_prefix' => env('DB_PREFIX', 'siska'),
    'migration_mode' => env('MIGRATION_MODE', 'enabled'), // disabled, enabled, testing
    
    'modules' => [
        'sd' => [
            'name' => 'Sekolah Dasar',
            'database' => 'siska_sd',
            'connection' => 'mysql_sd',
            'enabled' => true,
        ],
        'smp' => [
            'name' => 'Sekolah Menengah Pertama',
            'database' => 'siska_smp',
            'connection' => 'mysql_smp',
            'enabled' => false,
        ],
        'sma' => [
            'name' => 'Sekolah Menengah Atas',
            'database' => 'siska_sma',
            'connection' => 'mysql_sma',
            'enabled' => false,
        ],
        'smk' => [
            'name' => 'Sekolah Menengah Kejuruan',
            'database' => 'siska_smk',
            'connection' => 'mysql_smk',
            'enabled' => false,
        ],
    ],
];
```

### **C. PHASE 3: DATABASE SETUP (1 minggu)**

#### **3.1 Create Database Structure:**
```bash
#!/bin/bash
# scripts/setup-databases.sh

set -e

echo "Setting up isolated architecture databases..."

# Create databases
mysql -u root -p << 'EOF'
CREATE DATABASE IF NOT EXISTS siska_core CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS siska_public CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS siska_sd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS siska_smp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS siska_sma CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS siska_smk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

SHOW DATABASES LIKE 'siska_%';
EOF

echo "Databases created successfully!"
```

#### **3.2 Run Migrations:**
```bash
#!/bin/bash
# scripts/run-migrations.sh

set -e

SISKA_DIR="/opt/kesiswaan/siska"

echo "Running migrations for isolated architecture..."

cd "$SISKA_DIR"

# Run core migrations
php artisan migrate --path=database/migrations/core --database=mysql_core

# Run public migrations
php artisan migrate --path=database/migrations/public --database=mysql_public

# Run jenjang migrations (only for active modules)
ACTIVE_MODULES=$(php artisan tinker --execute="echo json_encode(config('isolated.active_modules'));")

for module in $(echo $ACTIVE_MODULES | jq -r '.[]'); do
    echo "Running migrations for $module..."
    php artisan migrate --path="jenjang/$module/database/migrations" --database="mysql_$module"
done

echo "Migrations completed successfully!"
```

### **D. PHASE 4: CODE MIGRATION (4-6 minggu)**

#### **4.1 Migration Strategy:**
```bash
#!/bin/bash
# scripts/migrate-code.sh

set -e

BASE_DIR="/opt/kesiswaan"
BACKEND_DIR="$BASE_DIR/backend"
SISKA_DIR="$BASE_DIR/siska"

echo "Starting code migration..."

# Migrate core models
echo "Migrating core models..."
cp -r "$BACKEND_DIR/app/Models/User.php" "$SISKA_DIR/core/app/Models/Core/"
cp -r "$BACKEND_DIR/app/Models/sekolah.php" "$SISKA_DIR/core/app/Models/Core/"

# Migrate public models
echo "Migrating public models..."
cp -r "$BACKEND_DIR/app/Models/Public/"* "$SISKA_DIR/core/app/Models/Public/"

# Migrate controllers
echo "Migrating controllers..."
cp -r "$BACKEND_DIR/app/Http/Controllers/Public/"* "$SISKA_DIR/core/app/Http/Controllers/Public/"

# Migrate services
echo "Migrating services..."
cp -r "$BACKEND_DIR/app/Services/Public/"* "$SISKA_DIR/core/app/Services/Public/"

# Migrate jenjang-specific code
echo "Migrating jenjang-specific code..."
for jenjang in sd smp sma smk; do
    # Copy and adapt models
    cp "$BACKEND_DIR/app/Models/Siswa.php" "$SISKA_DIR/jenjang/$jenjang/app/Models/Siswa${jenjang^^}.php"
    
    # Copy and adapt controllers
    cp "$BACKEND_DIR/app/Http/Controllers/SiswaController.php" "$SISKA_DIR/jenjang/$jenjang/app/Http/Controllers/SiswaController.php"
    
    # Copy and adapt services
    cp "$BACKEND_DIR/app/Services/SiswaService.php" "$SISKA_DIR/jenjang/$jenjang/app/Services/Siswa${jenjang^^}Service.php"
done

echo "Code migration completed successfully!"
```

---

## 🔄 **ENVIRONMENT SWITCHING STRATEGY**

### **A. Environment Detection:**
```php
<?php
// siska/app/Services/Core/EnvironmentService.php

namespace App\Services\Core;

class EnvironmentService
{
    public function detectEnvironment()
    {
        $workspace = getenv('WORKSPACE_PATH') ?: '/opt/kesiswaan';
        
        // Check if we're in isolated architecture
        if (strpos($workspace, '/siska') !== false) {
            return [
                'type' => 'isolated',
                'workspace' => $workspace,
                'base_path' => dirname($workspace),
                'architecture' => 'isolated',
            ];
        }
        
        // Check if we're in legacy architecture
        if (file_exists($workspace . '/backend/artisan')) {
            return [
                'type' => 'legacy',
                'workspace' => $workspace,
                'base_path' => $workspace,
                'architecture' => 'legacy',
            ];
        }
        
        throw new \Exception("Unknown environment type");
    }
    
    public function getDatabaseConfig()
    {
        $env = $this->detectEnvironment();
        
        if ($env['architecture'] === 'isolated') {
            return $this->getIsolatedDatabaseConfig();
        }
        
        return $this->getLegacyDatabaseConfig();
    }
    
    private function getIsolatedDatabaseConfig()
    {
        return [
            'default' => 'mysql_core',
            'connections' => [
                'mysql_core' => [
                    'driver' => 'mysql',
                    'host' => env('DB_HOST', '127.0.0.1'),
                    'port' => env('DB_PORT', '3306'),
                    'database' => env('DB_DATABASE_CORE', 'siska_core'),
                    'username' => env('DB_USERNAME', 'root'),
                    'password' => env('DB_PASSWORD', ''),
                ],
                'mysql_public' => [
                    'driver' => 'mysql',
                    'host' => env('DB_HOST', '127.0.0.1'),
                    'port' => env('DB_PORT', '3306'),
                    'database' => env('DB_DATABASE_PUBLIC', 'siska_public'),
                    'username' => env('DB_USERNAME', 'root'),
                    'password' => env('DB_PASSWORD', ''),
                ],
                // Add jenjang connections based on active modules
            ],
        ];
    }
    
    private function getLegacyDatabaseConfig()
    {
        return [
            'default' => 'mysql',
            'connections' => [
                'mysql' => [
                    'driver' => 'mysql',
                    'host' => env('DB_HOST', '127.0.0.1'),
                    'port' => env('DB_PORT', '3306'),
                    'database' => env('DB_DATABASE', 'kesiswaan'),
                    'username' => env('DB_USERNAME', 'root'),
                    'password' => env('DB_PASSWORD', ''),
                ],
                'mysql_public' => [
                    'driver' => 'mysql',
                    'host' => env('DB_HOST', '127.0.0.1'),
                    'port' => env('DB_PORT', '3306'),
                    'database' => env('DB_DATABASE_PUBLIC', 'kesiswaan_public'),
                    'username' => env('DB_USERNAME', 'root'),
                    'password' => env('DB_PASSWORD', ''),
                ],
            ],
        ];
    }
}
```

### **B. Switch Environment Script:**
```bash
#!/bin/bash
# scripts/switch-environment.sh

set -e

ENVIRONMENT=${1:-"legacy"}
BASE_DIR="/opt/kesiswaan"

case $ENVIRONMENT in
    "legacy")
        WORKSPACE="$BASE_DIR/backend"
        echo "Switching to legacy environment..."
        ;;
    "isolated")
        WORKSPACE="$BASE_DIR/siska"
        echo "Switching to isolated environment..."
        ;;
    *)
        echo "Usage: $0 [legacy|isolated]"
        exit 1
        ;;
esac

if [ ! -d "$WORKSPACE" ]; then
    echo "Error: Workspace $WORKSPACE does not exist"
    exit 1
fi

# Update environment variable
export WORKSPACE_PATH="$WORKSPACE"

# Update symlink for easy access
ln -sfn "$WORKSPACE" "$BASE_DIR/active"

# Restart services
systemctl restart nginx
systemctl restart php8.3-fpm

# Validate environment
cd "$WORKSPACE"
if [ -f "artisan" ]; then
    php artisan env:validate
fi

echo "Environment switched to: $ENVIRONMENT"
echo "Workspace: $WORKSPACE"
echo "Active symlink: $BASE_DIR/active"
```

---

## 🎯 **KEUNTUNGAN STRATEGI FOLDER STRUCTURE INI:**

1. **Parallel Development**: Develop isolated tanpa mengganggu proyek aktual
2. **Easy Switch**: Mudah switch antar environment dengan script
3. **Zero Downtime**: Proyek aktual tetap berjalan normal
4. **Backward Compatibility**: Tetap support proyek aktual
5. **Gradual Migration**: Migrasi bertahap tanpa risiko
6. **Clear Separation**: Pemisahan yang jelas antar architecture
7. **Easy Testing**: Test isolated architecture tanpa risiko
8. **Rollback Capability**: Mudah rollback ke proyek aktual

---

## 🚀 **IMPLEMENTASI BERKELANJUTAN:**

1. **Week 1**: Setup folder structure dan environment
2. **Week 2**: Setup database dan migration
3. **Week 3-8**: Code migration dan development
4. **Week 9**: Testing dan validation
5. **Week 10**: Deployment dan switch

Dengan strategi ini, kita bisa dengan aman develop isolated architecture sambil tetap mempertahankan proyek aktual yang sudah berjalan bro! 🚀✨
