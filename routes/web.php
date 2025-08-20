<?php

use App\Http\Middleware\RedirectAccordingToRole;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DemandeDemoController;
use App\Http\Controllers\Commercial\FactureController;

// Inclure les routes temporaires
if (app()->environment('local')) {
    require __DIR__.'/temp-routes.php';
}

// Routes publiques
Route::get('/solutions', [App\Http\Controllers\PublicController::class, 'solutions'])->name('solutions');
Route::get('/', [App\Http\Controllers\PublicController::class, 'home'])->name('home');

Route::get('/services', [App\Http\Controllers\PublicController::class, 'services'])->name('services');
Route::get('/services/{service}', [App\Http\Controllers\PublicController::class, 'serviceDetail'])->name('service.detail');
Route::get('/test-services', [App\Http\Controllers\PublicController::class, 'testServices'])->name('test.services');
Route::get('/test-colors', function() {
    return view('test-colors');
})->name('test.colors');

Route::get('/contact', function () {
    return view('portal.contact');
})->name('contact');

// Route pour le formulaire de demande de démo
Route::post('/demande-demo', [DemandeDemoController::class, 'store'])->name('demande-demo.store');

// Route de test pour les emails (à supprimer en production)
Route::get('/test-email', function () {
    try {
        $demande = new \App\Models\DemandeDemo([
            'nom' => 'Test Client',
            'email' => 'test@example.com',
            'telephone' => '+221 77 123 45 67',
            'message' => 'Ceci est un test d\'email',
            'statut' => 'en_attente',
            'source' => 'test',
            'priorite' => 'moyenne',
        ]);
        
        // Test email de confirmation
        \Mail::to('test@example.com')->send(new \App\Mail\DemandeDemoConfirmation($demande));
        
        // Test email de notification admin
        \Mail::to(config('app.admin_email'))->send(new \App\Mail\NouvelleDemandeDemo($demande));
        
        return 'Emails envoyés avec succès ! Vérifiez les logs dans storage/logs/laravel.log';
    } catch (\Exception $e) {
        return 'Erreur: ' . $e->getMessage();
    }
})->name('test.email');

// Route de test Livewire
Route::get('/test-livewire', function () {
    return view('test-livewire');
})->name('test.livewire');

// Default dashboard route - redirects users according to role
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if (!$user) {
        return redirect()->route('login');
    }
    
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
    
    // Clients go to their profile page
    return redirect()->route('client.profile');
})->middleware('auth:sanctum')->name('dashboard');

// Authentication routes (Jetstream handles these)
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware(RedirectAccordingToRole::class);

Route::get('/register', function () {
    return view('auth.register');
})->name('register')->middleware(RedirectAccordingToRole::class);

// Routes d'inscription client (publiques)
Route::prefix('client')->name('client.')->group(function () {
    Route::get('/register', [App\Http\Controllers\Client\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Client\RegisterController::class, 'register'])->name('register.post');
});

// Client routes (authenticated clients stay on public portal)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Client specific routes
    Route::prefix('client')->name('client.')->group(function () {
        // Route principale du profil (compatible avec l'espace existant)
        Route::get('/profile', function () {
            return view('portal.client-profile');
        })->name('profile');
        
        // Route pour voir les devis (compatible avec l'espace existant)
        Route::get('/devis', function () {
            return view('portal.client-devis');
        })->name('devis');
        
        // Route pour voir les factures (compatible avec l'espace existant)
        Route::get('/factures', function () {
            return view('portal.client-factures');
        })->name('factures');
        
                         // Routes avancées pour le profil client (sous un préfixe différent)
                 Route::prefix('advanced-profile')->name('advanced-profile.')->group(function () {
                     Route::get('/', [App\Http\Controllers\Client\ProfileController::class, 'show'])->name('show');
                     Route::put('/update', [App\Http\Controllers\Client\ProfileController::class, 'update'])->name('update');
                     
                     // Routes pour les devis du client
                     Route::prefix('devis')->name('devis.')->group(function () {
                         Route::get('/{devis}', [App\Http\Controllers\Client\ProfileController::class, 'showDevis'])->name('show');
                         Route::get('/{devis}/preview', [App\Http\Controllers\Client\ProfileController::class, 'previewDevis'])->name('preview');
                         Route::get('/{devis}/download', [App\Http\Controllers\Client\ProfileController::class, 'downloadDevis'])->name('download');
                         Route::post('/{devis}/validate', [App\Http\Controllers\Client\ProfileController::class, 'validateDevis'])->name('validate');
                     });
                 });
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
        
        // Routes pour la gestion des demandes de démo
        Route::prefix('demandes-demo')->group(function () {
            Route::get('/', [DemandeDemoController::class, 'index'])->name('admin.demandes-demo.index');
            Route::get('/{demandeDemo}', [DemandeDemoController::class, 'show'])->name('admin.demandes-demo.show');
            Route::put('/{demandeDemo}', [DemandeDemoController::class, 'update'])->name('admin.demandes-demo.update');
            Route::delete('/{demandeDemo}', [DemandeDemoController::class, 'destroy'])->name('admin.demandes-demo.destroy');
            Route::patch('/{demandeDemo}/traiter', [DemandeDemoController::class, 'traiter'])->name('admin.demandes-demo.traiter');
            Route::patch('/{demandeDemo}/terminer', [DemandeDemoController::class, 'terminer'])->name('admin.demandes-demo.terminer');
        });
    });
});

// Manager area
Route::prefix('manager')->name('manager.')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('manager.dashboard');
    })->name('dashboard');
    
    // Gestion des commerciaux
    Route::get('/commerciaux', function () {
        return view('manager.commerciaux.index');
    })->name('commerciaux.index');
    
    Route::get('/commerciaux/{commercial}', function ($commercial) {
        return view('manager.commerciaux.show', compact('commercial'));
    })->name('commerciaux.show');
    
    // Supervision des demandes de démo
    Route::get('/demandes-demo', function () {
        return view('manager.demandes-demo.index');
    })->name('demandes-demo.index');
    
    Route::get('/demandes-demo/{demande}', function ($demande) {
        return view('manager.demandes-demo.show', compact('demande'));
    })->name('demandes-demo.show');
    
    // Supervision des devis
    Route::get('/devis', function () {
        return view('manager.devis.index');
    })->name('devis.index');
    
    // Supervision des factures
    Route::get('/factures', function () {
        return view('manager.factures.index');
    })->name('factures.index');
    
    // Rapports
    Route::get('/rapports', function () {
        return view('manager.rapports.index');
    })->name('rapports.index');
    
    // Analytics
    Route::get('/analytics', function () {
        return view('manager.analytics.index');
    })->name('analytics.index');
    
    // Gestion des services
    Route::resource('services', \App\Http\Controllers\Manager\ServiceController::class);
    
    // Gestion des éléments des services
    Route::prefix('services/{service}/items')->name('services.items.')->group(function () {
        Route::get('/create', [\App\Http\Controllers\Manager\ItemController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Manager\ItemController::class, 'store'])->name('store');
        Route::get('/{item}/edit', [\App\Http\Controllers\Manager\ItemController::class, 'edit'])->name('edit');
        Route::put('/{item}', [\App\Http\Controllers\Manager\ItemController::class, 'update'])->name('update');
        Route::delete('/{item}', [\App\Http\Controllers\Manager\ItemController::class, 'destroy'])->name('destroy');
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
        
        // Routes pour la gestion des demandes de démo (commerciaux)
        Route::prefix('demandes-demo')->group(function () {
            Route::get('/', [DemandeDemoController::class, 'indexCommercial'])->name('commercial.demandes-demo.index');
            Route::get('/create', [DemandeDemoController::class, 'createCommercial'])->name('commercial.demandes-demo.create');
            Route::post('/', [DemandeDemoController::class, 'storeCommercial'])->name('commercial.demandes-demo.store');
            Route::get('/{demandeDemo}', [DemandeDemoController::class, 'showCommercial'])->name('commercial.demandes-demo.show');
            Route::put('/{demandeDemo}', [DemandeDemoController::class, 'updateCommercial'])->name('commercial.demandes-demo.update');
            Route::patch('/{demandeDemo}/traiter', [DemandeDemoController::class, 'traiter'])->name('commercial.demandes-demo.traiter');
            Route::patch('/{demandeDemo}/terminer', [DemandeDemoController::class, 'terminer'])->name('commercial.demandes-demo.terminer');
            Route::post('/{demandeDemo}/envoyer-confirmation', [DemandeDemoController::class, 'envoyerConfirmation'])->name('commercial.demandes-demo.confirmation');
            Route::post('/{demandeDemo}/accepter', [DemandeDemoController::class, 'accepter'])->name('commercial.demandes-demo.accepter');
            Route::post('/{demandeDemo}/refuser', [DemandeDemoController::class, 'refuser'])->name('commercial.demandes-demo.refuser');
            Route::post('/{demandeDemo}/planifier-rdv', [DemandeDemoController::class, 'planifierRendezVous'])->name('commercial.demandes-demo.planifier-rdv');
            Route::patch('/{demandeDemo}/en-cours', [DemandeDemoController::class, 'marquerEnCours'])->name('commercial.demandes-demo.en-cours');
            Route::patch('/{demandeDemo}/terminee', [DemandeDemoController::class, 'marquerTerminee'])->name('commercial.demandes-demo.terminee');
            Route::patch('/{demandeDemo}/en-attente', [DemandeDemoController::class, 'mettreEnAttente'])->name('commercial.demandes-demo.en-attente');
            Route::patch('/{demandeDemo}/priorite', [DemandeDemoController::class, 'modifierPriorite'])->name('commercial.demandes-demo.priorite');
        });

        // Routes pour la gestion du planning
        Route::prefix('planning')->group(function () {
            Route::get('/', [DemandeDemoController::class, 'planning'])->name('commercial.planning');
            Route::post('/creer-creneau', [DemandeDemoController::class, 'creerCreneau'])->name('commercial.planning.creer');
        });

        // Routes pour la gestion des clients
        Route::prefix('clients')->group(function () {
            Route::get('/', [\App\Http\Controllers\Commercial\ClientController::class, 'index'])->name('commercial.clients.index');
            Route::get('/create', [\App\Http\Controllers\Commercial\ClientController::class, 'create'])->name('commercial.clients.create');
            Route::post('/', [\App\Http\Controllers\Commercial\ClientController::class, 'store'])->name('commercial.clients.store');
            Route::get('/{client}', [\App\Http\Controllers\Commercial\ClientController::class, 'show'])->name('commercial.clients.show');
            Route::get('/{client}/edit', [\App\Http\Controllers\Commercial\ClientController::class, 'edit'])->name('commercial.clients.edit');
            Route::put('/{client}', [\App\Http\Controllers\Commercial\ClientController::class, 'update'])->name('commercial.clients.update');
            Route::delete('/{client}', [\App\Http\Controllers\Commercial\ClientController::class, 'destroy'])->name('commercial.clients.destroy');
            Route::post('/{client}/planifier-rdv', [\App\Http\Controllers\Commercial\ClientController::class, 'planifierRendezVous'])->name('commercial.clients.planifier-rdv');
            Route::post('/{client}/envoyer-email', [\App\Http\Controllers\Commercial\ClientController::class, 'envoyerEmail'])->name('commercial.clients.envoyer-email');
        });

        // Routes pour la gestion des demandes de devis
        Route::prefix('demandes-devis')->group(function () {
            Route::get('/', function () {
                return view('commercial.demandes-devis.index');
            })->name('commercial.demandes-devis.index');
            Route::get('/create', function () {
                return view('commercial.demandes-devis.create');
            })->name('commercial.demandes-devis.create');
            Route::get('/{demandeDevis}', function ($demandeDevis) {
                return view('commercial.demandes-devis.show', compact('demandeDevis'));
            })->name('commercial.demandes-devis.show');
            Route::get('/{demandeDevis}/edit', function ($demandeDevis) {
                return view('commercial.demandes-devis.edit', compact('demandeDevis'));
            })->name('commercial.demandes-devis.edit');
        });

        // Routes pour la gestion des factures (commerciaux)
        Route::resource('factures', FactureController::class);
        
        // Routes supplémentaires pour les factures
        Route::prefix('factures')->name('factures.')->group(function () {
            Route::get('{facture}/download', [FactureController::class, 'downloadPdf'])->name('download');
            Route::post('{facture}/send', [FactureController::class, 'sendByEmail'])->name('send');
            Route::patch('{facture}/mark-as-paid', [FactureController::class, 'markAsPaid'])->name('mark-as-paid');
            Route::delete('{facture}/cancel', [FactureController::class, 'cancel'])->name('cancel');
        });
        
        // Routes pour la gestion des devis (commerciaux)
        Route::prefix('devis')->group(function () {
            Route::get('/', [\App\Http\Controllers\Commercial\DevisController::class, 'index'])->name('commercial.devis.index');
            Route::get('/create', [\App\Http\Controllers\Commercial\DevisController::class, 'create'])->name('commercial.devis.create');
            Route::post('/', [\App\Http\Controllers\Commercial\DevisController::class, 'store'])->name('commercial.devis.store');
            Route::get('/{devis}', [\App\Http\Controllers\Commercial\DevisController::class, 'show'])->name('commercial.devis.show');
            Route::get('/{devis}/edit', [\App\Http\Controllers\Commercial\DevisController::class, 'edit'])->name('commercial.devis.edit');
            Route::put('/{devis}', [\App\Http\Controllers\Commercial\DevisController::class, 'update'])->name('commercial.devis.update');
            Route::delete('/{devis}', [\App\Http\Controllers\Commercial\DevisController::class, 'destroy'])->name('commercial.devis.destroy');
            Route::get('/{devis}/download', [\App\Http\Controllers\Commercial\DevisController::class, 'download'])->name('commercial.devis.download');
Route::get('/{devis}/preview', [\App\Http\Controllers\Commercial\DevisController::class, 'preview'])->name('commercial.devis.preview');

// Routes alternatives pour la génération PDF
Route::get('/{devis}/pdf-alternative', [\App\Http\Controllers\Commercial\DevisPdfController::class, 'generatePDF'])->name('commercial.devis.pdf.alternative');
Route::get('/{devis}/html', [\App\Http\Controllers\Commercial\DevisPdfController::class, 'showHTML'])->name('commercial.devis.html');
Route::get('/{devis}/download-html', [\App\Http\Controllers\Commercial\DevisPdfController::class, 'downloadHTML'])->name('commercial.devis.download.html');
        });

        // Routes pour la gestion des factures
        Route::prefix('factures')->group(function () {
            Route::get('/', function () {
                return view('commercial.factures.index');
            })->name('commercial.factures.index');
            Route::get('/create', function () {
                return view('commercial.factures.create');
            })->name('commercial.factures.create');
            Route::get('/{facture}', function ($facture) {
                return view('commercial.factures.show', compact('facture'));
            })->name('commercial.factures.show');
            Route::get('/{facture}/edit', function ($facture) {
                return view('commercial.factures.edit', compact('facture'));
            })->name('commercial.factures.edit');
            Route::get('/{facture}/download', function ($facture) {
                // Logique de téléchargement
                return response()->json(['message' => 'Téléchargement en cours']);
            })->name('commercial.factures.download');
        });

        // Routes pour la gestion des abonnements
        Route::prefix('abonnements')->group(function () {
            Route::get('/', function () {
                return view('commercial.abonnements.index');
            })->name('commercial.abonnements.index');
            Route::get('/create', function () {
                return view('commercial.abonnements.create');
            })->name('commercial.abonnements.create');
            Route::get('/{abonnement}', function ($abonnement) {
                return view('commercial.abonnements.show', compact('abonnement'));
            })->name('commercial.abonnements.show');
            Route::get('/{abonnement}/edit', function ($abonnement) {
                return view('commercial.abonnements.edit', compact('abonnement'));
            })->name('commercial.abonnements.edit');
        });
    });
});
