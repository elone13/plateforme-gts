<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande de démo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #dc2626;
            background-color: #fef2f2;
            padding: 20px;
            border-radius: 8px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 10px;
        }
        .title {
            color: #991b1b;
            font-size: 20px;
            margin-bottom: 20px;
        }
        .alert {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
            color: #92400e;
        }
        .content {
            margin-bottom: 30px;
        }
        .info-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .info-label {
            font-weight: bold;
            color: #374151;
            margin-bottom: 5px;
        }
        .info-value {
            color: #6b7280;
            margin-bottom: 15px;
        }
        .priority-high {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 10px 15px;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
        }
        .priority-medium {
            background-color: #fffbeb;
            border: 1px solid #fed7aa;
            color: #92400e;
            padding: 10px 15px;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
        }
        .priority-low {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 10px 15px;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .action-button {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: bold;
        }
        .action-button:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">GTS AFRIQUE</div>
            <div class="title">🚨 Nouvelle demande de démo reçue</div>
        </div>

        <div class="content">
            <div class="alert">
                ⚡ Une nouvelle demande de démo nécessite votre attention immédiate !
            </div>

            <p>Bonjour,</p>
            
            <p>Une nouvelle demande de démonstration a été soumise via le site web de GTS Afrique.</p>
            
            <div class="info-box">
                <div class="info-label">👤 Client :</div>
                <div class="info-value">{{ $demande->nom }}</div>
                
                <div class="info-label">📧 Email :</div>
                <div class="info-value">{{ $demande->email }}</div>
                
                <div class="info-label">📱 Téléphone :</div>
                <div class="info-value">{{ $demande->telephone }}</div>
                
                <div class="info-label">📅 Date de soumission :</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($demande->created_at)->format('d/m/Y à H:i') }}</div>
                
                <div class="info-label">🌐 Source :</div>
                <div class="info-value">{{ ucfirst(str_replace('_', ' ', $demande->source)) }}</div>
                
                @if($demande->message)
                    <div class="info-label">💬 Message du client :</div>
                    <div class="info-value">{{ $demande->message }}</div>
                @endif
            </div>

            @if($demande->priorite === 'haute')
                <div class="priority-high">
                    🔴 PRIORITÉ HAUTE - Traitement urgent requis
                </div>
            @elseif($demande->priorite === 'moyenne')
                <div class="priority-medium">
                    🟡 PRIORITÉ MOYENNE - Traitement dans les 24h
                </div>
            @else
                <div class="priority-low">
                    🟢 PRIORITÉ BASSE - Traitement dans les 48h
                </div>
            @endif

            <p><strong>Actions recommandées :</strong></p>
            <ul>
                <li>Contacter le client dans les plus brefs délais</li>
                <li>Évaluer ses besoins et proposer une démonstration</li>
                <li>Mettre à jour le statut de la demande</li>
                <li>Planifier un créneau de démonstration</li>
            </ul>

            <div style="text-align: center;">
                <a href="{{ route('commercial.demandes-demo.show', $demande->id) }}" class="action-button">
                    👁️ Voir les détails de la demande
                </a>
            </div>
        </div>

        <div class="footer">
            <p><strong>GTS AFRIQUE</strong></p>
            <p>Cette notification a été envoyée automatiquement</p>
            <p>© {{ date('Y') }} GTS Afrique. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
