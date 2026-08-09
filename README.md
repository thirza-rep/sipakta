# 🏛️ Sipakta - Sistem Informasi Pengarsipan Akta Nikah

Sistem Informasi Pengarsipan Akta Nikah (Sipakta) adalah aplikasi berbasis web yang dikembangkan khusus untuk Kantor Urusan Agama (KUA). Sistem ini memfasilitasi pengarsipan, pencarian cerdas, pelaporan akta nikah, serta pendaftaran profil pemohon secara mandiri dengan verifikasi WhatsApp OTP otomatis.

---

## 🚀 Fitur Utama

- **Pencarian Cerdas (Full-text Search):** Integrasi *Search Engine* modern untuk pencarian arsip yang super cepat dan relevan.
- **Verifikasi Real-time:** Pendaftaran mandiri dengan OTP via WhatsApp.
- **Manajemen Berkas:** Pengunggahan dokumen fisik (PDF/Gambar) dan pengambilan foto profil via WebRTC Camera.
- **Pelaporan Otomatis:** Pembuatan laporan bulanan dan rekapitulasi tahunan dengan mudah.

---

## 🛠️ Teknologi yang Digunakan

Aplikasi ini dibangun dengan *stack* teknologi modern untuk memastikan performa, skalabilitas, dan keandalan tinggi:

- **Web Framework:** [Laravel 12](https://laravel.com/) (PHP 8.2+)
- **Frontend & Styling:** [Tailwind CSS](https://tailwindcss.com/) & [Alpine.js](https://alpinejs.dev/) (Build menggunakan Vite)
- **Database:** [MySQL 8.0](https://www.mysql.com/)
- **Search Engine:** [Meilisearch](https://www.meilisearch.com/) / Elasticsearch terintegrasi untuk pencarian tingkat lanjut
- **Messaging/OTP:** [Node.js](https://nodejs.org/) (`whatsapp-web.js`) terintegrasi dengan Puppeteer
- **Containerization:** [Docker & Docker Compose](https://www.docker.com/) (Nginx, PHP-FPM, MySQL, Meilisearch)

---

## 👥 Hak Akses (Role-Based Access Control)

Sistem ini mendukung pembatasan akses berbasis peran (*Role*) untuk menjaga keamanan data:

| Peran | Deskripsi Hak Akses |
|-------|---------------------|
| **1. Pemohon** | Mendaftar, verifikasi OTP via WhatsApp, melengkapi data (KTP), dan foto profil via WebRTC. |
| **2. Pengelola Data** | Mengelola (Input, Edit, Hapus) arsip, unggah dokumen fisik, verifikasi pendaftar, dan cetak laporan. |
| **3. Kepala KUA** | Memantau arsip akta nikah (*Read-only*) dan mencetak laporan operasional. |
| **4. Admin Sistem** | Mengelola akun pengguna (CRUD) dan aktivasi/deaktivasi pengguna. |

---

## ⚙️ Panduan Instalasi (Development)

Proyek ini telah dikonfigurasi sepenuhnya menggunakan Docker untuk mempermudah proses pengembangan lokal.

### Prasyarat
- **Docker Desktop** terinstal dan berjalan.
- **Node.js** (Minimal v18 LTS) terinstal di mesin lokal (untuk modul WhatsApp).
- **Composer** terinstal di mesin lokal.

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
   Pastikan pengaturan basis data dan search engine pada `.env` sudah mengarah ke kontainer Docker:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=sipakta-db
   DB_PORT=3306
   DB_DATABASE=sipakta
   DB_USERNAME=root
   DB_PASSWORD=root

   SCOUT_DRIVER=meilisearch
   MEILISEARCH_HOST=http://sipakta-meilisearch:7700
   MEILISEARCH_KEY=masterKey123!
   ```

4. **Menjalankan Kontainer Docker**
   Jalankan semua servis di *background* menggunakan Docker Compose.
   ```bash
   docker-compose up -d
   ```

5. **Migrasi, Penyemaian Data (Seeding), dan Storage**
   Eksekusi perintah artisan di dalam kontainer aplikasi.
   ```bash
   docker exec -it sipakta-app php artisan migrate:fresh --seed
   docker exec -it sipakta-app php artisan storage:link
   ```

6. **Sinkronisasi Search Engine (Opsional)**
   Untuk memastikan indeks pencarian diperbarui (tergantung *driver* yang aktif):
   ```bash
   # Jika menggunakan Meilisearch & Scout
   docker exec -it sipakta-app php artisan scout:import "App\Models\AktaNikah"
   
   # Jika menggunakan Custom Elasticsearch Script
   docker exec -it sipakta-app php artisan elastic:sync
   ```

7. **Menjalankan Modul WhatsApp OTP**
   Jalankan modul Node.js di terminal terpisah di mesin lokal.
   ```bash
   node scripts/whatsapp-helper.js
   ```
   *Catatan: Pindai kode QR yang muncul di terminal (atau melalui URL `/wa-qr.png`) untuk menghubungkan akun WhatsApp pengirim OTP.*

8. **Akses Aplikasi**
   Aplikasi dapat diakses melalui peramban di: [http://localhost:8000](http://localhost:8000)

---

## 🧪 Kredensial Pengujian Dasar

Gunakan kredensial berikut untuk masuk sebagai pengguna percobaan (Seeder):

| Peran | Email | Kata Sandi |
|-------|-------|------------|
| **Admin Sistem** | admin@kua.go.id | `password` |
| **Pengelola Data** | pengelola@kua.go.id | `password` |
| **Kepala KUA** | kepala@kua.go.id | `password` |
| **Pemohon** | pemohon@example.com | `password` |

---

## 📁 Struktur Proyek Utama

```text
sipakta/
├── app/
│   ├── Console/Commands/   # Command kustom (seperti ElasticSyncCommand)
│   ├── Http/Controllers/   # Logika bisnis (Arsip, Laporan, Pencarian, dll)
│   ├── Models/             # Model ORM (AktaNikah, ProfilPemohon, User)
│   └── Services/           # Layanan Eksternal (OtpService)
├── docker/
│   └── nginx/              # Konfigurasi Web Server
├── docker-compose.yml      # Konfigurasi orkestrasi kontainer (App, DB, Webserver, Meilisearch)
├── resources/
│   └── views/              # Berkas antarmuka Blade Templates
├── scripts/
│   └── whatsapp-helper.js  # Microservice Node.js untuk integrasi WhatsApp
└── storage/
    └── app/public/         # Penyimpanan berkas publik (Arsip, KTP, Avatar)
```

---

## 🐛 Troubleshooting

<details>
<summary><strong>1. Galat Koneksi Basis Data (Connection Refused)</strong></summary>

Pastikan kontainer Docker berjalan dengan perintah `docker ps`. Jika belum, jalankan ulang `docker-compose up -d`.
</details>

<details>
<summary><strong>2. QR Code WhatsApp Tidak Muncul / Sesi Usang</strong></summary>

Jika sesi WhatsApp tidak valid, hentikan skrip Node.js, hapus folder sesi, dan jalankan kembali:
```bash
rm -rf .wwebjs_auth
node scripts/whatsapp-helper.js
```
</details>

<details>
<summary><strong>3. Gambar KTP / Arsip PDF Tidak Muncul</strong></summary>

Pastikan *symlink* penyimpanan sudah terbuat di dalam kontainer:
```bash
docker exec -it sipakta-app php artisan storage:link
```
</details>

<details>
<summary><strong>4. Pencarian Teks Tidak Berfungsi (Meilisearch)</strong></summary>

Pastikan layanan Meilisearch berjalan (`docker ps | grep meilisearch`). Lakukan proses impor ulang data:
```bash
docker exec -it sipakta-app php artisan scout:import "App\Models\AktaNikah"
```
</details>

---

## 📄 Lisensi

Proyek ini menggunakan **lisensi eksklusif instansi**. Penggunaan dan modifikasi terbatas hanya untuk keperluan internal Kantor Urusan Agama (KUA).
