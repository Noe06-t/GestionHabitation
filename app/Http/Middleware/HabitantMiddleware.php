<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class HabitantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier que l'utilisateur est authentifié en tant qu'habitant
        if (!Auth::guard('habitant')->check()) {
            return redirect()->route('habitant.login')
                ->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }
        return $next($request);
    }
}
