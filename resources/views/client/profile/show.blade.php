@extends('layouts.app')

@section('page-title', 'Mon Profil - GTS AFRIQUE')
@section('page-description', 'Gérez votre profil et consultez vos devis')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- En-tête du profil -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mon Profil</h1>
            <p class="text-lg text-gray-600 mt-2">Bienvenue, {{ $client->nom_entreprise ?? $client->nom }}</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Informations du profil -->
            <div class="lg:col-span-1">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Informations Personnelles
                        </h2>
                        
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nom / Entreprise</p>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $client->nom_entreprise ?? $client->nom }}
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="text-gray-900">{{ $client->email }}</p>
                            </div>
                            
                            @if($client->telephone)
                            <div>
                                <p class="text-sm font-medium text-gray-500">Téléphone</p>
                                <p class="text-gray-900">{{ $client->telephone }}</p>
                            </div>
                            @endif
                            
                            @if($client->adresse)
                            <div>
                                <p class="text-sm font-medium text-gray-500">Adresse</p>
                                <p class="text-gray-900">{{ $client->adresse }}</p>
                            </div>
                            @endif
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Statistiques</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-blue-600">{{ count($devis) }}</p>
                                    <p class="text-sm text-gray-600">Devis</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-green-600">
                                        {{ $devis->where('statut', 'valide')->count() }}
                                    </p>
                                    <p class="text-sm text-gray-600">Validés</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Liste des devis -->
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Mes Devis
                        </h2>
                        
                        @if($devis->count() > 0)
                            <div class="space-y-4">
                                @foreach($devis as $devisItem)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-3">
                                                    <h3 class="text-lg font-semibold text-gray-900">
                                                        Devis {{ $devisItem->reference }}
                                                    </h3>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        {{ $devisItem->statut === 'valide' ? 'bg-green-100 text-green-800' : 
                                                           ($devisItem->statut === 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 
                                                           'bg-gray-100 text-gray-800') }}">
                                                        @switch($devisItem->statut)
                                                            @case('en_attente')
                                                                ⏳ En attente
                                                                @break
                                                            @case('valide')
                                                                ✅ Validé
                                                                @break
                                                            @default
                                                                {{ ucfirst($devisItem->statut) }}
                                                        @endswitch
                                                    </span>
                                                </div>
                                                
                                                <div class="mt-2 text-sm text-gray-600">
                                                    <p><strong>Date :</strong> {{ $devisItem->date->format('d/m/Y') }}</p>
                                                    <p><strong>Total :</strong> {{ number_format($devisItem->total_ttc, 0, ',', ' ') }} FCFA</p>
                                                    <p><strong>Prestations :</strong> {{ $devisItem->items->count() }} service(s)</p>
                                                </div>
                                            </div>
                                            
                                            <div class="flex flex-col space-y-2">
                                                <a href="{{ route('client.profile.devis.show', $devisItem) }}" 
                                                   class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                    👁️ Voir
                                                </a>
                                                
                                                <a href="{{ route('client.profile.devis.preview', $devisItem) }}" 
                                                   target="_blank"
                                                   class="inline-flex items-center px-3 py-2 border border-blue-300 shadow-sm text-sm font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100">
                                                    📄 Aperçu
                                                </a>
                                                
                                                <a href="{{ route('client.profile.devis.download', $devisItem) }}" 
                                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                                                    📥 PDF
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun devis</h3>
                                <p class="mt-1 text-sm text-gray-500">Vous n'avez pas encore de devis.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
