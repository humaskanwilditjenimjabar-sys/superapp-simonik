<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kantor_imigrasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kanwil_id')
                ->constrained('kantor_wilayah')
                ->cascadeOnDelete();
            $table->string('nama_kanim');
            $table->string('kode_kanim')->nullable();
            $table->string('alamat')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kantor_imigrasi');
    }
};