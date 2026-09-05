<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class Maintenance
{
    public function handle(Request $request, Closure $next): Response
    {
        $maintenance = Cache::remember('maintenance', now()->addMinutes(30), function () {
           return Setting::get('maintenance_status');
        });

        if($maintenance == 1){
            return response()->view('errors.503');
        }

        return $next($request);
    }
}
