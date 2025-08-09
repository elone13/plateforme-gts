<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeDemo extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'nom',
        'email',
        'telephone',
        'message',
        'statut',
    ];

    /**
     * Get the devis associated with the demo request.
     */
    public function devis()
    {
        return $this->belongsToMany(Devis::class, 'devis_demande_demo', 'demande_demo_id', 'devis_id');
    }
}
