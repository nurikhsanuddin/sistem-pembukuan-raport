# Instalasi Sistem Pembukuan Raport (Laravel 12)

Berikut adalah panduan instalasi untuk Sistem Pembukuan Raport berbasis Laravel 12 untuk berbagai lingkungan deployment.

## Persyaratan Sistem

- PHP 8.1 atau lebih baru
- Composer 2.2+
- Database:
  - MySQL 8.0+ 
  - MariaDB 10.5+
  - PostgreSQL 13+
  - SQLite 3.35+
- Ekstensi PHP wajib:
  - BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/repository.git sispem-raport
cd sispem-raport
```

### 2. Install Dependencies

```bash
composer install --optimize-autoloader --no-dev
```

### 3. Konfigurasi Environment

Salin file environment contoh dan sesuaikan:

```bash
cp .env.example .env
```

Edit file `.env` dengan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sispem_raport
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Migrasi Database

Jalankan migrasi dan seeder:

```bash
php artisan migrate --seed
```

### 6. Optimasi Aplikasi

```bash
php artisan optimize
php artisan view:cache
php artisan event:cache
```

### 7. Konfigurasi Storage Link

```bash
php artisan storage:link
```

## Konfigurasi Web Server

### Apache

Pastikan file `.htaccess` ada di root project dan konfigurasi Apache:

```
<VirtualHost *:80>
    ServerName sispem.test
    DocumentRoot "/path/to/sispem-raport/public"
    
    <Directory "/path/to/sispem-raport/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Nginx

```nginx
server {
    listen 80;
    server_name sispem.test;
    root /path/to/sispem-raport/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Penggunaan Development

Untuk environment development:

```bash
php artisan serve
```

Atau dengan Hot Reload:

```bash
php artisan serve --host=0.0.0.0 --port=8000
npm run dev
```

## Credential Default

**Admin:**
- Email: admin@sispem.id
- Password: admin123

**Guru:**
- Email: guru@sispem.id
- Password: guru123

**Siswa:**
- Email: siswa@sispem.id
- Password: siswa123

## Environment Variables Penting

| Variable           | Contoh Value          | Keterangan                     |
|--------------------|-----------------------|--------------------------------|
| APP_ENV            | production            | Environment aplikasi           |
| APP_DEBUG          | false                 | Mode debug                     |
| APP_URL            | https://raport.app    | URL aplikasi                   |
| LOG_CHANNEL        | stack                 | Channel logging                |
| DB_CONNECTION      | mysql                 | Koneksi database               |
| BROADCAST_DRIVER   | log                   | Driver broadcasting            |
| CACHE_DRIVER       | file                  | Driver cache                   |
| QUEUE_CONNECTION   | sync                  | Koneksi queue                  |
| SESSION_DRIVER     | file                  | Driver session                 |
| SESSION_LIFETIME   | 120                   | Masa aktif session (menit)     |

## Troubleshooting

**Error 500 setelah instalasi:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
chmod -R 775 storage bootstrap/cache
```

**Error migrasi:**
Pastikan versi database sesuai dan user database memiliki hak akses yang cukup.

**Error composer:**
Update composer:
```bash
composer self-update
composer install --no-scripts
```

## Kontribusi

1. Fork project
2. Buat branch fitur (`git checkout -b fitur-baru`)
3. Commit perubahan (`git commit -am 'Tambahkan fitur baru'`)
4. Push ke branch (`git push origin fitur-baru`)
5. Buat Pull Request

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).
