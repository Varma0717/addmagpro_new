# Production Deployment Setup Guide

## Overview

Complete production deployment guide for AddMagPro including server setup, environment configuration, security hardening, and monitoring.

---

## Server Requirements

### Minimum Specifications
- **CPU**: 2 cores
- **RAM**: 2GB (4GB recommended)
- **Storage**: 20GB SSD
- **Database**: MySQL 5.7+ or MariaDB 10.3+
- **PHP**: 8.1+ with extensions: PDO, MySQL, BCMath, Ctype, JSON, Mbstring, OpenSSL, Tokenizer
- **Node.js**: 18+ (for assets building)

### Recommended (Production)
- **CPU**: 4+ cores
- **RAM**: 8GB+
- **Storage**: 100GB+ SSD
- **CDN**: CloudFlare or similar
- **Monitoring**: New Relic or DataDog
- **Backups**: Daily automated backups

---

## Step 1: Server Setup (Ubuntu 22.04)

### Update System
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y curl git wget zip unzip
```

### Install PHP 8.2
```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-gd php8.2-bcmath php8.2-curl php8.2-json php8.2-mbstring php8.2-openssl php8.2-tokenizer php8.2-zip

# Verify installation
php -v
```

### Install MySQL 8.0
```bash
sudo apt install -y mysql-server

# Secure MySQL
sudo mysql_secure_installation
# Follow prompts to set root password, remove anonymous users, disable remote root

# Create Database
sudo mysql -u root -p
> CREATE DATABASE addmagpro CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
> CREATE USER 'addmagpro'@'localhost' IDENTIFIED BY 'StrongPassword123!';
> GRANT ALL PRIVILEGES ON addmagpro.* TO 'addmagpro'@'localhost';
> FLUSH PRIVILEGES;
> EXIT;
```

### Install Nginx
```bash
sudo apt install -y nginx

# Enable and start Nginx
sudo systemctl enable nginx
sudo systemctl start nginx
```

### Install Node.js
```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs

# Verify
node --version
npm --version
```

---

## Step 2: Deploy Application

### Clone Repository
```bash
cd /var/www
git clone https://github.com/Varma0717/addmagpro_new.git addmagpro
cd addmagpro
```

### Install PHP Dependencies
```bash
composer install --optimize-autoloader --no-dev
```

### Setup Environment
```bash
# Copy .env
cp .env.example .env

# Generate app key
php artisan key:generate

# Edit .env with production values
nano .env
```

### .env Production Configuration
```env
APP_NAME=AddMagPro
APP_ENV=production
APP_DEBUG=false
APP_URL=https://addmagpro.com

# Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=addmagpro
DB_USERNAME=addmagpro
DB_PASSWORD=StrongPassword123!

# Cache & Session
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_DRIVER=redis

# Mail (configure SendGrid or similar)
MAIL_DRIVER=sendgrid
SENDGRID_API_KEY=your-sendgrid-key

# Razorpay (Live Keys)
RAZORPAY_KEY_ID=rzp_live_ClCu3iwRLchrGu
RAZORPAY_KEY_SECRET=IPpmfWuwinMDo8rqbKw0Z2TV
RAZORPAY_MODE=live

# Sanctum
SANCTUM_STATEFUL_DOMAINS=addmagpro.com,www.addmagpro.com
SESSION_DOMAIN=addmagpro.com

# Firebase (for notifications)
FIREBASE_CREDENTIALS_PATH=/var/www/addmagpro/firebase-credentials.json

# Google Maps
GOOGLE_MAPS_API_KEY=your-google-maps-api-key
```

### Install Node Dependencies & Build Assets
```bash
npm install
npm run build  # Production build
```

### Run Database Migrations
```bash
php artisan migrate --force
php artisan db:seed --class=LocationSeeder --force
php artisan db:seed --class=ServiceSeeder --force
php artisan db:seed --class=CategorySeeder --force
php artisan db:seed --class=BannerSeeder --force
```

### Setup Storage Permissions
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data /var/www/addmagpro
```

---

## Step 3: Nginx Configuration

### Create Nginx Config
```bash
sudo nano /etc/nginx/sites-available/addmagpro.conf
```

### Nginx Configuration Content
```nginx
upstream php-fpm {
    server unix:/run/php/php8.2-fpm.sock;
}

server {
    listen 80;
    listen [::]:80;
    server_name addmagpro.com www.addmagpro.com;
    
    # Redirect HTTP to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name addmagpro.com www.addmagpro.com;
    
    # SSL Certificates (from Let's Encrypt)
    ssl_certificate /etc/letsencrypt/live/addmagpro.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/addmagpro.com/privkey.pem;
    
    # SSL Configuration
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;
    
    root /var/www/addmagpro/public;
    index index.php index.html;
    
    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_types text/plain text/css text/xml text/javascript application/x-javascript application/xml+rss;
    
    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    
    # Logging
    access_log /var/log/nginx/addmagpro_access.log;
    error_log /var/log/nginx/addmagpro_error.log;
    
    # Static files caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|webp)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }
    
    # Deny access to hidden files
    location ~ /\. {
        deny all;
    }
    
    # Deny access to sensitive files
    location ~ /(\.env|\.git|composer\.|package\.json) {
        deny all;
    }
    
    # PHP-FPM
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_pass php-fpm;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
        
        # Increase timeout for large requests
        fastcgi_read_timeout 300s;
        fastcgi_connect_timeout 300s;
    }
    
    # Laravel routing
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
}
```

### Enable Nginx Config
```bash
sudo ln -s /etc/nginx/sites-available/addmagpro.conf /etc/nginx/sites-enabled/
sudo rm /etc/nginx/sites-enabled/default
sudo nginx -t  # Test configuration
sudo systemctl restart nginx
```

---

## Step 4: SSL Certificate (Let's Encrypt)

### Install Certbot
```bash
sudo apt install -y certbot python3-certbot-nginx

# Generate certificate
sudo certbot certonly --nginx -d addmagpro.com -d www.addmagpro.com

# Auto-renewal
sudo systemctl enable certbot.timer
sudo systemctl start certbot.timer
```

---

## Step 5: PHP-FPM Optimization

### Configure PHP-FPM
```bash
sudo nano /etc/php/8.2/fpm/pool.d/www.conf
```

### Key Settings
```ini
[www]
user = www-data
group = www-data
listen = /run/php/php8.2-fpm.sock
listen.owner = www-data
listen.group = www-data

# Process management
pm = dynamic
pm.max_children = 20
pm.start_servers = 5
pm.min_spare_servers = 2
pm.max_spare_servers = 10

# Timeouts
request_timeout = 60s
```

### Restart PHP-FPM
```bash
sudo systemctl restart php8.2-fpm
```

---

## Step 6: Redis Setup (Caching)

### Install Redis
```bash
sudo apt install -y redis-server

# Enable and start
sudo systemctl enable redis-server
sudo systemctl start redis-server

# Verify
redis-cli ping  # Should return PONG
```

### Configure Redis
```bash
sudo nano /etc/redis/redis.conf
```

### Optimize Settings
```conf
maxmemory 256mb
maxmemory-policy allkeys-lru
appendonly yes
appendfsync everysec
```

---

## Step 7: Laravel Optimization

### Optimize for Production
```bash
cd /var/www/addmagpro

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize loader
php artisan optimize

# Disable debug mode
# .env: APP_DEBUG=false
```

### Setup Queues (Optional)
```bash
# Install Supervisor for queue workers
sudo apt install -y supervisor

# Create Supervisor config
sudo nano /etc/supervisor/conf.d/addmagpro-worker.conf
```

### Supervisor Configuration
```ini
[program:addmagpro-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/addmagpro/artisan queue:work redis --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/addmagpro/storage/logs/worker.log
```

---

## Step 8: Monitoring & Logging

### Application Logging
```bash
# Configure in .env
LOG_CHANNEL=daily
LOG_LEVEL=error

# Check logs
tail -f /var/www/addmagpro/storage/logs/laravel.log
```

### System Monitoring
```bash
# Install htop
sudo apt install -y htop

# Monitor real-time
htop
```

### Monitoring Tools (Optional)
```bash
# New Relic agent
curl -s https://download.newrelic.com/install/newrelic-cli/scripts/install.sh | bash
newrelic install -y

# Or use Sentry for error tracking
composer require sentry/sentry-laravel
php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider"
```

---

## Step 9: Backup Strategy

### Daily Database Backups
```bash
# Create backup script
sudo nano /usr/local/bin/backup-db.sh
```

### Backup Script
```bash
#!/bin/bash

BACKUP_DIR="/backups/addmagpro"
DB_NAME="addmagpro"
DB_USER="addmagpro"
DB_PASSWORD="StrongPassword123!"
DATE=$(date +%Y%m%d_%H%M%S)

mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u $DB_USER -p$DB_PASSWORD $DB_NAME | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Backup Laravel files
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/addmagpro

# Remove old backups (keep last 7 days)
find $BACKUP_DIR -type f -mtime +7 -delete

echo "Backup completed: $DATE"
```

### Setup Cron Job
```bash
sudo chmod +x /usr/local/bin/backup-db.sh

# Add to crontab (run daily at 2 AM)
sudo crontab -e
# 0 2 * * * /usr/local/bin/backup-db.sh
```

---

## Step 10: Security Hardening

### Firewall Configuration
```bash
sudo apt install -y ufw

# Enable firewall
sudo ufw enable

# Allow ports
sudo ufw allow 22/tcp      # SSH
sudo ufw allow 80/tcp      # HTTP
sudo ufw allow 443/tcp     # HTTPS

# Check rules
sudo ufw status
```

### Fail2Ban (Prevent Brute Force)
```bash
sudo apt install -y fail2ban

# Create local config
sudo nano /etc/fail2ban/jail.local
```

### Fail2Ban Configuration
```ini
[DEFAULT]
bantime = 3600
findtime = 600
maxretry = 5

[sshd]
enabled = true
logpath = /var/log/auth.log

[nginx-http-auth]
enabled = true
logpath = /var/log/nginx/error.log

[nginx-limit-req]
enabled = true
logpath = /var/log/nginx/error.log
```

### Enable Fail2Ban
```bash
sudo systemctl enable fail2ban
sudo systemctl restart fail2ban
```

---

## Step 11: Performance Monitoring

### Load Testing
```bash
# Install Apache Bench
sudo apt install -y apache2-utils

# Test homepage
ab -n 1000 -c 10 https://addmagpro.com/

# Expected results:
# - Requests/sec > 50
# - Failed requests: 0
# - Connection times < 500ms
```

### Monitor API Performance
```bash
# Check response times
curl -w "@curl-format.txt" -o /dev/null -s https://addmagpro.com/api/v1/home

# curl-format.txt content:
# time_namelookup:  %{time_namelookup}\n
# time_connect:     %{time_connect}\n
# time_appconnect:  %{time_appconnect}\n
# time_pretransfer: %{time_pretransfer}\n
# time_redirect:    %{time_redirect}\n
# time_starttransfer: %{time_starttransfer}\n
# time_total:       %{time_total}\n
```

---

## Step 12: Launch Checklist

### Pre-Launch (48 hours before)
- [ ] All 76 API endpoints tested
- [ ] Payment integration tested with real transaction
- [ ] Database migrations verified
- [ ] SSL certificate installed
- [ ] Nginx configuration tested
- [ ] Redis cache working
- [ ] Email notifications configured
- [ ] Monitoring alerts set up
- [ ] Backup strategy tested
- [ ] Support team trained

### Launch Day
- [ ] DNS updated to point to new server
- [ ] Wait for DNS propagation (up to 48 hours, but usually < 1 hour)
- [ ] Monitor error logs in real-time
- [ ] Test payment flow end-to-end
- [ ] Verify user registrations
- [ ] Check push notifications
- [ ] Monitor server resources
- [ ] Check response times

### Post-Launch (First Week)
- [ ] Monitor error rates
- [ ] Track user feedback
- [ ] Monitor transaction success rate
- [ ] Check server resource usage
- [ ] Optimize slow queries if needed
- [ ] Verify backups running
- [ ] Confirm emails sending

---

## Useful Commands

```bash
# Laravel commands
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan cache:clear
php artisan optimize:clear

# Server commands
systemctl restart nginx
systemctl restart php8.2-fpm
systemctl restart mysql
systemctl restart redis-server

# Monitoring
tail -f /var/log/nginx/error.log
tail -f /var/log/nginx/access.log
tail -f /var/www/addmagpro/storage/logs/laravel.log

# Database
mysql -u addmagpro -p addmagpro
SHOW PROCESSLIST;
SHOW STATUS;

# Redis
redis-cli
MONITOR
```

---

## Rollback Plan

If issues occur after deployment:

### 1. Immediate Rollback
```bash
# Revert to previous version
cd /var/www/addmagpro
git revert HEAD
composer install
php artisan config:cache
php artisan route:cache

# Restart services
sudo systemctl restart php8.2-fpm nginx
```

### 2. Restore from Backup
```bash
# Restore database
zcat /backups/addmagpro/db_20260525_020000.sql.gz | mysql -u addmagpro -p addmagpro

# Restore files
tar -xzf /backups/addmagpro/files_20260525_020000.tar.gz -C /
```

---

## Support & Documentation

- **Documentation**: https://addmagpro.dev/docs
- **API Docs**: https://addmagpro.dev/api/docs
- **Admin Portal**: https://addmagpro.com/admin
- **Support Email**: support@addmagpro.com

---

## Success Metrics

✅ All endpoints responding < 100ms  
✅ 99.9% uptime  
✅ 0 failed payment transactions (unless user cancelled)  
✅ All errors logged and monitored  
✅ Daily automated backups  
✅ Real-time monitoring alerts  
✅ DDoS protection enabled  
✅ SSL/TLS encryption for all traffic  

---

Generated: May 25, 2026
