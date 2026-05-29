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
        Schema::create('arsip', function (Blueprint $table) {
            $table->id(); // Primary key

            // Data dasar akta nikah
            $table->string('nomor_akta')->unique();       // Nomor akta nikah
            $table->string('nama_suami');                 // Nama suami
            $table->string('nama_istri');                 // Nama istri
            $table->integer('tahun_pernikahan');             // Tahun pernikahan
            $table->date('tanggal_pernikahan')->nullable(); // Opsional: tanggal pasti

            // Metadata arsip
            $table->string('kategori')->nullable();       // kategori: pendaftaran/akta nikah
            $table->string('lokasi_fisik')->nullable();   // lokasi berkas asli (lemari, rak, dsb)
            $table->string('file_path')->nullable();      // lokasi file digital (pdf/jpg scan)

            // Audit trail
            $table->timestamps();                         // created_at & updated_at
            $table->softDeletes();                        // jika ingin ada fitur hapus sementara
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip');
    }
    

};
