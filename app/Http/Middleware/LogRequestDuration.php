<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LogRequestDuration
{
    public function handle(Request $request, Closure $next): Response
    {
        $start = microtime(true);
        $response = $next($request);
        $duration = microtime(true) - $start;

        Log::info('Час виконання запиту', [
            'url' => $request->url(),
            'duration' => round($duration * 1000, 2) . ' ms',
        ]);

        return $response;
    }
}