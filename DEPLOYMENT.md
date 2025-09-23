# 🚀 **SISKA - DEPLOYMENT GUIDE**

## 📋 **INFORMASI SISTEM**

**Nama**: SISKA - Sistem Informasi Sekolah Bidang Kesiswaan  
**Versi**: 1.0.0  
**Arsitektur**: Isolated Jenjang Architecture  
**Database**: 6 Separate Databases  
**Frontend**: Vue.js 3 + TypeScript  
**Backend**: Laravel 11 + PHP 8.2  

## 🏗️ **ARSITEKTUR SISTEM**

### **Struktur Project:**
```
siska/
├── backend/                    # Laravel Backend API
├── frontend/                   # Vue.js Frontend
├── jenjang/                    # Isolated Jenjang Modules
│   ├── sd/                     # SD Module
│   ├── smp/                    # SMP Module
│   ├── sma/                    # SMA Module
│   └── smk/                    # SMK Module
├── installer/                  # Wizard Installation System
└── docs/                       # Documentation
```

### **Database Architecture:**
- **siska_backend** - Core system data
- **siska_public** - Public content data
- **siska_sd** - SD module data
- **siska_smp** - SMP module data
- **siska_sma** - SMA module data
- **siska_smk** - SMK module data

## 🔧 **SYSTEM REQUIREMENTS**

### **Server Requirements:**
- **OS**: Ubuntu 20.04+ / CentOS 8+ / Debian 11+
- **PHP**: 8.2+ dengan extensions:
  - BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML, ZIP
- **Database**: MySQL 8.0+ / MariaDB 10.6+
- **Web Server**: Nginx 1.18+ / Apache 2.4+
- **Node.js**: 18+ (untuk frontend build)
- **Composer**: 2.0+
- **Memory**: Minimum 2GB RAM
- **Storage**: Minimum 10GB free space

### **Recommended Server Specs:**
- **CPU**: 2+ cores
- **RAM**: 4GB+
- **Storage**: 50GB+ SSD
- **Network**: 100Mbps+

## 📦 **INSTALLATION METHODS**

### **Method 1: Wizard Installation (Recommended)**

1. **Upload Files:**
   ```bash
   # Upload semua file ke server
   scp -r siska/ user@server:/var/www/
   ```

2. **Set Permissions:**
   ```bash
   cd /var/www/siska
   chmod -R 755 .
   chown -R www-data:www-data .
   ```

3. **Access Wizard:**
   - Buka browser ke: `http://your-domain/installer`
   - Ikuti wizard installation step-by-step

### **Method 2: Manual Installation**

#### **Step 1: Database Setup**
```sql
-- Create databases
CREATE DATABASE siska_backend CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE siska_public CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE siska_sd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE siska_smp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE siska_sma CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE siska_smk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user
CREATE USER 'siska_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON siska_*.* TO 'siska_user'@'localhost';
FLUSH PRIVILEGES;
```

#### **Step 2: Backend Setup**
```bash
cd /var/www/siska/backend

# Install dependencies
composer install --optimize-autoloader --no-dev

# Environment setup
cp .env.example .env
nano .env  # Configure database and other settings

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link

# Cache optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### **Step 3: Frontend Setup**
```bash
cd /var/www/siska/frontend

# Install dependencies
npm install

# Build for production
npm run build

# Copy build files to web root
cp -r dist/* /var/www/html/
```

#### **Step 4: Web Server Configuration**

**Nginx Configuration:**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/siska/backend/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location /api {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location /installer {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

**Apache Configuration:**
```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot /var/www/siska/backend/public

    <Directory /var/www/siska/backend/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/siska_error.log
    CustomLog ${APACHE_LOG_DIR}/siska_access.log combined
</VirtualHost>
```

## 🔐 **SECURITY CONFIGURATION**

### **SSL Certificate:**
```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Get SSL certificate
sudo certbot --nginx -d your-domain.com

# Auto-renewal
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

### **Firewall Configuration:**
```bash
# UFW Configuration
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

### **PHP Security:**
```ini
# /etc/php/8.2/fpm/php.ini
expose_php = Off
display_errors = Off
log_errors = On
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 30
```

## 📊 **MONITORING & LOGGING**

### **Log Configuration:**
```bash
# Laravel logs
tail -f /var/www/siska/backend/storage/logs/laravel.log

# Nginx logs
tail -f /var/log/nginx/access.log
tail -f /var/log/nginx/error.log

# PHP-FPM logs
tail -f /var/log/php8.2-fpm.log
```

### **System Monitoring:**
```bash
# Install monitoring tools
sudo apt install htop iotop nethogs

# Monitor system resources
htop
iotop
nethogs
```

## 🔄 **BACKUP & RECOVERY**

### **Database Backup:**
```bash
#!/bin/bash
# backup.sh
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backup/siska"

mkdir -p $BACKUP_DIR

# Backup all databases
mysqldump -u siska_user -p siska_backend > $BACKUP_DIR/siska_backend_$DATE.sql
mysqldump -u siska_user -p siska_public > $BACKUP_DIR/siska_public_$DATE.sql
mysqldump -u siska_user -p siska_sd > $BACKUP_DIR/siska_sd_$DATE.sql
mysqldump -u siska_user -p siska_smp > $BACKUP_DIR/siska_smp_$DATE.sql
mysqldump -u siska_user -p siska_sma > $BACKUP_DIR/siska_sma_$DATE.sql
mysqldump -u siska_user -p siska_smk > $BACKUP_DIR/siska_smk_$DATE.sql

# Compress backups
tar -czf $BACKUP_DIR/siska_backup_$DATE.tar.gz $BACKUP_DIR/*_$DATE.sql

# Clean old backups (keep 7 days)
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
```

### **File Backup:**
```bash
#!/bin/bash
# file_backup.sh
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backup/siska"

# Backup application files
tar -czf $BACKUP_DIR/siska_files_$DATE.tar.gz /var/www/siska

# Clean old backups
find $BACKUP_DIR -name "siska_files_*.tar.gz" -mtime +7 -delete
```

### **Automated Backup:**
```bash
# Add to crontab
crontab -e

# Daily backup at 2 AM
0 2 * * * /path/to/backup.sh
0 3 * * * /path/to/file_backup.sh
```

## 🚀 **PERFORMANCE OPTIMIZATION**

### **Laravel Optimization:**
```bash
cd /var/www/siska/backend

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize database
php artisan optimize
```

### **Database Optimization:**
```sql
-- Optimize all databases
OPTIMIZE TABLE siska_backend.*;
OPTIMIZE TABLE siska_public.*;
OPTIMIZE TABLE siska_sd.*;
OPTIMIZE TABLE siska_smp.*;
OPTIMIZE TABLE siska_sma.*;
OPTIMIZE TABLE siska_smk.*;
```

### **Frontend Optimization:**
```bash
cd /var/www/siska/frontend

# Build with optimization
npm run build

# Enable gzip compression in Nginx
gzip on;
gzip_vary on;
gzip_min_length 1024;
gzip_types text/plain text/css text/xml text/javascript application/javascript application/xml+rss application/json;
```

## 🔧 **MAINTENANCE**

### **Regular Maintenance Tasks:**
```bash
# Weekly maintenance script
#!/bin/bash

# Clear Laravel caches
cd /var/www/siska/backend
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Update dependencies (if needed)
composer update --no-dev
npm update

# Check disk space
df -h

# Check system resources
free -h
```

### **Update Procedure:**
```bash
# 1. Backup current system
./backup.sh

# 2. Download new version
wget https://github.com/your-repo/siska/releases/latest/siska.tar.gz

# 3. Extract new version
tar -xzf siska.tar.gz

# 4. Update dependencies
cd siska/backend
composer install --optimize-autoloader --no-dev

cd ../frontend
npm install
npm run build

# 5. Run migrations
cd ../backend
php artisan migrate --force

# 6. Clear caches
php artisan optimize
```

## 🆘 **TROUBLESHOOTING**

### **Common Issues:**

#### **1. Database Connection Error:**
```bash
# Check database service
sudo systemctl status mysql

# Check database credentials
mysql -u siska_user -p -e "SHOW DATABASES;"

# Check Laravel configuration
php artisan config:show database
```

#### **2. Permission Issues:**
```bash
# Fix permissions
sudo chown -R www-data:www-data /var/www/siska
sudo chmod -R 755 /var/www/siska
sudo chmod -R 775 /var/www/siska/backend/storage
sudo chmod -R 775 /var/www/siska/backend/bootstrap/cache
```

#### **3. Frontend Build Issues:**
```bash
# Clear npm cache
npm cache clean --force

# Reinstall dependencies
rm -rf node_modules package-lock.json
npm install

# Rebuild
npm run build
```

#### **4. API Not Working:**
```bash
# Check Laravel logs
tail -f /var/www/siska/backend/storage/logs/laravel.log

# Check web server logs
tail -f /var/log/nginx/error.log

# Test API endpoints
curl -X GET http://your-domain.com/api/auth/check
```

## 📞 **SUPPORT**

### **Documentation:**
- **Main README**: `/opt/kesiswaan/siska/README.md`
- **Jenjang Modules**: `/opt/kesiswaan/siska/jenjang/*/README.md`
- **API Documentation**: `/opt/kesiswaan/siska/docs/api.md`

### **Contact:**
- **Developer**: jejakawan.com
- **Supported by**: K2NET - PT. Kirana Karina Network
- **Email**: support@jejakawan.com

### **Version Information:**
- **SISKA Version**: 1.0.0
- **Laravel Version**: 11.x
- **Vue.js Version**: 3.x
- **PHP Version**: 8.2+
- **MySQL Version**: 8.0+

---

**SISKA** - Sistem Informasi Sekolah Bidang Kesiswaan  
**Developed by**: [jejakawan.com](https://jejakawan.com)  
**Supported by**: **K2NET** - PT. Kirana Karina Network
