<?php

namespace App\Jenjang\SMK\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class SMKServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register SMK module configuration
        $this->mergeConfigFrom(
            __DIR__.'/../../../../../../jenjang/smk/config/smk.php', 'smk'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load SMK module routes
        $this->loadRoutesFrom(__DIR__.'/../../../../../../jenjang/smk/routes/api.php');

        // Load SMK module migrations
        $this->loadMigrationsFrom(__DIR__.'/../../../../../../jenjang/smk/database/migrations');

        // Publish SMK module configuration
        $this->publishes([
            __DIR__.'/../../../../../../jenjang/smk/config/smk.php' => config_path('smk.php'),
        ], 'smk-config');

        // Publish SMK module migrations
        $this->publishes([
            __DIR__.'/../../../../../../jenjang/smk/database/migrations' => database_path('migrations/smk'),
        ], 'smk-migrations');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['smk'];
    }
}
