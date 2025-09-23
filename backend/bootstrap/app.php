<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withProviders([
        // Core Service Providers
        App\Providers\AppServiceProvider::class,
        
        // Jenjang Service Providers (temporarily disabled for testing)
        // App\Jenjang\SD\Providers\SDServiceProvider::class,
        // App\Jenjang\SMP\Providers\SMPServiceProvider::class,
        // App\Jenjang\SMA\Providers\SMAServiceProvider::class,
        // App\Jenjang\SMK\Providers\SMKServiceProvider::class,
        
        // Installer Service Provider (temporarily disabled)
        // App\Installer\Providers\InstallerServiceProvider::class,
    ])->create();
