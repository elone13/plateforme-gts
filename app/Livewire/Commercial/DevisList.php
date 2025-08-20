<?php

namespace App\Livewire\Commercial;

use App\Models\Devis;
use Livewire\Component;
use Livewire\WithPagination;

class DevisList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $clientFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $showFilters = false;
    
    // Tri
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'clientFilter' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingClientFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->clientFilter = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function getDevisQuery()
    {
        $query = Devis::with(['client', 'items'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('reference', 'like', '%' . $this->search . '%')
                      ->orWhere('conditions', 'like', '%' . $this->search . '%')
                      ->orWhereHas('client', function ($clientQuery) {
                          $clientQuery->where('nom_entreprise', 'like', '%' . $this->search . '%')
                                    ->orWhere('nom', 'like', '%' . $this->search . '%')
                                    ->orWhere('email', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('statut', $this->statusFilter);
            })
            ->when($this->clientFilter, function ($query) {
                $query->where('client_idclient', $this->clientFilter);
            })
            ->when($this->dateFrom, function ($query) {
                $query->where('date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->where('date', '<=', $this->dateTo);
            });

        return $query;
    }

    public function getDevisProperty()
    {
        return $this->getDevisQuery()
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);
    }

    public function getStatsProperty()
    {
        $query = $this->getDevisQuery();
        
        return [
            'total' => $query->count(),
            'en_attente' => $query->whereIn('statut', ['brouillon', 'envoye'])->count(),
            'acceptes' => $query->where('statut', 'accepte')->count(),
            'refuses' => $query->where('statut', 'refuse')->count(),
            'expires' => $query->where('statut', 'expire')->count(),
            'montant_total' => $query->sum('total_ttc'), // Utiliser total_ttc maintenant disponible
        ];
    }

    public function render()
    {
        return view('livewire.commercial.devis-list', [
            'devis' => $this->devis,
            'stats' => $this->stats,
        ]);
    }
}
