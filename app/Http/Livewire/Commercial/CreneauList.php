<?php

namespace App\Http\Livewire\Commercial;

use App\Models\CreneauDisponible;
use Livewire\Component;
use Carbon\Carbon;

class CreneauList extends Component
{
    public $date;
    public $creneaux;
    public $showEditModal = false;
    public $editingCreneau = null;
    
    // Propriétés du formulaire d'édition
    public $heure_debut;
    public $heure_fin;
    public $statut;
    public $notes;
    
    protected $listeners = [
        'creneauCreated' => 'refreshCreneaux',
        'creneauUpdated' => 'refreshCreneaux',
        'creneauDeleted' => 'refreshCreneaux',
    ];
    
    public function mount($date = null)
    {
        $this->date = $date ?? now()->format('Y-m-d');
        $this->refreshCreneaux();
    }
    
    public function refreshCreneaux()
    {
        $this->creneaux = CreneauDisponible::where('date', $this->date)
            ->orderBy('heure_debut')
            ->get();
    }
    
    public function openEditModal($creneauId)
    {
        $creneau = CreneauDisponible::find($creneauId);
        if ($creneau) {
            $this->editingCreneau = $creneau;
            $this->heure_debut = $creneau->heure_debut->format('H:i');
            $this->heure_fin = $creneau->heure_fin->format('H:i');
            $this->statut = $creneau->statut;
            $this->notes = $creneau->notes ?? '';
            $this->showEditModal = true;
        }
    }
    
    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingCreneau = null;
        $this->reset(['heure_debut', 'heure_fin', 'statut', 'notes']);
    }
    
    public function updateCreneau()
    {
        $this->validate([
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'statut' => 'required|in:disponible,indisponible',
            'notes' => 'nullable|string|max:500',
        ]);
        
        if ($this->editingCreneau) {
            $this->editingCreneau->update([
                'heure_debut' => $this->heure_debut,
                'heure_fin' => $this->heure_fin,
                'statut' => $this->statut,
                'notes' => $this->notes,
            ]);
            
            $this->closeEditModal();
            $this->emit('creneauUpdated');
            session()->flash('success', 'Créneau mis à jour avec succès.');
        }
    }
    
    public function deleteCreneau($creneauId)
    {
        $creneau = CreneauDisponible::find($creneauId);
        if ($creneau) {
            $creneau->delete();
            $this->emit('creneauDeleted');
            session()->flash('success', 'Créneau supprimé avec succès.');
        }
    }
    
    public function render()
    {
        return view('livewire.commercial.creneau-list');
    }
}

