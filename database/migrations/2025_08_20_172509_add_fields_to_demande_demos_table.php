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
            $table->string('nombre_vehicules', 50)->nullable()->after('telephone');
            $table->string('societe', 100)->nullable()->after('nombre_vehicules');
            $table->string('jour_prefere', 50)->nullable()->after('societe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demande_demos', function (Blueprint $table) {
            $table->dropColumn(['nombre_vehicules', 'societe', 'jour_prefere']);
        });
    }
};
