<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DetectDevice
{
    public function handle(Request $request, Closure $next)
    {
        $agent = $request->header('User-Agent');

        if (preg_match('/Mobile|Android|iPhone|iPad/', $agent)) {
            View::share('isMobile', true);
        } else {
            View::share('isMobile', false);
        }

        return $next($request);
    }
}

