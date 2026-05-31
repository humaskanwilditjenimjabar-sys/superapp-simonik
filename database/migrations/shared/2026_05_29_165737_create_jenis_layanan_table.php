<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_layanan', function (Blueprint $table) {
            $table->id();
            $table->string('kategori')->comment('doklan_paspor / doklan_izin_tinggal / wasdakim');
            $table->string('nama_layanan');
            $table->string('grup')->nullable()->comment('ITK / ITAS / ITAP untuk izin tinggal');
            $table->boolean('hitung_wna')->default(true);
            $table->boolean('is_aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_layanan');
    }
};