<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCartNotEmpty
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->query('empty') === 'true') {
            abort(403, 'Ваш кошик порожній! Додайте товари перед оформленням замовлення.');
        }

        return $next($request);
    }
}