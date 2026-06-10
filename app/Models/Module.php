<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $table = 'modules';

    protected $fillable = [
        'bidang_code',
        'module_code',
        'nama_modul',
        'icon',
        'route_name',
        'parent_code',
        'scope',
        'urutan',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    // ── Relasi ──
    public function userAccess(): HasMany
    {
        return $this->hasMany(UserModuleAccess::class, 'module_id');
    }

    public function parent()
    {
        return $this->belongsTo(Module::class, 'parent_code', 'module_code');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Module::class, 'parent_code', 'module_code');
    }

    // ── Scopes ──
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    public function scopeBidang($query, string $bidang)
    {
        return $query->where('bidang_code', $bidang);
    }

    public function scopeParentOnly($query)
    {
        return $query->whereNull('parent_code');
    }

    // ── Helpers ──
    public function getWarnaBidangAttribute(): array
    {
        return match($this->bidang_code) {
            'doklan'     => ['bg' => '#0D1B3E', 'accent' => '#1E3A8A', 'text' => 'rgba(212,175,55,0.7)'],
            'inteldakim' => ['bg' => '#071C24', 'accent' => '#0F4C5C', 'text' => 'rgba(20,184,166,0.6)'],
            'tu'         => ['bg' => '#1A1200', 'accent' => '#B8860B', 'text' => 'rgba(212,175,55,0.7)'],
            default      => ['bg' => '#0D1B3E', 'accent' => '#1E3A8A', 'text' => 'rgba(212,175,55,0.7)'],
        };
    }

    public function getNamaBidangAttribute(): string
    {
        return match($this->bidang_code) {
            'doklan'     => 'Doklan',
            'inteldakim' => 'Inteldakim',
            'tu'         => 'Tata Usaha',
            default      => ucfirst($this->bidang_code),
        };
    }
}