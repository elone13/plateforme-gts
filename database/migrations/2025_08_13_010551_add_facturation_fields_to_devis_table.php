<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('devis', function (Blueprint $table) {
            // Champs pour la facturation
            $table->string('numero_facture')->nullable()->after('reference');
            $table->date('date_facturation')->nullable()->after('date_validite');
            $table->date('date_echeance')->nullable()->after('date_facturation');
            $table->dateTime('date_paiement')->nullable()->after('date_echeance');
            $table->dateTime('date_annulation')->nullable()->after('date_paiement');
            $table->text('motif_annulation')->nullable()->after('date_annulation');
            $table->string('email_envoye_a')->nullable()->after('motif_annulation');
            $table->dateTime('date_envoi_email')->nullable()->after('email_envoye_a');
            $table->string('reference_commande')->nullable()->after('date_envoi_email');
            
            // Champs pour les calculs
            $table->decimal('total_ht', 10, 2)->default(0)->after('montant_total');
            $table->decimal('taux_tva', 5, 2)->default(0.20)->after('total_ht');
            $table->decimal('montant_tva', 10, 2)->default(0)->after('taux_tva');
            $table->decimal('total_ttc', 10, 2)->default(0)->after('montant_tva');
            $table->text('notes')->nullable()->after('total_ttc');
            
            // Modification du champ montant_total pour qu'il soit calculé
            $table->decimal('montant_total', 10, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->dropColumn([
                'numero_facture',
                'date_facturation',
                'date_echeance',
                'date_paiement',
                'date_annulation',
                'motif_annulation',
                'email_envoye_a',
                'date_envoi_email',
                'reference_commande',
                'total_ht',
                'taux_tva',
                'montant_tva',
                'total_ttc',
                'notes'
            ]);
        });
    }
};
