<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'idclient';

    protected $fillable = [
        'user_id',
        'telephone',
        'adresse',
        'entreprise',
    ];

    /**
     * Get the user that owns the client.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the devis for the client.
     */
    public function devis()
    {
        return $this->hasMany(Devis::class, 'client_idclient', 'idclient');
    }

    /**
     * Get the factures for the client through devis.
     */
    public function factures()
    {
        return $this->hasManyThrough(Facture::class, Devis::class, 'client_idclient', 'devis_id');
    }
}
