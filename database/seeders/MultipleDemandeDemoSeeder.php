<?php

namespace Database\Seeders;

use App\Models\DemandeDemo;
use Illuminate\Database\Seeder;

class MultipleDemandeDemoSeeder extends Seeder
{
    public function run(): void
    {
        $emails = [
            'test@example.com',
            'client1@example.com',
            'client2@example.com',
            'client3@example.com',
            'client4@example.com',
            'client5@example.com',
            'client6@example.com',
            'client7@example.com',
            'client8@example.com',
            'client9@example.com',
            'client10@example.com',
            'client11@example.com',
            'client12@example.com',
        ];

        $statuts = ['en_attente', 'acceptee', 'en_cours', 'terminee', 'planifiee', 'refusee'];
        $vehicules = ['1-5', '6-10', '11-20', '21-50', '50+'];
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
        $societes = ['Entreprise A', 'Société B', 'Compagnie C', 'Firme D', 'Groupe E', null];

        foreach ($emails as $index => $email) {
            $statut = $statuts[$index % count($statuts)];
            $vehicule = $vehicules[$index % count($vehicules)];
            $jour = $jours[$index % count($jours)];
            $societe = $societes[$index % count($societes)];
            
            $demande = DemandeDemo::create([
                'date' => now()->subDays(rand(1, 30))->format('Y-m-d'),
                'nom' => 'Client ' . ($index + 1),
                'email' => $email,
                'telephone' => '+221 77 ' . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT) . ' ' . str_pad(rand(10, 99), 2, '0', STR_PAD_LEFT) . ' ' . str_pad(rand(10, 99), 2, '0', STR_PAD_LEFT),
                'nombre_vehicules' => $vehicule,
                'societe' => $societe,
                'jour_prefere' => $jour,
                'message' => 'Ceci est une demande de démo de test numéro ' . ($index + 1) . '. Nous souhaitons découvrir votre solution.',
                'statut' => $statut,
                'source' => 'test',
                'priorite' => rand(0, 1) ? 'moyenne' : 'haute',
            ]);

            // Si le statut est 'planifiee', ajouter des détails de rendez-vous
            if ($statut === 'planifiee') {
                $demande->update([
                    'date_rdv' => now()->addDays(rand(1, 14))->format('Y-m-d'),
                    'heure_rdv' => sprintf('%02d:00:00', rand(9, 17)),
                    'duree_rdv' => rand(30, 120),
                    'type_rdv' => rand(0, 1) ? 'en_ligne' : 'en_presentiel',
                    'lien_reunion' => rand(0, 1) ? 'https://meet.google.com/test' . $index : null,
                    'instructions_rdv' => rand(0, 1) ? 'Préparez vos questions et assurez-vous d\'avoir une bonne connexion internet.' : null,
                    'commentaire_admin' => rand(0, 1) ? 'Client intéressé par notre solution. Rendez-vous confirmé.' : null,
                ]);
            }

            // Si le statut est 'refusee', ajouter une raison
            if ($statut === 'refusee') {
                $demande->update([
                    'raison_refus' => 'Budget insuffisant pour le moment. Contact à renouveler dans 6 mois.',
                ]);
            }

            // Si le statut est 'acceptee' ou 'en_cours', ajouter un commentaire
            if (in_array($statut, ['acceptee', 'en_cours'])) {
                $demande->update([
                    'commentaire_admin' => 'Client qualifié. Suivi en cours pour finaliser la vente.',
                ]);
            }
        }

        $this->command->info('12 demandes de démo de test créées avec succès !');
    }
}
