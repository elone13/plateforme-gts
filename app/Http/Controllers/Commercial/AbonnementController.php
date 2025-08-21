<?php

namespace App\Http\Controllers\Commercial;

use App\Http\Controllers\Controller;
use App\Models\Abonnement;
use App\Models\Client;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AbonnementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abonnements = Abonnement::with(['client', 'service'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total' => Abonnement::count(),
            'actifs' => Abonnement::actifs()->count(),
            'expires' => Abonnement::expires()->count(),
            'a_renouveler' => Abonnement::aRenouveler()->count(),
        ];

        return view('commercial.abonnements.index', compact('abonnements', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('nom')->get();
        $services = Service::orderBy('nom')->get();
        
        return view('commercial.abonnements.create', compact('clients', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'service_id' => 'required|exists:services,id',
            'date_debut' => 'required|date|after_or_equal:today',
            'duree_mois' => 'required|integer|min:1|max:120',
            'prix_mensuel' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'renouvellement_automatique' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $dateDebut = Carbon::parse($request->date_debut);
            $dateFin = $dateDebut->copy()->addMonths($request->duree_mois);
            $prixTotal = $request->prix_mensuel * $request->duree_mois;

            $abonnement = Abonnement::create([
                'client_id' => $request->client_id,
                'service_id' => $request->service_id,
                'statut' => 'actif',
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'prix_mensuel' => $request->prix_mensuel,
                'prix_total' => $prixTotal,
                'duree_mois' => $request->duree_mois,
                'notes' => $request->notes,
                'renouvellement_automatique' => $request->has('renouvellement_automatique'),
            ]);

            DB::commit();

            return redirect()->route('commercial.abonnements.index')
                ->with('success', 'Abonnement créé avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Erreur lors de la création de l\'abonnement : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Abonnement $abonnement)
    {
        $abonnement->load(['client', 'service']);
        return view('commercial.abonnements.show', compact('abonnement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Abonnement $abonnement)
    {
        $clients = Client::orderBy('nom')->get();
        $services = Service::orderBy('nom')->get();
        
        return view('commercial.abonnements.edit', compact('abonnement', 'clients', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Abonnement $abonnement)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'service_id' => 'required|exists:services,id',
            'date_debut' => 'required|date',
            'duree_mois' => 'required|integer|min:1|max:120',
            'prix_mensuel' => 'required|numeric|min:0',
            'statut' => 'required|in:actif,suspendu,résilié,expiré',
            'notes' => 'nullable|string|max:1000',
            'renouvellement_automatique' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $dateDebut = Carbon::parse($request->date_debut);
            $dateFin = $dateDebut->copy()->addMonths($request->duree_mois);
            $prixTotal = $request->prix_mensuel * $request->duree_mois;

            $abonnement->update([
                'client_id' => $request->client_id,
                'service_id' => $request->service_id,
                'statut' => $request->statut,
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'prix_mensuel' => $request->prix_mensuel,
                'prix_total' => $prixTotal,
                'duree_mois' => $request->duree_mois,
                'notes' => $request->notes,
                'renouvellement_automatique' => $request->has('renouvellement_automatique'),
            ]);

            DB::commit();

            return redirect()->route('commercial.abonnements.index')
                ->with('success', 'Abonnement mis à jour avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Erreur lors de la mise à jour de l\'abonnement : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Abonnement $abonnement)
    {
        try {
            $abonnement->delete();
            return redirect()->route('commercial.abonnements.index')
                ->with('success', 'Abonnement supprimé avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression de l\'abonnement : ' . $e->getMessage());
        }
    }

    /**
     * Changer le statut d'un abonnement
     */
    public function changeStatut(Request $request, Abonnement $abonnement)
    {
        $request->validate([
            'statut' => 'required|in:actif,suspendu,résilié,expiré'
        ]);

        $abonnement->update(['statut' => $request->statut]);

        return back()->with('success', 'Statut de l\'abonnement mis à jour !');
    }

    /**
     * Renouveler un abonnement
     */
    public function renouveler(Abonnement $abonnement)
    {
        try {
            DB::beginTransaction();

            // Créer un nouvel abonnement
            $nouvelAbonnement = $abonnement->replicate();
            $nouvelAbonnement->date_debut = $abonnement->date_fin->addDay();
            $nouvelAbonnement->date_fin = $nouvelAbonnement->date_debut->copy()->addMonths($abonnement->duree_mois);
            $nouvelAbonnement->statut = 'actif';
            $nouvelAbonnement->save();

            // Marquer l'ancien comme renouvelé
            $abonnement->update([
                'statut' => 'renouvelé',
                'date_renouvellement' => now()
            ]);

            DB::commit();

            return back()->with('success', 'Abonnement renouvelé avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors du renouvellement : ' . $e->getMessage());
        }
    }
}
