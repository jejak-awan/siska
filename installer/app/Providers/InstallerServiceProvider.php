<?php

namespace App\Installer\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class InstallerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register installer routes
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        
        // Register installer views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'installer');
        
        // Register installer middleware
        $this->app['router']->aliasMiddleware('installer.check', \App\Installer\Http\Middleware\CheckInstallationStatus::class);
        
        // Publish installer assets
        $this->publishes([
            __DIR__ . '/../../public' => public_path('installer'),
        ], 'installer-assets');
    }
}

