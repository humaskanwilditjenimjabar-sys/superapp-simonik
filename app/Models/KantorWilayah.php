<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KantorWilayah extends Model
{
    use HasFactory;

    protected $table = 'kantor_wilayah';

    protected $fillable = [
        'nama_kanwil',
        'kode_kanwil',
        'alamat',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function kantorImigrasi()
    {
        return $this->hasMany(KantorImigrasi::class, 'kanwil_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'kanwil_id');
    }

    public function hariLibur()
    {
        return $this->hasMany(HariLibur::class, 'kanwil_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }
}