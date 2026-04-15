<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArsipSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('arsip')->insert([
            [
                'nomor_akta' => '123/1973',
                'nama_suami' => 'Budi Santoso',
                'nama_istri' => 'Siti Aminah',
                'tahun_pernikahan' => 1973,
                'tanggal_pernikahan' => '1973-05-20',
                'kategori' => 'Pendaftaran Nikah',
                'lokasi_fisik' => 'Lemari A1',
                'file_path' => 'arsip/123-1973.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_akta' => '456/1980',
                'nama_suami' => 'Agus Wijaya',
                'nama_istri' => 'Dewi Lestari',
                'tahun_pernikahan' => 1980,
                'tanggal_pernikahan' => '1980-07-15',
                'kategori' => 'Akta Nikah',
                'lokasi_fisik' => 'Lemari B2',
                'file_path' => 'arsip/456-1980.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
