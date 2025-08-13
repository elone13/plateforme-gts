<?php

use App\Models\Devis;
use Illuminate\Support\Facades\Route;

Route::get('/temp/create-facture', function () {
    // Récupérer le devis accepté
    $devis = Devis::find(6);
    
    if (!$devis) {
        return 'Devis non trouvé';
    }
    
    // Mettre à jour le statut pour en faire une facture
    $devis->update([
        'statut' => 'facture',
        'numero_facture' => 'FACT-' . now()->format('Ymd') . '-TEST',
        'date_facturation' => now(),
        'date_echeance' => now()->addDays(30)
    ]);
    
    return redirect()->route('commercial.factures.show', $devis->id);
})->middleware(['auth']);
