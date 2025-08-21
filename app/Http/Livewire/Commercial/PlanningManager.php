<?php

namespace App\Http\Livewire\Commercial;

use App\Models\CreneauDisponible;
use App\Models\DemandeDemo;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PlanningManager extends Component
{
    public $showCreateModal = false;
    public $showEditModal = false;
    public $editingCreneau = null;
    
    // Propriétés du formulaire
    public $date;
    public $heure_debut;
    public $heure_fin;
    public $statut = 'disponible';
    public $notes = '';
    
    // Validation
    protected $rules = [
        'date' => 'required|date|after_or_equal:today',
        'heure_debut' => 'required|date_format:H:i',
        'heure_fin' => 'required|date_format:H:i',
        'statut' => 'required|in:disponible,indisponible',
        'notes' => 'nullable|string|max:500',
    ];
    
    protected $messages = [
        'date.after_or_equal' => 'La date doit être aujourd\'hui ou une date future.',
        'heure_fin.after' => 'L\'heure de fin doit être postérieure à l\'heure de début.',
    ];
    
    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $this->heure_debut = '09:00';
        $this->heure_fin = '10:00';
    }
    
    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }
    
    public function openEditModal($creneauId)
    {
        $creneau = CreneauDisponible::find($creneauId);
        if ($creneau) {
            $this->editingCreneau = $creneau;
            $this->date = $creneau->date->format('Y-m-d');
            $this->heure_debut = $creneau->heure_debut->format('H:i');
            $this->heure_fin = $creneau->heure_fin->format('H:i');
            $this->statut = $creneau->statut;
            $this->notes = $creneau->notes ?? '';
            $this->showEditModal = true;
        }
    }
    
    public function closeModal()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->editingCreneau = null;
        $this->resetForm();
    }
    
    public function resetForm()
    {
        $this->date = now()->format('Y-m-d');
        $this->heure_debut = '09:00';
        $this->heure_fin = '10:00';
        $this->statut = 'disponible';
        $this->notes = '';
        $this->resetValidation();
    }
    
    public function updatedHeureDebut()
    {
        // Ajuster automatiquement l'heure de fin si elle est antérieure
        if ($this->heure_debut && $this->heure_fin && $this->heure_debut >= $this->heure_fin) {
            $debut = Carbon::parse($this->heure_debut);
            $this->heure_fin = $debut->addHour()->format('H:i');
        }
    }
    
    public function store()
    {
        $this->validate();
        
        $commercial = Auth::user()->administrateur;
        
        // Vérifier les conflits
        $conflict = $this->checkConflicts($commercial->idadministrateur);
        if ($conflict) {
            $this->addError('conflict', $conflict);
            return;
        }
        
        CreneauDisponible::create([
            'commercial_id' => $commercial->idadministrateur,
            'date' => $this->date,
            'heure_debut' => $this->heure_debut,
            'heure_fin' => $this->heure_fin,
            'statut' => $this->statut,
            'notes' => $this->notes,
        ]);
        
        $this->closeModal();
        $this->emit('creneauCreated');
        session()->flash('success', 'Créneau créé avec succès.');
    }
    
    public function update()
    {
        $this->validate();
        
        if (!$this->editingCreneau) {
            return;
        }
        
        $commercial = Auth::user()->administrateur;
        
        // Vérifier les conflits (exclure le créneau en cours d'édition)
        $conflict = $this->checkConflicts($commercial->idadministrateur, $this->editingCreneau->id);
        if ($conflict) {
            $this->addError('conflict', $conflict);
            return;
        }
        
        $this->editingCreneau->update([
            'date' => $this->date,
            'heure_debut' => $this->heure_debut,
            'heure_fin' => $this->heure_fin,
            'statut' => $this->statut,
            'notes' => $this->notes,
        ]);
        
        $this->closeModal();
        $this->emit('creneauUpdated');
        session()->flash('success', 'Créneau mis à jour avec succès.');
    }
    
    public function delete($creneauId)
    {
        $creneau = CreneauDisponible::find($creneauId);
        if ($creneau) {
            $creneau->delete();
            $this->emit('creneauDeleted');
            session()->flash('success', 'Créneau supprimé avec succès.');
        }
    }
    
    private function checkConflicts($commercialId, $excludeId = null)
    {
        // Vérifier les conflits avec les créneaux existants
        $query = CreneauDisponible::where('commercial_id', $commercialId)
            ->where('date', $this->date);
            
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        // Logique de vérification des chevauchements
        $conflict = $query->where(function($q) {
            // Un créneau chevauche si :
            // - L'heure de début du nouveau créneau est avant la fin du créneau existant ET
            // - L'heure de fin du nouveau créneau est après le début du créneau existant
            $q->where(function($subQ) {
                $subQ->where('heure_debut', '<', $this->heure_fin)
                      ->where('heure_fin', '>', $this->heure_debut);
            });
        })->first();
        
        if ($conflict) {
            return "Ce créneau chevauche un créneau existant ({$conflict->heure_debut->format('H:i')} - {$conflict->heure_fin->format('H:i')}).";
        }
        
        // Vérifier les conflits avec les rendez-vous
        $rdvConflict = DemandeDemo::where('statut', 'planifiee')
            ->where('commercial_id', $commercialId)
            ->where('date_rdv', $this->date)
            ->where(function($q) {
                // Un créneau chevauche un rendez-vous si :
                // - L'heure de début du créneau est avant la fin du rendez-vous ET
                // - L'heure de fin du créneau est après le début du rendez-vous
                $q->where('heure_rdv', '<', $this->heure_fin)
                  ->whereRaw('DATE_ADD(heure_rdv, INTERVAL duree_rdv MINUTE) > ?', [$this->heure_debut]);
            })->first();
        
        if ($rdvConflict) {
            return "Ce créneau chevauche un rendez-vous existant avec {$rdvConflict->nom} à {$rdvConflict->heure_rdv->format('H:i')}.";
        }
        
        return null;
    }
    
    public function render()
    {
        return view('livewire.commercial.planning-manager');
    }
}
