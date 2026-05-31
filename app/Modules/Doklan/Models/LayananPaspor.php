<?php

namespace App\Modules\Doklan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\KantorImigrasi;
use App\Models\KantorWilayah;
use App\Models\LokasiLayanan;
use App\Models\JenisLayanan;
use App\Models\User;

class LayananPaspor extends Model
{
    use SoftDeletes;

    protected $table = 'doklan_layanan_paspor';

    protected $fillable = [
        'kanim_id',
        'kanwil_id',
        'lokasi_layanan_id',
        'jenis_layanan_id',
        'operator_id',
        'tanggal',
        'jumlah',
        'keterangan',
        'status',
        'verified_by',
        'verified_at',
        'catatan_verifikasi',
        'riwayat_verifikasi',
    ];

    protected $casts = [
        'tanggal'             => 'date',
        'verified_at'         => 'datetime',
        'riwayat_verifikasi'  => 'array',
    ];

    // ── Relationships ──────────────────────────────────────

    public function kanim()
    {
        return $this->belongsTo(KantorImigrasi::class, 'kanim_id');
    }

    public function kanwil()
    {
        return $this->belongsTo(KantorWilayah::class, 'kanwil_id');
    }

    public function lokasiLayanan()
    {
        return $this->belongsTo(LokasiLayanan::class, 'lokasi_layanan_id');
    }

    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class, 'jenis_layanan_id');
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // ── Helper: tambah entry ke riwayat_verifikasi ─────────

    public function tambahRiwayat(string $aksi, User $oleh, ?string $catatan = null): void
    {
        $riwayat = $this->riwayat_verifikasi ?? [];

        $riwayat[] = [
            'aksi'    => $aksi,
            'oleh_id' => $oleh->id,
            'nama'    => $oleh->nama_lengkap,
            'catatan' => $catatan,
            'at'      => now()->toDateTimeString(),
        ];

        $this->riwayat_verifikasi = $riwayat;
    }

    // ── Scopes ─────────────────────────────────────────────

    public function scopeByKanwil($query, int $kanwilId)
    {
        return $query->where('kanwil_id', $kanwilId);
    }

    public function scopeByKanim($query, ?int $kanimId)
    {
        return $kanimId ? $query->where('kanim_id', $kanimId) : $query;
    }

    public function scopeByStatus($query, ?string $status)
    {
        return $status ? $query->where('status', $status) : $query;
    }
}