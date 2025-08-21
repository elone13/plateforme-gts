<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Devis;
use App\Models\DemandeDemo;

class ProfileController extends Controller
{
    /**
     * Afficher le profil du client avec ses demandes de démo
     */
    public function show()
    {
        $user = Auth::user();
        $client = Client::where('user_id', $user->id)->first();
        
        // Si le client n'existe pas, le créer automatiquement
        if (!$client) {
            $client = Client::create([
                'user_id' => $user->id,
                'nom' => $user->name,
                'email' => $user->email,
                'date_inscription' => now(),
            ]);
        }
        
        // Récupérer les demandes de démo associées à l'email de l'utilisateur
        $demandesDemo = DemandeDemo::where('email', $user->email)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('portal.client-profile', compact('client', 'demandesDemo'));
    }

    /**
     * Mettre à jour le profil du client
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $client = Client::where('user_id', $user->id)->first();
        
        // Si le client n'existe pas, le créer automatiquement
        if (!$client) {
            $client = Client::create([
                'user_id' => $user->id,
                'nom' => $user->name,
                'email' => $user->email,
                'date_inscription' => now(),
            ]);
        }
        
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'nom_entreprise' => ['nullable', 'string', 'max:255'],

            'telephone' => ['nullable', 'string', 'max:20'],
            'adresse' => ['nullable', 'string', 'max:500'],
            'secteur_activite' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);
        
        try {
            $client->update([
                'nom' => $request->nom,
                'nom_entreprise' => $request->nom_entreprise,
    
                'telephone' => $request->telephone,
                'adresse' => $request->adresse,
                'secteur_activite' => $request->secteur_activite,
                'notes' => $request->notes,
            ]);
            
            return redirect()->route('client.profile')
                ->with('success', 'Profil mis à jour avec succès !');
                
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour du profil client: ' . $e->getMessage());
            
            return back()->withErrors([
                'error' => 'Une erreur est survenue lors de la mise à jour. Veuillez réessayer.'
            ])->withInput();
        }
    }

    /**
     * Afficher un devis spécifique
     */
    public function showDevis(Devis $devis)
    {
        $user = Auth::user();
        $client = Client::where('user_id', $user->id)->first();
        
        if (!$client || $devis->client_idclient !== $client->idclient) {
            abort(403, 'Accès non autorisé.');
        }
        
        return view('portal.client-devis', compact('devis'));
    }

    /**
     * Télécharger un devis en PDF
     */
    public function downloadDevis(Devis $devis)
    {
        $user = Auth::user();
        $client = Client::where('user_id', $user->id)->first();
        
        if (!$client || $devis->client_idclient !== $client->idclient) {
            abort(403, 'Accès non autorisé.');
        }
        
        // Utiliser le contrôleur commercial pour générer le PDF
        $devisController = new \App\Http\Controllers\Commercial\DevisController();
        return $devisController->generatePDF($devis);
    }

    /**
     * Afficher l'aperçu d'un devis
     */
    public function previewDevis(Devis $devis)
    {
        $user = Auth::user();
        $client = Client::where('user_id', $user->id)->first();
        
        if (!$client || $devis->client_idclient !== $client->idclient) {
            abort(403, 'Accès non autorisé.');
        }
        
        return view('commercial.devis.preview', compact('devis'));
    }

    /**
     * Valider un devis
     */
    public function validateDevis(Devis $devis)
    {
        $user = Auth::user();
        $client = Client::where('user_id', $user->id)->first();
        
        if (!$client || $devis->client_idclient !== $client->idclient) {
            abort(403, 'Accès non autorisé.');
        }
        
        // Vérifier que le devis est en attente
        if ($devis->statut !== 'en_attente') {
            return back()->with('error', 'Ce devis ne peut pas être validé. Seuls les devis en attente peuvent être validés.');
        }
        
        try {
            // Mettre à jour le statut du devis
            $devis->update([
                'statut' => 'valide',
                'date_validation' => now()
            ]);
            
            // Log de la validation
            \Log::info("Devis {$devis->reference} validé par le client {$client->nom} (ID: {$client->idclient})");
            
            return back()->with('success', 'Devis validé avec succès ! Le statut est maintenant "Validé".');
            
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la validation du devis: ' . $e->getMessage());
            
            return back()->with('error', 'Une erreur est survenue lors de la validation. Veuillez réessayer.');
        }
    }
}
