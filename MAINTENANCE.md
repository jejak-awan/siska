# 🔧 **SISKA - MAINTENANCE GUIDE**

## 📋 **INFORMASI SISTEM**

**Nama**: SISKA - Sistem Informasi Sekolah Bidang Kesiswaan  
**Versi**: 1.0.0  
**Arsitektur**: Isolated Jenjang Architecture  
**Database**: 6 Separate Databases  

## 🗓️ **MAINTENANCE SCHEDULE**

### **Daily Maintenance (Otomatis)**
- ✅ **Database Backup** - 02:00 WIB
- ✅ **Log Rotation** - 03:00 WIB
- ✅ **Cache Cleanup** - 04:00 WIB
- ✅ **Performance Monitoring** - Setiap jam

### **Weekly Maintenance (Manual)**
- ✅ **System Updates** - Minggu pagi
- ✅ **Security Patches** - Minggu pagi
- ✅ **Performance Optimization** - Minggu pagi
- ✅ **Log Analysis** - Minggu pagi

### **Monthly Maintenance (Manual)**
- ✅ **Full System Backup** - Awal bulan
- ✅ **Database Optimization** - Awal bulan
- ✅ **Security Audit** - Awal bulan
- ✅ **Performance Review** - Awal bulan

## 🔄 **BACKUP PROCEDURES**

### **1. Database Backup**

#### **Automated Backup Script:**
```bash
#!/bin/bash
# /opt/kesiswaan/scripts/backup_database.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backup/siska/database"
LOG_FILE="/var/log/siska/backup.log"

# Create backup directory
mkdir -p $BACKUP_DIR

# Database credentials
DB_USER="siska_user"
DB_PASS="your_password"

# Backup all databases
echo "$(date): Starting database backup" >> $LOG_FILE

# Backup Backend Database
mysqldump -u $DB_USER -p$DB_PASS siska_backend > $BACKUP_DIR/siska_backend_$DATE.sql
if [ $? -eq 0 ]; then
    echo "$(date): Backend database backup successful" >> $LOG_FILE
else
    echo "$(date): Backend database backup failed" >> $LOG_FILE
fi

# Backup Public Database
mysqldump -u $DB_USER -p$DB_PASS siska_public > $BACKUP_DIR/siska_public_$DATE.sql
if [ $? -eq 0 ]; then
    echo "$(date): Public database backup successful" >> $LOG_FILE
else
    echo "$(date): Public database backup failed" >> $LOG_FILE
fi

# Backup SD Database
mysqldump -u $DB_USER -p$DB_PASS siska_sd > $BACKUP_DIR/siska_sd_$DATE.sql
if [ $? -eq 0 ]; then
    echo "$(date): SD database backup successful" >> $LOG_FILE
else
    echo "$(date): SD database backup failed" >> $LOG_FILE
fi

# Backup SMP Database
mysqldump -u $DB_USER -p$DB_PASS siska_smp > $BACKUP_DIR/siska_smp_$DATE.sql
if [ $? -eq 0 ]; then
    echo "$(date): SMP database backup successful" >> $LOG_FILE
else
    echo "$(date): SMP database backup failed" >> $LOG_FILE
fi

# Backup SMA Database
mysqldump -u $DB_USER -p$DB_PASS siska_sma > $BACKUP_DIR/siska_sma_$DATE.sql
if [ $? -eq 0 ]; then
    echo "$(date): SMA database backup successful" >> $LOG_FILE
else
    echo "$(date): SMA database backup failed" >> $LOG_FILE
fi

# Backup SMK Database
mysqldump -u $DB_USER -p$DB_PASS siska_smk > $BACKUP_DIR/siska_smk_$DATE.sql
if [ $? -eq 0 ]; then
    echo "$(date): SMK database backup successful" >> $LOG_FILE
else
    echo "$(date): SMK database backup failed" >> $LOG_FILE
fi

# Compress backups
tar -czf $BACKUP_DIR/siska_backup_$DATE.tar.gz $BACKUP_DIR/*_$DATE.sql

# Clean up individual SQL files
rm $BACKUP_DIR/*_$DATE.sql

# Clean old backups (keep 30 days)
find $BACKUP_DIR -name "siska_backup_*.tar.gz" -mtime +30 -delete

echo "$(date): Database backup completed" >> $LOG_FILE
```

#### **Manual Backup Commands:**
```bash
# Backup specific database
mysqldump -u siska_user -p siska_backend > backup_backend_$(date +%Y%m%d).sql

# Backup all databases
for db in siska_backend siska_public siska_sd siska_smp siska_sma siska_smk; do
    mysqldump -u siska_user -p $db > backup_${db}_$(date +%Y%m%d).sql
done

# Compress backups
tar -czf siska_backup_$(date +%Y%m%d).tar.gz backup_*.sql
```

### **2. File System Backup**

#### **Automated File Backup Script:**
```bash
#!/bin/bash
# /opt/kesiswaan/scripts/backup_files.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backup/siska/files"
LOG_FILE="/var/log/siska/backup.log"

# Create backup directory
mkdir -p $BACKUP_DIR

echo "$(date): Starting file system backup" >> $LOG_FILE

# Backup application files
tar -czf $BACKUP_DIR/siska_files_$DATE.tar.gz \
    --exclude='node_modules' \
    --exclude='vendor' \
    --exclude='storage/logs' \
    --exclude='storage/framework/cache' \
    --exclude='storage/framework/sessions' \
    --exclude='storage/framework/views' \
    /opt/kesiswaan/siska

# Backup configuration files
tar -czf $BACKUP_DIR/siska_config_$DATE.tar.gz \
    /etc/nginx/sites-available/siska \
    /etc/php/8.2/fpm/pool.d/siska.conf \
    /opt/kesiswaan/siska/backend/.env

# Clean old backups (keep 30 days)
find $BACKUP_DIR -name "siska_files_*.tar.gz" -mtime +30 -delete
find $BACKUP_DIR -name "siska_config_*.tar.gz" -mtime +30 -delete

echo "$(date): File system backup completed" >> $LOG_FILE
```

## 🔍 **MONITORING PROCEDURES**

### **1. System Monitoring**

#### **Resource Monitoring Script:**
```bash
#!/bin/bash
# /opt/kesiswaan/scripts/monitor_system.sh

LOG_FILE="/var/log/siska/monitor.log"
ALERT_EMAIL="admin@your-domain.com"

# Check disk space
DISK_USAGE=$(df / | awk 'NR==2 {print $5}' | sed 's/%//')
if [ $DISK_USAGE -gt 80 ]; then
    echo "$(date): WARNING - Disk usage is ${DISK_USAGE}%" >> $LOG_FILE
    echo "Disk usage warning: ${DISK_USAGE}%" | mail -s "SISKA Disk Warning" $ALERT_EMAIL
fi

# Check memory usage
MEMORY_USAGE=$(free | awk 'NR==2{printf "%.2f", $3*100/$2}')
if (( $(echo "$MEMORY_USAGE > 80" | bc -l) )); then
    echo "$(date): WARNING - Memory usage is ${MEMORY_USAGE}%" >> $LOG_FILE
    echo "Memory usage warning: ${MEMORY_USAGE}%" | mail -s "SISKA Memory Warning" $ALERT_EMAIL
fi

# Check CPU load
CPU_LOAD=$(uptime | awk -F'load average:' '{print $2}' | awk '{print $1}' | sed 's/,//')
if (( $(echo "$CPU_LOAD > 2.0" | bc -l) )); then
    echo "$(date): WARNING - CPU load is ${CPU_LOAD}" >> $LOG_FILE
    echo "CPU load warning: ${CPU_LOAD}" | mail -s "SISKA CPU Warning" $ALERT_EMAIL
fi

# Check database connections
DB_CONNECTIONS=$(mysql -u siska_user -p -e "SHOW STATUS LIKE 'Threads_connected';" | awk 'NR==2 {print $2}')
if [ $DB_CONNECTIONS -gt 50 ]; then
    echo "$(date): WARNING - Database connections: ${DB_CONNECTIONS}" >> $LOG_FILE
    echo "Database connections warning: ${DB_CONNECTIONS}" | mail -s "SISKA DB Warning" $ALERT_EMAIL
fi

# Check web server status
if ! systemctl is-active --quiet nginx; then
    echo "$(date): ERROR - Nginx is not running" >> $LOG_FILE
    echo "Nginx service is down" | mail -s "SISKA Service Error" $ALERT_EMAIL
fi

if ! systemctl is-active --quiet php8.2-fpm; then
    echo "$(date): ERROR - PHP-FPM is not running" >> $LOG_FILE
    echo "PHP-FPM service is down" | mail -s "SISKA Service Error" $ALERT_EMAIL
fi

if ! systemctl is-active --quiet mysql; then
    echo "$(date): ERROR - MySQL is not running" >> $LOG_FILE
    echo "MySQL service is down" | mail -s "SISKA Service Error" $ALERT_EMAIL
fi
```

### **2. Application Monitoring**

#### **Laravel Health Check Script:**
```bash
#!/bin/bash
# /opt/kesiswaan/scripts/health_check.sh

LOG_FILE="/var/log/siska/health.log"
ALERT_EMAIL="admin@your-domain.com"

cd /opt/kesiswaan/siska/backend

# Check Laravel application
if ! php artisan --version > /dev/null 2>&1; then
    echo "$(date): ERROR - Laravel application not responding" >> $LOG_FILE
    echo "Laravel application error" | mail -s "SISKA App Error" $ALERT_EMAIL
fi

# Check database connectivity
if ! php artisan tinker --execute="DB::connection()->getPdo();" > /dev/null 2>&1; then
    echo "$(date): ERROR - Database connection failed" >> $LOG_FILE
    echo "Database connection error" | mail -s "SISKA DB Error" $ALERT_EMAIL
fi

# Check storage permissions
if [ ! -w storage/logs ]; then
    echo "$(date): WARNING - Storage logs not writable" >> $LOG_FILE
fi

if [ ! -w storage/framework/cache ]; then
    echo "$(date): WARNING - Storage cache not writable" >> $LOG_FILE
fi

# Check log file size
LOG_SIZE=$(du -m storage/logs/laravel.log | cut -f1)
if [ $LOG_SIZE -gt 100 ]; then
    echo "$(date): WARNING - Log file size: ${LOG_SIZE}MB" >> $LOG_FILE
    # Rotate log file
    mv storage/logs/laravel.log storage/logs/laravel_$(date +%Y%m%d_%H%M%S).log
    touch storage/logs/laravel.log
    chown www-data:www-data storage/logs/laravel.log
fi
```

## 🚀 **PERFORMANCE OPTIMIZATION**

### **1. Laravel Optimization**

#### **Weekly Optimization Script:**
```bash
#!/bin/bash
# /opt/kesiswaan/scripts/optimize_laravel.sh

cd /opt/kesiswaan/siska/backend

echo "$(date): Starting Laravel optimization" >> /var/log/siska/optimization.log

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Run database optimization
php artisan optimize

echo "$(date): Laravel optimization completed" >> /var/log/siska/optimization.log
```

### **2. Database Optimization**

#### **Monthly Database Optimization:**
```bash
#!/bin/bash
# /opt/kesiswaan/scripts/optimize_database.sh

DB_USER="siska_user"
DB_PASS="your_password"

echo "$(date): Starting database optimization" >> /var/log/siska/optimization.log

# Optimize all databases
for db in siska_backend siska_public siska_sd siska_smp siska_sma siska_smk; do
    echo "Optimizing database: $db"
    mysql -u $DB_USER -p$DB_PASS -e "USE $db; OPTIMIZE TABLE *;"
done

# Analyze tables
for db in siska_backend siska_public siska_sd siska_smp siska_sma siska_smk; do
    echo "Analyzing database: $db"
    mysql -u $DB_USER -p$DB_PASS -e "USE $db; ANALYZE TABLE *;"
done

echo "$(date): Database optimization completed" >> /var/log/siska/optimization.log
```

### **3. Frontend Optimization**

#### **Frontend Build Optimization:**
```bash
#!/bin/bash
# /opt/kesiswaan/scripts/optimize_frontend.sh

cd /opt/kesiswaan/siska/frontend

echo "$(date): Starting frontend optimization" >> /var/log/siska/optimization.log

# Clear npm cache
npm cache clean --force

# Install dependencies
npm install

# Build for production
npm run build

# Optimize images (if imagemagick is installed)
if command -v convert &> /dev/null; then
    find dist/assets -name "*.png" -exec convert {} -strip {} \;
    find dist/assets -name "*.jpg" -exec convert {} -strip -quality 85 {} \;
fi

echo "$(date): Frontend optimization completed" >> /var/log/siska/optimization.log
```

## 🔒 **SECURITY MAINTENANCE**

### **1. Security Updates**

#### **Weekly Security Update Script:**
```bash
#!/bin/bash
# /opt/kesiswaan/scripts/security_update.sh

LOG_FILE="/var/log/siska/security.log"

echo "$(date): Starting security updates" >> $LOG_FILE

# Update system packages
apt update
apt upgrade -y

# Update PHP packages
apt install php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl -y

# Update Composer packages
cd /opt/kesiswaan/siska/backend
composer update --no-dev

# Update NPM packages
cd /opt/kesiswaan/siska/frontend
npm update

# Check for security vulnerabilities
composer audit
npm audit

echo "$(date): Security updates completed" >> $LOG_FILE
```

### **2. Security Audit**

#### **Monthly Security Audit:**
```bash
#!/bin/bash
# /opt/kesiswaan/scripts/security_audit.sh

LOG_FILE="/var/log/siska/security_audit.log"

echo "$(date): Starting security audit" >> $LOG_FILE

# Check file permissions
find /opt/kesiswaan/siska -type f -perm /o+w >> $LOG_FILE
find /opt/kesiswaan/siska -type d -perm /o+w >> $LOG_FILE

# Check for suspicious files
find /opt/kesiswaan/siska -name "*.php" -exec grep -l "eval\|base64_decode\|system\|exec" {} \; >> $LOG_FILE

# Check log files for suspicious activity
grep -i "error\|warning\|failed\|denied" /var/log/nginx/error.log >> $LOG_FILE
grep -i "error\|warning\|failed\|denied" /opt/kesiswaan/siska/backend/storage/logs/laravel.log >> $LOG_FILE

# Check database for suspicious activity
mysql -u siska_user -p -e "SELECT * FROM mysql.general_log WHERE command_type = 'Query' AND argument LIKE '%DROP%' OR argument LIKE '%DELETE%';" >> $LOG_FILE

echo "$(date): Security audit completed" >> $LOG_FILE
```

## 📊 **LOG MANAGEMENT**

### **1. Log Rotation Configuration**

#### **Logrotate Configuration:**
```bash
# /etc/logrotate.d/siska

/opt/kesiswaan/siska/backend/storage/logs/*.log {
    daily
    missingok
    rotate 30
    compress
    delaycompress
    notifempty
    create 644 www-data www-data
    postrotate
        systemctl reload php8.2-fpm
    endscript
}

/var/log/siska/*.log {
    daily
    missingok
    rotate 30
    compress
    delaycompress
    notifempty
    create 644 root root
}
```

### **2. Log Analysis**

#### **Daily Log Analysis Script:**
```bash
#!/bin/bash
# /opt/kesiswaan/scripts/analyze_logs.sh

LOG_DIR="/opt/kesiswaan/siska/backend/storage/logs"
ANALYSIS_DIR="/var/log/siska/analysis"
DATE=$(date +%Y%m%d)

mkdir -p $ANALYSIS_DIR

# Analyze error logs
grep -i "error" $LOG_DIR/laravel.log | tail -100 > $ANALYSIS_DIR/errors_$DATE.log

# Analyze warning logs
grep -i "warning" $LOG_DIR/laravel.log | tail -100 > $ANALYSIS_DIR/warnings_$DATE.log

# Analyze access patterns
grep "GET\|POST\|PUT\|DELETE" $LOG_DIR/laravel.log | awk '{print $1}' | sort | uniq -c | sort -nr > $ANALYSIS_DIR/access_patterns_$DATE.log

# Generate summary report
echo "SISKA Log Analysis Report - $(date)" > $ANALYSIS_DIR/summary_$DATE.txt
echo "=================================" >> $ANALYSIS_DIR/summary_$DATE.txt
echo "Total Errors: $(grep -c -i "error" $LOG_DIR/laravel.log)" >> $ANALYSIS_DIR/summary_$DATE.txt
echo "Total Warnings: $(grep -c -i "warning" $LOG_DIR/laravel.log)" >> $ANALYSIS_DIR/summary_$DATE.txt
echo "Total Requests: $(grep -c "GET\|POST\|PUT\|DELETE" $LOG_DIR/laravel.log)" >> $ANALYSIS_DIR/summary_$DATE.txt
```

## 🆘 **TROUBLESHOOTING**

### **1. Common Issues**

#### **Database Connection Issues:**
```bash
# Check database service
systemctl status mysql

# Check database connectivity
mysql -u siska_user -p -e "SHOW DATABASES;"

# Check Laravel database configuration
cd /opt/kesiswaan/siska/backend
php artisan config:show database
```

#### **Permission Issues:**
```bash
# Fix file permissions
chown -R www-data:www-data /opt/kesiswaan/siska
chmod -R 755 /opt/kesiswaan/siska
chmod -R 775 /opt/kesiswaan/siska/backend/storage
chmod -R 775 /opt/kesiswaan/siska/backend/bootstrap/cache
```

#### **Service Issues:**
```bash
# Restart services
systemctl restart nginx
systemctl restart php8.2-fpm
systemctl restart mysql

# Check service status
systemctl status nginx
systemctl status php8.2-fpm
systemctl status mysql
```

### **2. Emergency Procedures**

#### **Emergency Backup:**
```bash
# Quick backup before emergency fix
mysqldump -u siska_user -p --all-databases > emergency_backup_$(date +%Y%m%d_%H%M%S).sql
tar -czf emergency_files_$(date +%Y%m%d_%H%M%S).tar.gz /opt/kesiswaan/siska
```

#### **Emergency Restore:**
```bash
# Restore from backup
mysql -u siska_user -p < emergency_backup_YYYYMMDD_HHMMSS.sql
tar -xzf emergency_files_YYYYMMDD_HHMMSS.tar.gz -C /
```

## 📞 **SUPPORT CONTACTS**

### **Technical Support:**
- **Developer**: jejakawan.com
- **Email**: support@jejakawan.com
- **Phone**: +62-xxx-xxx-xxxx

### **Emergency Contacts:**
- **System Administrator**: admin@your-domain.com
- **Database Administrator**: dba@your-domain.com
- **Network Administrator**: network@your-domain.com

---

**SISKA** - Sistem Informasi Sekolah Bidang Kesiswaan  
**Developed by**: [jejakawan.com](https://jejakawan.com)  
**Supported by**: **K2NET** - PT. Kirana Karina Network
