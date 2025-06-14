<?php

namespace App\Providers;
use Illuminate\Support\Facades\View; // <-- Tambahkan ini
use App\Http\View\Composers\NavigationComposer; 
use Illuminate\Support\ServiceProvider;

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
        View::composer('layouts.navigation', NavigationComposer::class);
    }
}
