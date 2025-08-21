<?php

namespace App\Http\Controllers\Commercial;

use App\Http\Controllers\Controller;
use App\Models\CreneauDisponible;
use App\Models\DemandeDemo;
use App\Models\Administrateur;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PlanningController extends Controller
{
    /**
     * Afficher le planning du mois
     */
    public function index(Request $request)
    {
        $commercial = Auth::user()->administrateur;
        
        // Récupérer le mois demandé (par défaut le mois actuel)
        $dateParam = $request->get('date');
        
        if ($dateParam) {
            // Si le paramètre est au format Y-m (année-mois), on l'ajoute au premier jour du mois
            if (preg_match('/^\d{4}-\d{2}$/', $dateParam)) {
                $month = Carbon::createFromFormat('Y-m', $dateParam)->startOfMonth();
            } else {
                // Sinon, on traite comme une date complète
                $month = Carbon::parse($dateParam)->startOfMonth();
            }
        } else {
            // Par défaut, le mois actuel
            $month = now()->startOfMonth();
        }
        
        // Récupérer tous les créneaux du mois
        $creneaux = CreneauDisponible::where('commercial_id', $commercial->idadministrateur)
            ->whereBetween('date', [
                $month->format('Y-m-d'),
                $month->endOfMonth()->format('Y-m-d')
            ])
            ->orderBy('date')
            ->orderBy('heure_debut')
            ->get()
            ->groupBy('date');
        
        // Récupérer les demandes de démo programmées du mois
        $demandesProgrammees = DemandeDemo::where('statut', 'planifiee')
            ->whereBetween('date_rdv', [
                $month->format('Y-m-d'),
                $month->endOfMonth()->format('Y-m-d')
            ])
            ->orderBy('date_rdv')
            ->orderBy('heure_rdv')
            ->get()
            ->groupBy('date_rdv');
        
        // Générer le calendrier du mois
        $calendar = $this->generateCalendar($month, $creneaux, $demandesProgrammees);
        
        // Statistiques du mois
        $stats = $this->getMonthlyStats($month, $creneaux, $demandesProgrammees);
        
        return view('commercial.planning.index', compact('calendar', 'month', 'stats', 'creneaux', 'demandesProgrammees'));
    }
    
    /**
     * Afficher le planning d'une journée spécifique
     */
    public function showDay(Request $request, $date)
    {
        $commercial = Auth::user()->administrateur;
        $dateObj = Carbon::parse($date);
        
        // Récupérer les créneaux de la journée
        $creneaux = CreneauDisponible::where('commercial_id', $commercial->idadministrateur)
            ->where('date', $date)
            ->orderBy('heure_debut')
            ->get();
        
        // Récupérer les rendez-vous de la journée
        $rendezVous = DemandeDemo::where('statut', 'planifiee')
            ->where('date_rdv', $date)
            ->orderBy('heure_rdv')
            ->get();
        
        return view('commercial.planning.show-day', compact('dateObj', 'creneaux', 'rendezVous'));
    }
    
    /**
     * Créer un nouveau créneau
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'statut' => 'required|in:disponible,indisponible',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $commercial = Auth::user()->administrateur;
        
        // Vérifier qu'il n'y a pas de conflit avec un créneau existant
        $conflict = CreneauDisponible::where('commercial_id', $commercial->idadministrateur)
            ->where('date', $request->date)
            ->where(function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('heure_debut', '<', $request->heure_fin)
                      ->where('heure_fin', '>', $request->heure_debut);
                });
            })
            ->first();
        
        if ($conflict) {
            return back()->withErrors(['conflict' => 'Ce créneau chevauche un créneau existant.']);
        }
        
        // Vérifier qu'il n'y a pas de conflit avec un rendez-vous
        $rdvConflict = DemandeDemo::where('statut', 'planifiee')
            ->where('commercial_id', $commercial->idadministrateur)
            ->where('date_rdv', $request->date)
            ->where(function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('heure_rdv', '<', $request->heure_fin)
                      ->whereRaw('DATE_ADD(heure_rdv, INTERVAL duree_rdv MINUTE) > ?', [$request->heure_debut]);
                });
            })
            ->first();
        
        if ($rdvConflict) {
            return back()->withErrors(['conflict' => 'Ce créneau chevauche un rendez-vous existant.']);
        }
        
        CreneauDisponible::create([
            'commercial_id' => $commercial->idadministrateur,
            'date' => $request->date,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
            'statut' => $request->statut,
            'notes' => $request->notes,
        ]);
        
        return back()->with('success', 'Créneau créé avec succès.');
    }
    
    /**
     * Mettre à jour un créneau
     */
    public function update(Request $request, CreneauDisponible $creneau)
    {
        $request->validate([
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'statut' => 'required|in:disponible,indisponible',
            'notes' => 'nullable|string|max:500',
        ]);
        
        // Vérifier les conflits (même logique que pour la création)
        $conflict = CreneauDisponible::where('commercial_id', $creneau->commercial_id)
            ->where('date', $creneau->date)
            ->where('id', '!=', $creneau->id)
            ->where(function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('heure_debut', '<', $request->heure_fin)
                      ->where('heure_fin', '>', $request->heure_debut);
                });
            })
            ->first();
        
        if ($conflict) {
            return back()->withErrors(['conflict' => 'Ce créneau chevauche un créneau existant.']);
        }
        
        $creneau->update([
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
            'statut' => $request->statut,
            'notes' => $request->notes,
        ]);
        
        return back()->with('success', 'Créneau mis à jour avec succès.');
    }
    
    /**
     * Supprimer un créneau
     */
    public function destroy(CreneauDisponible $creneau)
    {
        $creneau->delete();
        return back()->with('success', 'Créneau supprimé avec succès.');
    }
    
    /**
     * Générer le calendrier du mois
     */
    private function generateCalendar($month, $creneaux, $demandesProgrammees)
    {
        $calendar = [];
        $currentDate = $month->copy();
        
        // Remplir le calendrier avec tous les jours du mois
        while ($currentDate->month === $month->month) {
            $dateStr = $currentDate->format('Y-m-d');
            
            $calendar[$dateStr] = [
                'date' => $currentDate->copy(),
                'creneaux' => $creneaux->get($dateStr, collect()),
                'rendez_vous' => $demandesProgrammees->get($dateStr, collect()),
                'is_today' => $currentDate->isToday(),
                'is_weekend' => $currentDate->isWeekend(),
                'is_past' => $currentDate->isPast(),
            ];
            
            $currentDate->addDay();
        }
        
        return $calendar;
    }
    
    /**
     * Obtenir les statistiques du mois
     */
    private function getMonthlyStats($month, $creneaux, $demandesProgrammees)
    {
        $totalCreneaux = $creneaux->flatten()->count();
        $creneauxDisponibles = $creneaux->flatten()->where('statut', 'disponible')->count();
        $creneauxReserves = $creneaux->flatten()->where('statut', 'reserve')->count();
        $totalRendezVous = $demandesProgrammees->flatten()->count();
        
        return [
            'total_creneaux' => $totalCreneaux,
            'creneaux_disponibles' => $creneauxDisponibles,
            'creneaux_reserves' => $creneauxReserves,
            'total_rendez_vous' => $totalRendezVous,
            'taux_occupation' => $totalCreneaux > 0 ? round(($creneauxReserves / $totalCreneaux) * 100, 1) : 0,
        ];
    }
    
    /**
     * API pour vérifier la disponibilité d'un créneau
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i',
            'exclude_id' => 'nullable|integer',
        ]);
        
        $commercial = Auth::user()->administrateur;
        
        // Vérifier les conflits avec les créneaux
        $creneauConflict = CreneauDisponible::where('commercial_id', $commercial->idadministrateur)
            ->where('date', $request->date)
            ->when($request->exclude_id, function($query, $id) {
                return $query->where('id', '!=', $id);
            })
            ->where(function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('heure_debut', '<', $request->heure_fin)
                      ->where('heure_fin', '>', $request->heure_debut);
                });
            })
            ->first();
        
        // Vérifier les conflits avec les rendez-vous
        $rdvConflict = DemandeDemo::where('statut', 'planifiee')
            ->where('commercial_id', $commercial->idadministrateur)
            ->where('date_rdv', $request->date)
            ->where(function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('heure_rdv', '<', $request->heure_fin)
                      ->whereRaw('DATE_ADD(heure_rdv, INTERVAL duree_rdv MINUTE) > ?', [$request->heure_debut]);
                });
            })
            ->first();
        
        return response()->json([
            'available' => !$creneauConflict && !$rdvConflict,
            'creneau_conflict' => $creneauConflict ? [
                'id' => $creneauConflict->id,
                'heure_debut' => $creneauConflict->heure_debut,
                'heure_fin' => $creneauConflict->heure_fin,
                'statut' => $creneauConflict->statut,
            ] : null,
            'rdv_conflict' => $rdvConflict ? [
                'id' => $rdvConflict->id,
                'client' => $rdvConflict->nom,
                'heure_rdv' => $rdvConflict->heure_rdv,
                'duree' => $rdvConflict->duree_rdv,
            ] : null,
        ]);
    }
}
