# KUA Arsip - Sistem Pengarsipan Akta Nikah

> Sistem Informasi Pengarsipan Akta Nikah Berbasis Web untuk Kantor Urusan Agama Kemantren Tegalrejo

## 📋 Overview

Sistem web berbasis **Laravel 12** untuk pengelolaan arsip akta nikah dengan fitur role-based access control.

```
kua-arsip/
└── backend/          # Laravel Web Application
```

---

## 🔐 Role & Hak Akses

| Role | Hak Akses |
|------|-----------|
| **Admin** | Kelola pengguna (CRUD, activate/deactivate) |
| **Administrator Data** | Input, edit, upload arsip akta nikah, generate laporan |
| **Kepala KUA** | Lihat arsip (read-only), lihat & download laporan |

---

## 🔧 Teknologi Stack

- **Framework**: Laravel 12
- **PHP Version**: 8.2+
- **Database**: MySQL / SQLite
- **Authentication**: Laravel Breeze
- **PDF Export**: DomPDF
- **Styling**: Tailwind CSS

---

## 🚀 Instalasi & Menjalankan

1. **Masuk ke direktori backend**
   ```bash
   cd backend
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database** - Edit file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kua_arsip
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Jalankan migrasi & seeder**
   ```bash
   php artisan migrate
   php artisan db:seed
   php artisan storage:link
   ```

6. **Jalankan server**
   ```bash
   php artisan serve
   npm run dev
   ```

   Atau sekaligus:
   ```bash
   composer dev
   ```

Akses aplikasi di: `http://localhost:8000`

---

## 👤 Kredensial Login

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@kua-tegalrejo.go.id | password |
| Administrator Data | admindata@kua-tegalrejo.go.id | password |
| Kepala KUA | kepala@kua-tegalrejo.go.id | password |

---

## 📁 Struktur Proyek

```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ArsipController.php
│   │   │   ├── UserController.php
│   │   │   └── LaporanController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── Arsip.php
│       ├── User.php
│       └── LogPencarian.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── arsip/
│   ├── users/
│   ├── laporan/
│   └── layouts/
└── storage/app/public/arsip/
```

---

## ✅ Fitur Utama

- **Authentication & Authorization** - Login dengan role-based access
- **Kelola Pengguna** - CRUD user, toggle active/inactive (Admin)
- **Arsip Akta Nikah** - Input, edit, upload dokumen (PDF/JPG/PNG)
- **Pencarian** - Filter arsip berdasarkan nama, nomor akta, tahun
- **Laporan Bulanan** - Generate & export PDF laporan arsip
- **Rekap Tahunan** - Statistik arsip per bulan

---

## 🐛 Troubleshooting

**Error: Connection refused**
- Pastikan `php artisan serve` berjalan
- Check port 8000 tidak digunakan aplikasi lain

**Error: Storage link not found**
```bash
php artisan storage:link
```

**Error: Permission denied**
```bash
chmod -R 775 storage bootstrap/cache
```

---

## 📄 License

This project is licensed under the MIT License.

---

**Happy Coding! 🚀**

# sipakta
