@extends('layouts.commercial')

@section('page-title', 'Détail de la facture')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec boutons d'action -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Facture #{{ $facture->numero_facture }}</h2>
                <div class="mt-1 flex items-center space-x-2">
                    @php
                        $statusClasses = [
                            'facture' => 'bg-yellow-100 text-yellow-800',
                            'payee' => 'bg-green-100 text-green-800',
                            'en_retard' => 'bg-red-100 text-red-800',
                            'annule' => 'bg-gray-100 text-gray-800',
                        ][$facture->statut] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses }}">
                        {{ ucfirst($facture->statut) }}
                    </span>
                    <span class="text-sm text-gray-500">
                        Émise le {{ $facture->date_facturation->format('d/m/Y') }}
                    </span>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('commercial.factures.download', $facture) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <i class="fas fa-file-pdf mr-2"></i>
                    Télécharger PDF
                </a>
                <button type="button" 
                        onclick="document.getElementById('send-email-form').classList.toggle('hidden')"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Envoyer par email
                </button>
            </div>
        </div>

        <!-- Formulaire d'envoi d'email -->
        <div id="send-email-form" class="mb-6 p-4 bg-blue-50 rounded-md hidden">
            <form action="{{ route('commercial.factures.send', $facture) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Destinataire</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="email" name="email" id="email" 
                               class="focus:ring-primary focus:border-primary flex-1 block w-full rounded-md sm:text-sm border-gray-300" 
                               value="{{ $facture->client->email }}" required>
                    </div>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="document.getElementById('send-email-form').classList.add('hidden')"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Envoyer la facture
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Détails de la facture
                </h3>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Client
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="font-medium">{{ $facture->client->nom_entreprise ?? $facture->client->name }}</div>
                            <div class="text-gray-500">{{ $facture->client->email }}</div>
                            <div class="text-gray-500">{{ $facture->client->telephone }}</div>
                        </dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Période de facturation
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            Du {{ $facture->date_debut->format('d/m/Y') }} au {{ $facture->date_fin->format('d/m/Y') }}
                        </dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Date d'échéance
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $facture->date_echeance->format('d/m/Y') }}
                            @if($facture->statut === 'en_retard')
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    En retard
                                </span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Détails des prestations -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Détails des prestations
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantité
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prix unitaire HT
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total HT
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($facture->items as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->description }}</div>
                                <div class="text-sm text-gray-500">{{ $item->service->nom ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                {{ $item->quantite }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                {{ number_format($item->prix_unitaire, 2, ',', ' ') }} €
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                {{ number_format($item->prix_total, 2, ',', ' ') }} €
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Récapitulatif -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Récapitulatif
                </h3>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Sous-total HT
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 text-right">
                            {{ number_format($facture->total_ht, 2, ',', ' ') }} €
                        </dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            TVA ({{ $facture->taux_tva * 100 }}%)
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 text-right">
                            {{ number_format($facture->montant_tva, 2, ',', ' ') }} €
                        </dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50">
                        <dt class="text-lg font-bold text-gray-900">
                            Total TTC
                        </dt>
                        <dd class="mt-1 text-lg font-bold text-gray-900 sm:mt-0 sm:col-span-2 text-right">
                            {{ number_format($facture->total_ttc, 2, ',', ' ') }} €
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Historique des paiements -->
        @if($facture->paiements && $facture->paiements->count() > 0)
        <div class="mt-8">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                Historique des paiements
            </h3>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Montant
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Mode de paiement
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Référence
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($facture->paiements as $paiement)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $paiement->date_paiement->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($paiement->montant, 2, ',', ' ') }} €
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ ucfirst($paiement->mode_paiement) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $paiement->reference }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($paiement->statut === 'validé') bg-green-100 text-green-800
                                        @elseif($paiement->statut === 'en_attente') bg-yellow-100 text-yellow-800
                                        @elseif($paiement->statut === 'refusé') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($paiement->statut) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('commercial.factures.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à la liste
            </a>
            
            @if($facture->statut === 'facture' || $facture->statut === 'en_retard')
            <form action="{{ route('commercial.factures.mark-as-paid', $facture) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="fas fa-check-circle mr-2"></i>
                    Marquer comme payée
                </button>
            </form>
            @endif
            
            @if($facture->statut !== 'annule')
            <form action="{{ route('commercial.factures.cancel', $facture) }}" method="POST" class="inline" 
                  onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette facture ? Cette action est irréversible.');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-times-circle mr-2"></i>
                    Annuler la facture
                </button>
            </form>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Afficher un message de confirmation avant d'envoyer la facture par email
    document.addEventListener('DOMContentLoaded', function() {
        const sendForm = document.getElementById('send-email-form');
        if (sendForm) {
            sendForm.addEventListener('submit', function(e) {
                if (!confirm('Êtes-vous sûr de vouloir envoyer cette facture par email ?')) {
                    e.preventDefault();
                }
            });
        }
    });
</script>
@endpush

@endsection
