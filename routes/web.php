<?php

use App\Http\Controllers\Auth\DaftarController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Operator\Doklan\LayananPasporExcelController;
use App\Http\Controllers\Operator\Doklan\LayananPasporPdfController;
use App\Http\Controllers\Kanwil\Doklan\LayananPasporExcelController as KanwilPasporExcelController;
use App\Http\Controllers\Kanwil\Doklan\LayananPasporPdfController as KanwilPasporPdfController;
use Illuminate\Support\Facades\Route;

// ────────────────────────────────────────────────
// ROOT
// ────────────────────────────────────────────────
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard.redirect')
        : redirect()->route('login');
});

// ────────────────────────────────────────────────
// AUTH — Guest Only
// ────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/daftar',  [DaftarController::class, 'show'])->name('daftar');
    Route::post('/daftar', [DaftarController::class, 'store'])->name('daftar.post');
});

// Check NIP — login 2 langkah (tanpa auth)
Route::post('/login/check-nip', function (\Illuminate\Http\Request $request) {
    $request->validate(['nip' => 'required|digits:18']);

    $user = \App\Models\User::where('nip', $request->nip)->first();

    if (!$user) {
        return response()->json(['found' => false, 'message' => 'NIP tidak ditemukan.']);
    }
    if ($user->status === 'pending') {
        return response()->json(['found' => false, 'message' => 'Akun Anda masih menunggu persetujuan admin.']);
    }
    if ($user->status === 'ditolak') {
        return response()->json(['found' => false, 'message' => 'Akun Anda ditolak. Hubungi administrator.']);
    }
    if ($user->status !== 'aktif') {
        return response()->json(['found' => false, 'message' => 'Akun tidak aktif.']);
    }

    $bidang = \App\Core\Services\PermissionService::bidangUtama($user->id) ?? 'doklan';

    $warna = match($bidang) {
        'inteldakim' => [
            'bg' => '#071C24', 'accent' => '#0F4C5C',
            'badge_bg' => 'rgba(15,76,92,0.4)', 'badge_text' => 'rgba(20,184,166,0.9)',
            'btn' => '#0F4C5C', 'label' => 'Inteldakim',
        ],
        'tu' => [
            'bg' => '#1A1200', 'accent' => '#B8860B',
            'badge_bg' => 'rgba(184,134,11,0.3)', 'badge_text' => 'rgba(212,175,55,0.9)',
            'btn' => '#B8860B', 'label' => 'Tata Usaha',
        ],
        default => [
            'bg' => '#0D1B3E', 'accent' => '#1E3A8A',
            'badge_bg' => 'rgba(30,58,138,0.4)', 'badge_text' => '#93C5FD',
            'btn' => '#1E3A8A', 'label' => 'Doklan',
        ],
    };

    return response()->json([
        'found'   => true,
        'nama'    => $user->nama_lengkap,
        'jabatan' => $user->jabatan ?? $user->role,
        'kanim'   => $user->kanim?->nama_kanim ?? $user->kanwil?->nama_kanwil ?? 'Kanwil Ditjenim Jabar',
        'inisial' => strtoupper(substr($user->nama_lengkap, 0, 1))
                   . strtoupper(substr(explode(' ', $user->nama_lengkap)[1] ?? 'X', 0, 1)),
        'bidang'  => $bidang,
        'warna'   => $warna,
    ]);
})->name('login.check-nip');

// ────────────────────────────────────────────────
// LOGOUT
// ────────────────────────────────────────────────
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ────────────────────────────────────────────────
// STATUS HALAMAN
// ────────────────────────────────────────────────
Route::get('/pending', fn() => view('auth.pending'))->name('pending');
Route::get('/ditolak', fn() => view('auth.ditolak'))->name('ditolak');

// ────────────────────────────────────────────────
// AUTHENTICATED
// ────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard redirect sesuai role
    Route::get('/redirect', function () {
        return match(true) {
            in_array(auth()->user()->role, ['superadmin', 'admin_kakanwil'])
                => redirect()->route('admin.dashboard'),
            in_array(auth()->user()->role, [
                'admin_kabid_doklan', 'admin_kanwil_doklan',
                'admin_kabid_wasdakim', 'admin_kanwil_wasdakim',
                'admin_kabag_tu', 'admin_kanwil_tu',
            ]) => redirect()->route('kanwil.dashboard'),
            auth()->user()->role === 'admin_kanim'
                => redirect()->route('kanim.dashboard'),
            in_array(auth()->user()->role, ['operator_kanim', 'operator_tu'])
                => redirect()->route('operator.dashboard'),
            default => redirect()->route('login'),
        };
    })->name('dashboard.redirect');

    // ── ADMIN ─────────────────────────────────────
    Route::prefix('admin')
        ->middleware('role:superadmin,admin_kakanwil')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

            Route::prefix('users')->name('users.')->group(function () {
                Route::get('/',              fn() => view('admin.users.index'))->name('index');
                Route::get('/create',        fn() => view('admin.users.create-wrapper'))->name('create');
                Route::get('/{userId}/edit', fn($id) => view('admin.users.edit-wrapper', ['userId' => $id]))->name('edit');
                Route::get('/{userId}',      fn($id) => view('admin.users.view-wrapper', ['userId' => $id]))->name('show');
            });
        });

    // ── KANWIL ────────────────────────────────────
    Route::prefix('kanwil')
        ->middleware('role:admin_kabid_doklan,admin_kanwil_doklan,admin_kabid_wasdakim,admin_kanwil_wasdakim,admin_kabag_tu,admin_kanwil_tu')
        ->name('kanwil.')
        ->group(function () {
            Route::get('/dashboard', fn() => view('kanwil.dashboard'))->name('dashboard');

            Route::middleware('role:superadmin,admin_kabid_doklan,admin_kanwil_doklan')
                ->prefix('doklan')->name('doklan.')
                ->group(function () {
                    Route::prefix('paspor')->name('paspor.')->group(function () {
                        Route::get('/',             fn() => view('kanwil.doklan.paspor.index'))->name('index');
                        Route::get('/monitoring',   fn() => view('kanwil.doklan.paspor.monitoring-wrapper'))->name('monitoring');
                        Route::get('/export',       fn() => view('kanwil.doklan.paspor.export-wrapper'))->name('export');
                        Route::get('/export/excel', [KanwilPasporExcelController::class, 'export'])->name('export.excel');
                        Route::get('/export/pdf',   [KanwilPasporPdfController::class, 'export'])->name('export.pdf');
                    });
                });
        });

    // ── KANIM ─────────────────────────────────────
    Route::prefix('kanim')
        ->middleware('role:admin_kanim')
        ->name('kanim.')
        ->group(function () {
            Route::get('/dashboard', fn() => view('kanim.dashboard'))->name('dashboard');
        });

    // ── OPERATOR ──────────────────────────────────
    Route::prefix('operator')
        ->middleware('role:operator_kanim,operator_tu')
        ->name('operator.')
        ->group(function () {
            Route::get('/dashboard', fn() => view('operator.dashboard-wrapper'))->name('dashboard');

            // Paspor
            Route::prefix('doklan/paspor')->name('doklan.paspor')->group(function () {
                Route::get('/',             fn() => view('operator.doklan.paspor.wrapper'))->name('');
                Route::get('/export',       fn() => view('operator.doklan.paspor.export-wrapper'))->name('.export');
                Route::get('/export/excel', [LayananPasporExcelController::class, 'export'])->name('.export.excel');
                Route::get('/export/pdf',   [LayananPasporPdfController::class, 'export'])->name('.export.pdf');
            });

            // Izin Tinggal — /input & /wna HARUS SEBELUM /{id}
            Route::prefix('doklan/izin-tinggal')->name('doklan.izin-tinggal.')->group(function () {
                Route::get('/',          fn() => view('operator.doklan.izin-tinggal.index'))->name('index');
                Route::get('/input',     fn() => view('operator.doklan.izin-tinggal.input-wrapper'))->name('input');
                Route::get('/wna',       fn() => view('operator.doklan.izin-tinggal.wna-wrapper'))->name('wna');
                Route::get('/{id}/edit', fn($id) => view('operator.doklan.izin-tinggal.input-wrapper', ['id' => $id]))->name('edit');
                Route::get('/{id}',      fn($id) => view('operator.doklan.izin-tinggal.detail-wrapper', ['id' => $id]))->name('detail');
            });
        });
});