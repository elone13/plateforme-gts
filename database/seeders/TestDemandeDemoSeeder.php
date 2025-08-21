<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DemandeDemo;

class TestDemandeDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer une demande de démo de test
        DemandeDemo::create([
            'date' => now()->format('Y-m-d'),
            'nom' => 'Test Client',
            'email' => 'test@example.com',
            'telephone' => '+221 77 123 45 67',
            'nombre_vehicules' => '1-5',
            'societe' => 'Test Company',
            'jour_prefere' => 'lundi',
            'message' => 'Ceci est un test de la fonctionnalité avec rendez-vous programmé',
            'statut' => 'planifiee',
            'source' => 'test',
            'priorite' => 'moyenne',
            'date_rdv' => now()->addDays(3)->format('Y-m-d'),
            'heure_rdv' => '14:00:00',
            'duree_rdv' => 60,
        ]);

        $this->command->info('Demande de démo de test avec rendez-vous programmé créée avec succès !');
    }
}
