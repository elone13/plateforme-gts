<?php

namespace App\Livewire\Commercial;

use App\Models\Devis;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class DevisActions extends Component
{
    public $devis;
    public $showStatusModal = false;
    public $showEmailModal = false;
    public $newStatus = '';
    public $emailTo = '';
    public $emailSubject = '';
    public $emailMessage = '';

    protected $listeners = ['refreshDevis'];

    public function mount(Devis $devis)
    {
        $this->devis = $devis;
        $this->newStatus = $devis->statut;
        $this->emailTo = $devis->client->email ?? '';
        $this->emailSubject = "Devis {$devis->reference} - " . ($devis->client->nom_entreprise ?? $devis->client->nom ?? 'Client');
        $this->emailMessage = "Bonjour,\n\nVeuillez trouver ci-joint notre devis {$devis->reference}.\n\nCordialement,\nL'équipe commerciale";
    }

    public function openStatusModal()
    {
        $this->showStatusModal = true;
    }

    public function closeStatusModal()
    {
        $this->showStatusModal = false;
    }

    public function updateStatus()
    {
        $this->validate([
            'newStatus' => 'required|in:brouillon,envoye,accepte,refuse,expire'
        ]);

        try {
            $this->devis->update(['statut' => $this->newStatus]);
            
            // Si le devis est accepté, créer une facture
            if ($this->newStatus === 'accepte') {
                // Logique pour créer une facture
                // $this->createFacture();
            }

            $this->closeStatusModal();
            $this->dispatch('devisUpdated', $this->devis->id);
            session()->flash('success', 'Statut du devis mis à jour avec succès !');

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la mise à jour du statut : ' . $e->getMessage());
        }
    }

    public function openEmailModal()
    {
        $this->showEmailModal = true;
    }

    public function closeEmailModal()
    {
        $this->showEmailModal = false;
    }

    public function sendEmail()
    {
        $this->validate([
            'emailTo' => 'required|email',
            'emailSubject' => 'required|string|max:255',
            'emailMessage' => 'required|string'
        ]);

        try {
            // Ici, vous pouvez implémenter l'envoi d'email avec le devis en PDF
            // Mail::to($this->emailTo)->send(new DevisEmail($this->devis, $this->emailSubject, $this->emailMessage));
            
            // Mettre à jour le statut du devis
            $this->devis->update([
                'statut' => 'envoye',
                'email_envoye_a' => $this->emailTo,
                'date_envoi_email' => now()
            ]);

            $this->closeEmailModal();
            $this->dispatch('devisUpdated', $this->devis->id);
            session()->flash('success', 'Devis envoyé par email avec succès !');

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
        }
    }

    public function downloadPDF()
    {
        // Logique pour télécharger le PDF du devis
        return redirect()->route('commercial.devis.download', $this->devis);
    }

    public function refreshDevis()
    {
        $this->devis->refresh();
    }

    public function render()
    {
        return view('livewire.commercial.devis-actions');
    }
}
