<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Devis {{ $devis->reference }}</title>
    <style>
        @page {
            margin: 2cm;
            size: A4;
        }
        body {
            font-family: "DejaVu Sans", "Liberation Sans", Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .devis-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .devis-ref {
            font-size: 14px;
            color: #666;
        }
        .client-info {
            margin-bottom: 30px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        .client-label {
            font-weight: bold;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .subscription-info {
            margin-top: 30px;
            padding: 15px;
            background-color: #f0f8ff;
            border: 1px solid #b0d4f1;
        }
        .subscription-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c5aa0;
            margin-bottom: 15px;
        }
        .subscription-item {
            margin-bottom: 8px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">GTS AFRIQUE</div>
        <div class="devis-title">DEVIS</div>
        <div class="devis-ref">{{ $devis->reference }}</div>
    </div>
    
    <div class="client-info">
        <div class="client-label">Client:</div>
        <div>{{ $devis->client->nom_entreprise ?? $devis->client->nom ?? 'N/A' }}</div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Designation</th>
                <th>Qte</th>
                <th>Duree (mois)</th>
                <th>Prix unit.</th>
                <th>Total HT</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devis->items as $item)
                @php
                    $duree = $item->duree_mois ?? 12;
                    $totalItem = $item->prix * $item->quantite * $duree;
                @endphp
                <tr>
                    <td>{{ $item->service->nom ?? 'Service' }}</td>
                    <td>{{ $item->nom }}</td>
                    <td>{{ $item->quantite }}</td>
                    <td><strong>{{ $duree }} mois</strong></td>
                    <td>{{ number_format($item->prix, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($totalItem, 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="subscription-info">
        <div class="subscription-title">Informations d'Abonnement</div>
        <div class="subscription-item">
            <strong>Duree totale:</strong> {{ collect($devis->items)->sum('duree_mois') ?? 12 }} mois
        </div>
        <div class="subscription-item">
            <strong>Duree d'engagement:</strong> {{ collect($devis->items)->sum('duree_mois') ?? 12 }} mois minimum
        </div>
        <div class="subscription-item">
            <strong>Periodicite:</strong> Facturation mensuelle
        </div>
    </div>
    
    <div class="footer">
        <p>Ce devis a ete genere le {{ now()->format('d/m/Y a H:i') }}</p>
        <p>GTS AFRIQUE - Plateforme de gestion des services</p>
    </div>
</body>
</html>
