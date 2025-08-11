<?php

namespace App\Livewire\Commercial;

use App\Models\DemandeDemo;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class DemandeDemoList extends Component
{
    use WithPagination;

    #[Url(as: 'statut')]
    public $filterStatut = '';
    
    #[Url(as: 'priorite')]
    public $filterPriorite = '';
    
    #[Url(as: 'recherche')]
    public $recherche = '';

    public function updatingRecherche()
    {
        $this->resetPage();
    }

    public function updatingFilterStatut()
    {
        $this->resetPage();
    }

    public function updatingFilterPriorite()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['filterStatut', 'filterPriorite', 'recherche']);
        $this->resetPage();
    }

    public function render()
    {
        $query = DemandeDemo::query()
            ->orderBy('created_at', 'desc');

        // Filtres
        if ($this->filterStatut) {
            $query->where('statut', $this->filterStatut);
        }

        if ($this->filterPriorite) {
            $query->where('priorite', $this->filterPriorite);
        }

        if ($this->recherche) {
            $query->where(function($q) {
                $q->where('nom', 'like', '%' . $this->recherche . '%')
                  ->orWhere('email', 'like', '%' . $this->recherche . '%')
                  ->orWhere('message', 'like', '%' . $this->recherche . '%');
            });
        }

        $demandes = $query->paginate(5);

        return view('livewire.commercial.demande-demo-list', [
            'demandes' => $demandes
        ]);
    }
}
