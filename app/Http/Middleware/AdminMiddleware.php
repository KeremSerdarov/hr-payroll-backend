<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Diňe admin token bilen goralan API-a girip biler.
        abort_unless($request->user() && $request->user()->role === 'admin', 403);

        return $next($request);
    }
}
