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
        Schema::create('creneaux_disponibles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commercial_id');
            $table->date('date');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->enum('statut', ['disponible', 'reserve', 'indisponible'])->default('disponible');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Clés étrangères
            $table->foreign('commercial_id')->references('idadministrateur')->on('administrateurs')->onDelete('cascade');
            
            // Index pour améliorer les performances
            $table->index(['commercial_id', 'date']);
            $table->index(['date', 'heure_debut']);
            
            // Contrainte pour éviter les créneaux qui se chevauchent pour le même commercial
            $table->unique(['commercial_id', 'date', 'heure_debut'], 'unique_creneau_commercial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creneaux_disponibles');
    }
};
