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
     * Get the devis that owns the facture.
     */
    public function devis()
    {
        return $this->belongsTo(Devis::class);
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
