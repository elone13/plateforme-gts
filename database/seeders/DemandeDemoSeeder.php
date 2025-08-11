<?php

namespace Database\Seeders;

use App\Models\DemandeDemo;
use Illuminate\Database\Seeder;

class DemandeDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $demandes = [
            [
                'nom' => 'Jean Dupont',
                'email' => 'jean.dupont@entreprise.com',
                'telephone' => '+33 1 23 45 67 89',
                'message' => 'Bonjour, nous sommes intéressés par votre solution de géolocalisation pour notre flotte de 50 véhicules. Pouvez-vous nous proposer une démonstration ?',
                'statut' => 'en_attente',
                'source' => 'site_web',
                'priorite' => 'haute',
            ],
            [
                'nom' => 'Marie Martin',
                'email' => 'm.martin@logistique.fr',
                'telephone' => '+33 1 98 76 54 32',
                'message' => 'Nous cherchons une solution pour optimiser nos livraisons. Votre système semble correspondre à nos besoins.',
                'statut' => 'acceptee',
                'source' => 'site_web',
                'priorite' => 'moyenne',
            ],
            [
                'nom' => 'Pierre Durand',
                'email' => 'p.durand@transport-sa.com',
                'telephone' => '+33 1 45 67 89 12',
                'message' => 'Nous avons une flotte de transport de voyageurs et souhaitons améliorer notre suivi en temps réel.',
                'statut' => 'en_cours',
                'source' => 'site_web',
                'priorite' => 'haute',
            ],
            [
                'nom' => 'Sophie Bernard',
                'email' => 's.bernard@urgences.fr',
                'telephone' => '+33 1 11 22 33 44',
                'message' => 'Service d\'urgence médicale - nous avons besoin d\'une solution fiable et rapide pour nos ambulances.',
                'statut' => 'en_attente',
                'source' => 'site_web',
                'priorite' => 'haute',
            ],
            [
                'nom' => 'Lucas Petit',
                'email' => 'l.petit@particulier.fr',
                'telephone' => '+33 6 12 34 56 78',
                'message' => 'Je souhaite sécuriser mon véhicule personnel. Votre solution peut-elle convenir ?',
                'statut' => 'en_attente',
                'source' => 'site_web',
                'priorite' => 'basse',
            ],
        ];

        foreach ($demandes as $demande) {
            DemandeDemo::create([
                'date' => now()->subDays(rand(1, 30))->format('Y-m-d'),
                'nom' => $demande['nom'],
                'email' => $demande['email'],
                'telephone' => $demande['telephone'],
                'message' => $demande['message'],
                'statut' => $demande['statut'],
                'source' => $demande['source'],
                'priorite' => $demande['priorite'],
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
