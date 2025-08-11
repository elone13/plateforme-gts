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
        // Modifier la colonne role pour inclure les nouveaux rôles
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('client', 'admin', 'manager', 'commercial') DEFAULT 'client'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revenir aux rôles précédents
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('client', 'admin') DEFAULT 'client'");
    }
};
