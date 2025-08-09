<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'iditem';

    protected $fillable = [
        'quantite',
        'prix',
        'devis_id',
        'avancement',
        'statut',
        'service_id',
        'description',
    ];

    /**
     * Get the devis that owns the item.
     */
    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }

    /**
     * Get the service that owns the item.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the abonnements for the item.
     */
    public function abonnements()
    {
        return $this->hasMany(Abonnement::class, 'item_iditem', 'iditem');
    }
}
