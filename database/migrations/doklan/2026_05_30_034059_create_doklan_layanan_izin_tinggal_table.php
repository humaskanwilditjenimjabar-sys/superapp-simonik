<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doklan_layanan_izin_tinggal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wna_id')
                ->constrained('doklan_wna')
                ->cascadeOnDelete();
            $table->foreignId('kanim_id')
                ->constrained('kantor_imigrasi')
                ->cascadeOnDelete();
            $table->foreignId('kanwil_id')
                ->constrained('kantor_wilayah')
                ->cascadeOnDelete();
            $table->foreignId('lokasi_layanan_id')
                ->constrained('lokasi_layanan')
                ->cascadeOnDelete();
            $table->foreignId('jenis_layanan_id')
                ->constrained('jenis_layanan')
                ->cascadeOnDelete();
            $table->foreignId('operator_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->date('tanggal_penerbitan');
            $table->date('stay_permit_expire')->nullable();
            $table->string('permit_number')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', [
                'draft',
                'disubmit',
                'terverifikasi',
                'ditolak',
            ])->default('draft');
            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->text('catatan_verifikasi')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Index untuk performa
            $table->index('wna_id');
            $table->index('kanim_id');
            $table->index('kanwil_id');
            $table->index('tanggal_penerbitan');
            $table->index('stay_permit_expire');
            $table->index('status');
            $table->index('operator_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doklan_layanan_izin_tinggal');
    }
};