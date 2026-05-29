<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ArsipSeeder extends Seeder
{
    public function run(): void
    {
        // Get a valid petugas user ID
        $petugas = User::where('role', User::ROLE_PENGELOLA_DATA)->first()
            ?? User::where('role', User::ROLE_ADMIN)->first()
            ?? User::first();

        $petugasId = $petugas ? $petugas->id : 1;

        DB::table('akta_nikah')->insert([
            [
                'nomor_akta' => '123/1973',
                'nomor_buku' => 'B-001',
                'tanggal_akad' => '1973-05-20',
                'lokasi_akad' => 'KUA Tegalrejo',
                'nama_suami' => 'Budi Santoso',
                'nik_suami' => '3402162005730001',
                'tempat_lahir_suami' => 'Yogyakarta',
                'tanggal_lahir_suami' => '1950-01-15',
                'alamat_suami' => 'Tegalrejo, Yogyakarta',
                'nama_istri' => 'Siti Aminah',
                'nik_istri' => '3402166007750002',
                'tempat_lahir_istri' => 'Sleman',
                'tanggal_lahir_istri' => '1953-03-22',
                'alamat_istri' => 'Tegalrejo, Yogyakarta',
                'nama_wali' => 'Ahmad Yusuf',
                'jenis_wali' => 'nasab',
                'penghulu' => 'H. Muhammad Ridho',
                'mas_kawin' => 'Emas 10 Gram',
                'status_arsip' => 'aktif',
                'keterangan' => 'Arsip akad nikah tahun 1973',
                'petugas_input_id' => $petugasId,
                'kategori' => 'Pendaftaran Nikah',
                'lokasi_fisik' => 'Lemari A1',
                'file_path' => 'arsip/123-1973.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_akta' => '456/1980',
                'nomor_buku' => 'B-002',
                'tanggal_akad' => '1980-07-15',
                'lokasi_akad' => 'Masjid Raya Tegalrejo',
                'nama_suami' => 'Agus Wijaya',
                'nik_suami' => '3402161208800003',
                'tempat_lahir_suami' => 'Bantul',
                'tanggal_lahir_suami' => '1955-08-12',
                'alamat_suami' => 'Klitren, Gondokusuman, Yogyakarta',
                'nama_istri' => 'Dewi Lestari',
                'nik_istri' => '3402164409820004',
                'tempat_lahir_istri' => 'Yogyakarta',
                'tanggal_lahir_istri' => '1958-09-04',
                'alamat_istri' => 'Klitren, Gondokusuman, Yogyakarta',
                'nama_wali' => 'Bambang Susilo',
                'jenis_wali' => 'nasab',
                'penghulu' => 'H. Ahmad Syukri',
                'mas_kawin' => 'Seperangkat Alat Sholat',
                'status_arsip' => 'aktif',
                'keterangan' => 'Arsip akad nikah tahun 1980',
                'petugas_input_id' => $petugasId,
                'kategori' => 'Akta Nikah',
                'lokasi_fisik' => 'Lemari B2',
                'file_path' => 'arsip/456-1980.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

