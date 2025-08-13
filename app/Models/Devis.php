<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'date',
        'client_idclient',
        'statut',
        'montant_total',
        'conditions',
        'date_validite',
        // Champs pour la facturation
        'numero_facture',
        'date_facturation',
        'date_echeance',
        'date_paiement',
        'date_annulation',
        'motif_annulation',
        'email_envoye_a',
        'date_envoi_email',
        'reference_commande',
        'total_ht',
        'taux_tva',
        'montant_tva',
        'total_ttc',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'date_validite' => 'date',
        'date_facturation' => 'date',
        'date_echeance' => 'date',
        'date_paiement' => 'datetime',
        'date_annulation' => 'datetime',
        'date_envoi_email' => 'datetime',
        'montant_total' => 'decimal:2',
        'total_ht' => 'decimal:2',
        'taux_tva' => 'decimal:2',
        'montant_tva' => 'decimal:2',
        'total_ttc' => 'decimal:2',
    ];
    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($devis) {
            if (empty($devis->reference)) {
                $devis->reference = self::generateReference();
            }
            
            // Définir des valeurs par défaut
            $devis->statut = $devis->statut ?? 'brouillon';
            $devis->date = $devis->date ?? now();
            $devis->date_validite = $devis->date_validite ?? now()->addDays(30);
            $devis->taux_tva = $devis->taux_tva ?? config('app.taux_tva', 0.20); // 20% par défaut
        });
        
        static::saving(function ($devis) {
            // Calculer les totaux si nécessaire
            if ($devis->isDirty(['total_ht', 'taux_tva']) || !isset($devis->montant_tva)) {
                $devis->montant_tva = $devis->total_ht * $devis->taux_tva;
                $devis->total_ttc = $devis->total_ht + $devis->montant_tva;
                $devis->montant_total = $devis->total_ttc; // Pour rétrocompatibilité
            }
        });
    }

    /**
     * Get the client that owns the devis.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_idclient', 'idclient');
    }

    /**
     * Get the items for the devis.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Get the facture for the devis.
     */
    public function facture()
    {
        return $this->hasOne(Facture::class);
    }

    /**
     * Get the demo requests associated with the devis.
     */
    public function demandeDemos()
    {
        return $this->belongsToMany(DemandeDemo::class, 'devis_demande_demo', 'devis_id', 'demande_demo_id');
    }

    /**
     * Generate a unique reference for the devis.
     */
    public static function generateReference()
    {
        $prefix = 'DEV';
        $year = date('Y');
        $month = date('m');
        $lastDevis = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastDevis ? intval(substr($lastDevis->reference, -4)) + 1 : 1;
        
        return $prefix . $year . $month . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
