# 🔄 **STRATEGI GIT INTEGRATION UNTUK ISOLATED ARCHITECTURE**

## 📋 **INFORMASI PROYEK**

**SISKA** (Sistem Informasi Sekolah Bidang Kesiswaan)  
**Pengembang**: [jejakawan.com](https://jejakawan.com)  
**GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)  
**Supported by**: **K2NET** - PT. Kirana Karina Network  
*"Provide Different IT Solutions"*

## 🎯 **OVERVIEW STRATEGI GIT**

### **PRINSIP DASAR:**
1. **Repository Separation**: Repository terpisah untuk isolated architecture
2. **Shared Components**: Komponen yang bisa di-share antar repository
3. **Version Control**: Version control yang independen
4. **Collaboration**: Kolaborasi yang efisien antar tim
5. **Deployment**: Deployment yang terpisah dan independen

---

## 📂 **STRATEGI REPOSITORY STRUCTURE**

### **A. SINGLE REPOSITORY DENGAN BRANCH PER JENJANG (RECOMMENDED)**

#### **Repository Structure:**
```
siska-main/                    # Single repository
├── main/                      # Main branch (production)
├── core/                      # Core system branch
├── sd/                        # SD module branch
├── smp/                       # SMP module branch
├── sma/                       # SMA module branch
├── smk/                       # SMK module branch
├── public/                    # Public system branch
├── installer/                 # Installer wizard branch
└── shared/                    # Shared components branch
```

#### **Branch Strategy:**
```bash
# Main branches
main                    # Production-ready code (all modules)
develop                 # Development integration branch

# Module branches
core                    # Core system (License, School Profile, etc.)
sd                      # SD module development
smp                     # SMP module development
sma                     # SMA module development
smk                     # SMK module development
public                  # Public system development
installer               # Installer wizard development
shared                  # Shared components development

# Feature branches (per module)
feature/core-license    # License management feature
feature/sd-presensi     # SD presensi feature
feature/smp-ekstrakurikuler # SMP ekstrakurikuler feature
feature/sma-organisasi  # SMA organisasi feature
feature/smk-kejuruan    # SMK kejuruan feature
feature/public-news     # Public news feature
feature/installer-wizard # Installer wizard feature

# Release branches
release/v1.0.0          # Release preparation
release/v1.1.0          # Release preparation

# Hotfix branches
hotfix/critical-bug     # Critical bug fixes
```

#### **Folder Structure per Branch:**
```
siska-main/
├── core/                       # Core system (branch: core)
│   ├── app/
│   ├── config/
│   ├── database/
│   └── routes/
├── jenjang/
│   ├── sd/                     # SD module (branch: sd)
│   ├── smp/                    # SMP module (branch: smp)
│   ├── sma/                    # SMA module (branch: sma)
│   └── smk/                    # SMK module (branch: smk)
├── public/                     # Public system (branch: public)
│   ├── app/
│   ├── config/
│   ├── database/
│   └── routes/
├── installer/                  # Installer wizard (branch: installer)
│   ├── app/
│   ├── config/
│   └── resources/
├── shared/                     # Shared components (branch: shared)
│   ├── components/
│   ├── utilities/
│   └── styles/
└── frontend/                   # Frontend (all modules)
    ├── src/
    │   ├── components/
    │   │   ├── core/
    │   │   ├── jenjang/
    │   │   ├── public/
    │   │   └── installer/
    │   ├── views/
    │   ├── stores/
    │   └── services/
    └── package.json
```

---

## 🔧 **IMPLEMENTASI STRATEGI GIT**

### **A. SETUP SINGLE REPOSITORY DENGAN BRANCH PER JENJANG**

#### **1.1 Create Main Repository:**
```bash
#!/bin/bash
# scripts/setup-git-repository.sh

set -e

BASE_DIR="/opt/kesiswaan"
GITHUB_ORG="siska-project"
REPO_NAME="siska-main"

echo "Setting up Git repository with branch per jenjang..."

# Create main repository
cd "$BASE_DIR"
git init siska-main
cd siska-main

# Create .gitignore
cat > .gitignore << 'EOF'
# Laravel
/vendor/
/node_modules/
.env
.env.local
.env.production
.env.testing
/storage/app/*
!/storage/app/.gitkeep
/storage/framework/cache/*
!/storage/framework/cache/.gitkeep
/storage/framework/sessions/*
!/storage/framework/sessions/.gitkeep
/storage/framework/views/*
!/storage/framework/views/.gitkeep
/storage/logs/*
!/storage/logs/.gitkeep
/bootstrap/cache/*
!/bootstrap/cache/.gitkeep

# Frontend
/dist/
/build/
.cache/
.parcel-cache/

# IDE
.vscode/
.idea/
*.swp
*.swo

# OS
.DS_Store
Thumbs.db

# Logs
*.log
npm-debug.log*
yarn-debug.log*
yarn-error.log*

# Runtime data
pids
*.pid
*.seed
*.pid.lock

# Coverage directory used by tools like istanbul
coverage/

# nyc test coverage
.nyc_output

# Dependency directories
node_modules/
jspm_packages/

# Optional npm cache directory
.npm

# Optional REPL history
.node_repl_history

# Output of 'npm pack'
*.tgz

# Yarn Integrity file
.yarn-integrity

# dotenv environment variables file
.env

# next.js build output
.next

# Nuxt.js build output
.nuxt

# vuepress build output
.vuepress/dist

# Serverless directories
.serverless

# FuseBox cache
.fusebox/

# DynamoDB Local files
.dynamodb/

# TernJS port file
.tern-port

# Database
*.sqlite
*.db

# Backup files
*.backup
*.bak

# Temporary files
*.tmp
*.temp
EOF

# Create README
cat > README.md << 'EOF'
# SISKA Isolated Architecture

Sistem Manajemen Kesiswaan dengan arsitektur isolated untuk multi-jenjang.

## Architecture

- **Core System**: Shared core system dengan license management
- **Jenjang Modules**: Isolated modules per jenjang (SD, SMP, SMA, SMK)
- **Public System**: Public content management
- **Installer**: Installation wizard system

## Quick Start

```bash
# Clone repository
git clone https://github.com/siska-project/siska-isolated.git
cd siska-isolated

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Start development
php artisan serve
npm run dev
```

## Documentation

- [Architecture Documentation](docs/architecture/)
- [API Documentation](docs/api/)
- [Deployment Guide](docs/deployment/)
- [Migration Guide](docs/migration/)
EOF

# Initial commit
git add .
git commit -m "Initial commit: SISKA Main Repository"

# Create branches for each module
echo "Creating branches for each module..."

# Core branch
git checkout -b core
git commit --allow-empty -m "Initial commit: Core system"
git push -u origin core

# SD branch
git checkout -b sd
git commit --allow-empty -m "Initial commit: SD module"
git push -u origin sd

# SMP branch
git checkout -b smp
git commit --allow-empty -m "Initial commit: SMP module"
git push -u origin smp

# SMA branch
git checkout -b sma
git commit --allow-empty -m "Initial commit: SMA module"
git push -u origin sma

# SMK branch
git checkout -b smk
git commit --allow-empty -m "Initial commit: SMK module"
git push -u origin smk

# Public branch
git checkout -b public
git commit --allow-empty -m "Initial commit: Public system"
git push -u origin public

# Installer branch
git checkout -b installer
git commit --allow-empty -m "Initial commit: Installer wizard"
git push -u origin installer

# Shared branch
git checkout -b shared
git commit --allow-empty -m "Initial commit: Shared components"
git push -u origin shared

# Develop branch
git checkout -b develop
git commit --allow-empty -m "Initial commit: Development integration"
git push -u origin develop

# Back to main
git checkout main

echo "Git repository with branches initialized successfully!"
echo "Repository: $BASE_DIR/siska-main"
echo "Branches: main, core, sd, smp, sma, smk, public, installer, shared, develop"
```

#### **1.2 Setup Remote Repository:**
```bash
#!/bin/bash
# scripts/setup-remote-repository.sh

set -e

BASE_DIR="/opt/kesiswaan"
GITHUB_ORG="siska-project"
REPO_NAME="siska-main"

echo "Setting up remote repository..."

cd "$BASE_DIR/siska-main"

# Add remote origin
git remote add origin "https://github.com/$GITHUB_ORG/$REPO_NAME.git"

# Push all branches
git push -u origin --all

echo "Remote repository setup completed!"
echo "Repository URL: https://github.com/$GITHUB_ORG/$REPO_NAME"
echo "All branches pushed to remote repository"
```

### **B. GIT WORKFLOW STRATEGY**

#### **2.1 Branch Strategy:**
```bash
# Main branches
main                    # Production-ready code
develop                 # Development integration branch

# Feature branches
feature/core-system     # Core system development
feature/jenjang-sd      # SD module development
feature/jenjang-smp     # SMP module development
feature/jenjang-sma     # SMA module development
feature/jenjang-smk     # SMK module development
feature/installer       # Installer wizard development
feature/public-system   # Public system development

# Release branches
release/v1.0.0          # Release preparation
release/v1.1.0          # Release preparation

# Hotfix branches
hotfix/critical-bug     # Critical bug fixes
```

#### **2.2 Git Hooks:**
```bash
#!/bin/bash
# .git/hooks/pre-commit

echo "Running pre-commit checks..."

# Run PHP CS Fixer
./vendor/bin/php-cs-fixer fix --dry-run --diff

# Run PHPUnit tests
./vendor/bin/phpunit

# Run frontend tests
npm run test

# Run linting
npm run lint

echo "Pre-commit checks completed!"
```

#### **2.3 Git Configuration:**
```bash
#!/bin/bash
# scripts/setup-git-config.sh

set -e

echo "Setting up Git configuration..."

# Global Git configuration
git config --global user.name "SISKA Developer"
git config --global user.email "dev@siska.local"
git config --global init.defaultBranch main
git config --global pull.rebase false
git config --global push.default simple

# Repository-specific configuration
cd /opt/kesiswaan/siska-isolated
git config core.autocrlf input
git config core.filemode false
git config core.ignorecase false

echo "Git configuration completed!"
```

---

## 🔄 **INTEGRATION STRATEGY**

### **A. SHARED COMPONENTS STRATEGY**

#### **3.1 Shared Repository Setup:**
```bash
#!/bin/bash
# scripts/setup-shared-repository.sh

set -e

BASE_DIR="/opt/kesiswaan"
GITHUB_ORG="siska-project"

echo "Setting up shared components repository..."

# Create shared repository
cd "$BASE_DIR"
git init siska-shared
cd siska-shared

# Create structure
mkdir -p components/php
mkdir -p components/vue
mkdir -p utilities/php
mkdir -p utilities/js
mkdir -p styles/css
mkdir -p assets/images
mkdir -p assets/icons

# Create package.json for shared components
cat > package.json << 'EOF'
{
  "name": "@siska/shared",
  "version": "1.0.0",
  "description": "Shared components and utilities for SISKA",
  "main": "index.js",
  "scripts": {
    "build": "npm run build:css && npm run build:js",
    "build:css": "tailwindcss -i ./styles/css/input.css -o ./dist/css/shared.css",
    "build:js": "webpack --mode production",
    "dev": "npm run dev:css & npm run dev:js",
    "dev:css": "tailwindcss -i ./styles/css/input.css -o ./dist/css/shared.css --watch",
    "dev:js": "webpack --mode development --watch"
  },
  "dependencies": {
    "vue": "^3.5.21",
    "tailwindcss": "^3.4.0"
  },
  "devDependencies": {
    "webpack": "^5.0.0",
    "webpack-cli": "^5.0.0"
  }
}
EOF

# Create composer.json for PHP shared components
cat > composer.json << 'EOF'
{
    "name": "siska/shared",
    "description": "Shared PHP components for SISKA",
    "type": "library",
    "autoload": {
        "psr-4": {
            "Siska\\Shared\\": "components/php/"
        }
    },
    "require": {
        "php": "^8.3",
        "illuminate/support": "^11.0"
    },
    "require-dev": {
        "phpunit/phpunit": "^10.0"
    }
}
EOF

# Initial commit
git add .
git commit -m "Initial commit: SISKA Shared Components"

echo "Shared repository setup completed!"
```

#### **3.2 Integration dengan Main Repository:**
```bash
#!/bin/bash
# scripts/integrate-shared-components.sh

set -e

BASE_DIR="/opt/kesiswaan"
SISKA_DIR="$BASE_DIR/siska-isolated"
SHARED_DIR="$BASE_DIR/siska-shared"

echo "Integrating shared components..."

cd "$SISKA_DIR"

# Add shared repository as submodule
git submodule add "$SHARED_DIR" shared
git submodule update --init --recursive

# Update composer.json to include shared components
cat >> composer.json << 'EOF'
    "repositories": [
        {
            "type": "path",
            "url": "./shared"
        }
    ],
    "require": {
        "siska/shared": "*"
    }
EOF

# Update package.json to include shared components
cat >> package.json << 'EOF'
    "dependencies": {
        "@siska/shared": "file:./shared"
    }
EOF

# Install dependencies
composer update
npm install

echo "Shared components integration completed!"
```

### **B. CI/CD STRATEGY**

#### **4.1 GitHub Actions Workflow:**
```yaml
# .github/workflows/ci.yml
name: CI/CD Pipeline

on:
  push:
    branches: [ main, develop ]
  pull_request:
    branches: [ main, develop ]

jobs:
  test:
    runs-on: ubuntu-latest
    
    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: password
          MYSQL_DATABASE: siska_test
        ports:
          - 3306:3306
        options: --health-cmd="mysqladmin ping" --health-interval=10s --health-timeout=5s --health-retries=3

    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.3'
        extensions: mbstring, dom, fileinfo, mysql
        coverage: xdebug
    
    - name: Setup Node.js
      uses: actions/setup-node@v3
      with:
        node-version: '18'
        cache: 'npm'
    
    - name: Install PHP dependencies
      run: composer install --no-progress --prefer-dist --optimize-autoloader
    
    - name: Install Node dependencies
      run: npm ci
    
    - name: Copy environment file
      run: cp .env.example .env
    
    - name: Generate application key
      run: php artisan key:generate
    
    - name: Run database migrations
      run: php artisan migrate --force
    
    - name: Run PHPUnit tests
      run: ./vendor/bin/phpunit --coverage-clover coverage.xml
    
    - name: Run frontend tests
      run: npm run test
    
    - name: Run linting
      run: npm run lint
    
    - name: Upload coverage to Codecov
      uses: codecov/codecov-action@v3
      with:
        file: ./coverage.xml
        flags: unittests
        name: codecov-umbrella
```

#### **4.2 Deployment Workflow:**
```yaml
# .github/workflows/deploy.yml
name: Deploy to Production

on:
  push:
    branches: [ main ]
    tags: [ 'v*' ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Deploy to server
      uses: appleboy/ssh-action@v0.1.5
      with:
        host: ${{ secrets.HOST }}
        username: ${{ secrets.USERNAME }}
        key: ${{ secrets.SSH_KEY }}
        script: |
          cd /opt/kesiswaan/siska-isolated
          git pull origin main
          composer install --no-dev --optimize-autoloader
          npm ci --production
          npm run build
          php artisan migrate --force
          php artisan config:cache
          php artisan route:cache
          php artisan view:cache
          systemctl restart nginx
          systemctl restart php8.3-fpm
```

---

## 🔄 **MIGRATION STRATEGY**

### **A. CODE MIGRATION WORKFLOW**

#### **5.1 Migration Script:**
```bash
#!/bin/bash
# scripts/migrate-from-legacy.sh

set -e

BASE_DIR="/opt/kesiswaan"
LEGACY_DIR="$BASE_DIR/backend"
ISOLATED_DIR="$BASE_DIR/siska-isolated"

echo "Starting code migration from legacy to isolated..."

# Create migration branch
cd "$ISOLATED_DIR"
git checkout -b feature/migrate-from-legacy

# Migrate core models
echo "Migrating core models..."
cp -r "$LEGACY_DIR/app/Models/User.php" "$ISOLATED_DIR/core/app/Models/Core/"
cp -r "$LEGACY_DIR/app/Models/School.php" "$ISOLATED_DIR/core/app/Models/Core/"

# Migrate public models
echo "Migrating public models..."
cp -r "$LEGACY_DIR/app/Models/Public/"* "$ISOLATED_DIR/core/app/Models/Public/"

# Migrate controllers
echo "Migrating controllers..."
cp -r "$LEGACY_DIR/app/Http/Controllers/Public/"* "$ISOLATED_DIR/core/app/Http/Controllers/Public/"

# Migrate services
echo "Migrating services..."
cp -r "$LEGACY_DIR/app/Services/Public/"* "$ISOLATED_DIR/core/app/Services/Public/"

# Migrate jenjang-specific code
echo "Migrating jenjang-specific code..."
for jenjang in sd smp sma smk; do
    # Copy and adapt models
    cp "$LEGACY_DIR/app/Models/Siswa.php" "$ISOLATED_DIR/jenjang/$jenjang/app/Models/Siswa${jenjang^^}.php"
    
    # Copy and adapt controllers
    cp "$LEGACY_DIR/app/Http/Controllers/SiswaController.php" "$ISOLATED_DIR/jenjang/$jenjang/app/Http/Controllers/SiswaController.php"
    
    # Copy and adapt services
    cp "$LEGACY_DIR/app/Services/SiswaService.php" "$ISOLATED_DIR/jenjang/$jenjang/app/Services/Siswa${jenjang^^}Service.php"
done

# Commit migration
git add .
git commit -m "Migrate code from legacy architecture"

echo "Code migration completed!"
echo "Branch: feature/migrate-from-legacy"
```

#### **5.2 Data Migration Script:**
```bash
#!/bin/bash
# scripts/migrate-data.sh

set -e

echo "Starting data migration..."

# Create data migration branch
cd /opt/kesiswaan/siska-isolated
git checkout -b feature/migrate-data

# Run data migration
php artisan migrate:data --from=legacy --to=isolated

# Commit data migration
git add .
git commit -m "Migrate data from legacy to isolated architecture"

echo "Data migration completed!"
```

---

## 🎯 **KEUNTUNGAN STRATEGI GIT INI:**

1. **Repository Separation**: Repository terpisah untuk isolated architecture
2. **Independent Development**: Develop isolated tanpa mengganggu legacy
3. **Shared Components**: Komponen yang bisa di-share antar repository
4. **Version Control**: Version control yang independen
5. **CI/CD**: CI/CD pipeline yang terpisah
6. **Collaboration**: Kolaborasi yang efisien antar tim
7. **Deployment**: Deployment yang terpisah dan independen
8. **Rollback**: Mudah rollback ke versi sebelumnya

---

## 🚀 **IMPLEMENTASI BERKELANJUTAN:**

1. **Week 1**: Setup Git repositories dan workflow
2. **Week 2**: Setup CI/CD pipeline
3. **Week 3**: Setup shared components
4. **Week 4**: Code migration dan testing
5. **Week 5**: Data migration dan validation
6. **Week 6**: Deployment dan monitoring

Dengan strategi Git ini, kita bisa maintain isolated architecture dengan baik sambil tetap support legacy project bro! 🚀✨
