<?php

namespace App\Jenjang\SD\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class SDServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register SD module configuration
        $this->mergeConfigFrom(
            __DIR__.'/../../config/sd.php', 'sd'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load SD module routes
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
        
        // Load SD module migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        
        // Publish SD module configuration
        $this->publishes([
            __DIR__.'/../../config/sd.php' => config_path('sd.php'),
        ], 'sd-config');
        
        // Publish SD module migrations
        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations/sd'),
        ], 'sd-migrations');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
