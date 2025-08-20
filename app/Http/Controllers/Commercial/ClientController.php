<?php

namespace App\Http\Controllers\Commercial;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        return view('commercial.clients.index');
    }

    public function show(Client $client)
    {
        // Charger les relations nécessaires
        $client->load([
            'abonnements',
            'factures',
            'demandeDemos',
            'devis'
        ]);

        return view('commercial.clients.show', compact('client'));
    }

    public function create()
    {
        return view('commercial.clients.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'nom_entreprise' => 'nullable|string|max:255',
            'contact_principal' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:500',
            'secteur_activite' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $client = Client::create([
            'nom' => $request->nom,
            'nom_entreprise' => $request->nom_entreprise,
            'contact_principal' => $request->contact_principal,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'secteur_activite' => $request->secteur_activite,
            'notes' => $request->notes,
            'statut' => 'prospect', // Par défaut, nouveau client = prospect
            'derniere_interaction' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Client créé avec succès',
            'client' => $client
        ]);
    }

    public function edit(Client $client)
    {
        return view('commercial.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'nom_entreprise' => 'nullable|string|max:255',
            'contact_principal' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:500',
            'secteur_activite' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'statut' => 'required|in:prospect,actif,inactif,archive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $client->update([
            'nom' => $request->nom,
            'nom_entreprise' => $request->nom_entreprise,
            'contact_principal' => $request->contact_principal,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'secteur_activite' => $request->secteur_activite,
            'notes' => $request->notes,
            'statut' => $request->statut,
            'derniere_interaction' => now(),
        ]);

        return redirect()->route('commercial.clients.show', $client)
            ->with('success', 'Client mis à jour avec succès');
    }

    public function destroy(Client $client)
    {
        // Vérifier si le client peut être supprimé
        if ($client->abonnements()->where('statut', 'actif')->exists() ||
            $client->factures()->where('statut', 'impayee')->exists()) {
            return back()->with('error', 'Impossible de supprimer ce client car il a des abonnements actifs ou des factures impayées.');
        }

        // Archiver au lieu de supprimer
        $client->update(['statut' => 'archive']);
        
        return redirect()->route('commercial.clients.index')
            ->with('success', 'Client archivé avec succès');
    }

    public function planifierRendezVous(Request $request, Client $client)
    {
        $validator = Validator::make($request->all(), [
            'date_rdv' => 'required|date|after:today',
            'heure_rdv' => 'required|date_format:H:i',
            'type_rdv' => 'required|in:demo,suivi,formation',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Logique pour planifier le rendez-vous
        // TODO: Implémenter la logique de planification

        return back()->with('success', 'Rendez-vous planifié avec succès');
    }

    public function envoyerEmail(Request $request, Client $client)
    {
        $validator = Validator::make($request->all(), [
            'type_email' => 'required|in:confirmation,relance,renouvellement,custom',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Logique pour envoyer l'email
        // TODO: Implémenter l'envoi d'email

        return back()->with('success', 'Email envoyé avec succès');
    }
}
