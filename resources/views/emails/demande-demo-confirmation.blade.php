<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation - GTS Afrique</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #3b82f6;
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .rdv-details {
            background-color: white;
            border: 2px solid #3b82f6;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .rdv-details h3 {
            color: #3b82f6;
            margin-top: 0;
        }
        .rdv-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 15px 0;
        }
        .rdv-info div {
            padding: 10px;
            background-color: #f8fafc;
            border-radius: 4px;
        }
        .rdv-info label {
            font-weight: bold;
            color: #64748b;
            font-size: 12px;
            text-transform: uppercase;
        }
        .rdv-info p {
            margin: 5px 0 0 0;
            font-size: 16px;
        }
        .btn {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
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
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">GTS AFRIQUE</div>
        <h1>
            @if($demandeDemo->statut === 'planifiee')
                Rendez-vous confirmé !
            @else
                Demande reçue
            @endif
        </h1>
    </div>

    <div class="content">
        <p>Bonjour <strong>{{ $demandeDemo->nom }}</strong>,</p>

        @if($demandeDemo->statut === 'planifiee')
            <p>Nous avons le plaisir de confirmer votre rendez-vous de démonstration de la plateforme GTS Afrique.</p>

            <div class="rdv-details">
                <h3>📅 Détails du rendez-vous</h3>
                
                <div class="rdv-info">
                    <div>
                        <label>Date</label>
                        <p>{{ \Carbon\Carbon::parse($demandeDemo->date_rdv)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label>Heure</label>
                        <p>{{ \Carbon\Carbon::parse($demandeDemo->heure_rdv)->format('H:i') }}</p>
                    </div>
                    <div>
                        <label>Durée</label>
                        <p>{{ $demandeDemo->duree_rdv }} minutes</p>
                    </div>
                    <div>
                        <label>Type</label>
                        <p>{{ ucfirst(str_replace('_', ' ', $demandeDemo->type_rdv)) }}</p>
                    </div>
                </div>

                @if($demandeDemo->type_rdv === 'en_ligne')
                    <div style="margin-top: 20px;">
                        <label style="font-weight: bold; color: #64748b; font-size: 12px; text-transform: uppercase;">Lien de réunion</label>
                        <p style="margin: 5px 0 0 0; font-size: 16px;">
                            <a href="{{ $demandeDemo->lien_reunion }}" style="color: #3b82f6; text-decoration: none;">
                                {{ $demandeDemo->lien_reunion }}
                            </a>
                        </p>
                    </div>
                @endif

                @if($demandeDemo->instructions_rdv)
                    <div style="margin-top: 20px;">
                        <label style="font-weight: bold; color: #64748b; font-size: 12px; text-transform: uppercase;">Instructions</label>
                        <p style="margin: 5px 0 0 0; font-size: 16px;">{{ $demandeDemo->instructions_rdv }}</p>
                    </div>
                @endif
            </div>

            <p><strong>Préparez-vous pour votre démonstration :</strong></p>
            <ul>
                <li>Assurez-vous d'être disponible 5 minutes avant l'heure prévue</li>
                @if($demandeDemo->type_rdv === 'en_ligne')
                    <li>Testez votre connexion internet et votre micro</li>
                    <li>Préparez vos questions sur la plateforme</li>
                @endif
                @if($demandeDemo->type_rdv === 'en_presentiel')
                    <li>Préparez vos questions sur la plateforme</li>
                    <li>Nous vous contacterons pour confirmer le lieu exact</li>
                @endif
                @if($demandeDemo->type_rdv === 'telephone')
                    <li>Assurez-vous d'être dans un endroit calme</li>
                    <li>Préparez vos questions sur la plateforme</li>
                @endif
            </ul>

            @if($demandeDemo->type_rdv === 'en_ligne')
                <a href="{{ $demandeDemo->lien_reunion }}" class="btn">Rejoindre la réunion</a>
            @endif

        @else
            <p>Nous avons bien reçu votre demande de démonstration de la plateforme GTS Afrique.</p>
            
            <p><strong>Votre demande a été enregistrée avec les informations suivantes :</strong></p>
            <ul>
                <li><strong>Nom :</strong> {{ $demandeDemo->nom }}</li>
                <li><strong>Email :</strong> {{ $demandeDemo->email }}</li>
                @if($demandeDemo->telephone)
                    <li><strong>Téléphone :</strong> {{ $demandeDemo->telephone }}</li>
                @endif
                <li><strong>Date de demande :</strong> {{ $demandeDemo->created_at->format('d/m/Y H:i') }}</li>
            </ul>

            @if($demandeDemo->message)
                <p><strong>Votre message :</strong></p>
                <p style="background-color: #f1f5f9; padding: 15px; border-radius: 4px; border-left: 4px solid #3b82f6;">
                    {{ $demandeDemo->message }}
                </p>
            @endif

            <p>Notre équipe commerciale va examiner votre demande et vous contactera dans les plus brefs délais pour planifier une démonstration personnalisée.</p>
        @endif

        <p>Si vous avez des questions ou souhaitez modifier votre rendez-vous, n'hésitez pas à nous contacter.</p>

        <p>Cordialement,<br>
        <strong>L'équipe GTS Afrique</strong></p>
    </div>

    <div class="footer">
        <p>GTS Afrique - Plateforme de gestion de transport</p>
        <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre directement.</p>
    </div>
</body>
</html>
