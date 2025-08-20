<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Afficher le formulaire d'inscription client
     */
    public function showRegistrationForm()
    {
        return view('auth.client-register');
    }

    /**
     * Traiter l'inscription d'un nouveau client
     */
    public function register(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'nom_entreprise' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'adresse' => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        try {
            DB::beginTransaction();

            // Créer l'utilisateur
            $user = User::create([
                'name' => $request->nom_entreprise ?: $request->nom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'client',
            ]);

            // Créer le client
            $client = Client::create([
                'nom' => $request->nom,
                'nom_entreprise' => $request->nom_entreprise,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'adresse' => $request->adresse,
                'statut' => 'actif',
                'date_inscription' => now(),
                'user_id' => $user->id,
            ]);

            DB::commit();

            // Déclencher l'événement d'inscription
            event(new Registered($user));

            // Connecter automatiquement l'utilisateur
            Auth::login($user);

            return redirect()->route('client.profile')
                ->with('success', 'Inscription réussie ! Bienvenue sur votre espace client.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Erreur lors de l\'inscription client: ' . $e->getMessage());
            
            return back()->withErrors([
                'error' => 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.'
            ])->withInput();
        }
    }

    /**
     * Afficher la page de succès après inscription
     */
    public function success()
    {
        return view('auth.client-register-success');
    }
}
