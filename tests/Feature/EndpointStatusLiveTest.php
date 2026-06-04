<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EndpointStatusLiveTest extends TestCase
{
    public function test_endpoints()
    {
        DB::beginTransaction();
        try {
            // Guest
            echo "\nTesting Guest...\n";
            $this->get('/')->assertStatus(200);
            $this->get('/login')->assertStatus(200);
            
            // Pemohon
            echo "Testing Pemohon...\n";
            $pemohon = User::factory()->create(['role' => 'pemohon']);
            $this->actingAs($pemohon);
            $this->get('/profil-pemohon')->assertStatus(200);
            $this->get('/pencarian')->assertStatus(200);
            
            // Admin
            echo "Testing Admin...\n";
            $admin = User::factory()->create(['role' => 'admin']);
            $this->actingAs($admin);
            $this->get('/dashboard')->assertStatus(200);
            $this->get('/users')->assertStatus(200);

            // Pengelola Data
            echo "Testing Pengelola Data...\n";
            $pengelola = User::factory()->create(['role' => 'pengelola_data']);
            $this->actingAs($pengelola);
            $this->get('/dashboard')->assertStatus(200);
            $this->get('/admin/verification')->assertStatus(200);
            $this->get('/akta-nikah')->assertStatus(200);
            $this->get('/laporan')->assertStatus(200);

            // Kepala KUA
            echo "Testing Kepala KUA...\n";
            $kepala = User::factory()->create(['role' => 'kepala_kua']);
            $this->actingAs($kepala);
            $this->get('/dashboard')->assertStatus(200);
            $this->get('/riwayat')->assertStatus(200);
            
            echo "Semua endpoint utama (200 OK) berhasil!\n";
            $this->assertTrue(true);
            
        } finally {
            DB::rollBack();
        }
    }
}
