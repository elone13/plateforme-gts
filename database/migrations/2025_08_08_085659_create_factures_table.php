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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 255)->unique();
            $table->decimal('montant', 15, 2);
            $table->string('pdf_file', 255)->nullable();
            $table->foreignId('devis_id')->constrained()->onDelete('cascade');
            $table->enum('statut_paiement', ['en_attente', 'paye', 'en_retard', 'annule'])->default('en_attente');
            $table->date('date_echeance')->nullable();
            $table->date('date_paiement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
