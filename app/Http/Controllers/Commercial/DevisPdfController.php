<?php

namespace App\Http\Controllers\Commercial;

use App\Http\Controllers\Controller;
use App\Models\Devis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DevisPdfController extends Controller
{
    /**
     * Générer le PDF d'un devis avec une approche alternative
     */
    public function generatePDF(Devis $devis)
    {
        try {
            \Log::info('Génération PDF alternative pour devis: ' . $devis->reference);
            
            // Charger les relations nécessaires
            $devis->load(['client', 'items.service']);
            
            // Utiliser la vue ultra-simple qui fonctionne
            $view = View::make('commercial.devis.pdf-ultra-simple', compact('devis'));
            $html = $view->render();
            
            \Log::info('Vue ultra-simple rendue avec succès: ' . number_format(strlen($html) / 1024, 2) . ' KB');
            
            // Pour l'instant, retourner le HTML directement
            // Cela nous permettra de voir le contenu et de tester une solution PDF plus tard
            return response($html)
                ->header('Content-Type', 'text/html')
                ->header('Content-Disposition', 'inline; filename="devis-' . $devis->reference . '.html"');
                
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la génération PDF alternative: ' . $e->getMessage());
            return response('Erreur lors de la génération du PDF', 500);
        }
    }
    
    /**
     * Afficher le devis en HTML (pour test)
     */
    public function showHTML(Devis $devis)
    {
        try {
            $devis->load(['client', 'items.service']);
            
            return view('commercial.devis.pdf-ultra-simple', compact('devis'));
            
        } catch (\Exception $e) {
            return response('Erreur lors du chargement du devis', 500);
        }
    }
    
    /**
     * Télécharger le devis en HTML (solution temporaire)
     */
    public function downloadHTML(Devis $devis)
    {
        try {
            $devis->load(['client', 'items.service']);
            
            $view = View::make('commercial.devis.pdf-ultra-simple', compact('devis'));
            $html = $view->render();
            
            return response($html)
                ->header('Content-Type', 'text/html')
                ->header('Content-Disposition', 'attachment; filename="devis-' . $devis->reference . '.html"');
                
        } catch (\Exception $e) {
            return response('Erreur lors du téléchargement', 500);
        }
    }
}
