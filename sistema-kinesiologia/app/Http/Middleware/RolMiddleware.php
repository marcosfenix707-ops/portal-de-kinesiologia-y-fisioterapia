<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    /** Permite el acceso solo a usuarios activos con alguno de los roles indicados. */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! $user->activo || ! $user->tieneRol(...$roles)) {
            abort(403, 'No tiene permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
