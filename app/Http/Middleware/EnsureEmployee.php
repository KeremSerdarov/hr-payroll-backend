<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmployee
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // API maglumatlary diňe işgär roly we işgär ýazgysy bolan ulanyja açyk.
        abort_unless($user && $user->role === 'employee', 403, 'Bu API diňe işgärler üçin.');
        $user->loadMissing('employee');
        abort_unless($user->employee, 403, 'Işgär ýazgysy tapylmady.');

        return $next($request);
    }
}
