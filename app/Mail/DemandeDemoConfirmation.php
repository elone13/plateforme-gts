<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\DemandeDemo;

class DemandeDemoConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $demandeDemo;

    /**
     * Create a new message instance.
     */
    public function __construct(DemandeDemo $demandeDemo)
    {
        $this->demandeDemo = $demandeDemo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->demandeDemo->statut === 'planifiee' 
            ? 'Rendez-vous de démonstration confirmé - GTS Afrique'
            : 'Demande de démonstration reçue - GTS Afrique';
            
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.demande-demo-confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
