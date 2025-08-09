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
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 255)->unique();
            $table->date('date');
            // Temporary column; FK will be added in a later migration after clients table exists
            $table->unsignedBigInteger('client_idclient');
            $table->enum('statut', ['brouillon', 'envoye', 'accepte', 'refuse', 'expire'])->default('brouillon');
            $table->decimal('montant_total', 15, 2)->default(0);
            $table->text('conditions')->nullable();
            $table->date('date_validite')->nullable();
            $table->timestamps();

            $table->index('client_idclient');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};
