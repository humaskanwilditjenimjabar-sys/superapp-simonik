<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModuleAccess extends Model
{
    protected $table = 'user_module_access';

    protected $fillable = [
        'user_id',
        'module_id',
        'level',
        'is_aktif',
        'granted_by',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    // ── Relasi ──
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function grantedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'granted_by');
    }

    // ── Helpers ──
    public function getLevelLabelAttribute(): string
    {
        return match($this->level) {
            'viewer'      => 'Viewer',
            'operator'    => 'Operator',
            'verifikator' => 'Verifikator',
            'manager'     => 'Manager',
            'admin'       => 'Admin',
            default       => ucfirst($this->level),
        };
    }
}