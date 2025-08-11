<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeDevis extends Model
{
    use HasFactory;

    protected $table = 'demandes_devis';

    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'entreprise',
        'description_projet',
        'nombre_vehicules',
        'type_vehicule',
        'statut',
        'commentaire_commercial',
        'date_rdv',
        'heure_rdv',
        'source',
        'priorite',
        'commercial_id',
    ];

    protected $casts = [
        'date_rdv' => 'date',
        'heure_rdv' => 'datetime:H:i',
        'nombre_vehicules' => 'integer',
    ];

    // Relations
    public function commercial()
    {
        return $this->belongsTo(Administrateur::class, 'commercial_id');
    }

    // Scopes
    public function scopeParStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    public function scopeParPriorite($query, $priorite)
    {
        return $query->where('priorite', $priorite);
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeUrgentes($query)
    {
        return $query->where('priorite', 'haute');
    }

    // Accesseurs
    public function getStatutFormattedAttribute()
    {
        $statuts = [
            'en_attente' => 'En attente',
            'acceptee' => 'Acceptée',
            'refusee' => 'Refusée',
            'en_cours' => 'En cours',
            'terminee' => 'Terminée',
        ];

        return $statuts[$this->statut] ?? $this->statut;
    }

    public function getPrioriteFormattedAttribute()
    {
        $priorites = [
            'haute' => 'Haute',
            'moyenne' => 'Moyenne',
            'basse' => 'Basse',
        ];

        return $priorites[$this->priorite] ?? $this->priorite;
    }

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

    public function getPrioriteClassAttribute()
    {
        $classes = [
            'haute' => 'bg-red-100 text-red-800',
            'moyenne' => 'bg-yellow-100 text-yellow-800',
            'basse' => 'bg-green-100 text-green-800',
        ];

        return $classes[$this->priorite] ?? 'bg-gray-100 text-gray-800';
    }

    // Méthodes
    public function isUrgente()
    {
        return $this->priorite === 'haute';
    }

    public function canBeTraitee()
    {
        return in_array($this->statut, ['en_attente', 'en_cours']);
    }

    public function hasRendezVous()
    {
        return !is_null($this->date_rdv) && !is_null($this->heure_rdv);
    }
}


