<?php

use App\Http\Middleware\RedirectAccordingToRole;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DemandeDemoController;

// Public routes - Portail client
Route::get('/', function () {
    return view('portal.home');
})->name('home');

Route::get('/services', function () {
    return view('portal.services');
})->name('services');

Route::get('/contact', function () {
    return view('portal.contact');
})->name('contact');

// Route pour le formulaire de demande de démo
Route::post('/demande-demo', [DemandeDemoController::class, 'store'])->name('demande-demo.store');

// Authentication routes (Jetstream handles these)
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware(RedirectAccordingToRole::class);

Route::get('/register', function () {
    return view('auth.register');
})->name('register')->middleware(RedirectAccordingToRole::class);

// Client routes (authenticated clients stay on public portal)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Client profile and dashboard
    Route::get('/mon-profil', function () {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            // Redirect admins to their respective dashboards
            if ($user->administrateur) {
                if ($user->administrateur->type === 'manager') {
                    return redirect()->route('manager.dashboard');
                } elseif ($user->administrateur->type === 'commercial') {
                    return redirect()->route('commercial.dashboard');
                }
            }
            return redirect()->route('admin.dashboard');
        }
        
        // Clients stay on public portal with profile access
        return view('portal.client-profile');
    })->name('client.profile');

    // Client specific routes
    Route::prefix('client')->group(function () {
        Route::get('/devis', function () {
            return view('portal.client-devis');
        })->name('client.devis');
        
        Route::get('/factures', function () {
            return view('portal.client-factures');
        })->name('client.factures');
    });
});

if (app()->environment('local')) {
    Route::get('/debug-users', function () {
        return \App\Models\User::select('id', 'name', 'email', 'role')->get();
    });

    Route::get('/debug-try-login', function () {
        $email = request('email');
        $password = request('password');
        $ok = Auth::attempt(['email' => $email, 'password' => $password]);
        return [
            'email' => $email,
            'ok' => $ok,
        ];
    });
}

// Admin area
Route::prefix('admin')->group(function () {
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'role:admin',
    ])->group(function () {
        Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
    });
});

// Manager area
Route::prefix('manager')->group(function () {
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'role:admin',
    ])->group(function () {
        Route::view('/dashboard', 'manager.dashboard')->name('manager.dashboard');
    });
});

// Commercial area
Route::prefix('commercial')->group(function () {
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'role:admin',
    ])->group(function () {
        Route::view('/dashboard', 'commercial.dashboard')->name('commercial.dashboard');
    });
});
