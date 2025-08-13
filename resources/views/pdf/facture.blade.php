<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Facture {{ $facture->numero_facture }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }
        .header-info {
            margin-bottom: 30px;
        }
        .company-address, .client-address {
            margin-bottom: 30px;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #1a365d;
        }
        .invoice-number {
            font-size: 14px;
            margin-bottom: 20px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            background-color: #f7fafc;
            font-weight: bold;
            color: #4a5568;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-bold {
            font-weight: bold;
        }
        .totals {
            width: 300px;
            margin-left: auto;
        }
        .totals td {
            padding: 8px 15px;
        }
        .totals tr:last-child td {
            border-top: 2px solid #4a5568;
            font-weight: bold;
            font-size: 14px;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 10px;
            color: #718096;
            text-align: center;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- En-tête avec logo et informations de l'entreprise -->
    <div class="header">
        <div class="header-info">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ public_path('images/logo.png') }}" alt="Logo" class="logo">
            @endif
            
            <div class="company-address">
                <div class="text-bold">{{ config('app.name') }}</div>
                <div>123 Rue de l'Exemple</div>
                <div>75000 Paris, France</div>
                <div>Tél: +33 1 23 45 67 89</div>
                <div>Email: contact@example.com</div>
                <div>SIRET: 123 456 789 00012</div>
                <div>APE: 6201Z</div>
                <div>TVA Intra: FR 12 123456789</div>
            </div>
        </div>

        <!-- Titre et numéro de facture -->
        <div class="invoice-title">FACTURE</div>
        <div class="invoice-number">N° {{ $facture->numero_facture }}</div>
        
        <div class="flex justify-between">
            <!-- Informations client -->
            <div class="client-address">
                <div class="text-bold">FACTURÉ À</div>
                <div>{{ $facture->client->nom_entreprise ?? $facture->client->name }}</div>
                @if($facture->client->adresse)
                    <div>{{ $facture->client->adresse }}</div>
                @endif
                @if($facture->client->code_postal && $facture->client->ville)
                    <div>{{ $facture->client->code_postal }} {{ $facture->client->ville }}</div>
                @endif
                @if($facture->client->pays)
                    <div>{{ $facture->client->pays }}</div>
                @endif
                @if($facture->client->siret)
                    <div>SIRET: {{ $facture->client->siret }}</div>
                @endif
                @if($facture->client->tva_intracom)
                    <div>TVA Intra: {{ $facture->client->tva_intracom }}</div>
                @endif
            </div>

            <!-- Détails de la facture -->
            <div class="invoice-details">
                <table>
                    <tr>
                        <td class="text-bold">Date d'émission:</td>
                        <td>{{ $facture->date_facturation->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Date d'échéance:</td>
                        <td>{{ $facture->date_echeance->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Statut:</td>
                        <td>
                            @php
                                $statusClasses = [
                                    'facture' => 'background-color: #fef3c7; color: #92400e;',
                                    'payee' => 'background-color: #d1fae5; color: #065f46;',
                                    'en_retard' => 'background-color: #fee2e2; color: #991b1b;',
                                    'annule' => 'background-color: #f3f4f6; color: #374151;',
                                ][$facture->statut] ?? 'background-color: #f3f4f6; color: #374151;';
                            @endphp
                            <span class="status-badge" style="{{ $statusClasses }}">
                                {{ ucfirst($facture->statut) }}
                            </span>
                        </td>
                    </tr>
                    @if($facture->reference_commande)
                    <tr>
                        <td class="text-bold">Réf. commande:</td>
                        <td>{{ $facture->reference_commande }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Détails des prestations -->
    <div class="items">
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Qté</th>
                    <th class="text-right">Prix unitaire HT</th>
                    <th class="text-right">Montant HT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($facture->items as $item)
                <tr>
                    <td>
                        <div class="text-bold">{{ $item->description }}</div>
                        @if($item->service)
                            <div class="text-sm">{{ $item->service->nom }}</div>
                        @endif
                    </td>
                    <td class="text-right">{{ $item->quantite }}</td>
                    <td class="text-right">{{ number_format($item->prix_unitaire, 2, ',', ' ') }} €</td>
                    <td class="text-right">{{ number_format($item->prix_total, 2, ',', ' ') }} €</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Totaux -->
    <div class="totals">
        <table>
            <tr>
                <td class="text-bold">Sous-total HT:</td>
                <td class="text-right">{{ number_format($facture->total_ht, 2, ',', ' ') }} €</td>
            </tr>
            <tr>
                <td class="text-bold">TVA ({{ $facture->taux_tva * 100 }}%):</td>
                <td class="text-right">{{ number_format($facture->montant_tva, 2, ',', ' ') }} €</td>
            </tr>
            <tr>
                <td class="text-bold">Total TTC:</td>
                <td class="text-right">{{ number_format($facture->total_ttc, 2, ',', ' ') }} €</td>
            </tr>
        </table>
    </div>

    <!-- Conditions de paiement -->
    <div class="mt-10">
        <div class="text-bold mb-2">Conditions de paiement :</div>
        <p>Paiement à réception de facture, par virement bancaire dans les délais indiqués.</p>
        
        <div class="mt-4">
            <div class="text-bold mb-2">Coordonnées bancaires :</div>
            <div>Banque: MA BANQUE</div>
            <div>IBAN: FR76 XXXX XXXX XXXX XXXX XXXX XXXX XXX</div>
            <div>BIC: XXXXXXXX</div>
        </div>
        
        <div class="mt-4">
            <div class="text-bold mb-2">Mentions légales :</div>
            <p>En cas de retard de paiement, une indemnité forfaitaire pour frais de recouvrement de 40€ sera appliquée conformément à l'article D. 441-5 du code de commerce.</p>
            <p>Pénalité de retard au taux annuel de 10% à compter de la date d'échéance.</p>
        </div>
    </div>

    <!-- Pied de page -->
    <div class="footer">
        <div>{{ config('app.name') }} - {{ config('app.slogan') }}</div>
        <div>RCS Paris 123 456 789 - TVA intracommunautaire FR 12 123456789</div>
        <div>Contact : contact@example.com - Tél : +33 1 23 45 67 89</div>
    </div>
</body>
</html>
