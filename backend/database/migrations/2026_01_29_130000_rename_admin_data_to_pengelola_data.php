<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, modify the enum to include 'pengelola_data'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'pemohon', 'admin_data', 'kepala_kua', 'pengelola_data') DEFAULT 'pengelola_data'");
        
        // Then update existing admin_data to pengelola_data
        DB::table('users')->where('role', 'admin_data')->update(['role' => 'pengelola_data']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert pengelola_data back to admin_data
        DB::table('users')->where('role', 'pengelola_data')->update(['role' => 'admin_data']);
        
        // Revert enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'pemohon', 'admin_data', 'kepala_kua') DEFAULT 'admin_data'");
    }
};
