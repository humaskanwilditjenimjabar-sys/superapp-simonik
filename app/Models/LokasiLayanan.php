<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiLayanan extends Model
{
    use HasFactory;

    protected $table = 'lokasi_layanan';

    protected $fillable = [
        'kanim_id',
        'nama_lokasi',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function kanim()
    {
        return $this->belongsTo(KantorImigrasi::class, 'kanim_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }
}