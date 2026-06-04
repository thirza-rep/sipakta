# 🚀 Panduan Integrasi Postman untuk Sipakta

Dokumen ini menjelaskan cara menghasilkan (*generate*), mengimpor, dan menguji semua titik akhir (*endpoints*) API dan Web di aplikasi **Sipakta** secara otomatis menggunakan Postman.

Aplikasi ini menggunakan modul `andreaselia/laravel-api-to-postman` untuk mengekspor semua *routes* Laravel secara otomatis.

---

## 1. Menghasilkan (*Generate*) Koleksi Postman

Setiap kali Anda menambahkan fungsi baru, mengubah *route*, atau menambahkan *middleware* baru di Laravel, Anda bisa memperbarui koleksi Postman dengan satu perintah sederhana.

Jalankan perintah berikut di terminal (di dalam folder utama proyek):

```bash
php artisan export:postman
```

**Hasil:**
Perintah di atas akan menghasilkan sebuah berkas JSON baru di dalam folder lokal penyimpanan Anda:
📂 `storage/app/private/postman/`

Berkas ini akan memiliki nama berdasarkan waktu pembuatan, misalnya: `2026_06_01_194041_s_i_p_a_k_t_a_collection.json`.

---

## 2. Mengimpor ke Postman

Setelah berkas JSON berhasil dibuat, ikuti langkah ini untuk memindahkannya ke aplikasi Postman:

1. Buka aplikasi **Postman** di komputer Anda.
2. Di pojok kiri atas aplikasi Postman, klik tombol **Import** (atau tekan `Cmd/Ctrl + O`).
3. Pilih opsi **File** atau cukup tarik dan lepas (*drag and drop*) berkas JSON dari folder `storage/app/private/postman/` ke dalam jendela Postman.
4. Klik **Import**.

Koleksi baru bernama **Sipakta** (atau sesuai nama yang tertera) akan muncul di *sidebar* sebelah kiri Anda. Seluruh *route* telah dikelompokkan secara otomatis berdasarkan fiturnya (misalnya: ArsipController, ProfilPemohonController, dll).

---

## 3. Konfigurasi Autentikasi (Sangat Penting)

Sebagian besar *endpoints* di aplikasi Sipakta dilindungi oleh sistem login (*Authentication*). Jika Anda langsung mencoba *endpoint* seperti `/dashboard` tanpa login, Anda akan mendapatkan pesan error atau diarahkan (redirect) ke halaman login.

Karena ini adalah aplikasi Web (menggunakan sesi bawaan Laravel, bukan Token API seperti Sanctum/Passport), Anda perlu melakukan satu langkah ekstra di Postman untuk mendapatkan akses:

### Cara Menguji Endpoint yang Dilindungi:
1. Buka koleksi Sipakta di Postman.
2. Cari kelompok *routes* untuk autentikasi (biasanya di Auth atau AuthenticatedSessionController).
3. Buka tab untuk **POST `/login`**.
4. Di tab **Body**, pilih tipe **raw** lalu ganti format teks dari **Text** menjadi **JSON**. Masukkan format *raw* untuk login (lihat panduan Payload di bawah).
5. Klik **Send**.
6. Jika login berhasil, **Postman akan secara otomatis menyimpan Cookies sesi (Session Cookie)** dari Laravel.
7. Sekarang Anda bebas memanggil *endpoint* lain (seperti `/profil-pemohon` atau `/arsip`) dan Postman akan menyertakan *cookie* tersebut secara otomatis!

---

## 4. Contoh Format "Raw" JSON (Payload) untuk Pengujian

Saat Anda ingin mengirimkan data dari Postman ke *endpoint* spesifik, gunakan tab **Body** -> pilih **raw** -> pilih tipe **JSON**. Berikut adalah daftar *raw JSON* yang diperlukan untuk masing-masing fungsi utama di Sipakta:

### 🔑 A. Autentikasi (Login & Register)

**1. POST `/login`** (Untuk mendapatkan akses/Cookie)
```json
{
    "email": "admin@kua.go.id",
    "password": "password"
}
```

**2. POST `/register`** (Membuat akun pemohon baru)
```json
{
    "name": "Budi Santoso",
    "email": "budi.pemohon@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

### 📱 B. Modul Verifikasi WhatsApp (Profil Pemohon)

Pastikan Anda sudah **Login sebagai Pemohon** sebelum memanggil *endpoint* ini.

**1. POST `/profil-pemohon/send-otp`** (Meminta pengiriman OTP ke WA)
```json
{
    "no_telepon": "081234567890"
}
```
*Catatan: Nomor telepon minimal 9 digit dan maksimal 16 digit.*

**2. POST `/profil-pemohon/verify-otp`** (Memverifikasi OTP yang dikirim ke WA)
```json
{
    "no_telepon": "081234567890",
    "otp": "123456"
}
```
*Catatan: OTP wajib tepat 6 digit (berupa string).*

### 📋 C. Modul Profil Pemohon

**POST `/profil-pemohon/update`** (Melengkapi NIK, Alamat, dan KTP)
⚠️ **PERHATIAN KHUSUS:** Karena *endpoint* ini mensyaratkan unggahan *file* foto KTP, Anda **TIDAK BISA** menggunakan tipe *raw JSON*. 

Untuk *endpoint* ini, buka tab **Body** di Postman dan pilih tipe **form-data**. Lalu isi kolom berikut secara manual:

| Key | Value (Contoh) | Tipe Kolom (Pilih di Postman) |
| :--- | :--- | :--- |
| `nik` | `3201234567890123` | Text (Wajib 16 digit angka) |
| `nama_lengkap` | `Budi Santoso` | Text |
| `alamat` | `Jl. Merdeka No. 10` | Text |
| `no_telepon` | `081234567890` | Text (Wajib sama dengan yang diverifikasi) |
| `foto_ktp` | *(Pilih file gambar KTP dari komputer)* | **File** |

---

## 5. Pengaturan Lanjutan Konfigurasi Ekspor (Opsional)

Jika Anda ingin mengubah format ekspor (misalnya mengekspor *route* tertentu saja atau menyalakan fungsi data *form* *dummy* bawaan *package*), Anda dapat memodifikasi berkas konfigurasi di:

📂 `config/api-postman.php`

Beberapa pengaturan kunci yang sudah diaktifkan di Sipakta:
- `'structured' => true` (Mengelompokkan *routes* ke dalam folder agar rapi).
- `'include_middleware' => ['web', 'api']` (Mengekspor *routes* untuk web dan API sekaligus).
- `'include_doc_comments' => true` (Membaca komentar di atas fungsi PHP dan mengubahnya menjadi deskripsi Postman).

---
*Happy API Testing!* 🧑‍💻
