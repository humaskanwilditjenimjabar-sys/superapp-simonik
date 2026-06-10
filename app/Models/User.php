<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nip',
        'nama_lengkap',
        'jabatan',
        'role',
        'bidang',
        'jenis_layanan',
        'kanwil_id',
        'kanim_id',
        'password',
        'no_hp',
        'email',
        'status',
        'surat_pengajuan',
        'alasan_penolakan',
    ];
    
    protected $appends = ['name'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    
    // ── Relasi ──
    public function kanwil()
    {
        return $this->belongsTo(KantorWilayah::class, 'kanwil_id');
    }

    public function kanim()
    {
        return $this->belongsTo(KantorImigrasi::class, 'kanim_id');
    }

    // ── Helpers ──
    public function isOperatorKanim(): bool
    {
        return $this->role === 'operator_kanim';
    }

    public function isAdminKanim(): bool
    {
        return $this->role === 'admin_kanim';
    }

    public function isKanwilLevel(): bool
    {
        return in_array($this->role, [
            'admin_kabid_doklan',
            'admin_kanwil_doklan',
            'admin_kabid_wasdakim',
            'admin_kanwil_wasdakim',
            'admin_kabag_tu',
            'admin_kanwil_tu',
            'admin_kakanwil',
            'superadmin',
        ]);
    }

    public function isSuperOrKakanwil(): bool
    {
        return in_array($this->role, ['superadmin', 'admin_kakanwil']);
    }

    // ── Label ──
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'superadmin'              => 'Superadmin',
            'admin_kakanwil'          => 'Admin Kakanwil',
            'admin_kabid_doklan'      => 'Admin Kabid Doklan',
            'admin_kanwil_doklan'     => 'Admin Kanwil Doklan',
            'admin_kabid_wasdakim'    => 'Admin Kabid Wasdakim',
            'admin_kanwil_wasdakim'   => 'Admin Kanwil Wasdakim',
            'admin_kabag_tu'          => 'Admin Kabag TU',
            'admin_kanwil_tu'         => 'Admin Kanwil TU',
            'admin_kanim'             => 'Admin Kanim',
            'operator_kanim'          => 'Operator Kanim',
            'operator_tu'             => 'Operator TU',
            default                   => $this->role,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'  => 'Menunggu Verifikasi',
            'aktif'    => 'Aktif',
            'nonaktif' => 'Nonaktif',
            'ditolak'  => 'Ditolak',
            default    => $this->status,
        };
    }

    public function getAuthIdentifierName(): string
    {
        return 'nip';
    }

    public function getAuthIdentifier(): string
    {
        return $this->nip;
    }

    public function getAuthPassword(): string
    {
        return $this->password;
    }

    public function getNameAttribute(): string
    {
        return $this->nama_lengkap ?? '';
    }
    // ── Module Access ──
    public function moduleAccess()
    {
        return $this->hasMany(\App\Models\UserModuleAccess::class, 'user_id');
    }

    public function activeModules()
    {
        return $this->moduleAccess()
            ->where('is_aktif', true)
            ->with('module');
    }

    public function canAccessModule(string $moduleCode, string $minLevel = 'viewer'): bool
    {
        if ($this->role === 'superadmin') return true;

        return \App\Core\Services\PermissionService::can($moduleCode, $minLevel);
    }

    public function getBidangUtamaAttribute(): ?string
    {
        if ($this->role === 'superadmin') return 'doklan';

        return $this->moduleAccess()
            ->where('is_aktif', true)
            ->with('module')
            ->get()
            ->first()
            ?->module
            ?->bidang_code;
    }

}