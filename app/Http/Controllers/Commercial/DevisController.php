<?php

namespace App\Http\Controllers\Commercial;

use App\Http\Controllers\Controller;
use App\Models\Devis;
use App\Models\Client;
use App\Models\Service;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevisController extends Controller
{
    public function index()
    {
        $devis = Devis::with(['client', 'items'])->latest()->paginate(10);

        $totalDevis = Devis::count();
        $enAttente = Devis::whereIn('statut', ['brouillon', 'envoye'])->count();
        $acceptes = Devis::where('statut', 'accepte')->count();
        $montantTotal = (float) Devis::sum('montant_total');

        return view('commercial.devis.index', compact('devis', 'totalDevis', 'enAttente', 'acceptes', 'montantTotal'));
    }

    public function create()
    {
        $clients = Client::all();
        $services = Service::with('items')->get();
        return view('commercial.devis.create', compact('clients', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,idclient',
            'date_validite' => 'required|date|after:today',
            'description' => 'required|string|max:1000',
            'lignes' => 'required|array|min:1',
            'lignes.*.service_id' => 'required|exists:services,id',
            'lignes.*.item_id' => 'nullable|exists:items,iditem',
            'lignes.*.description' => 'required|string|max:255',
            'lignes.*.quantite' => 'required|integer|min:1',
            'lignes.*.prix_unitaire' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Créer le devis
            $devis = Devis::create([
                'reference' => Devis::generateReference(),
                'date' => now(),
                'client_idclient' => $request->client_id,
                'statut' => 'brouillon',
                'date_validite' => $request->date_validite,
                'conditions' => $request->description,
                'montant_total' => 0, // Sera calculé après
            ]);

            $montantTotal = 0;

            // Créer les items du devis
            foreach ($request->lignes as $ligne) {
                $totalLigne = $ligne['quantite'] * $ligne['prix_unitaire'];
                $montantTotal += $totalLigne;

                Item::create([
                    'nom' => $ligne['description'],
                    'quantite' => $ligne['quantite'],
                    'prix' => $ligne['prix_unitaire'],
                    'devis_id' => $devis->id,
                    'service_id' => $ligne['service_id'],
                    'description' => $ligne['description'],
                    'statut' => 'actif',
                    'avancement' => 0,
                ]);
            }

            // Mettre à jour le montant total du devis
            $devis->update(['montant_total' => $montantTotal]);

            DB::commit();

            return redirect()->route('commercial.devis.show', $devis)
                           ->with('success', 'Devis créé avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors de la création du devis : ' . $e->getMessage()]);
        }
    }

    public function show(Devis $devis)
    {
        $devis->load(['client', 'items.service']);
        return view('commercial.devis.show', compact('devis'));
    }

    public function edit(Devis $devis)
    {
        $clients = Client::all();
        $services = Service::with('items')->get();
        $devis->load(['client', 'items']);
        return view('commercial.devis.edit', compact('devis', 'clients', 'services'));
    }

    public function update(Request $request, Devis $devis)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,idclient',
            'date_validite' => 'required|date',
            'description' => 'required|string|max:1000',
            'lignes' => 'required|array|min:1',
            'lignes.*.service_id' => 'required|exists:services,id',
            'lignes.*.item_id' => 'nullable|exists:items,iditem',
            'lignes.*.description' => 'required|string|max:255',
            'lignes.*.quantite' => 'required|integer|min:1',
            'lignes.*.prix_unitaire' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Mettre à jour le devis
            $devis->update([
                'client_idclient' => $request->client_id,
                'date_validite' => $request->date_validite,
                'conditions' => $request->description,
            ]);

            // Supprimer les anciens items
            $devis->items()->delete();

            $montantTotal = 0;

            // Créer les nouveaux items
            foreach ($request->lignes as $ligne) {
                $totalLigne = $ligne['quantite'] * $ligne['prix_unitaire'];
                $montantTotal += $totalLigne;

                Item::create([
                    'nom' => $ligne['description'],
                    'quantite' => $ligne['quantite'],
                    'prix' => $ligne['prix_unitaire'],
                    'devis_id' => $devis->id,
                    'service_id' => $ligne['service_id'],
                    'description' => $ligne['description'],
                    'statut' => 'actif',
                    'avancement' => 0,
                ]);
            }

            // Mettre à jour le montant total
            $devis->update(['montant_total' => $montantTotal]);

            DB::commit();

            return redirect()->route('commercial.devis.show', $devis)
                           ->with('success', 'Devis mis à jour avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors de la mise à jour du devis : ' . $e->getMessage()]);
        }
    }

    public function destroy(Devis $devis)
    {
        try {
            $devis->items()->delete();
            $devis->delete();
            return redirect()->route('commercial.devis.index')
                           ->with('success', 'Devis supprimé avec succès !');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de la suppression du devis : ' . $e->getMessage()]);
        }
    }

    public function getServiceItems(Request $request)
    {
        $serviceId = $request->service_id;
        $items = Item::where('service_id', $serviceId)->get();
        
        return response()->json($items);
    }
}
