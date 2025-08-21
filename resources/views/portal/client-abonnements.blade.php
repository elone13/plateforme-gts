@extends('layouts.portal')
@section('title', 'Mes Abonnements - GTS Afrique')
@section('content')

<div class="min-h-screen bg-gray-50">
    <!-- Header de l'espace client -->
    <div class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-semibold text-gray-900">Mon Espace Client</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Navigation principale -->
                    <nav class="hidden md:flex space-x-8">
                        <a href="{{ route('client.profile') }}" class="text-gray-600 hover:text-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Tableau de bord
                        </a>
                        <a href="{{ route('client.demandes') }}" class="text-gray-600 hover:text-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Mes Demandes
                        </a>
                        <a href="{{ route('client.devis') }}" class="text-gray-600 hover:text-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Devis
                        </a>
                        <a href="{{ route('client.factures') }}" class="text-gray-600 hover:text-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Factures
                        </a>
                        <a href="{{ route('client.abonnements') }}" class="text-gts-primary border-b-2 border-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Abonnements
                        </a>
                    </nav>
                    
                    <!-- Bouton retour à l'accueil -->
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gts-primary text-white text-sm font-medium rounded-lg hover:bg-gts-primary/90 transition-colors duration-200">
                        <i class="fas fa-home mr-2"></i>
                        Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" style="padding-top: 8rem; margin-top: 2rem;">
        
        <!-- En-tête de la page -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Mes Abonnements</h2>
                    <p class="text-lg text-gray-600">Consultez vos abonnements et services actifs</p>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-blue-100 rounded-xl">
                            <i class="fas fa-list text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Actifs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-green-100 rounded-xl">
                            <i class="fas fa-check text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Actifs</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['actifs'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Expirés -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-red-100 rounded-xl">
                            <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Expirés</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['expires'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Résiliés -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-gray-100 rounded-xl">
                            <i class="fas fa-ban text-gray-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Résiliés</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['resilies'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des abonnements -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Mes abonnements</h3>
            </div>
            
            @if($abonnements->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($abonnements as $abonnement)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <!-- Informations principales -->
                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                                    <!-- Icône du service -->
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gts-primary rounded-lg flex items-center justify-center">
                                            <i class="fas fa-cog text-white text-xl"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Détails de l'abonnement -->
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-lg font-medium text-gray-900 mb-1">{{ $abonnement->service->nom }}</h4>
                                        <p class="text-sm text-gray-600 mb-2">{{ $abonnement->service->description }}</p>
                                        
                                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                            <span class="flex items-center">
                                                <i class="fas fa-calendar mr-1"></i>
                                                {{ $abonnement->date_debut->format('d/m/Y') }} - {{ $abonnement->date_fin->format('d/m/Y') }}
                                            </span>
                                            <span class="flex items-center">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $abonnement->duree_mois }} mois
                                            </span>
                                            <span class="flex items-center">
                                                <i class="fas fa-money-bill mr-1"></i>
                                                {{ number_format($abonnement->prix_mensuel, 0) }} FCFA/mois
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Statut et actions -->
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                <!-- Statut -->
                                <div class="flex items-center">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                        @if($abonnement->statut === 'actif') bg-green-100 text-green-800
                                        @elseif($abonnement->statut === 'suspendu') bg-yellow-100 text-yellow-800
                                        @elseif($abonnement->statut === 'résilié') bg-red-100 text-red-800
                                        @elseif($abonnement->statut === 'expiré') bg-gray-100 text-gray-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ ucfirst($abonnement->statut) }}
                                    </span>
                                </div>
                                
                                <!-- Bouton voir détails -->
                                <a href="{{ route('client.abonnements.show', $abonnement) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gts-primary text-white text-sm font-medium rounded-lg hover:bg-gts-primary/90 transition-colors duration-200">
                                    <i class="fas fa-eye mr-2"></i>
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($abonnements->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $abonnements->links() }}
                </div>
                @endif
            @else
                <!-- État vide -->
                <div class="p-12 text-center">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun abonnement</h3>
                    <p class="text-gray-600 mb-6">Vous n'avez pas encore d'abonnement actif.</p>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gts-primary text-white font-medium rounded-lg hover:bg-gts-primary/90 transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Découvrir nos services
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
