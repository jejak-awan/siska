<?php

namespace App\Installer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CheckInstallationStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if installation is already completed
        if ($this->isInstallationCompleted()) {
            // If accessing installer routes after completion, redirect to main app
            if ($request->is('installer*') && !$request->is('installer/completed')) {
                return redirect('/login');
            }
        } else {
            // If installation is not completed, redirect to installer
            if (!$request->is('installer*')) {
                return redirect('/installer');
            }
        }

        return $next($request);
    }

    /**
     * Check if installation is completed
     */
    private function isInstallationCompleted(): bool
    {
        $flagFile = storage_path('app/installer_complete.json');
        
        if (!File::exists($flagFile)) {
            return false;
        }

        try {
            $data = json_decode(File::get($flagFile), true);
            return isset($data['completed_at']);
        } catch (\Exception $e) {
            return false;
        }
    }
}
