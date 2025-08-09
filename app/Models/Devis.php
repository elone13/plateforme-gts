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
    ];

    protected $casts = [
        'date' => 'date',
        'date_validite' => 'date',
        'montant_total' => 'decimal:2',
    ];

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
