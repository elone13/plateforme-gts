@extends('layouts.commercial')

@section('page-title', 'Détails du Devis')
@section('page-description', 'Consultation et gestion du devis')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- En-tête avec actions -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-3xl font-bold text-gray-900">Devis {{ $devis->reference }}</h1>
                <p class="text-lg text-gray-600 mt-1">
                    {{ $devis->client->nom_entreprise ?? $devis->client->nom ?? 'Client' }}
                </p>
            </div>
            
            <!-- Actions rapides -->
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    {{ $devis->statut === 'accepte' ? 'bg-green-100 text-green-800' : 
                       ($devis->statut === 'refuse' ? 'bg-red-100 text-red-800' : 
                       ($devis->statut === 'envoye' ? 'bg-blue-100 text-blue-800' : 
                       'bg-yellow-100 text-yellow-800')) }}">
                    @switch($devis->statut)
                        @case('brouillon')
                            📝 Brouillon
                            @break
                        @case('envoye')
                            📤 Envoyé
                            @break
                        @case('accepte')
                            ✅ Accepté
                            @break
                        @case('refuse')
                            ❌ Refusé
                            @break
                        @case('expire')
                            ⏰ Expiré
                            @break
                        @default
                            {{ ucfirst($devis->statut) }}
                    @endswitch
                </span>
                
                <a href="{{ route('commercial.devis.preview', $devis) }}" 
                   target="_blank"
                   class="inline-flex items-center px-4 py-2 border border-blue-300 shadow-sm text-sm font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                    Aperçu
                </a>
                
                <a href="{{ route('commercial.devis.download', $devis) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.294-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    Télécharger PDF
                </a>
            </div>
        </div>

        <!-- Carte principale du devis -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-8">
                
                <!-- Informations générales -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                    
                    <!-- Informations client -->
                    <div class="lg:col-span-2">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Informations Client
                            </h3>
                            @if($devis->client)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Nom / Entreprise</p>
                                        <p class="text-lg font-semibold text-gray-900">
                                            {{ $devis->client->nom_entreprise ?? $devis->client->nom }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Email</p>
                                        <p class="text-gray-900">{{ $devis->client->email }}</p>
                                    </div>
                                    @if($devis->client->telephone)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Téléphone</p>
                                        <p class="text-gray-900">{{ $devis->client->telephone }}</p>
                                    </div>
                                    @endif
                                    @if($devis->client->adresse)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Adresse</p>
                                        <p class="text-gray-900">{{ $devis->client->adresse }}</p>
                                    </div>
                                    @endif
                                </div>
                            @else
                                <p class="text-gray-500">Aucun client associé</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Détails du devis -->
                    <div>
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Détails du Devis
                            </h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Référence</dt>
                                    <dd class="text-lg font-bold text-blue-600">{{ $devis->reference }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Date d'émission</dt>
                                    <dd class="text-gray-900">{{ \Carbon\Carbon::parse($devis->date)->format('d/m/Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Date de validité</dt>
                                    <dd class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($devis->date_validite)->format('d/m/Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">TVA</dt>
                                    <dd class="text-gray-900">{{ number_format($devis->taux_tva * 100, 0) }}%</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Tableau des prestations -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Prestations
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Désignation</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Durée</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unit.</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Remise</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total HT</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($devis->items as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                                <span class="text-sm font-medium text-gray-900">
                                                    {{ $item->service->nom ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 font-medium">{{ $item->nom }}</div>
                                            @if($item->description)
                                                <div class="text-xs text-gray-500">{{ $item->description }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $item->quantite }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $item->duree_mois ?? 12 }} mois
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm text-gray-900">
                                            {{ number_format($item->prix, 0, ',', ' ') }} FCFA
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($item->remise > 0)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    -{{ number_format($item->remise, 1) }}%
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-semibold text-gray-900">
                                            @php
                                                $total_item = $item->prix * $item->quantite * ($item->duree_mois ?? 12) * (1 - ($item->remise ?? 0) / 100);
                                            @endphp
                                            {{ number_format($total_item, 0, ',', ' ') }} FCFA
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                </svg>
                                                <p class="text-lg font-medium">Aucune prestation</p>
                                                <p class="text-sm">Ce devis ne contient aucune prestation pour le moment.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Récapitulatif financier -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-8 rounded-lg mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Récapitulatif Financier
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-600">Total HT</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($devis->total_ht, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-600">Remise</p>
                            <p class="text-xl font-semibold text-red-600">-{{ number_format($devis->total_remise, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-600">TVA ({{ number_format($devis->taux_tva * 100, 0) }}%)</p>
                            <p class="text-xl font-semibold text-purple-600">{{ number_format($devis->montant_tva, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-600">Total TTC</p>
                            <p class="text-3xl font-bold text-green-600">{{ number_format($devis->total_ttc, 0, ',', ' ') }} FCFA</p>
                        </div>
                    </div>
                </div>

                <!-- Conditions et notes -->
                @if($devis->conditions)
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Conditions Particulières
                    </h3>
                    <div class="bg-orange-50 border border-orange-200 p-6 rounded-lg">
                        <p class="text-gray-700 whitespace-pre-line">{{ $devis->conditions }}</p>
                    </div>
                </div>
                @endif

                <!-- Actions Livewire -->
                <div class="border-t border-gray-200 pt-8">
                    @livewire('commercial.devis-actions', ['devis' => $devis])
                </div>

                <!-- Actions de navigation -->
                <div class="flex flex-col sm:flex-row justify-between items-center pt-8 mt-8 border-t border-gray-200 space-y-4 sm:space-y-0">
                    <a href="{{ route('commercial.devis.index') }}" 
                       class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                        </svg>
                        Retour à la liste
                    </a>
                    
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                        <a href="{{ route('commercial.devis.edit', $devis) }}" 
                           class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                            </svg>
                            Modifier le devis
                        </a>
                        
                        <a href="{{ route('commercial.devis.preview', $devis) }}" 
                           target="_blank"
                           class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                            Aperçu PDF
                        </a>
                        
                        <a href="{{ route('commercial.devis.download', $devis) }}" 
                           class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                                <path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0017 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                            </svg>
                            Télécharger PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
