<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('bidang_code');          // 'doklan' | 'inteldakim' | 'tu'
            $table->string('module_code')->unique(); // 'doklan.paspor' | 'tu.surat' | dll
            $table->string('nama_modul');            // 'Paspor', 'Izin Tinggal', dll
            $table->string('icon')->nullable();      // nama icon tabler: 'notebook', 'mail', dll
            $table->string('route_name')->nullable();// nama route laravel
            $table->string('parent_code')->nullable();// untuk sub-menu, isi module_code parent
            $table->enum('scope', ['kanwil', 'kanim', 'both'])->default('both');
            $table->integer('urutan')->default(0);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};