# 📘 DOKUMENTASI E-HIBAH BUKITTINGGI - BAGIAN 4
## DEPLOYMENT & MAINTENANCE

**Tanggal:** 24 November 2025  
**Versi:** 1.0  

---

## 📋 DAFTAR ISI BAGIAN 4

1. [System Requirements](#system-requirements)
2. [Installation Guide](#installation-guide)
3. [Configuration](#configuration)
4. [Deployment](#deployment)
5. [Database Management](#database-management)
6. [Backup & Recovery](#backup--recovery)
7. [Monitoring](#monitoring)
8. [Troubleshooting](#troubleshooting)
9. [Maintenance Tasks](#maintenance-tasks)
10. [Security Hardening](#security-hardening)

---

## 💻 SYSTEM REQUIREMENTS

### Server Requirements

**Minimum:**
- PHP: 8.2+
- MySQL: 8.0+
- Nginx/Apache: Latest stable
- Composer: 2.6+
- Node.js: 18+
- NPM: 9+

**Recommended:**
- PHP: 8.3
- MySQL: 8.0.35
- Nginx: 1.24
- Redis: 7.0+ (untuk caching & queue)
- Supervisor (untuk queue worker)

---

### PHP Extensions Required

```ini
extension=bcmath
extension=ctype
extension=fileinfo
extension=json
extension=mbstring
extension=openssl
extension=pdo
extension=pdo_mysql
extension=tokenizer
extension=xml
extension=curl
extension=gd
extension=zip
```

---

### Server Specifications

**Development:**
- CPU: 2 cores
- RAM: 4 GB
- Storage: 20 GB SSD
- Bandwidth: 10 Mbps

**Production (Small Scale):**
- CPU: 4 cores
- RAM: 8 GB
- Storage: 100 GB SSD
- Bandwidth: 100 Mbps

**Production (Large Scale):**
- CPU: 8 cores
- RAM: 16 GB
- Storage: 500 GB SSD
- Bandwidth: 1 Gbps

---

## 🚀 INSTALLATION GUIDE

### 1. Clone Repository

```powershell
# Clone dari Git
git clone https://github.com/your-org/e-hibah-bukittinggi.git
cd e-hibah-bukittinggi
```

---

### 2. Install Dependencies

```powershell
# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node.js dependencies
npm install

# Build assets
npm run build
```

---

### 3. Environment Configuration

```powershell
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

**Edit `.env` file:**

```ini
# Application
APP_NAME="E-Hibah Bukittinggi"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY
APP_DEBUG=false
APP_TIMEZONE=Asia/Jakarta
APP_URL=https://ehibah.bukittinggi.go.id

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ehibah_bukittinggi
DB_USERNAME=ehibah_user
DB_PASSWORD=STRONG_PASSWORD_HERE

# Cache & Session
CACHE_STORE=redis
SESSION_DRIVER=database
QUEUE_CONNECTION=redis

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@bukittinggi.go.id
MAIL_FROM_NAME="${APP_NAME}"

# Filesystem
FILESYSTEM_DISK=local

# Logging
LOG_CHANNEL=daily
LOG_LEVEL=warning
```

---

### 4. Database Setup

```powershell
# Create database
mysql -u root -p -e "CREATE DATABASE ehibah_bukittinggi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Create database user
mysql -u root -p -e "CREATE USER 'ehibah_user'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD';"

# Grant privileges
mysql -u root -p -e "GRANT ALL PRIVILEGES ON ehibah_bukittinggi.* TO 'ehibah_user'@'localhost';"

# Flush privileges
mysql -u root -p -e "FLUSH PRIVILEGES;"

# Run migrations
php artisan migrate --force

# Seed initial data
php artisan db:seed --force
```

---

### 5. Storage Setup

```powershell
# Create storage link
php artisan storage:link

# Set permissions (Linux/Unix)
chmod -R 775 storage bootstrap/cache

# Set ownership (Linux/Unix)
chown -R www-data:www-data storage bootstrap/cache
```

**For Windows (Development):**
```powershell
# Ensure IIS_IUSRS has write access to:
# - storage/
# - bootstrap/cache/
```

---

### 6. Cache & Optimization

```powershell
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer dump-autoload -o
```

---

## ⚙️ CONFIGURATION

### Web Server Configuration

**Nginx Configuration:**

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name ehibah.bukittinggi.go.id;
    
    # Redirect to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name ehibah.bukittinggi.go.id;
    
    root /var/www/e-hibah-bukittinggi/public;
    index index.php index.html;
    
    # SSL Configuration
    ssl_certificate /etc/ssl/certs/ehibah.crt;
    ssl_certificate_key /etc/ssl/private/ehibah.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    
    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;
    
    # Logging
    access_log /var/log/nginx/ehibah_access.log;
    error_log /var/log/nginx/ehibah_error.log;
    
    # Client Body Size (for file uploads)
    client_max_body_size 100M;
    
    # Location blocks
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
    
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

---

**Apache Configuration (.htaccess):**

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Security Headers
<IfModule mod_headers.c>
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-Content-Type-Options "nosniff"
    Header set X-XSS-Protection "1; mode=block"
    Header set Referrer-Policy "no-referrer-when-downgrade"
</IfModule>

# File Upload Limit
php_value upload_max_filesize 100M
php_value post_max_size 100M
php_value max_execution_time 300
php_value max_input_time 300
```

---

### Supervisor Configuration (Queue Worker)

**File:** `/etc/supervisor/conf.d/ehibah-worker.conf`

```ini
[program:ehibah-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/e-hibah-bukittinggi/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/ehibah-worker.log
stopwaitsecs=3600
```

**Start Supervisor:**
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start ehibah-worker:*
```

---

### Cron Jobs

**File:** `/etc/cron.d/ehibah`

```bash
# Laravel Scheduler
* * * * * www-data cd /var/www/e-hibah-bukittinggi && php artisan schedule:run >> /dev/null 2>&1

# Daily Backup (03:00 AM)
0 3 * * * root /var/www/e-hibah-bukittinggi/scripts/backup.sh >> /var/log/ehibah-backup.log 2>&1

# Clean old logs (weekly)
0 2 * * 0 www-data cd /var/www/e-hibah-bukittinggi && php artisan log:clear --days=30

# Clear expired sessions (daily)
0 4 * * * www-data cd /var/www/e-hibah-bukittinggi && php artisan session:clear
```

---

## 🌐 DEPLOYMENT

### Deployment Workflow

```
Development → Staging → Production
```

---

### Using Deployment Script

**File:** `deploy.sh`

```bash
#!/bin/bash

# E-Hibah Bukittinggi Deployment Script
# Usage: ./deploy.sh [branch]

BRANCH=${1:-main}
APP_DIR="/var/www/e-hibah-bukittinggi"

echo "🚀 Starting deployment for branch: $BRANCH"

cd $APP_DIR

# Enable maintenance mode
echo "📝 Enabling maintenance mode..."
php artisan down

# Pull latest changes
echo "⬇️  Pulling latest code..."
git fetch origin
git checkout $BRANCH
git pull origin $BRANCH

# Install dependencies
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Update frontend assets
echo "🎨 Building assets..."
npm ci
npm run build

# Run migrations
echo "🗄️  Running migrations..."
php artisan migrate --force

# Clear & rebuild cache
echo "🔄 Rebuilding cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize
php artisan optimize

# Restart queue workers
echo "♻️  Restarting queue workers..."
php artisan queue:restart

# Set permissions
echo "🔒 Setting permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Disable maintenance mode
echo "✅ Disabling maintenance mode..."
php artisan up

echo "🎉 Deployment completed successfully!"
```

**Make executable and run:**
```bash
chmod +x deploy.sh
./deploy.sh main
```

---

### Zero-Downtime Deployment

**Using Laravel Forge / Envoyer:**

```yaml
# .envoyer/deploy.yml
deployment:
  - composer install --no-dev --optimize-autoloader
  - npm ci
  - npm run build
  - php artisan migrate --force
  - php artisan config:cache
  - php artisan route:cache
  - php artisan view:cache
  - php artisan queue:restart
```

---

## 💾 DATABASE MANAGEMENT

### Database Backup

**Backup Script:** `scripts/backup.sh`

```bash
#!/bin/bash

# Database Backup Script
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/ehibah"
DB_NAME="ehibah_bukittinggi"
DB_USER="ehibah_user"
DB_PASS="YOUR_PASSWORD"
RETENTION_DAYS=30

# Create backup directory
mkdir -p $BACKUP_DIR

# Backup database
echo "Starting database backup..."
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_backup_$DATE.sql.gz

# Backup uploaded files
echo "Backing up uploaded files..."
tar -czf $BACKUP_DIR/files_backup_$DATE.tar.gz /var/www/e-hibah-bukittinggi/storage/app/public

# Delete old backups
echo "Cleaning old backups..."
find $BACKUP_DIR -name "*.sql.gz" -mtime +$RETENTION_DAYS -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +$RETENTION_DAYS -delete

echo "Backup completed: $DATE"
```

---

### Database Restore

```bash
#!/bin/bash

# Database Restore Script
# Usage: ./restore.sh backup_file.sql.gz

BACKUP_FILE=$1
DB_NAME="ehibah_bukittinggi"
DB_USER="ehibah_user"
DB_PASS="YOUR_PASSWORD"

if [ -z "$BACKUP_FILE" ]; then
    echo "Usage: ./restore.sh backup_file.sql.gz"
    exit 1
fi

echo "⚠️  WARNING: This will replace current database!"
read -p "Are you sure? (yes/no): " confirm

if [ "$confirm" != "yes" ]; then
    echo "Restore cancelled."
    exit 0
fi

# Enable maintenance mode
php artisan down

# Restore database
echo "Restoring database..."
gunzip < $BACKUP_FILE | mysql -u $DB_USER -p$DB_PASS $DB_NAME

# Clear cache
php artisan cache:clear
php artisan config:clear

# Disable maintenance mode
php artisan up

echo "✅ Database restored successfully!"
```

---

### Database Optimization

```bash
# Optimize tables
php artisan db:optimize

# Or manually:
mysql -u root -p -e "USE ehibah_bukittinggi; OPTIMIZE TABLE users, lembagas, permohonans;"
```

---

## 📊 MONITORING

### Application Monitoring

**Install Laravel Telescope (Development):**

```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

**Config:** `config/telescope.php`

```php
'enabled' => env('TELESCOPE_ENABLED', true),
'path' => 'admin/telescope',
'middleware' => ['web', 'auth', 'role:Super Admin'],
```

---

### Server Monitoring

**Check Application Status:**

```bash
# Check PHP-FPM
sudo systemctl status php8.3-fpm

# Check Nginx
sudo systemctl status nginx

# Check MySQL
sudo systemctl status mysql

# Check Redis
sudo systemctl status redis

# Check Queue Workers
sudo supervisorctl status ehibah-worker:*
```

---

### Performance Monitoring

**Laravel Horizon (for Redis Queue):**

```bash
composer require laravel/horizon
php artisan horizon:install
php artisan horizon:publish
```

**Access:** `https://ehibah.bukittinggi.go.id/admin/horizon`

---

### Log Monitoring

**View Logs:**

```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Nginx access logs
tail -f /var/log/nginx/ehibah_access.log

# Nginx error logs
tail -f /var/log/nginx/ehibah_error.log

# MySQL slow query log
tail -f /var/log/mysql/mysql-slow.log

# Queue worker logs
tail -f /var/log/ehibah-worker.log
```

---

### Alert Setup

**Email Alerts for Errors:**

```php
// app/Exceptions/Handler.php
public function register(): void
{
    $this->reportable(function (Throwable $e) {
        if (app()->environment('production')) {
            Mail::to('admin@bukittinggi.go.id')->send(
                new ErrorAlert($e)
            );
        }
    });
}
```

---

## 🔧 TROUBLESHOOTING

### Common Issues

**1. Permission Denied**

```bash
# Fix storage permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

---

**2. 500 Internal Server Error**

```bash
# Check logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Regenerate cache
php artisan config:cache
php artisan route:cache
```

---

**3. Database Connection Failed**

```bash
# Check MySQL status
sudo systemctl status mysql

# Test connection
mysql -u ehibah_user -p -e "SHOW DATABASES;"

# Check .env configuration
cat .env | grep DB_

# Clear config cache
php artisan config:clear
```

---

**4. Queue Jobs Not Processing**

```bash
# Check queue workers
sudo supervisorctl status ehibah-worker:*

# Restart workers
sudo supervisorctl restart ehibah-worker:*

# Check failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all
```

---

**5. File Upload Error**

```bash
# Check upload limits
php -i | grep upload_max_filesize
php -i | grep post_max_size

# Check storage link
ls -la public/storage

# Recreate storage link
php artisan storage:link
```

---

**6. CSRF Token Mismatch**

```bash
# Clear sessions
php artisan session:flush

# Check session driver in .env
SESSION_DRIVER=database

# Clear browser cookies
```

---

**7. Memory Limit Exceeded**

```bash
# Increase memory limit in php.ini
memory_limit = 512M

# Or in .htaccess
php_value memory_limit 512M

# Restart PHP-FPM
sudo systemctl restart php8.3-fpm
```

---

## 🛠️ MAINTENANCE TASKS

### Daily Tasks

```bash
# Clear expired sessions
php artisan session:clear

# Process queued emails
php artisan queue:work --stop-when-empty

# Check application health
php artisan health:check
```

---

### Weekly Tasks

```bash
# Optimize database
php artisan db:optimize

# Clear old logs
php artisan log:clear --days=7

# Check disk space
df -h

# Review error logs
tail -100 storage/logs/laravel.log
```

---

### Monthly Tasks

```bash
# Full backup
./scripts/backup.sh

# Security updates
composer update --with-dependencies
npm audit fix

# Database maintenance
php artisan migrate:status

# Review user access
php artisan user:review
```

---

### Quarterly Tasks

```bash
# Performance audit
php artisan optimize:analyze

# Security audit
composer audit

# Dependency updates
composer outdated
npm outdated

# Code quality check
./vendor/bin/phpstan analyse
```

---

## 🔒 SECURITY HARDENING

### Application Security

**1. Environment File Protection:**

```bash
# Secure .env file
chmod 600 .env
chown www-data:www-data .env
```

---

**2. Disable Debug Mode:**

```ini
# .env
APP_DEBUG=false
APP_ENV=production
```

---

**3. Force HTTPS:**

```php
// app/Providers/AppServiceProvider.php
public function boot(): void
{
    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }
}
```

---

**4. Rate Limiting:**

```php
// routes/web.php
Route::middleware(['throttle:60,1'])->group(function () {
    // Protected routes
});
```

---

**5. SQL Injection Prevention:**

```php
// Always use Eloquent or prepared statements
User::where('email', $email)->first(); // ✅ Safe

// Never use raw queries with user input
DB::select("SELECT * FROM users WHERE email = '$email'"); // ❌ Dangerous
```

---

### Server Security

**1. Firewall Configuration:**

```bash
# Allow SSH
sudo ufw allow 22/tcp

# Allow HTTP/HTTPS
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp

# Enable firewall
sudo ufw enable
```

---

**2. Fail2Ban (Brute Force Protection):**

```bash
# Install
sudo apt install fail2ban

# Configure for Nginx
sudo nano /etc/fail2ban/jail.local

[nginx-auth]
enabled = true
filter = nginx-auth
logpath = /var/log/nginx/error.log
maxretry = 5
bantime = 3600
```

---

**3. SSL/TLS Certificate:**

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Obtain certificate
sudo certbot --nginx -d ehibah.bukittinggi.go.id

# Auto-renewal
sudo certbot renew --dry-run
```

---

**4. Disable Directory Listing:**

```nginx
# Nginx
autoindex off;
```

---

**5. Hide Server Information:**

```nginx
# Nginx
server_tokens off;
```

```ini
# PHP
expose_php = Off
```

---

### Database Security

**1. Strong Password Policy:**

```sql
ALTER USER 'ehibah_user'@'localhost' IDENTIFIED WITH mysql_native_password BY 'VERY_STRONG_PASSWORD_HERE';
```

---

**2. Limited Privileges:**

```sql
REVOKE ALL PRIVILEGES ON *.* FROM 'ehibah_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ehibah_bukittinggi.* TO 'ehibah_user'@'localhost';
FLUSH PRIVILEGES;
```

---

**3. Disable Remote Root Access:**

```sql
DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');
FLUSH PRIVILEGES;
```

---

**4. Regular Backups:**

```bash
# Automated daily backups
0 3 * * * /var/www/e-hibah-bukittinggi/scripts/backup.sh
```

---

## 📝 MAINTENANCE CHECKLIST

### Pre-Deployment

- [ ] Run all tests: `php artisan test`
- [ ] Check code quality: `./vendor/bin/phpstan analyse`
- [ ] Review migrations: `php artisan migrate:status`
- [ ] Backup database
- [ ] Backup files
- [ ] Test in staging environment
- [ ] Review environment variables

---

### During Deployment

- [ ] Enable maintenance mode
- [ ] Pull latest code
- [ ] Install dependencies
- [ ] Run migrations
- [ ] Clear cache
- [ ] Rebuild cache
- [ ] Restart queue workers
- [ ] Test critical features
- [ ] Disable maintenance mode

---

### Post-Deployment

- [ ] Verify application is running
- [ ] Check error logs
- [ ] Test user authentication
- [ ] Test file uploads
- [ ] Test email sending
- [ ] Monitor performance
- [ ] Review queue jobs
- [ ] Notify stakeholders

---

## 📞 SUPPORT CONTACTS

**Technical Support:**
- Email: support@bukittinggi.go.id
- Phone: (0752) 123-4567

**Emergency Hotline:**
- 24/7 Support: +62 812-3456-7890

**Documentation:**
- GitHub: https://github.com/your-org/e-hibah-bukittinggi
- Wiki: https://wiki.bukittinggi.go.id/ehibah

---

## 📄 CHANGE LOG

### Version 1.0.0 (2025-11-24)
- ✅ Initial release
- ✅ Complete testing infrastructure
- ✅ Comprehensive documentation
- ✅ Production-ready deployment

---

**DOKUMENTASI LENGKAP:**
- [← Bagian 1: Overview & Arsitektur](01_OVERVIEW_DAN_ARSITEKTUR.md)
- [← Bagian 2: Fitur & Workflow](02_FITUR_DAN_WORKFLOW.md)
- [← Bagian 3: Testing & QA](03_TESTING_DAN_QA.md)

---

**© 2025 Pemerintah Kota Bukittinggi. All Rights Reserved.**
