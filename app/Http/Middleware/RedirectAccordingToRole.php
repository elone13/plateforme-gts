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
            
            if ($user->role === 'admin') {
                if ($user->administrateur) {
                    if ($user->administrateur->type === 'manager') {
                        return redirect()->route('manager.dashboard');
                    } elseif ($user->administrateur->type === 'commercial') {
                        return redirect()->route('commercial.dashboard');
                    }
                }
                return redirect()->route('admin.dashboard');
            }
            
            // Clients go to home page
            return redirect()->route('home');
        }

        return $next($request);
    }
}

