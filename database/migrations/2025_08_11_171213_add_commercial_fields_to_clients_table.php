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
        Schema::table('clients', function (Blueprint $table) {
            // Nouveaux champs pour la gestion commerciale
            $table->string('nom_entreprise')->nullable()->after('idclient');
            $table->string('contact_principal')->nullable()->after('nom_entreprise');
            $table->string('email')->unique()->nullable()->after('contact_principal');
            $table->string('secteur_activite')->nullable()->after('telephone');
            $table->text('notes')->nullable()->after('secteur_activite');
            $table->enum('statut', ['prospect', 'actif', 'inactif', 'archive'])->default('prospect')->after('notes');
            $table->string('source')->nullable()->after('statut');
            $table->timestamp('derniere_interaction')->nullable()->after('source');
            
            // Rendre user_id nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Renommer le champ existant 'entreprise' en 'nom_entreprise' si nécessaire
            if (Schema::hasColumn('clients', 'entreprise')) {
                $table->renameColumn('entreprise', 'nom_entreprise_old');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'nom_entreprise',
                'contact_principal',
                'email',
                'secteur_activite',
                'notes',
                'statut',
                'source',
                'derniere_interaction'
            ]);
            
            // Restaurer l'ancien champ si nécessaire
            if (Schema::hasColumn('clients', 'nom_entreprise_old')) {
                $table->renameColumn('nom_entreprise_old', 'entreprise');
            }
        });
    }
};
