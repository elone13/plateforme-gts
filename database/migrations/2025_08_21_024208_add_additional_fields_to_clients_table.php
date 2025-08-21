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
            $table->string('taille_entreprise')->nullable()->after('secteur_activite');
            $table->string('nombre_vehicules')->nullable()->after('taille_entreprise');
            $table->string('budget_estime')->nullable()->after('nombre_vehicules');
            $table->boolean('newsletter')->default(false)->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['taille_entreprise', 'nombre_vehicules', 'budget_estime', 'newsletter']);
        });
    }
};
