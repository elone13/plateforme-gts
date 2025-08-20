<?php

namespace App\Http\Controllers\Commercial;

use App\Http\Controllers\Controller;
use App\Models\Devis;
use App\Models\Client;
use App\Models\Service;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevisController extends Controller
{
    public function index()
    {
        // La logique est maintenant gérée par le composant Livewire DevisList
        return view('commercial.devis.index');
    }

    public function show(Devis $devis)
    {
        $devis->load(['client', 'items.service']);
        
        // Générer automatiquement le PDF si c'est un nouveau devis
        if ($devis->statut === 'en_attente' && !file_exists(storage_path("app/public/devis/{$devis->reference}.pdf"))) {
            $this->generatePDF($devis);
        }
        
        return view('commercial.devis.show', compact('devis'));
    }
    
    /**
     * Générer le PDF du devis
     */
    public function generatePDF(Devis $devis)
    {
        try {
            \Log::info('Génération PDF pour devis: ' . $devis->reference);
            \Log::info('Vue utilisée: commercial.devis.pdf');
            
            $devis->load(['client', 'items.service']);
            
            // Générer le logo en base64
            $logoBase64 = $this->getLogoBase64();
            
            // Utiliser la vue originale qui marchait
            $html = \Illuminate\Support\Facades\View::make('commercial.devis.pdf', compact('devis', 'logoBase64'))->render();
            \Log::info('Contenu HTML généré: ' . substr($html, 0, 200) . '...');
            
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
            $pdf->setPaper('A4');
            $pdf->setOption('isRemoteEnabled', true);
            $pdf->setOption('isHtml5ParserEnabled', true);
            
            $directory = storage_path('app/public/devis');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            $pdfPath = $directory . "/{$devis->reference}.pdf";
            $pdf->save($pdfPath);
            
            \Log::info('PDF généré avec succès: ' . $pdfPath);
            \Log::info('Taille du PDF: ' . number_format(filesize($pdfPath) / 1024, 2) . ' KB');
            
            return $pdfPath;
            
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la génération du PDF: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return false;
        }
    }
    
    /**
     * Télécharger le PDF du devis
     */
    public function download(Devis $devis)
    {
        try {
            // Vérifier si le fichier existe, sinon le générer
            $filePath = storage_path("app/public/devis/{$devis->reference}.pdf");
            if (!file_exists($filePath)) {
                $this->generatePDF($devis);
            }
            
            // Vérifier à nouveau si le fichier a été généré
            if (file_exists($filePath)) {
                return response()->download($filePath, "Devis_{$devis->reference}.pdf");
            } else {
                return back()->withErrors(['error' => 'Impossible de générer le fichier']);
            }
        } catch (\Exception $e) {
            \Log::error('Erreur lors du téléchargement: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Erreur lors du téléchargement : ' . $e->getMessage()]);
        }
    }

    public function preview(Devis $devis)
    {
        $devis->load(['client', 'items.service']);
        return view('commercial.devis.preview', compact('devis'));
    }
    
    /**
     * Générer le logo en base64 pour le PDF
     */
    private function getLogoBase64()
    {
        try {
            $logoPath = public_path('images/logo.png');
            if (file_exists($logoPath)) {
                return base64_encode(file_get_contents($logoPath));
            }
            return null;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la lecture du logo: ' . $e->getMessage());
            return null;
        }
    }

    public function create()
    {
        // La création est maintenant gérée par le composant Livewire CreateDevisModal
        return redirect()->route('commercial.devis.index');
    }

    public function edit(Devis $devis)
    {
        $clients = Client::orderBy('nom_entreprise')->get();
        $services = Service::with('items')->get();
        return view('commercial.devis.edit', compact('devis', 'clients', 'services'));
    }

    public function update(Request $request, Devis $devis)
    {
        $request->validate([
            'client_idclient' => 'required|exists:clients,idclient',
            'date_validite' => 'required|date|after:today',
            'conditions' => 'nullable|string',
            'total_ht' => 'required|numeric|min:0',
            'taux_tva' => 'required|numeric|min:0|max:1',
            'montant_tva' => 'required|numeric|min:0',
            'total_ttc' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $devis->update([
                'client_idclient' => $request->client_idclient,
                'date_validite' => $request->date_validite,
                'conditions' => $request->conditions,
                'total_ht' => $request->total_ht,
                'taux_tva' => $request->taux_tva,
                'montant_tva' => $request->montant_tva,
                'total_ttc' => $request->total_ttc,
                'montant_total' => $request->total_ttc,
            ]);

            DB::commit();

            return redirect()->route('commercial.devis.show', $devis)
                           ->with('success', 'Devis mis à jour avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors de la mise à jour : ' . $e->getMessage()]);
        }
    }

    public function destroy(Devis $devis)
    {
        try {
            DB::beginTransaction();

            // Supprimer les items du devis
            $devis->items()->delete();
            
            // Supprimer le devis
            $devis->delete();

            DB::commit();

            return redirect()->route('commercial.devis.index')
                           ->with('success', 'Devis supprimé avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors de la suppression : ' . $e->getMessage()]);
        }
    }
}
