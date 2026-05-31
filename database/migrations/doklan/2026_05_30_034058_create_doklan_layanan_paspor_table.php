<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doklan_layanan_paspor', function (Blueprint $table) {
            $table->id();
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
            $table->date('tanggal');
            $table->integer('jumlah')->default(0);
            $table->text('keterangan')->nullable();
            $table->enum('status', [
                'disubmit',
                'terverifikasi',
                'ditolak',
            ])->default('disubmit');
            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->text('catatan_verifikasi')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('kanim_id');
            $table->index('kanwil_id');
            $table->index('tanggal');
            $table->index('status');
            $table->index('operator_id');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('doklan_layanan_paspor');
    }
};