<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KantorImigrasi extends Model
{
    use HasFactory;

    protected $table = 'kantor_imigrasi';

    protected $fillable = [
        'kanwil_id',
        'nama_kanim',
        'kode_kanim',
        'alamat',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function kanwil()
    {
        return $this->belongsTo(KantorWilayah::class, 'kanwil_id');
    }

    public function lokasiLayanan()
    {
        return $this->hasMany(LokasiLayanan::class, 'kanim_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'kanim_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }
}