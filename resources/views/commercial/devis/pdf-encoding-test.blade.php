<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Test Encodage - {{ $devis->reference }}</title>
</head>
<body>
    <h1>GTS AFRIQUE - TEST ENCODAGE</h1>
    <h2>DEVIS {{ $devis->reference }}</h2>
    
    <p><strong>Client:</strong> {{ $devis->client->nom_entreprise ?? $devis->client->nom ?? 'N/A' }}</p>
    
    <h3>Tableau des prestations:</h3>
    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
        <tr>
            <th>Service</th>
            <th>Désignation</th>
            <th>Qté</th>
            <th>Durée (mois)</th>
            <th>Prix unit.</th>
            <th>Total HT</th>
        </tr>
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
    </table>
    
    <h3>Informations d'Abonnement</h3>
    <p><strong>Durée totale:</strong> {{ collect($devis->items)->sum('duree_mois') ?? 12 }} mois</p>
    
    <h3>Conditions d'Abonnement</h3>
    <ul>
        <li><strong>Durée d'engagement:</strong> {{ collect($devis->items)->sum('duree_mois') ?? 12 }} mois minimum</li>
        <li><strong>Périodicité:</strong> Facturation mensuelle</li>
    </ul>
    
    <p><strong>Total TTC:</strong> {{ number_format($devis->total_ttc, 0, ',', ' ') }} FCFA</p>
    
    <p><em>Ce devis a été généré le {{ now()->format('d/m/Y à H:i') }}</em></p>
    
    <!-- Test avec des caractères spéciaux -->
    <div style="margin-top: 20px; padding: 10px; background-color: #f0f0f0; border: 1px solid #ccc;">
        <h4>Test de caractères spéciaux:</h4>
        <p>€uro: € | Pound: £ | Yen: ¥ | Degree: ° | Plus/Minus: ± | Registered: ® | Copyright: ©</p>
        <p>Accents: é è à ù ç ï ö ü ë</p>
        <p>Symboles: → ← ↑ ↓ ↔ ↕</p>
    </div>
</body>
</html>
