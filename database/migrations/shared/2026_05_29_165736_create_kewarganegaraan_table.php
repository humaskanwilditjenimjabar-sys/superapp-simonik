<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kewarganegaraan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_negara');
            $table->string('kode_negara', 5)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kewarganegaraan');
    }
};