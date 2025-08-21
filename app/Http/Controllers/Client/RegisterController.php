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
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientEmailVerification;

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
        // Vérifier d'abord si l'email existe déjà
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return back()->withErrors([
                'email' => 'Un compte avec cet email existe déjà. Veuillez vous connecter ou utiliser un autre email.'
            ])->withInput()->with('existing_account', true);
        }

        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nom_entreprise' => ['nullable', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'adresse' => ['nullable', 'string', 'max:500'],
            'secteur_activite' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        // Vérifier si l'email correspond à une demande de démo existante (optionnel)
        $demandeDemo = \App\Models\DemandeDemo::where('email', $request->email)->first();
        
        // Si une demande de démo existe, on peut l'associer au client
        // Si elle n'existe pas, ce n'est pas un problème

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
                'email' => $request->email,
                'nom_entreprise' => $request->nom_entreprise,
                'telephone' => $request->telephone,
                'adresse' => $request->adresse,
                'secteur_activite' => $request->secteur_activite,
                'source' => $request->source,
                'notes' => $request->notes,
                'statut' => 'actif',
                'date_inscription' => now(),
                'derniere_interaction' => now(),
                'user_id' => $user->id,
            ]);

            // Si une demande de démo existe, l'associer au client
            if ($demandeDemo) {
                $demandeDemo->update(['client_id' => $client->id]);
            }

            DB::commit();

            // Déclencher l'événement d'inscription
            event(new Registered($user));

            // Envoyer l'email de vérification
            $verificationUrl = url('/email/verify/' . $user->id . '/' . sha1($user->email));
            Mail::to($user->email)->send(new ClientEmailVerification($user, $verificationUrl));

            // Rediriger vers la page de confirmation d'email
            return redirect()->route('verification.notice')
                ->with('success', 'Inscription réussie ! Veuillez vérifier votre email pour accéder à votre espace client.');

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
