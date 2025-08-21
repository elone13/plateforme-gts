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
        // Supprimer complètement la table existante
        Schema::dropIfExists('abonnements');
        
        // Recréer la table avec la nouvelle structure
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('service_id');
            $table->string('statut')->default('actif'); // actif, suspendu, résilié, expiré
            $table->date('date_debut');
            $table->date('date_fin');
            $table->decimal('prix_mensuel', 10, 2);
            $table->decimal('prix_total', 10, 2);
            $table->integer('duree_mois');
            $table->text('notes')->nullable();
            $table->date('date_renouvellement')->nullable();
            $table->boolean('renouvellement_automatique')->default(true);
            $table->timestamps();
            
            // Ajouter les contraintes de clés étrangères
            $table->foreign('client_id')->references('idclient')->on('clients')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonnements');
    }
};
