<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminTypeMiddleware
{
    /**
     * Ensure the admin user has a specific type.
     */
    public function handle(Request $request, Closure $next, string $type): Response
    {
        $user = $request->user();
        
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Accès non autorisé');
        }
        
        $administrateur = $user->administrateur;
        if (!$administrateur || $administrateur->type !== $type) {
            abort(403, 'Type d\'administrateur non autorisé');
        }
        
        return $next($request);
    }
}

