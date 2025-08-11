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
        Schema::table('demande_demos', function (Blueprint $table) {
            $table->string('lien_reunion')->nullable()->after('heure_rdv');
            $table->text('instructions_rdv')->nullable()->after('lien_reunion');
            $table->integer('duree_rdv')->default(60)->after('instructions_rdv'); // en minutes
            $table->enum('type_rdv', ['en_ligne', 'en_presentiel', 'telephone'])->default('en_ligne')->after('duree_rdv');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demande_demos', function (Blueprint $table) {
            $table->dropColumn(['lien_reunion', 'instructions_rdv', 'duree_rdv', 'type_rdv']);
        });
    }
};
