<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisLayanan extends Model
{
    use HasFactory;

    protected $table = 'jenis_layanan';

    protected $fillable = [
        'kategori',
        'nama_layanan',
        'grup',
        'hitung_wna',
        'is_aktif',
        'urutan',
    ];

    protected $casts = [
        'hitung_wna' => 'boolean',
        'is_aktif'   => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    public function scopeDoklanPaspor($query)
    {
        return $query->where('kategori', 'doklan_paspor');
    }

    public function scopeDoklanIzinTinggal($query)
    {
        return $query->where('kategori', 'doklan_izin_tinggal');
    }

    public function scopeWasdakim($query)
    {
        return $query->where('kategori', 'wasdakim');
    }
}