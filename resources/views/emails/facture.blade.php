@component('mail::message')
# Facture {{ $facture->numero_facture }}

Bonjour {{ $facture->client->name ?? 'Madame, Monsieur' }},

Veuillez trouver ci-joint la facture n°{{ $facture->numero_facture }} d'un montant de **{{ number_format($facture->total_ttc, 2, ',', ' ') }} € TTC**.

**Détails de la facture :**  
- Date d'émission : {{ $facture->date_facturation->format('d/m/Y') }}  
- Date d'échéance : {{ $facture->date_echeance->format('d/m/Y') }}  
- Référence : {{ $facture->reference_commande ?? 'Non spécifiée' }}

**Moyens de paiement acceptés :**  
- Virement bancaire (coordonnées bancaires disponibles sur la facture)  
- Carte bancaire (lien de paiement sécurisé disponible sur demande)

Pour toute question concernant cette facture, n'hésitez pas à répondre à cet email ou à nous contacter directement.

Cordialement,  
L'équipe {{ config('app.name') }}

---

<small>
    Cet email a été envoyé automatiquement. Merci de ne pas y répondre directement.  
    Pour toute question, veuillez utiliser notre formulaire de contact ou répondre à cet email.
</small>
@endcomponent
