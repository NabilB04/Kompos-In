<?php

// app/Http/Middleware/NoCache.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NoCache
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                       ->header('Pragma', 'no-cache')
                       ->header('Expires', '0');
    }
}
