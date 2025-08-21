<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre compte GTS Afrique - Identifiants de connexion</title>
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
        .credentials-box {
            background: #fcd61be6;
            border: 2px solid #f39c12;
            border-radius: 16px;
            padding: 25px;
            margin: 30px 0;
            text-align: center;
        }
        .credentials-box h3 {
            color: #2c3e50;
            margin-top: 0;
            font-size: 18px;
            font-weight: 600;
        }
        .credentials-info {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 20px;
            margin: 15px 0;
        }
        .credential-item {
            margin: 15px 0;
            padding: 10px;
            background: rgba(44, 62, 80, 0.05);
            border-radius: 8px;
        }
        .credential-item label {
            display: block;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
            font-size: 14px;
        }
        .credential-item .value {
            font-family: 'Courier New', monospace;
            background: #2c3e50;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .login-button {
            display: inline-block;
            background: #2c3e50;
            color: white;
            text-decoration: none;
            padding: 18px 36px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: all 0.3s ease;
            border: 2px solid #2c3e50;
        }
        .login-button:hover {
            background: #34495e;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(44, 62, 80, 0.3);
        }
        .info-section {
            background: rgba(252, 214, 27, 0.1);
            border-left: 4px solid #fcd61be6;
            padding: 20px;
            border-radius: 0 12px 12px 0;
            margin: 20px 0;
        }
        .info-section h4 {
            color: #2c3e50;
            margin-top: 0;
            font-size: 16px;
            font-weight: 600;
        }
        .info-section p {
            margin: 8px 0;
            color: #555;
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
        .security-note {
            background: #e8f4fd;
            border: 1px solid #2196f3;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
            color: #1976d2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="GTS Afrique" class="logo">
            </div>
            <h1>Bienvenue sur GTS Afrique</h1>
            <p>Votre compte client a été créé avec succès</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                Bonjour {{ $user->name }},
            </div>
            
            <div class="message">
                Notre équipe commerciale a créé votre compte client sur la plateforme GTS Afrique. 
                Vous pouvez maintenant accéder à votre espace personnel pour consulter vos devis, 
                factures et suivre vos demandes de démonstration.
            </div>
            
            <div class="highlight">
                Votre compte est prêt à être utilisé
            </div>
            
            <div class="credentials-box">
                <h3>Vos identifiants de connexion</h3>
                <div class="credentials-info">
                    <div class="credential-item">
                        <label>Adresse email :</label>
                        <div class="value">{{ $user->email }}</div>
                    </div>
                    <div class="credential-item">
                        <label>Mot de passe temporaire :</label>
                        <div class="value">{{ $defaultPassword }}</div>
                    </div>
                </div>
                
                <div style="margin-top: 20px;">
                    <a href="{{ route('login') }}" class="login-button">
                        Se connecter maintenant
                    </a>
                </div>
            </div>
            
            <div class="info-section">
                <h4>Que pouvez-vous faire avec votre compte ?</h4>
                <p>Consulter et télécharger vos devis</p>
                <p>Accéder à vos factures</p>
                <p>Suivre l'état de vos demandes de démonstration</p>
                <p>Mettre à jour vos informations personnelles</p>
                <p>Contacter directement notre équipe</p>
            </div>
            
            <div class="security-note">
                <strong>Sécurité :</strong> Pour votre sécurité, nous vous recommandons de changer 
                votre mot de passe lors de votre première connexion. Vous pouvez le faire depuis 
                votre profil après vous être connecté.
            </div>
            
            <div class="message">
                <strong>Besoin d'aide ?</strong><br>
                Si vous rencontrez des difficultés pour vous connecter ou si vous avez des questions, 
                n'hésitez pas à contacter notre équipe support. Nous sommes là pour vous accompagner !
            </div>
        </div>
        
        <div class="footer">
            <div class="social-links">
                <a href="mailto:contact@gts-afrique.com">Contact</a>
                <a href="{{ url('/') }}">Site web</a>
                <a href="{{ route('login') }}">Se connecter</a>
            </div>
            <p><strong>GTS Afrique</strong></p>
            <p>Solutions de gestion de flotte intelligentes</p>
            <p>© 2025 GTS Afrique. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>

