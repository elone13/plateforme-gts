<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'nom_entreprise' => 'TechSolutions SARL',
                'contact_principal' => 'Jean Dupont',
                'email' => 'jean.dupont@techsolutions.ci',
                'telephone' => '+225 27 22 45 67 89',
                'adresse' => '123 Avenue des Technologies, Abidjan',
                'secteur_activite' => 'Informatique',
                'notes' => 'Client intéressé par nos solutions de gestion. Premier contact lors du salon TechExpo 2024.',
                'statut' => 'prospect',
                'source' => 'salon',
                'derniere_interaction' => now()->subDays(5),
            ],
            [
                'nom_entreprise' => 'CommercePlus',
                'contact_principal' => 'Marie Konan',
                'email' => 'm.konan@commerceplus.ci',
                'telephone' => '+225 27 21 34 56 78',
                'adresse' => '456 Boulevard du Commerce, Yamoussoukro',
                'secteur_activite' => 'Commerce',
                'notes' => 'Client actif depuis 2 ans. Très satisfait de nos services.',
                'statut' => 'actif',
                'source' => 'recommandation',
                'derniere_interaction' => now()->subDays(2),
            ],
            [
                'nom_entreprise' => 'ServicesPro',
                'contact_principal' => 'Pierre Kouassi',
                'email' => 'p.kouassi@servicespro.ci',
                'telephone' => '+225 27 23 45 67 89',
                'adresse' => '789 Rue des Services, Bouaké',
                'secteur_activite' => 'Services',
                'notes' => 'Prospect rencontré lors d\'une prospection téléphonique. Intéressé par nos solutions.',
                'statut' => 'prospect',
                'source' => 'prospection',
                'derniere_interaction' => now()->subDays(10),
            ],
            [
                'nom_entreprise' => 'IndustrieModerne',
                'contact_principal' => 'Sophie Traoré',
                'email' => 's.traore@industriemoderne.ci',
                'telephone' => '+225 27 24 56 78 90',
                'adresse' => '321 Avenue Industrielle, San-Pédro',
                'secteur_activite' => 'Industrie',
                'notes' => 'Client inactif depuis 6 mois. À relancer.',
                'statut' => 'inactif',
                'source' => 'site_web',
                'derniere_interaction' => now()->subMonths(6),
            ],
            [
                'nom_entreprise' => 'StartupInnov',
                'contact_principal' => 'Alexandre Yao',
                'email' => 'a.yao@startupinnov.ci',
                'telephone' => '+225 27 25 67 89 01',
                'adresse' => '654 Rue de l\'Innovation, Korhogo',
                'secteur_activite' => 'Startup',
                'notes' => 'Nouvelle startup prometteuse. Premier contact via LinkedIn.',
                'statut' => 'prospect',
                'source' => 'reseau',
                'derniere_interaction' => now()->subDays(1),
            ],
        ];

        foreach ($clients as $clientData) {
            Client::create($clientData);
        }

        $this->command->info('Clients de test créés avec succès !');
    }
}
