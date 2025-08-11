<?php

namespace App\Livewire\Commercial;

use App\Models\DemandeDemo;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemandeDemoConfirmation;

class DemandeDemoManager extends Component
{
    use WithPagination;

    public DemandeDemo $demandeDemo;
    public $showModal = false;
    public $modalType = '';
    public $commentaire_admin = '';
    public $raison_refus = '';
    public $nouvelle_priorite = '';

    // Propriétés pour les alertes
    public $showAlert = false;
    public $alertMessage = '';
    public $alertType = 'success'; // success, error, warning

    // Champs pour la planification de RDV
    #[Rule('required|date|after:today')]
    public $date_rdv = '';
    
    #[Rule('required|date_format:H:i')]
    public $heure_rdv = '';
    
    #[Rule('required|url')]
    public $lien_reunion = '';
    
    #[Rule('nullable|string|max:500')]
    public $instructions_rdv = '';
    
    #[Rule('required|integer|min:15|max:480')]
    public $duree_rdv = 60;
    
    #[Rule('required|in:en_ligne,en_presentiel,telephone')]
    public $type_rdv = 'en_ligne';

    public function mount(DemandeDemo $demandeDemo = null)
    {
        if ($demandeDemo && $demandeDemo->exists) {
            $this->demandeDemo = $demandeDemo;
        }
    }

    public function openModal($type)
    {
        $this->modalType = $type;
        $this->showModal = true;
        $this->resetForm();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->modalType = '';
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->commentaire_admin = '';
        $this->raison_refus = '';
        $this->nouvelle_priorite = '';
        $this->date_rdv = '';
        $this->heure_rdv = '';
        $this->lien_reunion = '';
        $this->instructions_rdv = '';
        $this->duree_rdv = 60;
        $this->type_rdv = 'en_ligne';
    }

    public function showAlert($message, $type = 'success')
    {
        $this->alertMessage = $message;
        $this->alertType = $type;
        $this->showAlert = true;
        
        // Auto-disparition après 3 secondes
        $this->dispatch('alert-auto-hide');
    }

    public function accepter()
    {
        \Log::info('Méthode accepter appelée pour la demande #' . $this->demandeDemo->id);
        
        $this->demandeDemo->update([
            'statut' => 'acceptee',
            'commentaire_admin' => $this->commentaire_admin,
        ]);
        
        \Log::info('Statut mis à jour vers acceptee');
        
        $this->closeModal();
        $this->showAlert('Demande acceptée avec succès !', 'success');
        
        \Log::info('Modal fermé et alerte affichée');
    }

    public function refuser()
    {
        $this->demandeDemo->update([
            'statut' => 'refusee',
            'raison_refus' => $this->raison_refus,
        ]);
        
        $this->closeModal();
        $this->showAlert('Demande refusée avec succès !', 'success');
    }

    public function planifierRendezVous()
    {
        // Validation manuelle des champs requis
        if (empty($this->date_rdv)) {
            $this->addError('date_rdv', 'La date est requise.');
            return;
        }
        
        if (empty($this->heure_rdv)) {
            $this->addError('heure_rdv', 'L\'heure est requise.');
            return;
        }
        
        if (empty($this->lien_reunion)) {
            $this->addError('lien_reunion', 'Le lien de réunion est requis.');
            return;
        }
        
        if (empty($this->duree_rdv)) {
            $this->addError('duree_rdv', 'La durée est requise.');
            return;
        }
        
        if (empty($this->type_rdv)) {
            $this->addError('type_rdv', 'Le type de rendez-vous est requis.');
            return;
        }
        
        // Vérifier si le créneau est disponible
        $creneauOccupe = DemandeDemo::where('id', '!=', $this->demandeDemo->id)
            ->where('date_rdv', $this->date_rdv)
            ->where('heure_rdv', $this->heure_rdv)
            ->where('statut', '!=', 'refusee')
            ->where('statut', '!=', 'terminee')
            ->exists();
            
        if ($creneauOccupe) {
            $this->addError('date_rdv', 'Ce créneau est déjà occupé.');
            return;
        }
        
        $this->demandeDemo->update([
            'date_rdv' => $this->date_rdv,
            'heure_rdv' => $this->heure_rdv,
            'lien_reunion' => $this->lien_reunion,
            'instructions_rdv' => $this->instructions_rdv,
            'duree_rdv' => $this->duree_rdv,
            'type_rdv' => $this->type_rdv,
            'statut' => 'planifiee',
        ]);
        
        try {
            Mail::to($this->demandeDemo->email)->send(new DemandeDemoConfirmation($this->demandeDemo));
            $this->closeModal();
            $this->showAlert('Rendez-vous planifié et email envoyé avec succès !', 'success');
        } catch (\Exception $e) {
            $this->closeModal();
            $this->showAlert('Rendez-vous planifié mais erreur lors de l\'envoi de l\'email : ' . $e->getMessage(), 'warning');
        }
    }

    public function marquerEnCours()
    {
        $this->demandeDemo->update(['statut' => 'en_cours']);
        $this->closeModal();
        $this->showAlert('Démonstration marquée comme commencée !', 'success');
    }

    public function marquerTerminee()
    {
        $this->demandeDemo->update(['statut' => 'terminee']);
        $this->closeModal();
        $this->showAlert('Démonstration marquée comme terminée !', 'success');
    }

    public function mettreEnAttente()
    {
        $this->demandeDemo->update(['statut' => 'en_attente']);
        $this->closeModal();
        $this->showAlert('Demande remise en attente !', 'success');
    }

    public function modifierPriorite()
    {
        if (empty($this->nouvelle_priorite)) {
            $this->addError('nouvelle_priorite', 'Veuillez sélectionner une priorité.');
            return;
        }
        
        $this->demandeDemo->update(['priorite' => $this->nouvelle_priorite]);
        $this->closeModal();
        $this->showAlert('Priorité modifiée avec succès !', 'success');
    }

    public function render()
    {
        return view('livewire.commercial.demande-demo-manager');
    }
}
