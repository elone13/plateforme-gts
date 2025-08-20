@extends('layouts.commercial')

@section('page-title', 'Fiche Client - ' . $client->nom)
@section('page-description', 'Gérer et suivre ce client')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header avec actions -->
        <div class="bg-white shadow-lg rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $client->nom }}</h1>
                        @if($client->nom_entreprise)
                            <p class="text-sm text-gray-600">{{ $client->nom_entreprise }}</p>
                        @endif
                        <p class="text-sm text-gray-600">{{ $client->contact_principal }} - {{ $client->email }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('commercial.clients.edit', $client) }}" class="btn-secondary">
                            <i class="fas fa-edit mr-2"></i>Modifier
                        </a>
                        <a href="{{ route('commercial.clients.index') }}" class="btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Colonne principale -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations générales -->
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Informations générales</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $client->nom }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Statut</label>
                                <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($client->statut === 'actif') bg-green-100 text-green-800
                                    @elseif($client->statut === 'inactif') bg-red-100 text-red-800
                                    @elseif($client->statut === 'prospect') bg-yellow-100 text-yellow-800
                                    @elseif($client->statut === 'archive') bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($client->statut) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Secteur d'activité</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $client->secteur_activite ?? 'Non défini' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $client->telephone ?? 'Non renseigné' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de création</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $client->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        
                        @if($client->adresse)
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Adresse</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $client->adresse }}</p>
                        </div>
                        @endif
                        
                        @if($client->notes)
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Notes</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $client->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Historique des demandes de démo -->
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Demandes de démo</h3>
                    </div>
                    <div class="p-6">
                        @if($client->demandeDemos->count() > 0)
                            <div class="space-y-3">
                                @foreach($client->demandeDemos->take(5) as $demo)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $demo->message }}</p>
                                        <p class="text-xs text-gray-500">{{ $demo->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($demo->statut === 'en_attente') bg-yellow-100 text-yellow-800
                                        @elseif($demo->statut === 'acceptee') bg-green-100 text-green-800
                                        @elseif($demo->statut === 'planifiee') bg-blue-100 text-blue-800
                                        @elseif($demo->statut === 'en_cours') bg-purple-100 text-purple-800
                                        @elseif($demo->statut === 'terminee') bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($demo->statut) }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                            @if($client->demandeDemos->count() > 5)
                                <div class="mt-4 text-center">
                                    <a href="#" class="text-primary hover:text-primary-dark text-sm">
                                        Voir toutes les demandes ({{ $client->demandeDemos->count() }})
                                    </a>
                                </div>
                            @endif
                        @else
                            <p class="text-gray-500 text-center py-4">Aucune demande de démo</p>
                        @endif
                    </div>
                </div>

                <!-- Historique des devis -->
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Devis</h3>
                    </div>
                    <div class="p-6">
                        @if($client->devis->count() > 0)
                            <div class="space-y-3">
                                @foreach($client->devis->take(5) as $devis)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Devis #{{ $devis->id }}</p>
                                        <p class="text-xs text-gray-500">{{ $devis->created_at->format('d/m/Y') }} - {{ number_format($devis->montant_total, 2) }}€</p>
                                    </div>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($devis->statut === 'en_attente') bg-yellow-100 text-yellow-800
                                        @elseif($devis->statut === 'accepte') bg-green-100 text-green-800
                                        @elseif($devis->statut === 'refuse') bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($devis->statut) }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">Aucun devis</p>
                        @endif
                    </div>
                </div>

                <!-- Historique des factures -->
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Factures</h3>
                    </div>
                    <div class="p-6">
                        @if($client->factures->count() > 0)
                            <div class="space-y-3">
                                @foreach($client->factures->take(5) as $facture)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Facture #{{ $facture->numero }}</p>
                                        <p class="text-xs text-gray-500">{{ $facture->created_at->format('d/m/Y') }} - {{ number_format($facture->montant_total, 2) }}€</p>
                                    </div>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($facture->statut === 'impayee') bg-red-100 text-red-800
                                        @elseif($facture->statut === 'payee') bg-green-100 text-green-800
                                        @elseif($facture->statut === 'en_retard') bg-orange-100 text-orange-800
                                        @endif">
                                        {{ ucfirst($facture->statut) }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">Aucune facture</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar avec actions rapides -->
            <div class="space-y-6">
                <!-- Actions rapides -->
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Actions rapides</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <!-- Planifier RDV -->
                            <a href="#" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                <i class="fas fa-calendar-plus text-sm"></i>
                                <span>Planifier RDV</span>
                            </a>
                            
                            <!-- Envoyer email -->
                            <a href="#" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                <i class="fas fa-envelope text-sm"></i>
                                <span>Envoyer email</span>
                            </a>
                            
                            <!-- Nouvelle demande démo -->
                            <a href="{{ route('commercial.demandes-demo.create') }}?client_id={{ $client->idclient }}" 
                               class="w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                <i class="fas fa-desktop text-sm"></i>
                                <span>Nouvelle demande démo</span>
                            </a>
                            
                            <!-- Nouveau devis -->
                            <a href="{{ route('commercial.devis.create') }}?client_id={{ $client->idclient }}" 
                               class="w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                <i class="fas fa-file-alt text-sm"></i>
                                <span>Nouveau devis</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Statistiques du client -->
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Statistiques</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Demandes de démo</span>
                                <span class="text-sm font-medium text-gray-900 bg-purple-100 px-2 py-1 rounded-full">
                                    {{ $client->demandeDemos->count() }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Devis</span>
                                <span class="text-sm font-medium text-gray-900 bg-blue-100 px-2 py-1 rounded-full">
                                    {{ $client->devis->count() }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Factures</span>
                                <span class="text-sm font-medium text-gray-900 bg-green-100 px-2 py-1 rounded-full">
                                    {{ $client->factures->count() }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Abonnements actifs</span>
                                <span class="text-sm font-medium text-gray-900 bg-yellow-100 px-2 py-1 rounded-full">
                                    {{ $client->abonnements->where('statut', 'actif')->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations rapides -->
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Informations rapides</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                <span>Créé le {{ $client->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-clock text-gray-400 mr-2"></i>
                                <span>Dernière interaction : {{ $client->derniere_interaction ? $client->derniere_interaction->diffForHumans() : 'Jamais' }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                <span>{{ $client->adresse ?: 'Adresse non renseignée' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
