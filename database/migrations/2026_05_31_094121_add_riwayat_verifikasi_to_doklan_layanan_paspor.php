<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doklan_layanan_paspor', function (Blueprint $table) {
            $table->json('riwayat_verifikasi')->nullable()->after('catatan_verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('doklan_layanan_paspor', function (Blueprint $table) {
            $table->dropColumn('riwayat_verifikasi');
        });
    }
};