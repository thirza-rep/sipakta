<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('akta_nikah', function (Blueprint $table) {
            $table->string('kategori')->nullable()->after('mas_kawin');
            $table->string('lokasi_fisik')->nullable()->after('kategori');
            $table->string('file_path')->nullable()->after('lokasi_fisik');
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('akta_nikah', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'lokasi_fisik', 'file_path']);
            $table->dropSoftDeletes();
        });
    }
};
