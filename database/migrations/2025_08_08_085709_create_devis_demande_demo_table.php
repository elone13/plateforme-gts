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
        Schema::create('devis_demande_demo', function (Blueprint $table) {
            $table->foreignId('devis_id')->constrained()->onDelete('cascade');
            $table->foreignId('demande_demo_id')->constrained('demande_demos')->onDelete('cascade');
            $table->primary(['devis_id', 'demande_demo_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis_demande_demo');
    }
};
