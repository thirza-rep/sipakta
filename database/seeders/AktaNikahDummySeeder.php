<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\AktaNikah;

class AktaNikahDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $diyCities = ['Yogyakarta', 'Sleman', 'Bantul', 'Gunungkidul', 'Kulon Progo'];
        $kuaList = [
            'KUA Tegalrejo', 'KUA Jetis', 'KUA Gondokusuman', 'KUA Danurejan', 'KUA Gedongtengen',
            'KUA Ngampilan', 'KUA Wirobrajan', 'KUA Mantrijeron', 'KUA Kraton', 'KUA Mergangsan',
            'KUA Umbulharjo', 'KUA Kotagede', 'KUA Pakualaman', 'KUA Depok', 'KUA Mlati'
        ];
        
        $masKawinList = [
            'Seperangkat Alat Shalat', 'Logam Mulia 5 Gram', 'Uang Tunai Rp 1.000.000',
            'Perhiasan Emas 10 Gram', 'Cincin Emas 5 Gram', 'Logam Mulia 10 Gram'
        ];

        $kategoriList = ['Umum', 'Isbat', 'Rujuk'];
        
        $data = [];
        
        for ($i = 0; $i < 200; $i++) {
            // NIK DIY starts with 34 (3471 Kota Yogyakarta, 3404 Sleman, 3402 Bantul, 3403 GK, 3401 KP)
            $nikPrefixes = ['3471', '3404', '3402', '3403', '3401'];
            
            $suamiPrefix = $faker->randomElement($nikPrefixes);
            // remaining 12 digits
            $nikSuami = $suamiPrefix . $faker->numerify('############');
            
            $istriPrefix = $faker->randomElement($nikPrefixes);
            $nikIstri = $istriPrefix . $faker->numerify('############');
            
            $tanggalAkad = $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d');
            
            $kotaSuami = $faker->randomElement($diyCities);
            $kotaIstri = $faker->randomElement($diyCities);
            
            $data[] = [
                'nomor_akta' => $faker->numerify('####') . '/KUA.34/' . date('m', strtotime($tanggalAkad)) . '/' . date('Y', strtotime($tanggalAkad)),
                'nomor_buku' => 'B-' . $faker->numerify('#######'),
                'tanggal_akad' => $tanggalAkad,
                'lokasi_akad' => $faker->randomElement($kuaList),
                
                'nama_suami' => $faker->firstNameMale() . ' ' . $faker->lastNameMale(),
                'nik_suami' => $nikSuami,
                'tempat_lahir_suami' => $kotaSuami,
                'tanggal_lahir_suami' => $faker->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
                'alamat_suami' => $faker->streetAddress() . ', ' . $kotaSuami . ', DIY',
                
                'nama_istri' => $faker->firstNameFemale() . ' ' . $faker->lastNameFemale(),
                'nik_istri' => $nikIstri,
                'tempat_lahir_istri' => $kotaIstri,
                'tanggal_lahir_istri' => $faker->dateTimeBetween('-35 years', '-19 years')->format('Y-m-d'),
                'alamat_istri' => $faker->streetAddress() . ', ' . $kotaIstri . ', DIY',
                
                'nama_wali' => $faker->firstNameMale() . ' ' . $faker->lastNameMale(),
                'jenis_wali' => $faker->randomElement(['nasab', 'hakim']),
                'penghulu' => 'Drs. ' . $faker->firstNameMale() . ' ' . $faker->lastNameMale(),
                'mas_kawin' => $faker->randomElement($masKawinList),
                
                'kategori' => $faker->randomElement($kategoriList),
                'lokasi_fisik' => 'Laci ' . $faker->numberBetween(1, 10) . ' / Rak ' . $faker->randomElement(['A', 'B', 'C', 'D']),
                'file_path' => null,
                'status_arsip' => $faker->randomElement(['aktif', 'arsip_lama']),
                'keterangan' => 'Data dummy seeder DIY',
                'petugas_input_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // Insert in chunks to avoid memory issues
        foreach (array_chunk($data, 50) as $chunk) {
            DB::table('akta_nikah')->insert($chunk);
        }
        
        $this->command->info('200 Dummy Akta Nikah DIY generated successfully!');
    }
}
