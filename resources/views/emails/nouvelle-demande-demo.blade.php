<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Demande de Démo - GTS Afrique</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 650px;
            margin: 0 auto;
            padding: 20px;
            background: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 1px solid #e1e5e9;
        }
        .header {
            background: #ffffff;
            color: #2c3e50;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            border-bottom: 3px solid #fcd61be6;
        }
        .logo-container {
            margin: 0 auto 20px;
            text-align: center;
        }
        .logo {
            width: 120px;
            height: auto;
            max-height: 80px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .header h1 {
            font-size: 28px;
            margin: 0;
            font-weight: 700;
            color: #2c3e50;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header p {
            font-size: 16px;
            margin: 10px 0 0 0;
            color: #34495e;
            font-weight: 500;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 20px;
            margin-bottom: 25px;
            color: #2c3e50;
            font-weight: 600;
        }
        .message {
            font-size: 16px;
            margin-bottom: 25px;
            color: #555;
            line-height: 1.7;
        }
        .client-details {
            background: #fcd61be6;
            border: 2px solid #f39c12;
            border-radius: 16px;
            padding: 25px;
            margin: 30px 0;
            position: relative;
        }
        .client-details h3 {
            color: #2c3e50;
            margin-top: 0;
            font-size: 18px;
            font-weight: 600;
        }
        .client-info {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 20px;
            margin: 15px 0;
        }
        .client-info p {
            margin: 8px 0;
            color: #2c3e50;
            font-weight: 500;
        }
        .client-info strong {
            color: #f39c12;
        }
        .cta-button {
            display: inline-block;
            background: #fcd61be6;
            color: #2c3e50;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: all 0.3s ease;
            border: 2px solid #f39c12;
        }
        .cta-button:hover {
            background: #f39c12;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(243, 156, 18, 0.3);
        }
        .footer {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .footer p {
            margin: 5px 0;
            font-size: 14px;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #fcd61be6;
            text-decoration: none;
            font-weight: 600;
        }
        .highlight {
            background: #fcd61be6;
            color: #2c3e50;
            padding: 15px 20px;
            border-radius: 12px;
            margin: 20px 0;
            font-weight: 600;
            text-align: center;
        }
        .priority-badge {
            background: #e74c3c;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="GTS Afrique" class="logo">
            </div>
            <h1>Nouvelle Demande de Démo</h1>
            <p>Un nouveau prospect souhaite une démonstration</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                Bonjour équipe commerciale,
            </div>
            
            <div class="message">
                Une nouvelle demande de démonstration a été reçue sur le site GTS Afrique. 
                Ce prospect est intéressé par nos solutions de gestion de flotte.
            </div>
            
            <div class="highlight">
                Nouvelle opportunité commerciale
            </div>
            
            <div class="client-details">
                <h3>Informations du prospect</h3>
                <div class="client-info">
                    <p><strong>Nom :</strong> {{ $demande->nom }}</p>
                    <p><strong>Email :</strong> {{ $demande->email }}</p>
                    <p><strong>Téléphone :</strong> {{ $demande->telephone }}</p>
                    <p><strong>Société :</strong> {{ $demande->societe ?? 'Non spécifié' }}</p>
                    <p><strong>Nombre de véhicules :</strong> {{ $demande->nombre_vehicules ?? 'Non spécifié' }}</p>
                    <p><strong>Jour préféré :</strong> {{ $demande->jour_prefere ?? 'Non spécifié' }}</p>
                    <p><strong>Message :</strong> {{ $demande->message ?? 'Aucun message' }}</p>
                    <p><strong>Date de demande :</strong> {{ $demande->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            
            <div class="priority-badge">
                Action requise : Contacter le prospect dans les 24h
            </div>
            
            <div class="message">
                <strong>Actions recommandées :</strong>
                <ul style="margin: 15px 0; padding-left: 20px;">
                    <li>Contacter le prospect par téléphone ou email</li>
                    <li>Présenter nos solutions adaptées à ses besoins</li>
                    <li>Proposer un créneau de démonstration</li>
                    <li>Suivre le prospect dans le CRM</li>
                </ul>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ route('commercial.demandes-demo.show', $demande->id) }}" class="cta-button">
                    Voir les détails complets
                </a>
            </div>
        </div>
        
        <div class="footer">
            <div class="social-links">
                <a href="{{ route('commercial.demandes-demo.index') }}">Toutes les demandes</a>
                <a href="{{ route('commercial.dashboard') }}">Tableau de bord</a>
            </div>
            <p><strong>GTS Afrique</strong></p>
            <p>Solutions de gestion de flotte intelligentes</p>
            <p>© 2025 GTS Afrique. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>