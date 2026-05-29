<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@kua-tegalrejo.go.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
                'is_active' => true,
            ]
        );

        // Pengelola Data User (formerly Admin Data)
        User::updateOrCreate(
            ['email' => 'pengelola@kua-tegalrejo.go.id'],
            [
                'name' => 'Pengelola Data',
                'password' => Hash::make('password'),
                'role' => User::ROLE_PENGELOLA_DATA,
                'is_active' => true,
            ]
        );

        // Kepala KUA User
        User::updateOrCreate(
            ['email' => 'kepala@kua-tegalrejo.go.id'],
            [
                'name' => 'Kepala KUA',
                'password' => Hash::make('password'),
                'role' => User::ROLE_KEPALA_KUA,
                'is_active' => true,
            ]
        );

        // Sample Pemohon User
        User::updateOrCreate(
            ['email' => 'pemohon@example.com'],
            [
                'name' => 'Pemohon Demo',
                'password' => Hash::make('password'),
                'role' => User::ROLE_PEMOHON,
                'is_active' => true,
            ]
        );
    }
}
