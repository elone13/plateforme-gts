<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devis {{ $devis->reference }} - GTS AFRIQUE</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .devis-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
        }
        .logo-section {
            display: flex;
            align-items: center;
        }
        .logo {
            width: 80px;
            height: 80px;
            margin-right: 15px;
        }
        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: #374151;
        }
        .logo-subtext {
            font-size: 14px;
            color: #6b7280;
        }
        .devis-info {
            text-align: right;
        }
        .devis-title {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
        }
        .devis-number {
            font-size: 18px;
            color: #374151;
            margin-bottom: 5px;
        }
        .devis-date {
            font-size: 14px;
            color: #6b7280;
        }
        .client-section {
            margin-bottom: 40px;
        }
        .client-title {
            font-size: 16px;
            font-weight: bold;
            color: #374151;
            margin-bottom: 10px;
        }
        .client-name {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 5px;
        }
        .client-address {
            font-size: 14px;
            color: #6b7280;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #f9fafb;
            padding: 12px 8px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
            color: #374151;
            text-transform: uppercase;
            border-bottom: 2px solid #e5e7eb;
        }
        .items-table td {
            padding: 12px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        .item-name {
            font-weight: 500;
            color: #1f2937;
        }
        .item-description {
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
        }
        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }
        .totals-table {
            width: 300px;
        }
        .totals-table td {
            padding: 8px 0;
            font-size: 14px;
        }
        .totals-table .label {
            color: #6b7280;
        }
        .totals-table .value {
            text-align: right;
            font-weight: 500;
            color: #1f2937;
        }
        .total-ttc {
            font-size: 18px;
            font-weight: bold;
            color: #059669;
            border-top: 2px solid #e5e7eb;
            padding-top: 8px;
        }
        .payment-section {
            margin-bottom: 30px;
        }
        .payment-title {
            font-size: 16px;
            font-weight: bold;
            color: #374151;
            margin-bottom: 10px;
        }
        .payment-info {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.5;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        .company-info {
            font-size: 12px;
            color: #6b7280;
        }
        .signature-section {
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
        .signature-box {
            width: 200px;
            height: 80px;
            border: 1px dashed #d1d5db;
            margin: 10px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
        }
        @media print {
            body { background: white; }
            .devis-container { box-shadow: none; }
        }
    </style>
</head>
<body>
    <div class="devis-container">
        <!-- En-tête avec logo GTS AFRIQUE -->
        <div class="header">
            <div class="logo-section">
                <div class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="GTS AFRIQUE Logo">
                </div>
                <div style="font-size: 12px; color: #6b7280; margin-top: 5px;">
                    Mermoz Pyrotechnique N°22<br>
                    Angle rue MZ-51 Dakar<br>
                    contact@gts-afrique.com<br>
                    www.gts-afrique.com<br>
                    TEL: +221 33 821 03 03
                </div>
            </div>
            
            <div class="devis-info">
                <div class="devis-title">PROFORMA</div>
                <div class="devis-number">{{ $devis->reference }}</div>
                <div class="devis-date">Dakar, le {{ \Carbon\Carbon::parse($devis->date)->format('d/m/Y') }}</div>
            </div>
        </div>

        <!-- Section client -->
        <div class="client-section">
            <div class="client-title">Destinataire :</div>
            <div class="client-name">{{ $devis->client->nom_entreprise ?? $devis->client->nom }}</div>
            <div class="client-address">
                {{ $devis->client->adresse ?? 'Dakar - Sénégal' }}
            </div>
        </div>

        <!-- Tableau des éléments -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th>Remise</th>
                    <th>Qté</th>
                    <th>Durée</th>
                    <th>PU HT</th>
                    <th>Total HT</th>
                    <th>TVA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devis->items as $item)
                <tr>
                    <td>
                        <div class="item-name">{{ $item->nom }}</div>
                        @if($item->description)
                            <div class="item-description">{{ $item->description }}</div>
                        @endif
                    </td>
                    <td>{{ $item->remise ?? 0 }}%</td>
                    <td>{{ $item->quantite }}</td>
                    <td>{{ $item->duree_mois ?? 12 }} mois</td>
                    <td>{{ number_format($item->prix, 0) }} FCFA</td>
                    <td>{{ number_format($item->prix * $item->quantite * ($item->duree_mois ?? 12) * (1 - ($item->remise ?? 0) / 100), 0) }} FCFA</td>
                    <td>{{ $devis->taux_tva * 100 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Récapitulatif des totaux -->
        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td class="label">Total HT:</td>
                    <td class="value">{{ number_format($devis->total_ht, 0) }} FCFA</td>
                </tr>
                @if($devis->total_remise > 0)
                <tr>
                    <td class="label">Remise {{ number_format($devis->total_remise / $devis->total_ht * 100, 1) }}%:</td>
                    <td class="value">{{ number_format($devis->total_remise, 0) }} FCFA</td>
                </tr>
                <tr>
                    <td class="label">Total HT remisé:</td>
                    <td class="value">{{ number_format($devis->total_ht_remise ?? ($devis->total_ht - $devis->total_remise), 0) }} FCFA</td>
                </tr>
                @endif
                <tr>
                    <td class="label">TVA ({{ $devis->taux_tva * 100 }}%):</td>
                    <td class="value">{{ number_format($devis->montant_tva, 0) }} FCFA</td>
                </tr>
                <tr class="total-ttc">
                    <td class="label">Total TTC:</td>
                    <td class="value">{{ number_format($devis->total_ttc, 0) }} FCFA</td>
                </tr>
            </table>
        </div>

        <!-- Conditions de paiement -->
        <div class="payment-section">
            <div class="payment-title">Conditions de paiement :</div>
            <div class="payment-info">
                <strong>À payer : {{ number_format($devis->total_ttc, 0) }} FCFA</strong><br>
                Mode : 100% à la commande par chèque au nom de GTS Afrique SARL
            </div>
        </div>

        <!-- Validité -->
        @if($devis->date_validite)
        <div class="payment-section">
            <div class="payment-title">Validité :</div>
            <div class="payment-info">
                Ce devis est valable jusqu'au {{ \Carbon\Carbon::parse($devis->date_validite)->format('d/m/Y') }}
            </div>
        </div>
        @endif

        <!-- Conditions spéciales -->
        @if($devis->conditions)
        <div class="payment-section">
            <div class="payment-title">Conditions spéciales :</div>
            <div class="payment-info">
                {{ $devis->conditions }}
            </div>
        </div>
        @endif

        <!-- Pied de page -->
        <div class="footer">
            <div class="company-info">
                <strong>GTS AFRIQUE SARL</strong><br>
                AU CAPITAL DE 1.000.000 CFA<br>
                NINEA: 008257968 2V2<br>
                RCS: SN DKR 2020 B 31366
            </div>
            
            <div class="signature-section">
                <div>Date et signature du client précédée de la mention</div>
                <div style="font-weight: bold; margin: 5px 0;">"Bon pour accord"</div>
                <div class="signature-box">
                    Signature
                </div>
            </div>
        </div>
    </div>
</body>
</html>
