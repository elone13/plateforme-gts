<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test PDF - {{ $devis->reference }}</title>
</head>
<body>
    <h1>TEST PDF - DEVIS {{ $devis->reference }}</h1>
    
    <h2>Client: {{ $devis->client->nom_entreprise ?? $devis->client->nom ?? 'N/A' }}</h2>
    
    <h3>Colonne Durée (mois) - TEST</h3>
    
    <h3>Section Informations d'Abonnement - TEST</h3>
    
    <h3>Section Conditions d'Abonnement - TEST</h3>
    
    <h3>GTS AFRIQUE - TEST</h3>
    
    <h3>DEVIS - TEST</h3>
    
    <h3>FCFA - TEST</h3>
    
    <h3>TVA - TEST</h3>
    
    <p>Ceci est un test pour vérifier que la génération PDF fonctionne avec la bonne vue.</p>
    
    <p>Date: {{ now()->format('d/m/Y H:i:s') }}</p>
</body>
</html>
