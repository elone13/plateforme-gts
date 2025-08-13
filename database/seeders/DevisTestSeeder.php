<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Devis;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DevisTestSeeder extends Seeder
{
    public function run()
    {
        // Vérifier s'il y a déjà des devis de test
        if (Devis::where('reference', 'like', 'DEV%TEST%')->exists()) {
            $this->command->info('Des devis de test existent déjà.');
            return;
        }

        // Désactiver temporairement les contraintes de clé étrangère
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Créer un client de test
        $client = new Client();
        $client->idclient = 9999; // ID fixe pour le test
        $client->nom_entreprise = 'Entreprise de Test';
        $client->contact_principal = 'Jean Dupont';
        $client->email = 'client@test.com';
        $client->telephone = '0123456789';
        $client->adresse = '123 Rue de Test, 75000 Paris, France';
        $client->secteur_activite = 'Informatique';
        $client->statut = 'actif';
        
        try {
            $client->save();
            $this->command->info('Client de test créé avec succès. ID: ' . $client->idclient);
        } catch (\Exception $e) {
            $this->command->warn('Le client de test existe peut-être déjà. Erreur: ' . $e->getMessage());
            $client = Client::where('email', 'client@test.com')->first();
            if (!$client) {
                $this->command->error('Impossible de créer ou de récupérer le client de test.');
                return;
            }
        }

        // Créer un devis accepté avec les champs minimaux requis
        $devis = new Devis();
        $devis->reference = 'DEV' . date('Ymd') . 'TEST1';
        $devis->date = now();
        $devis->client_idclient = $client->idclient; // Utiliser idclient au lieu de id
        $devis->statut = 'accepte';
        $devis->montant_total = 1200.00;
        $devis->conditions = 'Paiement à 30 jours';
        $devis->date_validite = now()->addDays(30);
        
        // Champs ajoutés par la migration
        $devis->total_ht = 1000.00;
        $devis->taux_tva = 0.20;
        $devis->montant_tva = 200.00;
        $devis->total_ttc = 1200.00;
        
        try {
            $devis->save();
            $this->command->info('Devis de test créé avec succès. ID: ' . $devis->id);
        } catch (\Exception $e) {
            $this->command->error('Erreur lors de la création du devis de test: ' . $e->getMessage());
        }
        
        // Réactiver les contraintes de clé étrangère
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
