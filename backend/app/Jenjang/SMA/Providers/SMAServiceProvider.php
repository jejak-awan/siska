<?php

namespace App\Jenjang\SMA\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class SMAServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register SMA module configuration
        $this->mergeConfigFrom(
            __DIR__.'/../../../../../../jenjang/sma/config/sma.php', 'sma'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load SMA module routes
        $this->loadRoutesFrom(__DIR__.'/../../../../../../jenjang/sma/routes/api.php');

        // Load SMA module migrations
        $this->loadMigrationsFrom(__DIR__.'/../../../../../../jenjang/sma/database/migrations');

        // Publish SMA module configuration
        $this->publishes([
            __DIR__.'/../../../../../../jenjang/sma/config/sma.php' => config_path('sma.php'),
        ], 'sma-config');

        // Publish SMA module migrations
        $this->publishes([
            __DIR__.'/../../../../../../jenjang/sma/database/migrations' => database_path('migrations/sma'),
        ], 'sma-migrations');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['sma'];
    }
}
