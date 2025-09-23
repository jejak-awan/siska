<?php

namespace App\Jenjang\SMP\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class SMPServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register SMP module configuration
        $this->mergeConfigFrom(
            __DIR__.'/../../../../../../jenjang/smp/config/smp.php', 'smp'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load SMP module routes
        $this->loadRoutesFrom(__DIR__.'/../../../../../../jenjang/smp/routes/api.php');

        // Load SMP module migrations
        $this->loadMigrationsFrom(__DIR__.'/../../../../../../jenjang/smp/database/migrations');

        // Publish SMP module configuration
        $this->publishes([
            __DIR__.'/../../../../../../jenjang/smp/config/smp.php' => config_path('smp.php'),
        ], 'smp-config');

        // Publish SMP module migrations
        $this->publishes([
            __DIR__.'/../../../../../../jenjang/smp/database/migrations' => database_path('migrations/smp'),
        ], 'smp-migrations');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['smp'];
    }
}