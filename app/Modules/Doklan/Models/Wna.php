<?php

namespace App\Modules\Doklan\Models;

use App\Models\KantorImigrasi;
use App\Models\KantorWilayah;
use App\Models\Kewarganegaraan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wna extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'doklan_wna';

    protected $fillable = [
            'kanim_id',
            'kanwil_id',
            'kewarganegaraan_id',
            'nama_lengkap',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'nomor_paspor',
            'paspor_expire',
            'nomor_izin_tinggal',
            'jabatan',
            'aktivitas',
            'alamat_di_indonesia',
    ];

    protected $casts = [
        'tanggal_lahir'  => 'date',
        'paspor_expire'  => 'date',
    ];

    // ── Relasi ──
    public function kanim()
    {
        return $this->belongsTo(KantorImigrasi::class, 'kanim_id');
    }

    public function kanwil()
    {
        return $this->belongsTo(KantorWilayah::class, 'kanwil_id');
    }

    public function kewarganegaraan()
    {
        return $this->belongsTo(Kewarganegaraan::class, 'kewarganegaraan_id');
    }

    public function izinTinggal()
    {
        return $this->hasMany(LayananIzinTinggal::class, 'wna_id');
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

    // ── Helpers ──
    public function getUmurAttribute(): ?int
    {
        return $this->tanggal_lahir
            ? $this->tanggal_lahir->age
            : null;
    }

    public function getNamaNegaraAttribute(): string
    {
        return $this->kewarganegaraan?->nama_negara ?? '-';
    }
}