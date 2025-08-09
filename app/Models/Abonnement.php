<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;

    protected $primaryKey = 'idabonnement';

    protected $fillable = [
        'date_debut',
        'date_fin',
        'item_iditem',
        'statut',
        'montant_mensuel',
    ];

    protected $casts = [
        'montant_mensuel' => 'decimal:2',
    ];

    /**
     * Get the item that owns the abonnement.
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_iditem', 'iditem');
    }
}
