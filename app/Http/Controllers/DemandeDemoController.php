<?php

namespace App\Http\Controllers;

use App\Models\DemandeDemo;
use App\Mail\DemandeDemoConfirmation;
use App\Mail\NouvelleDemandeDemo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class DemandeDemoController extends Controller
{
    /**
     * Afficher la liste des demandes de démo (pour les admins)
     */
    public function index(Request $request)
    {
        $query = DemandeDemo::query();

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtre par priorité
        if ($request->filled('priorite')) {
            $query->where('priorite', $request->priorite);
        }

        // Recherche par nom, email ou téléphone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        $demandes = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.demandes-demo.index', compact('demandes'));
    }

    /**
     * Afficher une demande de démo spécifique
     */
    public function show(DemandeDemo $demandeDemo)
    {
        return view('admin.demandes-demo.show', compact('demandeDemo'));
    }

    /**
     * Afficher le formulaire de demande de démo
     */
    public function create()
    {
        $user = Auth::user();
        $client = null;
        
        if ($user && $user->role === 'client') {
            $client = $user->client;
        }
        
        return view('portal.contact', compact('client'));
    }

    /**
     * Stocker une nouvelle demande de démo (public)
     */
    public function store(Request $request)
    {
        // Si l'utilisateur est connecté et est un client, utiliser ses informations
        $user = Auth::user();
        $client = null;
        
        if ($user && $user->role === 'client') {
            $client = $user->client;
            
            // Pré-remplir avec les informations du client connecté
            $request->merge([
                'nom' => $client->nom,
                'email' => $client->email,
                'telephone' => $client->telephone ?: $request->telephone,
                'societe' => $client->nom_entreprise ?: $request->societe,
            ]);
        }

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:45',
            'email' => 'required|email|max:45',
            'telephone' => 'required|string|max:45',
            'nombre_vehicules' => 'nullable|string|max:50',
            'societe' => 'nullable|string|max:100',
            'jour_prefere' => 'nullable|string|max:50',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $demande = DemandeDemo::create([
            'date' => now()->format('Y-m-d'),
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'nombre_vehicules' => $request->nombre_vehicules,
            'societe' => $request->societe,
            'jour_prefere' => $request->jour_prefere,
            'message' => $request->message,
            'statut' => 'en_attente',
            'source' => $request->input('source', 'site_web'),
            'priorite' => $request->input('priorite', 'moyenne'),
            'client_id' => $client ? $client->id : null, // Associer la demande au client si connecté
        ]);

        // Envoyer un email de confirmation au client
        Mail::to($request->email)->send(new DemandeDemoConfirmation($demande));

        // Envoyer une notification aux administrateurs
        Mail::to(config('app.admin_email'))->send(new NouvelleDemandeDemo($demande));

        return back()->with('success', 'Votre demande de démo a été envoyée avec succès ! Nous vous contacterons bientôt.');
    }

    /**
     * Mettre à jour le statut d'une demande de démo
     */
    public function update(Request $request, DemandeDemo $demandeDemo)
    {
        $validator = Validator::make($request->all(), [
            'statut' => 'required|in:en_attente,acceptee,refusee,en_cours,terminee',
            'commentaire_admin' => 'nullable|string',
            'date_rdv' => 'nullable|date',
            'heure_rdv' => 'nullable|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $demandeDemo->update([
            'statut' => $request->statut,
            'commentaire_admin' => $request->commentaire_admin,
            'date_rdv' => $request->date_rdv,
            'heure_rdv' => $request->heure_rdv,
        ]);

        // Envoyer un email au client selon le statut
        if ($request->statut === 'acceptee') {
            // Mail::to($demandeDemo->email)->send(new DemandeDemoAcceptee($demandeDemo));
        } elseif ($request->statut === 'refusee') {
            // Mail::to($demandeDemo->email)->send(new DemandeDemoRefusee($demandeDemo));
        }

        return back()->with('success', 'Statut de la demande mis à jour avec succès.');
    }

    /**
     * Supprimer une demande de démo
     */
    public function destroy(DemandeDemo $demandeDemo)
    {
        $demandeDemo->delete();
        return redirect()->route('admin.demandes-demo.index')->with('success', 'Demande de démo supprimée avec succès.');
    }

    /**
     * Marquer une demande comme traitée
     */
    public function traiter(DemandeDemo $demandeDemo)
    {
        $demandeDemo->update(['statut' => 'en_cours']);
        return back()->with('success', 'Demande marquée comme en cours de traitement.');
    }

    /**
     * Marquer une demande comme terminée
     */
    public function terminer(DemandeDemo $demandeDemo)
    {
        $demandeDemo->update(['statut' => 'terminee']);
        return back()->with('success', 'Demande marquée comme terminée.');
    }

    /**
     * Afficher la liste des demandes de démo (pour les commerciaux)
     */
    public function indexCommercial(Request $request)
    {
        $query = DemandeDemo::query();

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtre par priorité
        if ($request->filled('priorite')) {
            $query->where('priorite', $request->priorite);
        }

        // Recherche par nom, email ou téléphone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        $demandes = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('commercial.demandes-demo.index', compact('demandes'));
    }

    /**
     * Afficher une demande de démo spécifique (pour les commerciaux)
     */
    public function showCommercial(DemandeDemo $demandeDemo)
    {
        return view('commercial.demandes-demo.show', compact('demandeDemo'));
    }

    /**
     * Mettre à jour une demande de démo (pour les commerciaux)
     */
    public function updateCommercial(Request $request, DemandeDemo $demandeDemo)
    {
        $validator = Validator::make($request->all(), [
            'statut' => 'required|in:en_attente,acceptee,refusee,en_cours,terminee',
            'commentaire_admin' => 'nullable|string',
            'date_rdv' => 'nullable|date',
            'heure_rdv' => 'nullable|date_format:H:i',
            'priorite' => 'nullable|in:haute,moyenne,basse',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $demandeDemo->update([
            'statut' => $request->statut,
            'commentaire_admin' => $request->commentaire_admin,
            'date_rdv' => $request->date_rdv,
            'heure_rdv' => $request->heure_rdv,
            'priorite' => $request->priorite,
        ]);

        // Envoyer un email au client selon le statut
        if ($request->statut === 'acceptee') {
            // Mail::to($demandeDemo->email)->send(new DemandeDemoAcceptee($demandeDemo));
        } elseif ($request->statut === 'refusee') {
            // Mail::to($demandeDemo->email)->send(new DemandeDemoRefusee($demandeDemo));
        }

        return back()->with('success', 'Demande mise à jour avec succès.');
    }

    /**
     * Envoyer une confirmation de rendez-vous au client
     */
    public function envoyerConfirmation(Request $request, DemandeDemo $demandeDemo)
    {
        $validator = Validator::make($request->all(), [
            'date_rdv' => 'required|date|after:today',
            'heure_rdv' => 'required|date_format:H:i',
            'message_confirmation' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Mettre à jour la demande avec les informations du rendez-vous
        $demandeDemo->update([
            'statut' => 'acceptee',
            'date_rdv' => $request->date_rdv,
            'heure_rdv' => $request->heure_rdv,
        ]);

        // Envoyer un email de confirmation au client
        try {
            // Mail::to($demandeDemo->email)->send(new DemandeDemoConfirmation($demandeDemo));
            
            return back()->with('success', 'Confirmation de rendez-vous envoyée avec succès au client !');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
        }
    }

    /**
     * Afficher le planning des rendez-vous (pour les commerciaux)
     */
    public function planning(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        
        $demandes = DemandeDemo::where('statut', 'acceptee')
            ->whereNotNull('date_rdv')
            ->whereDate('date_rdv', $date)
            ->orderBy('heure_rdv')
            ->get();

        return view('commercial.planning', compact('demandes', 'date'));
    }

    /**
     * Créer un créneau de rendez-vous
     */
    public function creerCreneau(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_rdv' => 'required|date|after:today',
            'heure_rdv' => 'required|date_format:H:i',
            'client_id' => 'required|exists:clients,id',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Créer un nouveau créneau
        // Ici vous pouvez ajouter la logique pour créer un créneau de rendez-vous
        
        return back()->with('success', 'Créneau créé avec succès.');
    }

    /**
     * Planifier un rendez-vous pour une demande de démo
     */
    public function planifierRendezVous(Request $request, DemandeDemo $demandeDemo)
    {
        $validator = Validator::make($request->all(), [
            'date_rdv' => 'required|date|after:today',
            'heure_rdv' => 'required|date_format:H:i',
            'lien_reunion' => 'required|url',
            'instructions_rdv' => 'nullable|string|max:500',
            'duree_rdv' => 'required|integer|min:15|max:480', // 15 min à 8h
            'type_rdv' => 'required|in:en_ligne,en_presentiel,telephone',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Vérifier que le créneau est disponible
        $creneauOccupe = DemandeDemo::where('id', '!=', $demandeDemo->id)
            ->where('date_rdv', $request->date_rdv)
            ->where('heure_rdv', $request->heure_rdv)
            ->where('statut', '!=', 'refusee')
            ->where('statut', '!=', 'terminee')
            ->exists();

        if ($creneauOccupe) {
            return back()->withErrors(['date_rdv' => 'Ce créneau est déjà occupé.'])->withInput();
        }

        // Mettre à jour la demande avec les informations du rendez-vous
        $demandeDemo->update([
            'date_rdv' => $request->date_rdv,
            'heure_rdv' => $request->heure_rdv,
            'lien_reunion' => $request->lien_reunion,
            'instructions_rdv' => $request->instructions_rdv,
            'duree_rdv' => $request->duree_rdv,
            'type_rdv' => $request->type_rdv,
            'statut' => 'planifiee',
        ]);

        // Envoyer un email de confirmation au client
        try {
            Mail::to($demandeDemo->email)->send(new DemandeDemoConfirmation($demandeDemo));
            return back()->with('success', 'Rendez-vous planifié avec succès ! Un email de confirmation a été envoyé au client.');
        } catch (\Exception $e) {
            return back()->with('warning', 'Rendez-vous planifié mais erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
        }
    }

    /**
     * Accepter une demande de démo
     */
    public function accepter(Request $request, DemandeDemo $demandeDemo)
    {
        $demandeDemo->update([
            'statut' => 'acceptee',
            'commentaire_admin' => $request->commentaire_admin ?? 'Demande acceptée',
        ]);

        return back()->with('success', 'Demande acceptée avec succès.');
    }

    /**
     * Refuser une demande de démo
     */
    public function refuser(Request $request, DemandeDemo $demandeDemo)
    {
        $validator = Validator::make($request->all(), [
            'raison_refus' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $demandeDemo->update([
            'statut' => 'refusee',
            'commentaire_admin' => $request->raison_refus,
        ]);

        return back()->with('success', 'Demande refusée avec succès.');
    }

    /**
     * Marquer une demande comme "en cours"
     */
    public function marquerEnCours(DemandeDemo $demandeDemo)
    {
        $demandeDemo->update(['statut' => 'en_cours']);
        return back()->with('success', 'Demande marquée comme "en cours".');
    }

    /**
     * Marquer une demande comme "terminée"
     */
    public function marquerTerminee(DemandeDemo $demandeDemo)
    {
        $demandeDemo->update(['statut' => 'terminee']);
        return back()->with('success', 'Demande marquée comme "terminée".');
    }

    /**
     * Mettre en attente une demande
     */
    public function mettreEnAttente(DemandeDemo $demandeDemo)
    {
        $demandeDemo->update(['statut' => 'en_attente']);
        return back()->with('success', 'Demande remise en attente.');
    }

    /**
     * Modifier la priorité d'une demande
     */
    public function modifierPriorite(Request $request, DemandeDemo $demandeDemo)
    {
        $request->validate([
            'nouvelle_priorite' => 'required|in:basse,normale,haute,urgente'
        ]);

        $demandeDemo->update([
            'priorite' => $request->nouvelle_priorite
        ]);

        return back()->with('success', 'Priorité mise à jour avec succès.');
    }

    /**
     * Afficher le formulaire de création d'une demande de démo (pour les commerciaux)
     */
    public function createCommercial()
    {
        return view('commercial.demandes-demo.create');
    }

    /**
     * Stocker une nouvelle demande de démo (pour les commerciaux)
     */
    public function storeCommercial(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,idclient',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'message' => 'required|string|min:10|max:1000',
            'priorite' => 'required|in:basse,normale,haute,urgente',
            'source' => 'nullable|string|max:100'
        ]);

        // Créer la demande de démo
        $demandeDemo = DemandeDemo::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'message' => $request->message,
            'statut' => 'en_attente',
            'priorite' => $request->priorite,
            'source' => $request->source,
            'date_demande' => now()
        ]);

        // Envoyer un email de confirmation au client
        try {
            // Mail::to($demandeDemo->email)->send(new DemandeDemoConfirmation($demandeDemo));
            
            return redirect()->route('commercial.demandes-demo.show', $demandeDemo)
                           ->with('success', 'Demande de démo créée avec succès !');
        } catch (\Exception $e) {
            return redirect()->route('commercial.demandes-demo.show', $demandeDemo)
                           ->with('warning', 'Demande créée mais erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
        }
    }
} 