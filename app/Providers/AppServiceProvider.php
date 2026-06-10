<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Core\Services\PermissionService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PermissionService::class);
    }

    public function boot(): void
    {
        // Daftarkan layout component
        Blade::component('layouts.app', 'app-layout');

        // Daftarkan migrations dari subdirectory
        $this->loadMigrationsFrom([
            database_path('migrations/core'),
            database_path('migrations/shared'),
            database_path('migrations/doklan'),
            database_path('migrations/wasdakim'),
            database_path('migrations/tata_usaha'),
        ]);

        // Blade directive: @canModule('doklan.paspor') ... @endcanModule
        Blade::if('canModule', function (string $moduleCode, string $minLevel = 'viewer') {
            return PermissionService::can($moduleCode, $minLevel);
        });

        // Blade directive: @bidang('doklan') ... @endbidang
        Blade::if('bidang', function (string $bidangCode) {
            return PermissionService::hasBidang($bidangCode);
        });
    }
}