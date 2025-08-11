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
            $table->text('raison_refus')->nullable()->after('commentaire_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demande_demos', function (Blueprint $table) {
            $table->dropColumn('raison_refus');
        });
    }
};
