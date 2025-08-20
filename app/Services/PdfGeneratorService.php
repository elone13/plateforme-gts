<?php

namespace App\Services;

use FPDF;

class PdfGeneratorService
{
    /**
     * Générer un PDF avec la colonne durée visible
     */
    public function generateSimplePdf($devis)
    {
        try {
            // Créer le contenu du PDF
            $content = $this->generatePdfContent($devis);
            
            // Sauvegarder en fichier texte d'abord
            $directory = storage_path('app/public/devis');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            $txtPath = $directory . "/{$devis->reference}.txt";
            file_put_contents($txtPath, $content);
            
            // Maintenant essayer de créer un vrai PDF avec FPDF
            $pdfPath = $directory . "/{$devis->reference}.pdf";
            $this->createPdfWithFpdf($devis, $pdfPath);
            
            // Retourner le chemin du PDF s'il existe, sinon le fichier texte
            if (file_exists($pdfPath)) {
                return $pdfPath;
            } else {
                return $txtPath;
            }
            
        } catch (\Exception $e) {
            \Log::error('Erreur génération PDF: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Créer un PDF avec FPDF
     */
    private function createPdfWithFpdf($devis, $pdfPath)
    {
        try {
            // Créer une nouvelle instance FPDF
            $pdf = new FPDF();
            $pdf->AddPage();
            
            // Couleurs personnalisées
            $pdf->SetFillColor(41, 128, 185); // Bleu professionnel
            $pdf->SetTextColor(44, 62, 80);   // Gris foncé
            $pdf->SetDrawColor(189, 195, 199); // Gris clair
            
            // En-tête avec design moderne
            $pdf->SetFont('Arial', 'B', 24);
            $pdf->Cell(0, 15, 'GTS AFRIQUE', 0, 1, 'C');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 5, 'Plateforme de gestion des services', 0, 1, 'C');
            
            // Ligne de séparation
            $pdf->SetDrawColor(41, 128, 185);
            $pdf->SetLineWidth(0.5);
            $pdf->Line(20, 35, 190, 35);
            
            // Titre du devis
            $pdf->SetFont('Arial', 'B', 18);
            $pdf->SetTextColor(41, 128, 185);
            $pdf->Cell(0, 15, 'DEVIS ' . $devis->reference, 0, 1, 'C');
            $pdf->Ln(5);
            
            // Informations client dans un encadré élégant
            $pdf->SetFillColor(236, 240, 241);
            $pdf->SetDrawColor(189, 195, 199);
            $pdf->SetLineWidth(0.3);
            $pdf->Rect(20, 55, 170, 25, 'DF');
            
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetTextColor(44, 62, 80);
            $pdf->Cell(0, 8, 'INFORMATIONS CLIENT', 0, 1, 'C');
            
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetTextColor(52, 73, 94);
            $pdf->Cell(40, 6, 'Client:', 0, 0);
            $pdf->Cell(0, 6, ($devis->client->nom_entreprise ?? $devis->client->nom ?? 'N/A'), 0, 1);
            $pdf->Cell(40, 6, 'Date:', 0, 0);
            $pdf->Cell(0, 6, $devis->date->format('d/m/Y'), 0, 1);
            $pdf->Cell(40, 6, 'Validité:', 0, 0);
            $pdf->Cell(0, 6, $devis->date_validite->format('d/m/Y'), 0, 1);
            
            $pdf->Ln(10);
            
            // Tableau des prestations avec design moderne
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->SetTextColor(41, 128, 185);
            $pdf->Cell(0, 10, 'TABLEAU DES PRESTATIONS', 0, 1, 'C');
            $pdf->Ln(5);
            
            // En-têtes du tableau avec style moderne
            $pdf->SetFillColor(41, 128, 185);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetLineWidth(0.3);
            
            // En-têtes avec coins arrondis simulés
            $pdf->Cell(32, 8, 'Service', 1, 0, 'C', true);
            $pdf->Cell(42, 8, 'Designation', 1, 0, 'C', true);
            $pdf->Cell(18, 8, 'Qte', 1, 0, 'C', true);
            $pdf->Cell(23, 8, 'DUREE', 1, 0, 'C', true);
            $pdf->Cell(28, 8, 'Prix unit.', 1, 0, 'C', true);
            $pdf->Cell(28, 8, 'Total HT', 1, 1, 'C', true);
            
            // Données du tableau avec alternance de couleurs
            $pdf->SetTextColor(44, 62, 80);
            $pdf->SetFont('Arial', '', 8);
            $totalHT = 0;
            $totalDuree = 0;
            $row = 0;
            
            foreach ($devis->items as $item) {
                $duree = $item->duree_mois ?? 12;
                $totalItem = $item->prix * $item->quantite * $duree;
                $totalHT += $totalItem;
                $totalDuree += $duree;
                
                // Alternance de couleurs pour les lignes
                $fillColor = ($row % 2 == 0) ? array(248, 249, 250) : array(255, 255, 255);
                $pdf->SetFillColor($fillColor[0], $fillColor[1], $fillColor[2]);
                
                $pdf->Cell(32, 7, substr($item->service->nom ?? 'Service', 0, 14), 1, 0, 'L', true);
                $pdf->Cell(42, 7, substr($item->nom, 0, 18), 1, 0, 'L', true);
                $pdf->Cell(18, 7, $item->quantite, 1, 0, 'C', true);
                $pdf->Cell(23, 7, $duree . ' mois', 1, 0, 'C', true);
                $pdf->Cell(28, 7, number_format($item->prix, 0, ',', ' ') . ' FCFA', 1, 0, 'R', true);
                $pdf->Cell(28, 7, number_format($totalItem, 0, ',', ' ') . ' FCFA', 1, 1, 'R', true);
                $row++;
            }
            
            // Totaux avec style distinctif
            $pdf->SetFillColor(52, 73, 94);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 9);
            
            $pdf->Cell(115, 8, 'TOTAL HT', 1, 0, 'R', true);
            $pdf->Cell(28, 8, number_format($totalHT, 0, ',', ' ') . ' FCFA', 1, 1, 'R', true);
            
            // TVA
            $montantTVA = $totalHT * ($devis->taux_tva ?? 0.18);
            $pdf->Cell(115, 8, 'TVA (18%)', 1, 0, 'R', true);
            $pdf->Cell(28, 8, number_format($montantTVA, 0, ',', ' ') . ' FCFA', 1, 1, 'R', true);
            
            // Total TTC avec couleur d'accent
            $pdf->SetFillColor(231, 76, 60);
            $pdf->SetFont('Arial', 'B', 10);
            $totalTTC = $totalHT + $montantTVA;
            $pdf->Cell(115, 9, 'TOTAL TTC', 1, 0, 'R', true);
            $pdf->Cell(28, 9, number_format($totalTTC, 0, ',', ' ') . ' FCFA', 1, 1, 'R', true);
            
            $pdf->Ln(15);
            
            // Section abonnement avec design moderne
            $pdf->SetFillColor(46, 204, 113);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 8, 'INFORMATIONS D\'ABONNEMENT', 0, 1, 'C', true);
            
            $pdf->SetFillColor(236, 240, 241);
            $pdf->SetTextColor(44, 62, 80);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 6, 'Durée totale: ' . $totalDuree . ' mois', 0, 1, 'L');
            $pdf->Cell(0, 6, 'Durée d\'engagement: ' . $totalDuree . ' mois minimum', 0, 1, 'L');
            $pdf->Cell(0, 6, 'Périodicité: Facturation mensuelle', 0, 1, 'L');
            $pdf->Ln(5);
            
            // Conditions avec icônes simulées
            $pdf->SetFillColor(155, 89, 182);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 8, 'CONDITIONS D\'ABONNEMENT', 0, 1, 'C', true);
            
            $pdf->SetFillColor(248, 249, 250);
            $pdf->SetTextColor(44, 62, 80);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 6, '• Durée d\'engagement: ' . $totalDuree . ' mois minimum', 0, 1, 'L');
            $pdf->Cell(0, 6, '• Périodicité: Facturation mensuelle', 0, 1, 'L');
            $pdf->Cell(0, 6, '• Paiement: À réception de facture', 0, 1, 'L');
            $pdf->Cell(0, 6, '• Validité: 30 jours', 0, 1, 'L');
            
            // Pied de page élégant
            $pdf->Ln(20);
            $pdf->SetDrawColor(41, 128, 185);
            $pdf->SetLineWidth(0.5);
            $pdf->Line(20, 250, 190, 250);
            
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetTextColor(127, 140, 141);
            $pdf->Cell(0, 5, 'Ce devis a été généré le ' . now()->format('d/m/Y à H:i'), 0, 1, 'C');
            $pdf->Cell(0, 5, 'GTS AFRIQUE - Plateforme de gestion des services', 0, 1, 'C');
            
            // Sauvegarder le PDF
            $pdf->Output('F', $pdfPath);
            
            return file_exists($pdfPath);
            
        } catch (\Exception $e) {
            \Log::error('Erreur création PDF FPDF: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Générer le contenu du PDF
     */
    private function generatePdfContent($devis)
    {
        $content = "";
        
        // En-tête
        $content .= "GTS AFRIQUE\n";
        $content .= "DEVIS {$devis->reference}\n";
        $content .= str_repeat("=", 50) . "\n\n";
        
        // Informations client
        $content .= "CLIENT: " . ($devis->client->nom_entreprise ?? $devis->client->nom ?? 'N/A') . "\n";
        $content .= "DATE: " . $devis->date->format('d/m/Y') . "\n";
        $content .= "VALIDITE: " . $devis->date_validite->format('d/m/Y') . "\n\n";
        
        // Tableau des prestations
        $content .= "TABLEAU DES PRESTATIONS:\n";
        $content .= str_repeat("-", 80) . "\n";
        $content .= sprintf("%-20s %-25s %-8s %-15s %-15s %-15s\n", 
            "SERVICE", "DESIGNATION", "QTE", "DUREE (MOIS)", "PRIX UNIT.", "TOTAL HT");
        $content .= str_repeat("-", 80) . "\n";
        
        $totalHT = 0;
        $totalDuree = 0;
        
        foreach ($devis->items as $item) {
            $duree = $item->duree_mois ?? 12;
            $totalItem = $item->prix * $item->quantite * $duree;
            $totalHT += $totalItem;
            $totalDuree += $duree;
            
            $content .= sprintf("%-20s %-25s %-8s %-15s %-15s %-15s\n",
                substr($item->service->nom ?? 'Service', 0, 19),
                substr($item->nom, 0, 24),
                $item->quantite,
                $duree . " mois",
                number_format($item->prix, 0, ',', ' ') . " FCFA",
                number_format($totalItem, 0, ',', ' ') . " FCFA"
            );
        }
        
        $content .= str_repeat("-", 80) . "\n";
        $content .= sprintf("%-68s %-15s\n", "TOTAL HT", number_format($totalHT, 0, ',', ' ') . " FCFA");
        
        // TVA
        $montantTVA = $totalHT * ($devis->taux_tva ?? 0.18);
        $content .= sprintf("%-68s %-15s\n", "TVA (18%)", number_format($montantTVA, 0, ',', ' ') . " FCFA");
        
        // Total TTC
        $totalTTC = $totalHT + $montantTVA;
        $content .= sprintf("%-68s %-15s\n", "TOTAL TTC", number_format($totalTTC, 0, ',', ' ') . " FCFA");
        
        $content .= "\n";
        
        // Informations d'abonnement
        $content .= "INFORMATIONS D'ABONNEMENT:\n";
        $content .= str_repeat("-", 30) . "\n";
        $content .= "Durée totale: {$totalDuree} mois\n";
        $content .= "Durée d'engagement: {$totalDuree} mois minimum\n";
        $content .= "Périodicité: Facturation mensuelle\n\n";
        
        // Conditions
        $content .= "CONDITIONS D'ABONNEMENT:\n";
        $content .= str_repeat("-", 25) . "\n";
        $content .= "• Durée d'engagement: {$totalDuree} mois minimum\n";
        $content .= "• Périodicité: Facturation mensuelle\n";
        $content .= "• Paiement: À réception de facture\n";
        $content .= "• Validité: 30 jours\n\n";
        
        // Pied de page
        $content .= str_repeat("=", 50) . "\n";
        $content .= "Ce devis a été généré le " . now()->format('d/m/Y à H:i') . "\n";
        $content .= "GTS AFRIQUE - Plateforme de gestion des services\n";
        
        return $content;
    }
    
    /**
     * Générer un PDF HTML simple
     */
    public function generateHtmlPdf($devis)
    {
        try {
            $devis->load(['client', 'items.service']);
            
            // Utiliser la vue ultra-simple qui fonctionne
            $view = \Illuminate\Support\Facades\View::make('commercial.devis.pdf-ultra-simple', compact('devis'));
            $html = $view->render();
            
            // Sauvegarder en HTML
            $directory = storage_path('app/public/devis');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            $htmlPath = $directory . "/{$devis->reference}.html";
            file_put_contents($htmlPath, $html);
            
            return $htmlPath;
            
        } catch (\Exception $e) {
            \Log::error('Erreur génération HTML: ' . $e->getMessage());
            return false;
        }
    }
}
