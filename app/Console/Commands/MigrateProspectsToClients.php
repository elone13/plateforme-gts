<?php

namespace App\Console\Commands;

use App\Models\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MigrateProspectsToClients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clients:migrate-prospects {--dry-run : Afficher seulement ce qui serait fait sans faire de changements}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrer automatiquement les prospects vers le statut client si ils ont des paiements validés';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        if ($isDryRun) {
            $this->info('🔍 Mode simulation - Aucun changement ne sera effectué');
        }

        $this->info('🚀 Début de la migration des prospects vers clients...');

        // Récupérer tous les prospects qui ont des paiements validés
        $prospectsReady = Client::readyToBecomeClient()->get();
        
        if ($prospectsReady->isEmpty()) {
            $this->info('✅ Aucun prospect prêt à devenir client trouvé.');
            return 0;
        }

        $this->info("📊 {$prospectsReady->count()} prospect(s) prêt(s) à devenir client(s) :");

        $tableData = [];
        foreach ($prospectsReady as $prospect) {
            $firstPayment = $prospect->getFirstValidatedPayment();
            $nom = $prospect->nom_entreprise ? $prospect->nom_entreprise : $prospect->nom;
            $tableData[] = [
                $nom,
                $prospect->email,
                $firstPayment ? $firstPayment->date_paiement->format('d/m/Y') : 'N/A',
                $firstPayment ? $firstPayment->reference : 'N/A'
            ];
        }

        $this->table(
            ['Entreprise/Contact', 'Email', 'Date 1er paiement', 'Réf. facture'],
            $tableData
        );

        if ($isDryRun) {
            $this->info('🔍 Simulation terminée. Utilisez la commande sans --dry-run pour effectuer la migration.');
            return 0;
        }

        // Demander confirmation
        if (!$this->confirm('Voulez-vous procéder à la migration de ces prospects vers le statut client ?')) {
            $this->info('❌ Migration annulée.');
            return 0;
        }

        $this->info('🔄 Migration en cours...');

        $migratedCount = 0;
        $errors = [];

        foreach ($prospectsReady as $prospect) {
            try {
                $oldStatus = $prospect->statut;
                $prospect->updateStatusBasedOnPayment();
                
                // Vérifier si le statut a changé
                if ($prospect->statut !== $oldStatus) {
                    $migratedCount++;
                    $nom = $prospect->nom_entreprise ? $prospect->nom_entreprise : $prospect->nom;
                    $this->line("✅ {$nom} : {$oldStatus} → {$prospect->statut}");
                    
                    // Log de la migration
                    Log::info("Prospect migré vers client", [
                        'client_id' => $prospect->idclient,
                        'email' => $prospect->email,
                        'ancien_statut' => $oldStatus,
                        'nouveau_statut' => $prospect->statut,
                        'date_migration' => now()
                    ]);
                }
            } catch (\Exception $e) {
                $nom = $prospect->nom_entreprise ? $prospect->nom_entreprise : $prospect->nom;
                $errors[] = [
                    'client' => $nom,
                    'error' => $e->getMessage()
                ];
                $this->error("❌ Erreur lors de la migration de {$nom} : {$e->getMessage()}");
            }
        }

        // Résumé
        $this->newLine();
        $this->info("🎉 Migration terminée !");
        $this->info("✅ {$migratedCount} prospect(s) migré(s) avec succès");
        
        if (!empty($errors)) {
            $this->error("❌ " . count($errors) . " erreur(s) rencontrée(s)");
            foreach ($errors as $error) {
                $this->error("   - {$error['client']} : {$error['error']}");
            }
        }

        return 0;
    }
}
