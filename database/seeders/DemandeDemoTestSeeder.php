<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DemandeDemo;
use Carbon\Carbon;

class DemandeDemoTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des demandes de démo de test
        $demandes = [
            [
                'nom' => 'Jean Dupont',
                'email' => 'jean.dupont@entreprise.com',
                'telephone' => '+221 77 123 45 67',
                'message' => 'Bonjour, nous sommes intéressés par votre plateforme de gestion de flotte. Pouvez-vous nous faire une démonstration ?',
                'statut' => 'en_attente',
                'priorite' => 'haute',
                'source' => 'Site web',
                'date' => Carbon::now()->subDays(2),
            ],
            [
                'nom' => 'Marie Martin',
                'email' => 'marie.martin@transport.com',
                'telephone' => '+221 76 987 65 43',
                'message' => 'Nous cherchons une solution pour optimiser nos trajets. Votre plateforme semble parfaite !',
                'statut' => 'acceptee',
                'priorite' => 'moyenne',
                'source' => 'Formulaire contact',
                'date' => Carbon::now()->subDays(1),
            ],
            [
                'nom' => 'Pierre Durand',
                'email' => 'pierre.durand@logistics.com',
                'telephone' => '+221 75 555 44 33',
                'message' => 'Nous avons une flotte de 50 véhicules. Pouvez-vous nous montrer comment votre solution peut nous aider ?',
                'statut' => 'planifiee',
                'priorite' => 'haute',
                'source' => 'Recommandation',
                'date' => Carbon::now()->subDays(3),
                'date_rdv' => Carbon::now()->addDays(2),
                'heure_rdv' => Carbon::now()->addDays(2)->setTime(14, 0),
                'lien_reunion' => 'https://meet.google.com/abc-defg-hij',
                'instructions_rdv' => 'Préparez vos questions sur la gestion de flotte et la géolocalisation.',
                'duree_rdv' => 90,
                'type_rdv' => 'en_ligne',
            ],
            [
                'nom' => 'Sophie Bernard',
                'email' => 'sophie.bernard@delivery.com',
                'telephone' => '+221 78 111 22 33',
                'message' => 'Nous livrons dans toute la région de Dakar. Votre solution peut-elle nous aider à optimiser nos tournées ?',
                'statut' => 'en_cours',
                'priorite' => 'moyenne',
                'source' => 'LinkedIn',
                'date' => Carbon::now()->subDays(5),
            ],
            [
                'nom' => 'Lucas Petit',
                'email' => 'lucas.petit@taxi.com',
                'telephone' => '+221 79 444 55 66',
                'message' => 'Nous gérons une flotte de taxis. Intéressé par votre solution de géolocalisation.',
                'statut' => 'terminee',
                'priorite' => 'basse',
                'source' => 'Facebook',
                'date' => Carbon::now()->subDays(10),
            ],
        ];

        foreach ($demandes as $demande) {
            DemandeDemo::create($demande);
        }

        $this->command->info('Demandes de démo de test créées avec succès !');
    }
}
