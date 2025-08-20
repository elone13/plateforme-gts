<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Devis {{ $devis->reference }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>GTS AFRIQUE</h1>
        <h2>DEVIS {{ $devis->reference }}</h2>
    </div>
    
    <h3>Client: {{ $devis->client->nom_entreprise ?? $devis->client->nom ?? 'N/A' }}</h3>
    
    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Désignation</th>
                <th>Qté</th>
                <th>Durée (mois)</th>
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
                    <td>{{ $duree }} mois</td>
                    <td>{{ number_format($item->prix, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($totalItem, 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <h3>Informations d'Abonnement</h3>
    <p>Durée totale: {{ collect($devis->items)->sum('duree_mois') ?? 12 }} mois</p>
    
    <h3>Conditions d'Abonnement</h3>
    <ul>
        <li>Durée d'engagement: {{ collect($devis->items)->sum('duree_mois') ?? 12 }} mois minimum</li>
        <li>Périodicité: Facturation mensuelle</li>
    </ul>
    
    <p>Total TTC: {{ number_format($devis->total_ttc, 0, ',', ' ') }} FCFA</p>
</body>
</html>
