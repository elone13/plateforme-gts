<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Item;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Service 1: Balises GPS
        $service1 = Service::create([
            'nom' => 'Balises GPS Haute Précision',
            'description' => 'Système de géolocalisation en temps réel avec une précision de ±3 mètres. Balises résistantes IP67, autonomie jusqu\'à 5 ans, parfaites pour le suivi de flotte et la sécurité des véhicules.',
            'image' => null,
        ]);

        // Items pour le service Balises GPS
        Item::create([
            'nom' => 'Balise GPS Pro',
            'description' => 'Balise GPS professionnelle avec autonomie 5 ans',
            'prix' => 299.99,
            'quantite' => 1,
            'statut' => 'actif',
            'service_id' => $service1->id,
        ]);

        Item::create([
            'nom' => 'Antenne GPS Externe',
            'description' => 'Antenne GPS externe pour signal optimal',
            'prix' => 89.99,
            'quantite' => 1,
            'statut' => 'actif',
            'service_id' => $service1->id,
        ]);

        // Service 2: Système Antidémarrage
        $service2 = Service::create([
            'nom' => 'Système Antidémarrage Intelligent',
            'description' => 'Contrôle à distance de vos véhicules avec blocage instantané. Sécurisez votre flotte depuis votre smartphone avec notre solution d\'antidémarrage avancée.',
            'image' => null,
        ]);

        // Items pour le service Antidémarrage
        Item::create([
            'nom' => 'Module Antidémarrage',
            'description' => 'Module de contrôle antidémarrage à distance',
            'prix' => 199.99,
            'quantite' => 1,
            'statut' => 'actif',
            'service_id' => $service2->id,
        ]);

        Item::create([
            'nom' => 'Application Mobile',
            'description' => 'Application mobile pour contrôle à distance',
            'prix' => 49.99,
            'quantite' => 1,
            'statut' => 'actif',
            'service_id' => $service2->id,
        ]);

        // Service 3: Éco-conduite
        $service3 = Service::create([
            'nom' => 'Solution Éco-conduite',
            'description' => 'Optimisez la consommation de carburant de votre flotte avec notre système de lecture CAN bus. Réduisez vos coûts de 15-20% et formez vos conducteurs.',
            'image' => null,
        ]);

        // Items pour le service Éco-conduite
        Item::create([
            'nom' => 'Lecteur CAN Bus',
            'description' => 'Lecteur CAN bus pour analyse des données véhicule',
            'prix' => 159.99,
            'quantite' => 1,
            'statut' => 'actif',
            'service_id' => $service3->id,
        ]);

        Item::create([
            'nom' => 'Module Formation',
            'description' => 'Module de formation à l\'éco-conduite',
            'prix' => 79.99,
            'quantite' => 1,
            'statut' => 'actif',
            'service_id' => $service3->id,
        ]);

        // Service 4: Gestion Carburant
        $service4 = Service::create([
            'nom' => 'Gestion Intelligente du Carburant',
            'description' => 'Surveillez et optimisez la consommation de carburant de votre flotte. Détection des anomalies, prévention des vols et rapports détaillés pour une gestion optimale.',
            'image' => null,
        ]);

        // Items pour le service Gestion Carburant
        Item::create([
            'nom' => 'Capteur Niveau Carburant',
            'description' => 'Capteur de niveau de carburant haute précision',
            'prix' => 129.99,
            'quantite' => 1,
            'statut' => 'actif',
            'service_id' => $service4->id,
        ]);

        Item::create([
            'nom' => 'Système de Rapports',
            'description' => 'Système de génération de rapports automatiques',
            'prix' => 99.99,
            'quantite' => 1,
            'statut' => 'actif',
            'service_id' => $service4->id,
        ]);

        $this->command->info('Services et items créés avec succès !');
    }
}
