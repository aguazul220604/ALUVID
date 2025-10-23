<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Mapeo de IDs a descripciones
            $roles = [
                1 => 'Administrador',
                2 => 'Colaborador',
            ];

            $userRoleDescripcion = $roles[$user->role] ?? null;

            if ($userRoleDescripcion === $role) {
                return $next($request);
            }
        }

        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
}
