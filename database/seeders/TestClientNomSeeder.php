<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class TestClientNomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un client de test avec le nouveau champ 'nom'
        Client::create([
            'nom' => 'Jean Dupont',
            'nom_entreprise' => 'Entreprise Test SARL',
            'email' => 'jean.dupont@test.com',
            'telephone' => '+221 77 123 45 67',
            'adresse' => '123 Rue Test, Dakar, Sénégal',
            'secteur_activite' => 'Informatique',
            'notes' => 'Client de test pour vérifier le champ nom',
            'statut' => 'prospect',
            'source' => 'test',
            'derniere_interaction' => now(),
        ]);

        // Créer un client sans entreprise (particulier)
        Client::create([
            'nom' => 'Marie Martin',
            'nom_entreprise' => null,
            'email' => 'marie.martin@test.com',
            'telephone' => '+221 76 987 65 43',
            'adresse' => '456 Avenue Test, Dakar, Sénégal',
            'secteur_activite' => 'Services',
            'notes' => 'Particulier de test',
            'statut' => 'prospect',
            'source' => 'test',
            'derniere_interaction' => now(),
        ]);

        echo "Clients de test créés avec succès !\n";
        echo "- Jean Dupont (avec entreprise)\n";
        echo "- Marie Martin (particulier)\n";
    }
}
