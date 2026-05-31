<?php

use App\Http\Controllers\Auth\DaftarController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Operator\Doklan\LayananPasporExcelController;
use App\Http\Controllers\Operator\Doklan\LayananPasporPdfController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kanwil\Doklan\LayananPasporExcelController as KanwilPasporExcelController;
use App\Http\Controllers\Kanwil\Doklan\LayananPasporPdfController as KanwilPasporPdfController;

// ── Root redirect ──
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard.redirect');
    }
    return redirect()->route('login');
});

// ── Auth (Guest only) ──
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/daftar', [DaftarController::class, 'show'])->name('daftar');
    Route::post('/daftar', [DaftarController::class, 'store'])->name('daftar.post');
});

// ── Logout ──
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ── Status halaman ──
Route::get('/pending', fn() => view('auth.pending'))->name('pending');
Route::get('/ditolak', fn() => view('auth.ditolak'))->name('ditolak');

// ── Redirect ke panel sesuai role ──
Route::middleware('auth')->group(function () {

    Route::get('/redirect', function () {
        $role = auth()->user()->role;
        return match(true) {
            in_array($role, ['superadmin', 'admin_kakanwil'])
                => redirect()->route('admin.dashboard'),
            in_array($role, ['admin_kabid_doklan', 'admin_kanwil_doklan', 'admin_kabid_wasdakim', 'admin_kanwil_wasdakim', 'admin_kabag_tu', 'admin_kanwil_tu'])
                => redirect()->route('kanwil.dashboard'),
            $role === 'admin_kanim'
                => redirect()->route('kanim.dashboard'),
            in_array($role, ['operator_kanim', 'operator_tu'])
                => redirect()->route('operator.dashboard'),
            default => redirect()->route('login'),
        };
    })->name('dashboard.redirect');

    // ── Panel Admin ──
    Route::prefix('admin')
        ->middleware('role:superadmin,admin_kakanwil')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
            Route::get('/users', function() {
                return view('admin.users.index');
            })->name('users.index');
            Route::get('/users/create', function() {
                return view('admin.users.create-wrapper');
            })->name('users.create');
            Route::get('/users/{userId}/edit', function($userId) {
                return view('admin.users.edit-wrapper', compact('userId'));
            })->name('users.edit');
            Route::get('/users/{userId}', function($userId) {
                return view('admin.users.view-wrapper', compact('userId'));
            })->name('users.show');
        });

    // ── Panel Kanwil ──
    Route::prefix('kanwil')
    ->middleware('role:admin_kabid_doklan,admin_kanwil_doklan,admin_kabid_wasdakim,admin_kanwil_wasdakim,admin_kabag_tu,admin_kanwil_tu')
    ->name('kanwil.')
    ->group(function () {

        Route::get('/dashboard', fn() => view('kanwil.dashboard'))->name('dashboard');
        // Doklan — hanya kabid & kanwil doklan
        Route::middleware('role:superadmin,admin_kabid_doklan,admin_kanwil_doklan')
            ->group(function () {
                Route::get('/doklan/paspor', fn() => view('kanwil.doklan.paspor.index'))
                    ->name('doklan.paspor');
                Route::get('/doklan/paspor/monitoring', fn() => view('kanwil.doklan.paspor.monitoring-wrapper'))
                    ->name('doklan.paspor.monitoring');
                Route::get('/doklan/paspor/export', fn() => view('kanwil.doklan.paspor.export-wrapper'))
                    ->name('doklan.paspor.export');

                Route::get('/doklan/paspor/export/excel', [KanwilPasporExcelController::class, 'export'])
                    ->name('doklan.paspor.export.excel');
                Route::get('/doklan/paspor/export/pdf', [KanwilPasporPdfController::class, 'export'])
                    ->name('doklan.paspor.export.pdf');
                
               
            });
    });

    // ── Panel Kanim ──
    Route::prefix('kanim')
        ->middleware('role:admin_kanim')
        ->name('kanim.')
        ->group(function () {
            Route::get('/dashboard', fn() => view('kanim.dashboard'))->name('dashboard');
        });

    // ── Panel Operator ──
    Route::prefix('operator')
        ->middleware('role:operator_kanim,operator_tu')
        ->name('operator.')
        ->group(function () {
            Route::get('/dashboard', fn() => view('operator.dashboard-wrapper'))->name('dashboard');
            Route::get('/doklan/paspor', function() {
                return view('operator.doklan.paspor.wrapper');
            })->name('doklan.paspor');
            Route::get('/doklan/paspor/export', fn() => view('operator.doklan.paspor.export-wrapper'))->name('doklan.paspor.export');
            Route::get('/doklan/paspor/export/excel', [LayananPasporExcelController::class, 'export'])->name('doklan.paspor.export.excel');
            Route::get('/doklan/paspor/export/pdf', [LayananPasporPdfController::class, 'export'])->name('doklan.paspor.export.pdf');

            // Izin Tinggal
            Route::get('/doklan/izin-tinggal', fn() => view('operator.doklan.izin-tinggal.index'))
                ->name('doklan.izin-tinggal.index');
            Route::get('/doklan/izin-tinggal/input', fn() => view('operator.doklan.izin-tinggal.input-wrapper'))
                ->name('doklan.izin-tinggal.input');
            Route::get('/doklan/izin-tinggal/wna', fn() => view('operator.doklan.izin-tinggal.wna-wrapper'))
                ->name('doklan.izin-tinggal.wna');
            Route::get('/doklan/izin-tinggal/{id}/edit', fn($id) => view('operator.doklan.izin-tinggal.input-wrapper', ['id' => $id]))
                ->name('doklan.izin-tinggal.edit');
            Route::get('/doklan/izin-tinggal/{id}', fn($id) => view('operator.doklan.izin-tinggal.detail-wrapper', ['id' => $id]))
                ->name('doklan.izin-tinggal.detail');
        });

});