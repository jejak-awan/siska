<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        // Set default string length for MySQL
        Schema::defaultStringLength(191);
        
        // Register any global configurations
        $this->registerGlobalConfigurations();
    }

    /**
     * Register global configurations
     */
    private function registerGlobalConfigurations(): void
    {
        // Set timezone
        date_default_timezone_set(config('app.timezone', 'Asia/Jakarta'));
        
        // Register any global middleware or configurations
    }
}

