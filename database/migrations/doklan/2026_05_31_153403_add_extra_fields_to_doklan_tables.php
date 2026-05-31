<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Tambah kolom ke doklan_wna ──
        Schema::table('doklan_wna', function (Blueprint $table) {
            $table->string('jabatan')->nullable()->after('nomor_izin_tinggal');
            $table->string('aktivitas')->nullable()->after('jabatan');
            $table->text('alamat_di_indonesia')->nullable()->after('aktivitas');
        });

        // ── Tambah kolom ke doklan_layanan_izin_tinggal ──
        Schema::table('doklan_layanan_izin_tinggal', function (Blueprint $table) {
            $table->string('nama_sponsor')->nullable()->after('keterangan');
            $table->string('kontak_sponsor')->nullable()->after('nama_sponsor');
            $table->text('alamat_sponsor')->nullable()->after('kontak_sponsor');
        });
    }

    public function down(): void
    {
        Schema::table('doklan_wna', function (Blueprint $table) {
            $table->dropColumn(['jabatan', 'aktivitas', 'alamat_di_indonesia']);
        });

        Schema::table('doklan_layanan_izin_tinggal', function (Blueprint $table) {
            $table->dropColumn(['nama_sponsor', 'kontak_sponsor', 'alamat_sponsor']);
        });
    }
};