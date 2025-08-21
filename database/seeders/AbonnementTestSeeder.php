<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Abonnement;
use App\Models\Client;
use App\Models\Service;
use Carbon\Carbon;

class AbonnementTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer quelques clients et services existants
        $clients = Client::take(5)->get();
        $services = Service::take(3)->get();

        if ($clients->isEmpty() || $services->isEmpty()) {
            $this->command->info('Aucun client ou service trouvé. Créez d\'abord des clients et des services.');
            return;
        }

        $statuts = ['actif', 'suspendu', 'résilié', 'expiré'];
        $durees = [6, 12, 24, 36];

        foreach ($clients as $client) {
            foreach ($services as $service) {
                // Créer 1-2 abonnements par client
                $nombreAbonnements = rand(1, 2);
                
                for ($i = 0; $i < $nombreAbonnements; $i++) {
                    $duree = $durees[array_rand($durees)];
                    $dateDebut = Carbon::now()->subMonths(rand(1, 12));
                    $dateFin = $dateDebut->copy()->addMonths($duree);
                    $prixMensuel = rand(5000, 50000);
                    $prixTotal = $prixMensuel * $duree;
                    $statut = $statuts[array_rand($statuts)];

                    Abonnement::create([
                        'client_id' => $client->idclient,
                        'service_id' => $service->id,
                        'statut' => $statut,
                        'date_debut' => $dateDebut,
                        'date_fin' => $dateFin,
                        'prix_mensuel' => $prixMensuel,
                        'prix_total' => $prixTotal,
                        'duree_mois' => $duree,
                        'notes' => 'Abonnement de test créé par le seeder',
                        'renouvellement_automatique' => rand(0, 1),
                    ]);
                }
            }
        }

        $this->command->info('Abonnements de test créés avec succès !');
    }
}
