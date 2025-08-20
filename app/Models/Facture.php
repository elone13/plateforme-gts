<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'montant',
        'pdf_file',
        'devis_id',
        'statut_paiement',
        'date_echeance',
        'date_paiement',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_echeance' => 'date',
        'date_paiement' => 'date',
    ];

    /**
     * Accesseur pour le statut (compatibilité avec l'ancien code)
     */
    public function getStatutAttribute()
    {
        // Mapper statut_paiement vers statut
        switch ($this->statut_paiement) {
            case 'paye':
                return 'payee';
            case 'en_attente':
                return 'en_attente';
            case 'en_retard':
                return 'en_retard';
            case 'annule':
                return 'annule';
            default:
                return 'en_attente';
        }
    }

    /**
     * Get the devis that owns the facture.
     */
    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }

    /**
     * Get the client through the devis.
     */
    public function client()
    {
        return $this->devis->client;
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Lorsqu'une facture est mise à jour
        static::updated(function ($facture) {
            // Si le statut passe à 'payee', mettre à jour le statut du client
            if ($facture->isDirty('statut') && $facture->statut === 'payee') {
                $facture->updateClientStatus();
            }
        });

        // Lorsqu'une facture est créée avec le statut 'payee'
        static::created(function ($facture) {
            if ($facture->statut === 'payee') {
                $facture->updateClientStatus();
            }
        });
    }

    /**
     * Mettre à jour le statut du client si c'est un prospect
     */
    public function updateClientStatus(): void
    {
        if ($this->client && $this->client->statut === 'prospect') {
            $this->client->updateStatusBasedOnPayment();
        }
    }

    /**
     * Vérifier si la facture est payée
     */
    public function isPaid(): bool
    {
        return $this->statut === 'payee';
    }

    /**
     * Vérifier si la facture est en retard
     */
    public function isOverdue(): bool
    {
        return $this->date_echeance && $this->date_echeance->isPast() && !$this->isPaid();
    }

    /**
     * Generate a unique reference for the facture.
     */
    public static function generateReference()
    {
        $prefix = 'FAC';
        $year = date('Y');
        $month = date('m');
        $lastFacture = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastFacture ? intval(substr($lastFacture->reference, -4)) + 1 : 1;
        
        return $prefix . $year . $month . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
