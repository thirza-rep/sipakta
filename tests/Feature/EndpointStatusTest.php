<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EndpointStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_endpoints_return_200()
    {
        $this->get('/')->assertStatus(200);
        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);
    }

    public function test_pemohon_endpoints_return_200()
    {
        $user = User::factory()->create(['role' => 'pemohon']);
        $this->actingAs($user);

        // Dashboard redirects to pencarian
        $this->get('/dashboard')->assertRedirect(route('pencarian.index'));
        
        $this->get('/profil-pemohon')->assertStatus(200);
        $this->get('/pencarian')->assertStatus(200);
    }

    public function test_admin_endpoints_return_200()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);

        $this->get('/dashboard')->assertStatus(200);
        $this->get('/users')->assertStatus(200);
    }

    public function test_pengelola_data_endpoints_return_200()
    {
        $user = User::factory()->create(['role' => 'pengelola_data']);
        $this->actingAs($user);

        $this->get('/dashboard')->assertStatus(200);
        $this->get('/admin/verification')->assertStatus(200);
        $this->get('/akta-nikah')->assertStatus(200);
        $this->get('/laporan')->assertStatus(200);
    }

    public function test_kepala_kua_endpoints_return_200()
    {
        $user = User::factory()->create(['role' => 'kepala_kua']);
        $this->actingAs($user);

        $this->get('/dashboard')->assertStatus(200);
        $this->get('/akta-nikah')->assertStatus(200);
        $this->get('/laporan')->assertStatus(200);
        $this->get('/riwayat')->assertStatus(200);
    }
}
