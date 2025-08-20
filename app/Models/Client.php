<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'idclient';

    protected $fillable = [
        'nom',
        'nom_entreprise',
        'contact_principal',
        'email',
        'telephone',
        'adresse',
        'secteur_activite',
        'notes',
        'statut',
        'source',
        'derniere_interaction',
        'user_id',
        'date_inscription',
    ];

    protected $casts = [
        'derniere_interaction' => 'datetime',
    ];

    /**
     * Get the user that owns the client.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
        return $this->hasManyThrough(
            Facture::class,
            Devis::class,
            'client_idclient', // Foreign key on devis table
            'devis_id', // Foreign key on factures table
            'idclient', // Local key on clients table
            'id' // Local key on devis table
        );
    }

    /**
     * Get the demandes de démo for the client.
     */
    public function demandeDemos()
    {
        return $this->hasMany(DemandeDemo::class, 'email', 'email');
    }

    /**
     * Get the abonnements for the client.
     */
    public function abonnements()
    {
        return $this->hasManyThrough(
            Abonnement::class,
            Devis::class,
            'client_idclient', // Foreign key on devis table
            'item_iditem', // Foreign key on abonnements table
            'idclient', // Local key on clients table
            'id' // Local key on devis table
        );
    }

    /**
     * Get the count of abonnements for the client.
     */
    public function getAbonnementsCountAttribute()
    {
        return $this->devis()->with('items.abonnements')->get()
            ->flatMap->items
            ->flatMap->abonnements
            ->count();
    }

    /**
     * Get the count of factures for the client.
     */
    public function getFacturesCountAttribute()
    {
        return $this->factures()->count();
    }

    /**
     * Vérifier si le client peut passer du statut prospect à client
     * Un prospect devient client uniquement après validation d'un premier paiement
     */
    public function canBecomeClient(): bool
    {
        if ($this->statut !== 'prospect') {
            return false;
        }

        // Vérifier s'il y a au moins une facture payée
        return $this->hasValidatedPayment();
    }

    /**
     * Vérifier si le client a un paiement validé
     */
    public function hasValidatedPayment(): bool
    {
        return $this->factures()
            ->where('statut_paiement', 'paye')
            ->exists();
    }

    /**
     * Passer automatiquement du statut prospect à client si un paiement est validé
     */
    public function updateStatusBasedOnPayment(): void
    {
        if ($this->statut === 'prospect' && $this->hasValidatedPayment()) {
            $this->update([
                'statut' => 'actif',
                'derniere_interaction' => now()
            ]);
        }
    }

    /**
     * Obtenir le premier paiement validé du client
     */
    public function getFirstValidatedPayment()
    {
        return $this->factures()
            ->where('statut_paiement', 'paye')
            ->orderBy('date_paiement', 'asc')
            ->first();
    }

    /**
     * Obtenir la date de passage prospect → client
     */
    public function getClientSinceDate()
    {
        if ($this->statut === 'actif') {
            $firstPayment = $this->getFirstValidatedPayment();
            return $firstPayment ? $firstPayment->date_paiement : null;
        }
        return null;
    }

    /**
     * Scope pour les prospects qui peuvent devenir clients
     */
    public function scopeReadyToBecomeClient($query)
    {
        return $query->where('statut', 'prospect')
                    ->whereHas('factures', function ($q) {
                        $q->where('statut_paiement', 'paye');
                    });
    }

    /**
     * Scope pour les clients actifs
     */
    public function scopeActiveClients($query)
    {
        return $query->where('statut', 'actif');
    }

    /**
     * Scope pour les prospects
     */
    public function scopeProspects($query)
    {
        return $query->where('statut', 'prospect');
    }

    /**
     * Scope pour filtrer par statut
     */
    public function scopeByStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    /**
     * Scope pour filtrer par secteur
     */
    public function scopeBySecteur($query, $secteur)
    {
        return $query->where('secteur_activite', 'like', '%' . $secteur . '%');
    }

    /**
     * Scope pour la recherche
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nom', 'like', '%' . $search . '%')
              ->orWhere('nom_entreprise', 'like', '%' . $search . '%')
              ->orWhere('contact_principal', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%')
              ->orWhere('secteur_activite', 'like', '%' . $search . '%');
        });
    }
}
