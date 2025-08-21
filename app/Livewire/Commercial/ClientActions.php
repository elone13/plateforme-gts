<?php

namespace App\Livewire\Commercial;

use App\Models\Client;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class ClientActions extends Component
{
    public Client $client;
    public $showModal = false;
    public $modalType = '';
    
    // Propriétés pour planifier RDV
    public $date_rdv = '';
    public $heure_rdv = '';
    public $type_rdv = '';
    public $notes_rdv = '';
    
    // Propriétés pour envoyer email
    public $type_email = '';
    public $sujet_email = '';
    public $message_email = '';
    
    // Propriétés pour modifier statut
    public $nouveau_statut = '';
    
    protected $rules = [
        'date_rdv' => 'required|date|after:today',
        'heure_rdv' => 'required',
        'type_rdv' => 'required|in:demo,suivi,formation,commercial',
        'notes_rdv' => 'nullable|string|max:500',
        'type_email' => 'required|in:confirmation,relance,renouvellement,information',
        'sujet_email' => 'required|string|max:200',
        'message_email' => 'required|string|max:1000',
        'nouveau_statut' => 'required|in:prospect,actif,inactif,archive'
    ];

    public function mount(Client $client)
    {
        $this->client = $client;
        $this->nouveau_statut = $client->statut;
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
        $this->date_rdv = '';
        $this->heure_rdv = '';
        $this->type_rdv = '';
        $this->notes_rdv = '';
        $this->type_email = '';
        $this->sujet_email = '';
        $this->message_email = '';
    }

    public function planifierRendezVous()
    {
        $this->validate([
            'date_rdv' => 'required|date|after:today',
            'heure_rdv' => 'required',
            'type_rdv' => 'required|in:demo,suivi,formation,commercial',
            'notes_rdv' => 'nullable|string|max:500'
        ]);

        // Générer un lien de réunion automatique
        $lien_reunion = $this->genererLienReunion();
        
        // Créer une demande de démo si c'est une démo
        if ($this->type_rdv === 'demo') {
            $this->client->demandeDemos()->create([
                'nom' => $this->client->nom,
                'email' => $this->client->email,
                'telephone' => $this->client->telephone,
                'message' => $this->notes_rdv,
                'statut' => 'planifiee',
                'priorite' => 'normale',
                'date_rdv' => $this->date_rdv . ' ' . $this->heure_rdv,
                'lien_reunion' => $lien_reunion,
                'instructions_rdv' => $this->notes_rdv,
                'duree_rdv' => 60,
                'type_rdv' => 'demo'
            ]);
        }

        // Mettre à jour la dernière interaction
        $this->client->update([
            'derniere_interaction' => now()
        ]);

        // Envoyer un email de confirmation
        $this->envoyerEmailConfirmationRDV($lien_reunion);

        $this->closeModal();
        session()->flash('success', 'Rendez-vous planifié avec succès !');
        $this->dispatch('client-updated');
    }

    public function envoyerEmail()
    {
        $this->validate([
            'type_email' => 'required|in:confirmation,relance,renouvellement,information',
            'sujet_email' => 'required|string|max:200',
            'message_email' => 'required|string|max:1000'
        ]);

        // Envoyer l'email
        $this->envoyerEmailClient();

        // Mettre à jour la dernière interaction
        $this->client->update([
            'derniere_interaction' => now()
        ]);

        $this->closeModal();
        session()->flash('success', 'Email envoyé avec succès !');
        $this->dispatch('client-updated');
    }

    public function modifierStatut()
    {
        $this->validate([
            'nouveau_statut' => 'required|in:prospect,actif,inactif,archive'
        ]);

        // Empêcher le passage manuel de prospect à actif
        if ($this->client->statut === 'prospect' && $this->nouveau_statut === 'actif') {
            session()->flash('error', 'Un prospect ne peut devenir client que suite à un premier paiement validé. Le statut sera automatiquement mis à jour.');
            return;
        }

        // Empêcher le retour d'un client actif au statut prospect
        if ($this->client->statut === 'actif' && $this->nouveau_statut === 'prospect') {
            session()->flash('error', 'Un client actif ne peut pas redevenir prospect.');
            return;
        }

        $this->client->update([
            'statut' => $this->nouveau_statut,
            'derniere_interaction' => now()
        ]);

        $this->closeModal();
        session()->flash('success', 'Statut du client mis à jour !');
        $this->dispatch('client-updated');
    }

    /**
     * Vérifier si le client peut changer de statut
     */
    public function canChangeStatus($newStatus): bool
    {
        if ($this->client->statut === 'prospect' && $newStatus === 'actif') {
            return false;
        }
        
        if ($this->client->statut === 'actif' && $newStatus === 'prospect') {
            return false;
        }
        
        return true;
    }

    /**
     * Obtenir le message d'aide pour le changement de statut
     */
    public function getStatusChangeHelp($newStatus): ?string
    {
        if ($this->client->statut === 'prospect' && $newStatus === 'actif') {
            return 'Un prospect devient automatiquement client après validation de son premier paiement.';
        }
        
        if ($this->client->statut === 'actif' && $newStatus === 'prospect') {
            return 'Un client actif ne peut pas redevenir prospect.';
        }
        
        return null;
    }

    private function genererLienReunion()
    {
        // Générer un lien Zoom ou Google Meet
        $types = [
            'https://meet.google.com/' . strtolower(str_replace(' ', '-', $this->client->nom_entreprise)) . '-' . date('Ymd'),
            'https://zoom.us/j/' . rand(100000000, 999999999)
        ];
        
        return $types[array_rand($types)];
    }

    private function envoyerEmailConfirmationRDV($lien_reunion)
    {
        // Logique pour envoyer l'email de confirmation
        // Pour l'instant, on simule l'envoi
        \Log::info('Email de confirmation RDV envoyé à ' . $this->client->email);
    }

    private function envoyerEmailClient()
    {
        // Logique pour envoyer l'email
        // Pour l'instant, on simule l'envoi
        \Log::info('Email envoyé à ' . $this->client->email . ': ' . $this->sujet_email);
    }

    public function render()
    {
        return view('livewire.commercial.client-actions');
    }
}
