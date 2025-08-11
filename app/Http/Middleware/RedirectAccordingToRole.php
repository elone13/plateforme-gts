<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectAccordingToRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Vérifier d'abord si l'utilisateur est un administrateur (manager ou commercial)
            if ($user->administrateur) {
                if ($user->administrateur->type === 'manager') {
                    return redirect()->route('manager.dashboard');
                } elseif ($user->administrateur->type === 'commercial') {
                    return redirect()->route('commercial.dashboard');
                }
            }
            
            // Si c'est un admin général (sans type spécifique)
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            // Clients go to their profile page
            return redirect()->route('client.profile');
        }

        return $next($request);
    }
}

