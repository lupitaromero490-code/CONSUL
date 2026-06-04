<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!in_array($user->rol, $roles)) {
            return redirect()->route('dashboard')
                             ->with('error', 'No tienes permiso para acceder a esa sección');
        }

        return $next($request);
    }
}