<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Symfony\Component\HttpFoundation\Response;

class AllowAdminDuringMaintenance
{
    // public function handle($request, Closure $next)
    // {
    //     if (app()->isDownForMaintenance()) {
    //         $user = auth()->user();
    //         if (!$user || $user->role !== 'admin') {
    //             throw new MaintenanceModeException(now(), null, 'Maintenance mode');
    //         }
    //     }

    //     return $next($request);
    // }
}
