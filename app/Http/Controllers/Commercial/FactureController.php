<?php

namespace App\Http\Controllers\Commercial;

use App\Http\Controllers\Controller;
use App\Models\Devis;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FactureController extends Controller
{
    /**
     * Affiche la liste des factures
     */
    public function index()
    {
        $factures = Devis::where('statut', 'accepte')
            ->with(['client', 'items.service'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('commercial.factures.index', compact('factures'));
    }

    /**
     * Affiche le formulaire de création d'une facture
     */
    public function create()
    {
        // Généralement, les factures sont créées à partir de devis acceptés
        return redirect()->route('commercial.devis.index')
            ->with('info', 'Veuillez sélectionner un devis accepté pour créer une facture.');
    }

    /**
     * Enregistre une nouvelle facture
     */
    public function store(Request $request)
    {
        $devis = Devis::findOrFail($request->devis_id);
        
        // Vérifier si le devis est accepté
        if ($devis->statut !== 'accepte') {
            return back()->with('error', 'Seuls les devis acceptés peuvent être facturés.');
        }
        
        // Générer un numéro de facture unique
        $factureNumero = 'FACT-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        
        // Mettre à jour le devis avec le numéro de facture
        $devis->update([
            'numero_facture' => $factureNumero,
            'date_facturation' => now(),
            'statut' => 'facture'
        ]);
        
        return redirect()->route('commercial.factures.show', $devis->id)
            ->with('success', 'Facture créée avec succès.');
    }

    /**
     * Affiche une facture spécifique
     */
    public function show(string $id)
    {
        $facture = Devis::with(['client', 'items.service'])
            ->where('id', $id)
            ->whereIn('statut', ['facture', 'payee', 'en_retard'])
            ->firstOrFail();
            
        return view('commercial.factures.show', compact('facture'));
    }
    
    /**
     * Télécharge une facture au format PDF
     */
    public function downloadPdf(string $id)
    {
        $facture = Devis::with(['client', 'items.service'])
            ->where('id', $id)
            ->whereIn('statut', ['facture', 'payee', 'en_retard'])
            ->firstOrFail();
            
        $pdf = PDF::loadView('pdf.facture', compact('facture'));
        
        return $pdf->download('facture-' . $facture->numero_facture . '.pdf');
    }
    
    /**
     * Envoie une facture par email
     */
    public function sendByEmail(Request $request, string $id)
    {
        $facture = Devis::with('client')
            ->where('id', $id)
            ->whereIn('statut', ['facture', 'payee', 'en_retard'])
            ->firstOrFail();
            
        $email = $request->input('email', $facture->client->email);
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $pdf = PDF::loadView('pdf.facture', compact('facture'));
            
            Mail::send('emails.facture', ['facture' => $facture], function($message) use ($facture, $email, $pdf) {
                $message->to($email)
                        ->subject('Votre facture ' . $facture->numero_facture)
                        ->attachData($pdf->output(), 'facture-' . $facture->numero_facture . '.pdf');
            });
            
            // Enregistrer l'historique d'envoi
            $facture->update([
                'email_envoye_a' => $email,
                'date_envoi_email' => now()
            ]);
            
            return back()->with('success', 'La facture a été envoyée avec succès à ' . $email);
        }
        
        return back()->with('error', 'Adresse email invalide.');
    }

    /**
     * Affiche le formulaire de modification d'une facture
     */
    public function edit(string $id)
    {
        // Généralement, on ne modifie pas une facture, on crée une note de crédit si nécessaire
        return back()->with('info', 'Les factures ne peuvent pas être modifiées. Créez une note de crédit si nécessaire.');
    }

    /**
     * Met à jour une facture existante
     */
    public function update(Request $request, string $id)
    {
        // Généralement, on ne met pas à jour une facture existante
        return back()->with('info', 'Les factures ne peuvent pas être modifiées. Créez une note de crédit si nécessaire.');
    }

    /**
     * Marque une facture comme payée
     */
    public function markAsPaid(Devis $facture)
    {
        if (!in_array($facture->statut, ['facture', 'en_retard'])) {
            return back()->with('error', 'Seules les factures non payées peuvent être marquées comme payées.');
        }
        
        // Créer un enregistrement de paiement
        $paiement = new \App\Models\Paiement([
            'montant' => $facture->total_ttc,
            'date_paiement' => now(),
            'mode_paiement' => 'virement', // À adapter selon votre logique
            'reference' => 'PAI-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
            'statut' => 'validé',
            'devis_id' => $facture->id,
            'client_id' => $facture->client_id,
        ]);
        
        $paiement->save();
        
        // Mettre à jour le statut de la facture
        $facture->update([
            'statut' => 'payee',
            'date_paiement' => now()
        ]);
        
        return redirect()->route('commercial.factures.show', $facture)
            ->with('success', 'La facture a été marquée comme payée avec succès.');
    }
    
    /**
     * Annule une facture
     */
    public function cancel(Devis $facture)
    {
        if ($facture->statut !== 'facture' && $facture->statut !== 'en_retard') {
            return back()->with('error', 'Seules les factures non payées peuvent être annulées.');
        }
        
        $facture->update([
            'statut' => 'annule',
            'date_annulation' => now(),
            'motif_annulation' => request('motif', 'Annulée par l\'utilisateur')
        ]);
        
        // Envoyer une notification d'annulation si nécessaire
        // Notification::send(...);
        
        return redirect()->route('commercial.factures.index')
            ->with('success', 'La facture a été annulée avec succès.');
    }
    
    /**
     * Supprime une facture
     */
    public function destroy(string $id)
    {
        // Généralement, on ne supprime pas une facture, on l'annule
        $facture = Devis::findOrFail($id);
        
        if ($facture->statut === 'facture') {
            $facture->update([
                'statut' => 'annule',
                'date_annulation' => now()
            ]);
            
            return redirect()->route('commercial.factures.index')
                ->with('success', 'La facture a été annulée avec succès.');
        }
        
        return back()->with('error', 'Impossible de supprimer cette facture.');
    }
}
