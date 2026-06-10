<?php

namespace App\Core\Services;

use App\Models\Module;
use App\Models\UserModuleAccess;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PermissionService
{
    // Level hierarchy — semakin tinggi angkanya semakin besar aksesnya
    const LEVELS = [
        'viewer'      => 1,
        'operator'    => 2,
        'verifikator' => 3,
        'manager'     => 4,
        'admin'       => 5,
    ];

    // ── Cek akses user ke modul dengan level tertentu ──
    public static function can(string $moduleCode, string $minLevel = 'viewer'): bool
    {
        if (!Auth::check()) return false;

        $user = Auth::user();

        // Superadmin bisa semua
        if ($user->role === 'superadmin') return true;

        $access = static::getUserAccess($user->id)
            ->first(fn($a) => $a->module->module_code === $moduleCode && $a->is_aktif);

        if (!$access) return false;

        return static::LEVELS[$access->level] >= static::LEVELS[$minLevel];
    }

    // ── Cek apakah user punya akses ke bidang tertentu ──
    public static function hasBidang(string $bidangCode): bool
    {
        if (!Auth::check()) return false;

        $user = Auth::user();
        if ($user->role === 'superadmin') return true;

        return static::getUserAccess($user->id)
            ->contains(fn($a) => $a->module->bidang_code === $bidangCode && $a->is_aktif);
    }

    // ── Ambil semua modul yang user punya akses ──
    public static function modules(): Collection
    {
        if (!Auth::check()) return collect();

        $user = Auth::user();

        if ($user->role === 'superadmin') {
            return Module::with('children')
                ->aktif()
                ->orderBy('bidang_code')
                ->orderBy('urutan')
                ->get();
        }

        return static::getUserAccess($user->id)
            ->filter(fn($a) => $a->is_aktif)
            ->map(fn($a) => $a->module)
            ->sortBy('urutan');
    }

    // ── Ambil modul yang dikelompokkan per bidang ──
    public static function modulesByBidang(): Collection
    {
        return static::modules()->groupBy('bidang_code');
    }

    // ── Ambil bidang utama user (bidang pertama yang punya akses) ──
    public static function bidangUtama(?int $userId = null): ?string
    {
        $userId = $userId ?? Auth::id();
        if (!$userId) return null;

        $user = \App\Models\User::find($userId);
        if ($user?->role === 'superadmin') return 'doklan';

        $access = static::getUserAccess($userId)->first(fn($a) => $a->is_aktif);
        return $access?->module->bidang_code;
    }

    // ── Ambil level akses user ke modul tertentu ──
    public static function level(string $moduleCode): ?string
    {
        if (!Auth::check()) return null;

        $user = Auth::user();
        if ($user->role === 'superadmin') return 'admin';

        $access = static::getUserAccess($user->id)
            ->first(fn($a) => $a->module->module_code === $moduleCode && $a->is_aktif);

        return $access?->level;
    }

    // ── Ambil warna bidang user ──
    public static function warnaBidang(?string $bidangCode = null): array
    {
        $bidang = $bidangCode ?? static::bidangUtama();

        return match($bidang) {
            'doklan'     => ['bg' => '#0D1B3E', 'accent' => '#1E3A8A', 'foot' => 'rgba(212,175,55,0.7)'],
            'inteldakim' => ['bg' => '#071C24', 'accent' => '#0F4C5C', 'foot' => 'rgba(20,184,166,0.6)'],
            'tu'         => ['bg' => '#1A1200', 'accent' => '#B8860B', 'foot' => 'rgba(212,175,55,0.7)'],
            default      => ['bg' => '#0D1B3E', 'accent' => '#1E3A8A', 'foot' => 'rgba(212,175,55,0.7)'],
        };
    }

    // ── Clear cache akses user ──
    public static function clearCache(?int $userId = null): void
    {
        $userId = $userId ?? Auth::id();
        if ($userId) {
            Cache::forget("user_module_access_{$userId}");
        }
    }

    // ── Private: ambil akses user dengan cache ──
    private static function getUserAccess(int $userId): Collection
    {
        // Tidak cache object Eloquent — langsung query setiap request
        // Cache Eloquent object menyebabkan __PHP_Incomplete_Class saat unserialize
        return UserModuleAccess::with('module')
            ->where('user_id', $userId)
            ->get();
    }
}