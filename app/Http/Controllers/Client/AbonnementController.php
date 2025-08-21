<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Abonnement;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbonnementController extends Controller
{
    /**
     * Afficher la liste des abonnements du client connecté
     */
    public function index()
    {
        $user = Auth::user();
        
        // Récupérer le client associé à l'utilisateur connecté
        $client = Client::where('email', $user->email)->first();
        
        if (!$client) {
            return redirect()->route('client.profile')->with('error', 'Aucun profil client trouvé.');
        }
        
        // Récupérer les abonnements du client
        $abonnements = Abonnement::where('client_id', $client->idclient)
            ->with(['service'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Statistiques
        $stats = [
            'total' => $abonnements->total(),
            'actifs' => Abonnement::where('client_id', $client->idclient)->where('statut', 'actif')->count(),
            'expires' => Abonnement::where('client_id', $client->idclient)->where('statut', 'expiré')->count(),
            'resilies' => Abonnement::where('client_id', $client->idclient)->where('statut', 'résilié')->count(),
        ];
        
        return view('portal.client-abonnements', compact('abonnements', 'stats', 'client'));
    }
    
    /**
     * Afficher les détails d'un abonnement spécifique
     */
    public function show(Abonnement $abonnement)
    {
        $user = Auth::user();
        $client = Client::where('email', $user->email)->first();
        
        if (!$client || $abonnement->client_id != $client->idclient) {
            abort(403, 'Accès non autorisé à cet abonnement.');
        }
        
        $abonnement->load(['service', 'client']);
        
        return view('portal.client-abonnement-show', compact('abonnement', 'client'));
    }
}

