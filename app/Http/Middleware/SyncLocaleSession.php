<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SyncLocaleSession
{
    public function handle(Request $request, Closure $next)
    {
        session(['locale' => app()->getLocale()]);

        return $next($request);
    }
}
