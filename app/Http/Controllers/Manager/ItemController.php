<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Service;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Show the form for creating a new item for a specific service.
     */
    public function create(Service $service)
    {
        return view('manager.items.create', compact('service'));
    }

    /**
     * Store a newly created item in storage.
     */
    public function store(Request $request, Service $service)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'quantite' => 'required|integer|min:1|max:9999',
            'description' => 'required|string|min:10|max:1000',
            'prix' => 'nullable|numeric|min:0|max:999999.99',
            'statut' => 'required|in:actif,inactif'
        ]);

        $service->items()->create([
            'nom' => $request->nom,
            'quantite' => $request->quantite,
            'description' => $request->description,
            'prix' => $request->prix,
            'statut' => $request->statut
        ]);

        return redirect()->route('manager.services.show', $service)
                        ->with('success', 'Élément ajouté avec succès !');
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit(Service $service, Item $item)
    {
        return view('manager.items.edit', compact('service', 'item'));
    }

    /**
     * Update the specified item in storage.
     */
    public function update(Request $request, Service $service, Item $item)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'quantite' => 'required|integer|min:1|max:9999',
            'description' => 'required|string|min:10|max:1000',
            'prix' => 'nullable|numeric|min:0|max:999999.99',
            'statut' => 'required|in:actif,inactif'
        ]);

        $item->update([
            'nom' => $request->nom,
            'quantite' => $request->quantite,
            'description' => $request->description,
            'prix' => $request->prix,
            'statut' => $request->statut
        ]);

        return redirect()->route('manager.services.show', $service)
                        ->with('success', 'Élément mis à jour avec succès !');
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy(Service $service, Item $item)
    {
        // Vérifier si l'élément est utilisé dans des devis
        if ($item->devis()->count() > 0) {
            return redirect()->route('manager.services.show', $service)
                            ->with('error', 'Impossible de supprimer cet élément car il est utilisé dans des devis.');
        }

        $item->delete();

        return redirect()->route('manager.services.show', $service)
                        ->with('success', 'Élément supprimé avec succès !');
    }
}
