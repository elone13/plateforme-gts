<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devis {{ $devis->reference }} - GTS AFRIQUE</title>
    <style>
        @page {
            margin: 2cm;
            size: A4;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #f59e0b;
            padding-bottom: 20px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            display: inline-block;
            margin-bottom: 15px;
        }
        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }
        
        .company-subtitle {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 10px;
        }
        
        .company-info {
            font-size: 12px;
            color: #6b7280;
        }
        
        .devis-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 8px;
        }
        
        .devis-info {
            flex: 1;
        }
        
        .devis-number {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
        }
        
        .devis-dates {
            font-size: 14px;
            color: #6b7280;
        }
        
        .client-info {
            flex: 1;
            text-align: right;
        }
        
        .client-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
        }
        
        .client-details {
            font-size: 14px;
            color: #6b7280;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .items-table th {
            background-color: #f3f4f6;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            color: #374151;
            border-bottom: 2px solid #d1d5db;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        .items-table td {
            padding: 12px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 12px;
        }
        
        .items-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .service-header {
            background-color: #dbeafe !important;
            font-weight: bold;
            color: #1e40af !important;
        }
        
        .service-header td {
            padding: 8px;
            font-size: 13px;
        }
        
        .totals {
            margin-left: auto;
            width: 300px;
            margin-bottom: 30px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .total-row.final {
            border-top: 2px solid #1f2937;
            border-bottom: none;
            font-weight: bold;
            font-size: 16px;
            color: #1f2937;
            padding-top: 15px;
        }
        
        .conditions {
            margin-top: 30px;
            padding: 20px;
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            border-radius: 4px;
        }
        
        .conditions h3 {
            color: #92400e;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .text-large { font-size: 16px; }
        .text-xl { font-size: 18px; }
        .text-2xl { font-size: 24px; }
        .text-gray { color: #6b7280; }
        .text-blue { color: #1e40af; }
        .text-green { color: #059669; }
        .text-red { color: #dc2626; }
    </style>
</head>
<body>
    <!-- En-tête -->
    <div class="header">
        <div class="logo">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 36px; font-weight: bold; color: white; box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);">
                GTS
            </div>
        </div>
        <div class="company-name">GTS AFRIQUE</div>
        <div class="company-subtitle">Solutions Technologiques & Services</div>
        <div class="company-info">
            Dakar, Sénégal | Tél: +221 XX XXX XX XX | Email: contact@gts-afrique.com<br>
            SIRET: XX XXX XXX XXX XXX | TVA: SN XXX XXX XXX
        </div>
    </div>

    <!-- Informations du devis -->
    <div class="devis-header">
        <div class="devis-info">
            <div class="devis-number">DEVIS {{ $devis->reference }}</div>
            <div class="devis-dates">
                <strong>Date d'émission :</strong> {{ \Carbon\Carbon::parse($devis->date)->format('d/m/Y') }}<br>
                <strong>Date de validité :</strong> {{ \Carbon\Carbon::parse($devis->date_validite)->format('d/m/Y') }}
            </div>
        </div>
        
        <div class="client-info">
            <div class="client-title">CLIENT</div>
            <div class="client-details">
                <strong>{{ $devis->client->nom_entreprise ?? $devis->client->nom ?? 'Client' }}</strong><br>
                @if($devis->client->email)
                    {{ $devis->client->email }}<br>
                @endif
                @if($devis->client->telephone)
                    Tél: {{ $devis->client->telephone }}<br>
                @endif
                @if($devis->client->adresse)
                    {{ $devis->client->adresse }}
                @endif
            </div>
        </div>
    </div>

    <!-- Tableau des prestations -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 15%;">Service</th>
                <th style="width: 25%;">Désignation</th>
                <th style="width: 8%;">Qté</th>
                <th style="width: 12%;">Durée (mois)</th>
                <th style="width: 15%;">Prix unit.</th>
                <th style="width: 10%;">Remise</th>
                <th style="width: 15%;">Total HT</th>
            </tr>
        </thead>
        <tbody>
            @php
                $currentService = null;
                $totalHT = 0;
                $totalRemise = 0;
                $totalDuree = 0;
            @endphp
            
            @foreach($devis->items as $item)
                @if($currentService !== $item->service->id)
                    @php $currentService = $item->service->id; @endphp
                    <tr class="service-header">
                        <td colspan="7">
                            <strong>{{ $item->service->nom ?? 'Service' }}</strong>
                            <span style="float: right; font-size: 11px; color: #6b7280;">
                                📅 Durée totale: {{ $item->service->items->sum('duree_mois') ?? 12 }} mois
                            </span>
                        </td>
                    </tr>
                @endif
                
                @php
                    $duree = $item->duree_mois ?? 12;
                    $totalItem = $item->prix * $item->quantite * $duree * (1 - ($item->remise ?? 0) / 100);
                    $remiseItem = $item->prix * $item->quantite * $duree * (($item->remise ?? 0) / 100);
                    $totalHT += $totalItem;
                    $totalRemise += $remiseItem;
                    $totalDuree += $duree;
                @endphp
                
                <tr>
                    <td></td>
                    <td>
                        <strong>{{ $item->nom }}</strong><br>
                        @if($item->description)
                            <span class="text-gray">{{ $item->description }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span style="font-weight: bold;">{{ $item->quantite }}</span>
                    </td>
                    <td class="text-center">
                        <div style="background-color: #dbeafe; padding: 4px 8px; border-radius: 12px; font-weight: bold; color: #1e40af; font-size: 11px;">
                            {{ $duree }} mois
                        </div>
                    </td>
                    <td class="text-right">{{ number_format($item->prix, 0, ',', ' ') }} FCFA</td>
                    <td class="text-center">
                        @if($item->remise > 0)
                            <span style="color: #dc2626; font-weight: bold;">-{{ number_format($item->remise, 1) }}%</span>
                        @else
                            <span style="color: #6b7280;">-</span>
                        @endif
                    </td>
                    <td class="text-right text-bold">
                        {{ number_format($totalItem, 0, ',', ' ') }} FCFA
                        <div style="font-size: 10px; color: #6b7280; margin-top: 2px;">
                            ({{ $duree }} mois)
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Récapitulatif financier -->
    <div class="totals">
        <!-- Informations d'abonnement -->
        <div style="background-color: #f0f9ff; border: 2px solid #0ea5e9; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
            <h3 style="color: #0c4a6e; margin: 0 0 10px 0; font-size: 16px; text-align: center;">📅 Informations d'Abonnement</h3>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong style="color: #0c4a6e;">Durée totale :</strong><br>
                    <span style="font-size: 18px; font-weight: bold; color: #0ea5e9;">
                        @php
                            $totalDuree = 0;
                            foreach($devis->items as $item) {
                                $totalDuree += $item->duree_mois ?? 12;
                            }
                        @endphp
                        {{ $totalDuree }} mois
                    </span>
                </div>
                <div style="text-align: right;">
                    <strong style="color: #0c4a6e;">Périodicité :</strong><br>
                    <span style="font-size: 14px; color: #0ea5e9;">Mensuel</span>
                </div>
            </div>
        </div>
        
        <div class="total-row">
            <span>Total HT :</span>
            <span class="text-bold">{{ number_format($devis->total_ht, 0, ',', ' ') }} FCFA</span>
        </div>
        
        @if($devis->total_remise > 0)
        <div class="total-row">
            <span>Remise :</span>
            <span style="color: #dc2626; font-weight: bold;">-{{ number_format($devis->total_remise, 0, ',', ' ') }} FCFA</span>
        </div>
        
        <div class="total-row">
            <span>Total HT remisé :</span>
            <span class="text-bold">{{ number_format($devis->total_ht_remise, 0, ',', ' ') }} FCFA</span>
        </div>
        @endif
        
        <div class="total-row">
            <span>TVA ({{ number_format($devis->taux_tva * 100, 0) }}%) :</span>
            <span class="text-bold">{{ number_format($devis->montant_tva, 0, ',', ' ') }} FCFA</span>
        </div>
        
        <div class="total-row final">
            <span>TOTAL TTC :</span>
            <span style="color: #059669; font-weight: bold;">{{ number_format($devis->total_ttc, 0, ',', ' ') }} FCFA</span>
        </div>
        
        <!-- Montant mensuel -->
        <div style="margin-top: 15px; padding: 10px; background-color: #f0fdf4; border: 1px solid #22c55e; border-radius: 6px;">
            <div style="text-align: center;">
                <span style="font-size: 12px; color: #166534;">Montant mensuel moyen :</span><br>
                <span style="font-size: 16px; font-weight: bold; color: #22c55e;">
                    {{ number_format($devis->total_ttc / max($totalDuree, 1), 0, ',', ' ') }} FCFA/mois
                </span>
            </div>
        </div>
    </div>

    <!-- Conditions particulières -->
    @if($devis->conditions)
    <div class="conditions">
        <h3>📋 Conditions Particulières</h3>
        <p>{{ $devis->conditions }}</p>
    </div>
    @endif

    <!-- Conditions d'abonnement -->
    <div style="margin-top: 30px; padding: 20px; background-color: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 4px;">
        <h3 style="color: #92400e; margin-bottom: 15px; font-size: 16px;">📅 Conditions d'Abonnement</h3>
        <ul style="margin: 0; padding-left: 20px; color: #92400e;">
            <li><strong>Durée d'engagement :</strong> {{ $totalDuree }} mois minimum</li>
            <li><strong>Périodicité :</strong> Facturation mensuelle</li>
            <li><strong>Renouvellement :</strong> Automatique sauf résiliation</li>
            <li><strong>Résiliation :</strong> Préavis de 30 jours par écrit</li>
            <li><strong>Modification :</strong> Possible en cours d'abonnement</li>
        </ul>
    </div>

    <!-- Conditions générales -->
    <div class="conditions">
        <h3>📋 Conditions Générales</h3>
        <ul style="margin: 0; padding-left: 20px;">
            <li>Validité du devis : 30 jours à compter de la date d'émission</li>
            <li>Paiement : 100% à la commande par chèque au nom de GTS Afrique SARL</li>
            <li>Délai de livraison : À définir selon la disponibilité</li>
            <li>Garantie : Selon les conditions des fabricants</li>
            <li>Loi applicable : Droit sénégalais</li>
        </ul>
    </div>

    <!-- Signature -->
    <div style="margin-top: 50px; display: flex; justify-content: space-between;">
        <div style="width: 45%;">
            <div style="border-top: 1px solid #000; padding-top: 10px; text-align: center;">
                <strong>Signature du client</strong><br>
                <span style="font-size: 11px; color: #6b7280;">Cachet et signature</span>
            </div>
        </div>
        
        <div style="width: 45%;">
            <div style="border-top: 1px solid #000; padding-top: 10px; text-align: center;">
                <strong>GTS AFRIQUE</strong><br>
                <span style="font-size: 11px; color: #6b7280;">Cachet et signature</span>
            </div>
        </div>
    </div>

    <!-- Pied de page -->
    <div class="footer">
        <p><strong>GTS AFRIQUE</strong> - Solutions Technologiques & Services</p>
        <p>Dakar, Sénégal | Tél: +221 XX XXX XX XX | Email: contact@gts-afrique.com</p>
        <p>Ce devis a été généré automatiquement le {{ \Carbon\Carbon::now()->format('d/m/Y à H:i') }}</p>
    </div>
</body>
</html>
