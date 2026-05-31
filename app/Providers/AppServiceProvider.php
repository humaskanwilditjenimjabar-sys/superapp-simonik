<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Daftarkan layout component
        Blade::component('layouts.app', 'app-layout');

        // Daftarkan migrations dari subdirectory
        $this->loadMigrationsFrom([
            database_path('migrations/shared'),
            database_path('migrations/doklan'),
            database_path('migrations/wasdakim'),
            database_path('migrations/tata_usaha'),
        ]);
    }
}