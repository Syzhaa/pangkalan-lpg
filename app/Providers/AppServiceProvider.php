<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // <-- Tambahkan ini
use App\Models\SiteSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!app()->runningInConsole()) {
            // Mengambil semua settings sebagai array (key => value)
            $settings = SiteSetting::pluck('value', 'key')->all();

            // Membagikan variabel $settings ke SEMUA view
            View::share('settings', $settings);
        }
    }
}
