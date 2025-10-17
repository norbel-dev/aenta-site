<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('web')->user();

        // Verifica autenticación y rol admin (Spatie)
        if (!$user || !$user->hasRole('admin')) {
            abort(403, 'Solo los administradores pueden acceder a esta página.');
        }

        return $next($request);
    }
}
