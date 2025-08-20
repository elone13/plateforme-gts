<?php

namespace App\Livewire\Commercial;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class ClientList extends Component
{
    use WithPagination;

    #[Url(as: 'recherche')]
    public $recherche = '';

    #[Url(as: 'statut')]
    public $filterStatut = '';

    #[Url(as: 'secteur')]
    public $filterSecteur = '';

    public function updatingRecherche()
    {
        $this->resetPage();
    }

    public function updatingFilterStatut()
    {
        $this->resetPage();
    }

    public function updatingFilterSecteur()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->recherche = '';
        $this->filterStatut = '';
        $this->filterSecteur = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Client::query()
            ->with(['devis', 'demandeDemos'])
            ->orderBy('created_at', 'desc');

        // Filtre par recherche
        if (!empty($this->recherche)) {
            $query->where(function($q) {
                $q->where('nom', 'like', '%' . $this->recherche . '%')
                  ->orWhere('nom_entreprise', 'like', '%' . $this->recherche . '%')
                  ->orWhere('contact_principal', 'like', '%' . $this->recherche . '%')
                  ->orWhere('email', 'like', '%' . $this->recherche . '%')
                  ->orWhere('secteur_activite', 'like', '%' . $this->recherche . '%');
            });
        }

        // Filtre par statut
        if (!empty($this->filterStatut)) {
            $query->where('statut', $this->filterStatut);
        }

        // Filtre par secteur
        if (!empty($this->filterSecteur)) {
            $query->where('secteur_activite', 'like', '%' . $this->filterSecteur . '%');
        }

        $clients = $query->paginate(10);

        // Récupérer les secteurs uniques pour le filtre
        $secteurs = Client::distinct()->pluck('secteur_activite')->filter()->values();

        return view('livewire.commercial.client-list', [
            'clients' => $clients,
            'secteurs' => $secteurs
        ]);
    }
}
