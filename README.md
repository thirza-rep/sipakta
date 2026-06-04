# Sipakta - Sistem Informasi Pengarsipan Akta Nikah

Sistem Informasi Pengarsipan Akta Nikah (Sipakta) adalah aplikasi berbasis web yang dikembangkan untuk Kantor Urusan Agama (KUA). Sistem ini memfasilitasi pengarsipan, pencarian, dan pelaporan akta nikah, serta pendaftaran profil pemohon secara mandiri dengan verifikasi WhatsApp OTP otomatis.

## Arsitektur Sistem

Aplikasi ini dibangun menggunakan arsitektur modern untuk memastikan performa dan keandalan tinggi:

- **Web Framework:** Laravel 12 (PHP 8.2+)
- **Database:** MySQL
- **Messaging/OTP:** Node.js (whatsapp-web.js) terintegrasi dengan Puppeteer
- **Containerization:** Docker & Docker Compose (Nginx, PHP-FPM, MySQL)
- **Styling:** Tailwind CSS & Alpine.js

## Hak Akses (Role-Based Access Control)

Sistem ini mendukung pembatasan akses berbasis peran (Role) sebagai berikut:

1. **Pemohon**
   - Melakukan pendaftaran profil.
   - Melakukan verifikasi nomor telepon melalui WhatsApp OTP (Real-time).
   - Mengunggah foto KTP dan melengkapi data pribadi.
   - Mengambil foto profil secara langsung melalui WebRTC Camera.

2. **Pengelola Data (Administrator Data)**
   - Mengelola (Input, Edit, Hapus) arsip akta nikah.
   - Mengunggah salinan dokumen fisik (PDF/Gambar).
   - Menyetujui atau menolak profil pemohon yang baru mendaftar.
   - Menghasilkan laporan bulanan dan rekapitulasi tahunan.

3. **Kepala KUA**
   - Melihat dan memantau arsip akta nikah (Read-only).
   - Mengunduh dan mencetak laporan operasional.

4. **Admin Sistem**
   - Mengelola akun pengguna (CRUD).
   - Mengaktifkan atau menonaktifkan pengguna.

## Panduan Instalasi (Development)

Proyek ini telah dikonfigurasi sepenuhnya menggunakan Docker untuk mempermudah proses pengembangan lokal.

### Prasyarat
- Docker Desktop terinstal dan berjalan.
- Node.js (Minimal v18 LTS) terinstal di mesin lokal (untuk modul WhatsApp).
- Composer terinstal di mesin lokal.

### Langkah Instalasi

1. **Kloning Repositori**
   ```bash
   git clone https://github.com/thirza-rep/sipakta.git
   cd sipakta
   ```

2. **Instalasi Dependensi PHP & Node.js**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin file konfigurasi bawaan.
   ```bash
   cp .env.example .env
   ```
   Pastikan pengaturan basis data pada `.env` sudah mengarah ke kontainer Docker:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=sipakta-db
   DB_PORT=3306
   DB_DATABASE=sipakta
   DB_USERNAME=root
   DB_PASSWORD=root
   ```

4. **Menjalankan Kontainer Docker**
   ```bash
   docker-compose -f backend/docker-compose.yml up -d
   ```

5. **Migrasi dan Penyemaian Data (Seeding)**
   Eksekusi perintah artisan di dalam kontainer aplikasi.
   ```bash
   docker exec -it sipakta-app php artisan migrate:fresh --seed
   docker exec -it sipakta-app php artisan storage:link
   ```

6. **Menjalankan Modul WhatsApp OTP**
   Jalankan modul Node.js di terminal terpisah.
   ```bash
   node scripts/whatsapp-helper.js
   ```
   *Catatan: Anda perlu memindai kode QR yang muncul di terminal (atau melalui URL /wa-qr.png) untuk menghubungkan akun WhatsApp pengirim OTP.*

7. **Akses Aplikasi**
   Aplikasi dapat diakses melalui peramban di: `http://localhost:8000`

## Kredensial Pengujian Dasar

Gunakan kredensial berikut untuk masuk sebagai pengguna percobaan (Seeder):

| Peran | Email | Kata Sandi |
|-------|-------|------------|
| Admin | admin@kua.go.id | password |
| Pengelola Data | pengelola@kua.go.id | password |
| Kepala KUA | kepala@kua.go.id | password |
| Pemohon | pemohon@example.com | password |

## Struktur Proyek Utama

```text
sipakta/
├── app/
│   ├── Http/Controllers/   # Logika bisnis (Arsip, Laporan, ProfilPemohon)
│   ├── Models/             # Model ORM (AktaNikah, ProfilPemohon, User)
│   └── Services/           # Layanan Eksternal (OtpService)
├── backend/
│   └── docker-compose.yml  # Konfigurasi orkestrasi kontainer
├── docker/
│   ├── nginx/              # Konfigurasi Web Server
│   └── php/                # Konfigurasi PHP-FPM dan ekstensi
├── resources/
│   └── views/              # Berkas antarmuka Blade Templates
├── scripts/
│   └── whatsapp-helper.js  # Microservice Node.js untuk integrasi WhatsApp
└── storage/
    ├── app/private/        # Penyimpanan berkas privat (Koleksi Postman)
    └── app/public/         # Penyimpanan berkas publik (Arsip, KTP, Avatar)
```

## Troubleshooting

1. **Galat Koneksi Basis Data (Connection Refused)**
   Pastikan kontainer Docker berjalan dengan perintah `docker ps`. Jika belum, jalankan ulang `docker-compose up -d`.

2. **QR Code WhatsApp Tidak Muncul / Sesi Usang**
   Jika sesi WhatsApp tidak valid, hentikan skrip Node.js, hapus folder sesi, dan jalankan kembali:
   ```bash
   rm -rf .wwebjs_auth
   node scripts/whatsapp-helper.js
   ```

3. **Gambar KTP / Arsip PDF Tidak Muncul**
   Pastikan symlink penyimpanan sudah terbuat di dalam kontainer:
   ```bash
   docker exec -it sipakta-app php artisan storage:link
   ```

## Lisensi

Proyek ini menggunakan lisensi eksklusif instansi. Penggunaan dan modifikasi terbatas hanya untuk keperluan internal KUA.
