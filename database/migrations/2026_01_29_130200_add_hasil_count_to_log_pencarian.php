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
        Schema::table('log_pencarian', function (Blueprint $table) {
            $table->integer('hasil_count')->default(0)->after('kata_kunci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_pencarian', function (Blueprint $table) {
            $table->dropColumn('hasil_count');
        });
    }
};
