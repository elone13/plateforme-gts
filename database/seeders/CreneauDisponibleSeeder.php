<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CreneauDisponible;
use App\Models\Administrateur;
use Carbon\Carbon;

class CreneauDisponibleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer un commercial pour créer des créneaux
        $commercial = Administrateur::where('type', 'commercial')->first();
        
        if (!$commercial) {
            $this->command->info('Aucun commercial trouvé. Création des créneaux annulée.');
            return;
        }
        
        // Créer des créneaux pour la semaine en cours
        $startDate = Carbon::now()->startOfWeek();
        
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            
            // Ne pas créer de créneaux pour les weekends
            if ($date->isWeekend()) {
                continue;
            }
            
            // Créer des créneaux de 9h à 12h et de 14h à 17h
            $this->createCreneau($commercial->idadministrateur, $date, '09:00', '12:00', 'disponible');
            $this->createCreneau($commercial->idadministrateur, $date, '14:00', '17:00', 'disponible');
            
            // Créer un créneau indisponible pour le déjeuner
            $this->createCreneau($commercial->idadministrateur, $date, '12:00', '14:00', 'indisponible', 'Pause déjeuner');
        }
        
        $this->command->info('Créneaux de disponibilité créés avec succès.');
    }
    
    private function createCreneau($commercialId, $date, $heureDebut, $heureFin, $statut, $notes = null)
    {
        CreneauDisponible::create([
            'commercial_id' => $commercialId,
            'date' => $date->format('Y-m-d'),
            'heure_debut' => $heureDebut, // Juste l'heure (HH:MM)
            'heure_fin' => $heureFin,      // Juste l'heure (HH:MM)
            'statut' => $statut,
            'notes' => $notes,
        ]);
    }
}
