<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation - GTS Afrique</title>
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
        .rdv-details {
            background: #fcd61be6;
            border: 2px solid #f39c12;
            border-radius: 16px;
            padding: 25px;
            margin: 30px 0;
            position: relative;
        }
        .rdv-details h3 {
            color: #2c3e50;
            margin-top: 0;
            font-size: 18px;
            font-weight: 600;
        }
        .rdv-info {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 20px;
            margin: 15px 0;
        }
        .rdv-info p {
            margin: 8px 0;
            color: #2c3e50;
            font-weight: 500;
        }
        .rdv-info strong {
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
        .icon {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="GTS Afrique" class="logo">
            </div>
            <h1>Confirmation de Demande de Démo</h1>
            <p>Votre demande a été reçue avec succès</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                Bonjour {{ $demandeDemo->nom }},
            </div>
            
            <div class="message">
                Nous avons bien reçu votre demande de démonstration pour nos solutions de gestion de flotte. 
                Notre équipe commerciale va l'étudier et vous recontacter dans les plus brefs délais.
            </div>
            
            <div class="highlight">
                Votre demande est en cours de traitement
            </div>
            
            <div class="rdv-details">
                <h3>Détails de votre demande</h3>
                <div class="rdv-info">
                    <p><strong>Nom :</strong> {{ $demandeDemo->nom }}</p>
                    <p><strong>Email :</strong> {{ $demandeDemo->email }}</p>
                    <p><strong>Téléphone :</strong> {{ $demandeDemo->telephone }}</p>
                    <p><strong>Société :</strong> {{ $demandeDemo->societe ?? 'Non spécifié' }}</p>
                    <p><strong>Nombre de véhicules :</strong> {{ $demandeDemo->nombre_vehicules ?? 'Non spécifié' }}</p>
                    <p><strong>Jour préféré :</strong> {{ $demandeDemo->jour_prefere ?? 'Non spécifié' }}</p>
                    <p><strong>Message :</strong> {{ $demandeDemo->message ?? 'Aucun message' }}</p>
                </div>
            </div>
            
            <div class="message">
                <strong>Prochaines étapes :</strong>
                <ul style="margin: 15px 0; padding-left: 20px;">
                    <li>Notre équipe va analyser vos besoins</li>
                    <li>Nous vous proposerons un créneau de démonstration</li>
                    <li>Vous recevrez un email de confirmation avec les détails</li>
                </ul>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="cta-button">
                    Retourner sur le site
                </a>
            </div>
        </div>
        
        <div class="footer">
            <div class="social-links">
                <a href="mailto:contact@gts-afrique.com">Contact</a>
                <a href="{{ url('/') }}">Site web</a>
            </div>
            <p><strong>GTS Afrique</strong></p>
            <p>Solutions de gestion de flotte intelligentes</p>
            <p>© 2025 GTS Afrique. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>