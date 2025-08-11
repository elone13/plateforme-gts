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
        Schema::create('demande_demos', function (Blueprint $table) {
            $table->id();
            $table->string('date', 45);
            $table->string('nom', 45);
            $table->string('email', 45);
            $table->string('telephone', 45);
            $table->text('message')->nullable();
            $table->enum('statut', ['en_attente', 'acceptee', 'refusee', 'en_cours', 'terminee'])->default('en_attente');
            $table->text('commentaire_admin')->nullable();
            $table->date('date_rdv')->nullable();
            $table->time('heure_rdv')->nullable();
            $table->string('source', 50)->default('site_web');
            $table->enum('priorite', ['haute', 'moyenne', 'basse'])->default('moyenne');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_demos');
    }
};
