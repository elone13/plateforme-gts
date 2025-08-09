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
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id('idabonnement');
            $table->string('date_debut', 45);
            $table->string('date_fin', 45);
            $table->foreignId('item_iditem')->constrained('items', 'iditem')->onDelete('cascade');
            $table->enum('statut', ['actif', 'expire', 'suspendu', 'annule'])->default('actif');
            $table->decimal('montant_mensuel', 15, 2)->nullable();
            $table->timestamps();
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
