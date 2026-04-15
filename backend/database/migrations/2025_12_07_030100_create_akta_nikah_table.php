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
        Schema::create('akta_nikah', function (Blueprint $table) {
            $table->id();

            // Info administrasi
            $table->string('nomor_akta')->unique();
            $table->string('nomor_buku')->nullable();
            $table->date('tanggal_akad');
            $table->string('lokasi_akad')->nullable();

            // Data suami
            $table->string('nama_suami');
            $table->string('nik_suami', 20)->nullable();
            $table->string('tempat_lahir_suami')->nullable();
            $table->date('tanggal_lahir_suami')->nullable();
            $table->text('alamat_suami')->nullable();

            // Data istri
            $table->string('nama_istri');
            $table->string('nik_istri', 20)->nullable();
            $table->string('tempat_lahir_istri')->nullable();
            $table->date('tanggal_lahir_istri')->nullable();
            $table->text('alamat_istri')->nullable();

            // Wali & penghulu
            $table->string('nama_wali')->nullable();
            $table->enum('jenis_wali', ['nasab', 'hakim'])->nullable();
            $table->string('penghulu')->nullable();

            // Lain-lain
            $table->string('mas_kawin')->nullable();
            $table->enum('status_arsip', ['aktif', 'arsip_lama', 'hilang'])
                  ->default('aktif');
            $table->text('keterangan')->nullable();

            // Petugas input (relasi ke users)
            $table->foreignId('petugas_input_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->timestamps();

            // Index untuk pencarian cepat
            $table->index('nomor_akta');
            $table->index('nama_suami');
            $table->index('nama_istri');
            $table->index('tanggal_akad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akta_nikah');
    }
};