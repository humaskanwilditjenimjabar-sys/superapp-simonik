<?php

namespace App\Modules\Doklan\Models;

use App\Models\JenisLayanan;
use App\Models\KantorImigrasi;
use App\Models\KantorWilayah;
use App\Models\LokasiLayanan;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LayananIzinTinggal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'doklan_layanan_izin_tinggal';

    protected $fillable = [
        'wna_id',
        'kanim_id',
        'kanwil_id',
        'lokasi_layanan_id',
        'jenis_layanan_id',
        'operator_id',
        'tanggal_penerbitan',
        'stay_permit_expire',
        'permit_number',
        'keterangan',
        'status',
        'verified_by',
        'verified_at',
        'catatan_verifikasi',
        'nama_sponsor',
        'kontak_sponsor',
        'alamat_sponsor',
    ];

    protected $casts = [
        'tanggal_penerbitan' => 'date',
        'stay_permit_expire' => 'date',
        'verified_at'        => 'datetime',
    ];

    // ── Relasi ──
    public function wna()
    {
        return $this->belongsTo(Wna::class, 'wna_id');
    }

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

    // ── Scopes ──
    public function scopeByKanim($query, int $kanimId)
    {
        return $query->where('kanim_id', $kanimId);
    }

    public function scopeByKanwil($query, int $kanwilId)
    {
        return $query->where('kanwil_id', $kanwilId);
    }

    public function scopeAktif($query)
    {
        return $query->whereHas('jenisLayanan', fn($q) =>
            $q->where('hitung_wna', true)
        );
    }

    public function scopeEarlyWarning($query)
    {
        return $query->where('stay_permit_expire', '<=', now()->addDays(7))
                     ->where('stay_permit_expire', '>=', now())
                     ->where('status', 'terverifikasi');
    }

    public function scopeDisubmit($query)
    {
        return $query->where('status', 'disubmit');
    }

    public function scopeTerverifikasi($query)
    {
        return $query->where('status', 'terverifikasi');
    }

    // ── Helpers ──
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft'         => 'Draft',
            'disubmit'      => 'Menunggu Verifikasi',
            'terverifikasi' => 'Terverifikasi',
            'ditolak'       => 'Ditolak',
            default         => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'draft'         => 'gray',
            'disubmit'      => 'warning',
            'terverifikasi' => 'success',
            'ditolak'       => 'danger',
            default         => 'gray',
        };
    }

    public function isEarlyWarning(): bool
    {
        return $this->stay_permit_expire
            && $this->stay_permit_expire->lte(now()->addDays(7))
            && $this->stay_permit_expire->gte(now());
    }

    public function getSisaHariAttribute(): ?int
    {
        return $this->stay_permit_expire
            ? (int) now()->diffInDays($this->stay_permit_expire, false)
            : null;
    }
}