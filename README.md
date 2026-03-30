
```markdown
# 🛒 Aimeos E-Commerce Cloud Deployment

## 📋 Project Overview
Final Project - Cloud Full-Stack Deployment untuk DigitalSkola.  
E-commerce platform dengan Laravel 12 + Aimeos 2025.10 LTS yang di-deploy menggunakan arsitektur cloud-native (AWS EC2, RDS, S3).

## 🌍 Live Deployment
- **Production URL**: http://47.129.182.229/
- **Admin Panel**: http://47.129.182.229/admin
- **Credentials**: 
  - Email: admin@email.com
  - Password: Admin123!

## 🏗️ Architecture

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│   CloudFlare│────▶│   EC2       │────▶│   RDS       │
│   (DNS)     │     │ t3.small    │     │  MySQL 8.0  │
└─────────────┘     │  (PHP+Nginx)│     │  (Managed)  │
                    └──────┬──────┘     └─────────────┘
                           │
                    ┌──────┴──────┐
                    │     S3      │
                    │  (Storage)  │
                    └─────────────┘
```

## 🛠️ Tech Stack

| Layer | Technology | Version |
|-------|------------|---------|
| **Framework** | Laravel | 12.x |
| **E-Commerce** | Aimeos | 2025.10 LTS |
| **Language** | PHP | 8.3 FPM |
| **Web Server** | Nginx | 1.18 |
| **Database** | MySQL (RDS) | 8.0 |
| **Storage** | AWS S3 | Standard |
| **Cloud** | AWS EC2 | t3.small (2GB RAM) |
| **OS** | Ubuntu | 22.04 LTS |

## 🚀 Deployment Steps

### 1. Infrastructure Setup (AWS Console)
```bash
# EC2 Instance
- Launch t3.small (2GB RAM, 20GB gp3)
- Security Group: Port 22 (SSH), 80 (HTTP), 443 (HTTPS)
- IAM Role: AmazonS3FullAccess

# RDS Database
- Engine: MySQL 8.0
- Instance: db.t3.micro (Free Tier)
- Public Access: Yes (initial setup)
- Security Group: Allow port 3306 from EC2-SG

# S3 Bucket
- Name: aimeos-capstone-media
- Region: ap-southeast-1
- CORS: Enabled for web upload
```

### 2. Server Configuration (EC2)
```bash
# Update & Install Stack
sudo apt update && sudo apt install -y nginx php8.3-fpm php8.3-cli \
    php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip php8.3-bcmath \
    php8.3-gd php8.3-intl php8.3-opcache php8.3-mysql unzip git curl

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Clone Repository
cd /var/www/html
sudo git clone https://github.com/ajipamungkas/aimeos-cloud-final.git .
```

### 3. Application Setup
```bash
# Install Dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# Setup Environment
cp .env.example .env
php artisan key:generate

# Database Migration (RDS)
php artisan migrate --force

# Aimeos Setup
php artisan aimeos:setup --option=setup/default/demo:1
php artisan aimeos:account admin@email.com --password=Admin123! --super

# Permissions
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 storage bootstrap/cache
sudo chmod -R 777 public/files public/preview public/uploads
```

### 4. Nginx Configuration
```nginx
server {
    listen 80;
    server_name _;
    root /var/www/html/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
    }
    
    location ~ /\.ht {
        deny all;
    }
}
```

## 🔄 CI/CD Pipeline

**File**: `.github/workflows/deploy.yml`

Pipeline otomatis yang berjalan saat push ke branch `main`:
1. Checkout kode terbaru
2. SSH ke EC2 instance
3. Pull repository
4. Install composer dependencies
5. Run database migrations
6. Clear cache & restart Nginx

**Trigger**: Setiap push ke branch `main`

## 📊 Monitoring & Logging

### System Monitoring
- **Tool**: `htop` (real-time CPU, Memory, Processes)
- **Command**: `htop` atau `docker stats` (jika pakai Docker)
- **CloudWatch**: Basic monitoring enabled (CPU Utilization, Network In/Out)

### Application Logs
- **Laravel Log**: `/var/www/html/storage/logs/laravel.log`
- **Nginx Access**: `/var/log/nginx/access.log`
- **Nginx Error**: `/var/log/nginx/error.log`

### Health Check Endpoint
```
GET /health
Response: {"status": "ok", "database": "connected", "timestamp": "2026-03-30..."}
```

## 🔐 Security Measures

1. **Database Security**
   - RDS tidak publicly accessible (setelah initial setup)
   - Security Group restrict: Port 3306 hanya dari EC2 Security Group
   - Credentials tidak di-hardcode (menggunakan .env)

2. **Application Security**
   - APP_DEBUG=false (production mode)
   - Laravel Sanctum untuk API authentication (jika ada)
   - HTTPS ready (port 443 open, SSL certificate dapat di-install)

3. **Server Security**
   - Security Group EC2: Port 22 (SSH) restricted ke IP tertentu
   - File permissions: storage (755), public files (777 untuk upload)
   - Regular security updates: `sudo apt update`

4. **S3 Security**
   - Bucket policy: Public read untuk assets, private untuk uploads
   - IAM Role attached ke EC2 (tidak menggunakan access key di code)

## 📸 Screenshots

### 1. Homepage E-Commerce
![Homepage](screenshots/homepage.png)
*Landing page dengan katalog produk Aimeos*

### 2. Admin Dashboard
![Admin](screenshots/admin.png)
*Panel administrasi untuk manage produk dan orders*

### 3. System Monitoring
![Monitoring](screenshots/monitoring.png)
*htop showing resource usage di EC2 t3.small*

### 4. CI/CD Pipeline
![CI-CD](screenshots/cicd.png)
*GitHub Actions deployment status*

## 📝 Notes & Troubleshooting

**Common Issues:**
- **Permission Denied**: Jalankan `sudo chmod -R 777 storage public/files`
- **Database Connection**: Cek Security Group RDS (harus allow dari EC2)
- **Memory Limit**: t3.small (2GB) cukup, tapi tambahkan swap 1GB untuk safety

**Resource Usage:**
- RAM: ~1.2GB / 2GB (saat idle)
- Disk: ~4GB / 20GB (termasuk vendor dan uploads)
- Database: ~50MB (untuk demo data)

## 👤 Author
- **Name**: Setya Aji Pamungkas
- **Course**: DigitalSkola - Cloud Engineering
- **Project**: Capstone Final Project & Deployment Review
```
