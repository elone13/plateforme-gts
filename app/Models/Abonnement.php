<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'service_id',
        'statut',
        'date_debut',
        'date_fin',
        'prix_mensuel',
        'prix_total',
        'duree_mois',
        'notes',
        'date_renouvellement',
        'renouvellement_automatique',
    ];

    protected $casts = [
        'prix_mensuel' => 'decimal:2',
        'prix_total' => 'decimal:2',
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_renouvellement' => 'date',
        'renouvellement_automatique' => 'boolean',
    ];

    /**
     * Get the client that owns the abonnement.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'idclient');
    }

    /**
     * Get the service for this abonnement.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    /**
     * Scope pour filtrer par statut
     */
    public function scopeByStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    /**
     * Scope pour filtrer par client
     */
    public function scopeByClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    /**
     * Scope pour les abonnements actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    /**
     * Scope pour les abonnements expirés
     */
    public function scopeExpires($query)
    {
        return $query->where('date_fin', '<', now());
    }

    /**
     * Scope pour les abonnements à renouveler
     */
    public function scopeARenouveler($query)
    {
        return $query->where('date_fin', '<=', now()->addDays(30));
    }
}
