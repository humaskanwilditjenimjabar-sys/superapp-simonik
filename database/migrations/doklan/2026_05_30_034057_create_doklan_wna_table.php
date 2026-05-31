<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doklan_wna', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kanim_id')
                ->constrained('kantor_imigrasi')
                ->cascadeOnDelete();
            $table->foreignId('kanwil_id')
                ->constrained('kantor_wilayah')
                ->cascadeOnDelete();
            $table->foreignId('kewarganegaraan_id')
                ->constrained('kewarganegaraan')
                ->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('nomor_paspor')->nullable();
            $table->date('paspor_expire')->nullable();
            $table->string('nomor_izin_tinggal')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Index untuk performa
            $table->index('kanim_id');
            $table->index('kanwil_id');
            $table->index('kewarganegaraan_id');
            $table->index('nama_lengkap');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doklan_wna');
    }
};