<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ConditionalEmailVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (Auth::check()) {
            $user = Auth::user();
            
            // Utiliser la méthode personnalisée pour vérifier si l'email doit être vérifié
            if ($user->requiresEmailVerification() && !$user->isEmailVerified()) {
                return redirect()->route('verification.notice');
            }
        }

        return $next($request);
    }
}
