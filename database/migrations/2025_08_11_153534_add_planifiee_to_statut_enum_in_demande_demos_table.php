<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modifier l'enum pour inclure 'planifiee'
        DB::statement("ALTER TABLE demande_demos MODIFY COLUMN statut ENUM('en_attente', 'acceptee', 'planifiee', 'en_cours', 'refusee', 'terminee') NOT NULL DEFAULT 'en_attente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remettre l'enum original
        DB::statement("ALTER TABLE demande_demos MODIFY COLUMN statut ENUM('en_attente', 'acceptee', 'refusee', 'en_cours', 'terminee') NOT NULL DEFAULT 'en_attente'");
    }
};
