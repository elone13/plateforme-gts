<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeDemo extends Model
{
    use HasFactory;

    protected $table = 'demande_demos';

    protected $fillable = [
        'date',
        'nom',
        'email',
        'telephone',
        'message',
        'statut',
        'commentaire_admin',
        'raison_refus',
        'date_rdv',
        'heure_rdv',
        'lien_reunion',
        'instructions_rdv',
        'duree_rdv',
        'type_rdv',
        'source', // d'où vient la demande (site web, formulaire, etc.)
        'priorite', // haute, moyenne, basse
    ];

    protected $casts = [
        'date' => 'date',
        'date_rdv' => 'date',
        'heure_rdv' => 'datetime',
        'duree_rdv' => 'integer',
    ];

    /**
     * Get the devis associated with the demo request.
     */
    public function devis()
    {
        return $this->belongsToMany(Devis::class, 'devis_demande_demo', 'demande_demo_id', 'devis_id');
    }

    /**
     * Scope pour filtrer par statut
     */
    public function scopeParStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    /**
     * Scope pour filtrer par priorité
     */
    public function scopeParPriorite($query, $priorite)
    {
        return $query->where('priorite', $priorite);
    }

    /**
     * Scope pour les demandes en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    /**
     * Scope pour les demandes urgentes (haute priorité + en attente)
     */
    public function scopeUrgentes($query)
    {
        return $query->where('priorite', 'haute')->where('statut', 'en_attente');
    }

    /**
     * Obtenir le statut formaté
     */
    public function getStatutFormattedAttribute()
    {
        $statuts = [
            'en_attente' => 'En attente',
            'acceptee' => 'Acceptée',
            'planifiee' => 'Planifiée',
            'en_cours' => 'En cours',
            'refusee' => 'Refusée',
            'terminee' => 'Terminée',
        ];

        return $statuts[$this->statut] ?? $this->statut;
    }

    /**
     * Obtenir la priorité formatée
     */
    public function getPrioriteFormattedAttribute()
    {
        $priorites = [
            'haute' => 'Haute',
            'moyenne' => 'Moyenne',
            'basse' => 'Basse',
        ];

        return $priorites[$this->priorite] ?? $this->priorite;
    }

    /**
     * Obtenir la classe CSS pour le statut
     */
    public function getStatutClassAttribute()
    {
        $classes = [
            'en_attente' => 'bg-yellow-100 text-yellow-800',
            'acceptee' => 'bg-green-100 text-green-800',
            'refusee' => 'bg-red-100 text-red-800',
            'en_cours' => 'bg-blue-100 text-blue-800',
            'terminee' => 'bg-gray-100 text-gray-800',
        ];

        return $classes[$this->statut] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Obtenir la classe CSS pour la priorité
     */
    public function getPrioriteClassAttribute()
    {
        $classes = [
            'haute' => 'bg-red-100 text-red-800',
            'moyenne' => 'bg-yellow-100 text-yellow-800',
            'basse' => 'bg-green-100 text-green-800',
        ];

        return $classes[$this->priorite] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Vérifier si la demande est urgente
     */
    public function isUrgente()
    {
        return $this->priorite === 'haute' && $this->statut === 'en_attente';
    }

    /**
     * Vérifier si la demande peut être traitée
     */
    public function canBeTraitee()
    {
        return in_array($this->statut, ['en_attente', 'acceptee']);
    }
}
