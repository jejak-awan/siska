# 🎓 SISKA - Sistem Informasi Sekolah Bidang Kesiswaan (Isolated Architecture)

## 📋 **INFORMASI PROYEK**

**SISKA** (Sistem Informasi Sekolah Bidang Kesiswaan)  
**Pengembang**: [jejakawan.com](https://jejakawan.com)  
**GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)  
**Supported by**: **K2NET** - PT. Kirana Karina Network  
*"Provide Different IT Solutions"*

## 🎯 **OVERVIEW**

Workspace ini adalah implementasi dari **Isolated Architecture** untuk sistem SISKA. Setiap jenjang pendidikan (SD, SMP, SMA, SMK) memiliki modul terpisah dengan database isolated, namun tetap menggunakan core system yang shared.

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
git checkout sd

# 2. Develop features
git add .
git commit -m "feat(sd): add presensi system"

# 3. Push to remote
git push origin sd

# 4. Create Pull Request
# 5. Merge to develop
# 6. Deploy to main
```

### **Commit Convention:**
```bash
feat(scope): description    # New feature
fix(scope): description     # Bug fix
docs(scope): description    # Documentation
refactor(scope): description # Code refactoring
test(scope): description    # Tests
```

## 📚 **DOKUMENTASI**

### **Dokumentasi Strategi:**
- **[Skema Database Isolated](docs/skema-database-isolated.md)** - Database schema untuk isolated architecture
- **[Struktur Aplikasi Isolated](docs/struktur-aplikasi-isolated.md)** - Struktur aplikasi per jenjang
- **[Strategi Git Integration](docs/strategi-git-integration.md)** - Git workflow dan branch strategy
- **[Strategi Migrasi Folder Structure](docs/strategi-migrasi-folder-structure.md)** - Migrasi dari legacy ke isolated
- **[Strategi Multi-Jenjang Flow](docs/strategi-multi-jenjang-flow.md)** - Flow diagram dan strategi multi-jenjang
- **[Strategi Performa & Backup](docs/strategi-performa-backup-multi-jenjang.md)** - Optimasi performa dan backup strategy
- **[Strategi Wizard Instalasi](docs/strategi-wizard-installasi-isolated.md)** - Installation wizard flow
- **[Rekomendasi Dokumentasi](docs/rekomendasi-dokumentasi.md)** - Rekomendasi dokumentasi yang perlu dipertahankan
- **[Template Header](docs/template-header.md)** - Template untuk header dokumentasi

### **Dokumentasi Teknis:**
- **[Core System](backend/README.md)** - Dokumentasi core system
- **[SD Module](jenjang/sd/README.md)** - Dokumentasi modul SD
- **[Public System](public/README.md)** - Dokumentasi sistem publik
- **[Installer Wizard](installer/README.md)** - Dokumentasi installer
- **[Shared Components](shared/README.md)** - Dokumentasi komponen shared
- **[Frontend](frontend/README.md)** - Dokumentasi frontend

## 🏗️ **STRUKTUR WORKSPACE**

```
siska/
├── backend/                       # Core system (shared)
│   ├── app/
│   │   ├── Controllers/
│   │   │   ├── Core/          # License, sekolah Profile, etc.
│   │   │   └── Public/        # Public content management
│   │   ├── Models/
│   │   │   ├── Core/          # Core models
│   │   │   └── Public/        # Public models
│   │   └── Services/
│   │       ├── Core/          # Core services
│   │       └── Public/        # Public services
│   ├── config/                # Core configuration
│   ├── database/
│   │   ├── migrations/
│   │   │   ├── backend/          # Core migrations
│   │   │   └── public/        # Public migrations
│   │   └── seeders/
│   │       ├── backend/          # Core seeders
│   │       └── public/        # Public seeders
│   └── routes/                # Core routes
├── jenjang/                   # Jenjang modules (isolated)
│   ├── sd/                    # SD module
│   ├── smp/                   # SMP module
│   ├── sma/                   # SMA module
│   └── smk/                   # SMK module
├── public/                    # Public system (shared)
│   ├── app/
│   ├── config/
│   ├── database/
│   └── routes/
├── installer/                 # Installation wizard
│   ├── app/
│   ├── config/
│   └── resources/
├── shared/                    # Shared components
│   ├── components/
│   ├── utilities/
│   ├── styles/
│   └── assets/
└── frontend/                  # Frontend (all modules)
    ├── src/
    │   ├── components/
    │   │   ├── backend/
    │   │   ├── jenjang/
    │   │   ├── public/
    │   │   └── installer/
    │   ├── views/
    │   ├── stores/
    │   ├── services/
    │   └── utils/
    ├── assets/
    └── public/
└── docs/                       # Documentation
    ├── skema-database-isolated.md
    ├── struktur-aplikasi-isolated.md
    ├── strategi-git-integration.md
    ├── strategi-migrasi-folder-structure.md
    ├── strategi-multi-jenjang-flow.md
    ├── strategi-performa-backup-multi-jenjang.md
    ├── strategi-wizard-installasi-isolated.md
    ├── rekomendasi-dokumentasi.md
    └── template-header.md
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
git clone https://github.com/jejak-awan/siska-main.git
cd siska-main

# Setup core system
cd core
composer install
cp .env.example .env
php artisan key:generate

# Setup jenjang modules
cd ../jenjang/sd
composer install

# Setup public system
cd ../../public
composer install

# Setup installer
cd ../installer
composer install

# Setup frontend
cd ../frontend
npm install
npm run dev
```

## 📊 **DATABASE STRUCTURE**

### Isolated Databases per Jenjang:
- `siska_sd` - SD database (isolated)
- `siska_smp` - SMP database (isolated)
- `siska_sma` - SMA database (isolated)
- `siska_smk` - SMK database (isolated)

### Shared Databases:
- `siska_core` - Core database (license, sekolah profile, etc.)
- `siska_public` - Public database (news, programs, gallery, etc.)

## 🔄 **GIT STRATEGY**

### Branch per Module:
- `main` - Production-ready code (all modules)
- `core` - Core system development
- `sd` - SD module development
- `smp` - SMP module development
- `sma` - SMA module development
- `smk` - SMK module development
- `public` - Public system development
- `installer` - Installer wizard development
- `shared` - Shared components development
- `develop` - Development integration branch

## 📚 **DOCUMENTATION**

- [Database Schema](../docs/skema-database-isolated.md)
- [Application Structure](../docs/struktur-aplikasi-isolated.md)
- [Git Integration Strategy](../docs/strategi-git-integration.md)
- [Migration Strategy](../docs/strategi-migrasi-folder-structure.md)
- [Installation Wizard](../docs/strategi-wizard-installasi-isolated.md)
- [Performance & Backup](../docs/strategi-performa-backup-multi-jenjang.md)

## 🎯 **DEVELOPMENT WORKFLOW**

1. **Core Development**: Work di branch `core`
2. **Jenjang Development**: Work di branch sesuai jenjang (`sd`, `smp`, `sma`, `smk`)
3. **Public Development**: Work di branch `public`
4. **Installer Development**: Work di branch `installer`
5. **Integration**: Merge ke branch `develop`
6. **Production**: Merge ke branch `main`

## 🔐 **LICENSE MANAGEMENT**

Sistem ini menggunakan license-based access control:
- **Single Jenjang**: Install hanya 1 jenjang
- **Multi Jenjang**: Install multiple jenjang
- **Feature Access**: Akses fitur berdasarkan lisensi
- **Upgrade Path**: Upgrade dari single ke multi jenjang

## 📞 **SUPPORT**

- **GitHub**: [@jejak-awan](https://github.com/jejak-awan) | [@k2netid](https://github.com/k2netid)
- **Website**: [jejakawan.com](https://jejakawan.com)
- **Company**: K2NET - PT. Kirana Karina Network

---

**SISKA** - Membangun masa depan pendidikan Indonesia yang lebih baik! 🎓✨

*Dibuat dengan ❤️ untuk pendidikan Indonesia*
