<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profil_pemohon', function (Blueprint $table) {
            $table->enum('status', ['unverified', 'pending_verification', 'verified', 'rejected'])->default('unverified')->after('keperluan');
            $table->text('rejected_reason')->nullable()->after('status');
            $table->string('foto_ktp')->nullable()->after('rejected_reason');
            $table->timestamp('phone_verified_at')->nullable()->after('no_telepon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profil_pemohon', function (Blueprint $table) {
            $table->dropColumn(['status', 'rejected_reason', 'foto_ktp', 'phone_verified_at']);
        });
    }
};
