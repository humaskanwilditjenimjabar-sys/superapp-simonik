<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 18)->unique()->comment('NIP 18 digit — digunakan sebagai login');
            $table->string('nama_lengkap');
            $table->string('jabatan')->nullable();
            $table->string('role')->default('operator_kanim');
            $table->string('bidang')->nullable()->comment('doklan / wasdakim / tu / semua');
            $table->string('jenis_layanan')->nullable()->comment('paspor / izin_tinggal / keduanya / pengawasan / penindakan');
            $table->foreignId('kanwil_id')
                ->nullable()
                ->constrained('kantor_wilayah')
                ->nullOnDelete();
            $table->foreignId('kanim_id')
                ->nullable()
                ->constrained('kantor_imigrasi')
                ->nullOnDelete();
            $table->string('password');
            $table->string('no_hp', 20)->nullable();
            $table->string('email')->nullable();
            $table->enum('status', ['pending', 'aktif', 'nonaktif', 'ditolak'])->default('pending');
            $table->string('surat_pengajuan')->nullable()->comment('Path file PDF surat pengajuan');
            $table->text('alasan_penolakan')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('nip', 18)->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};