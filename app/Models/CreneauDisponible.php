<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreneauDisponible extends Model
{
    use HasFactory;

    protected $table = 'creneaux_disponibles';

    protected $fillable = [
        'commercial_id',
        'date',
        'heure_debut',
        'heure_fin',
        'statut',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'heure_debut' => 'datetime:H:i',
        'heure_fin' => 'datetime:H:i',
    ];

    // Relations
    public function commercial()
    {
        return $this->belongsTo(Administrateur::class, 'commercial_id', 'idadministrateur');
    }

    // Scopes
    public function scopeDisponibles($query)
    {
        return $query->where('statut', 'disponible');
    }

    public function scopeParDate($query, $date)
    {
        return $query->where('date', $date);
    }

    public function scopeParCommercial($query, $commercialId)
    {
        return $query->where('commercial_id', $commercialId);
    }

    public function scopeFuturs($query)
    {
        return $query->where('date', '>=', now()->toDateString());
    }

    // Accesseurs
    public function getStatutFormattedAttribute()
    {
        $statuts = [
            'disponible' => 'Disponible',
            'reserve' => 'Réservé',
            'indisponible' => 'Indisponible',
        ];

        return $statuts[$this->statut] ?? $this->statut;
    }

    public function getStatutClassAttribute()
    {
        $classes = [
            'disponible' => 'bg-green-100 text-green-800',
            'reserve' => 'bg-yellow-100 text-yellow-800',
            'indisponible' => 'bg-red-100 text-red-800',
        ];

        return $classes[$this->statut] ?? 'bg-gray-100 text-gray-800';
    }

    public function getDureeAttribute()
    {
        $debut = \Carbon\Carbon::parse($this->heure_debut);
        $fin = \Carbon\Carbon::parse($this->heure_fin);
        return $debut->diffInMinutes($fin);
    }

    // Méthodes
    public function isDisponible()
    {
        return $this->statut === 'disponible';
    }

    public function isReserve()
    {
        return $this->statut === 'reserve';
    }

    public function isIndisponible()
    {
        return $this->statut === 'indisponible';
    }

    public function isPasse()
    {
        return $this->date < now()->toDateString();
    }

    public function isAujourdhui()
    {
        return $this->date->isToday();
    }

    public function isDemain()
    {
        return $this->date->isTomorrow();
    }
}
