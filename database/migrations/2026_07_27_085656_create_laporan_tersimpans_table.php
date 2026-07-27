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
        Schema::create('laporan_tersimpans', function (Blueprint $table) {
            $table->id();
            $table->string('judul_laporan');
            $table->string('tipe_laporan'); // 'bulanan' or 'rekap_tahunan'
            $table->integer('bulan')->nullable();
            $table->integer('tahun');
            $table->string('file_path');
            $table->foreignId('pengelola_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_tersimpans');
    }
};
