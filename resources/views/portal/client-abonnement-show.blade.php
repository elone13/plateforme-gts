@extends('layouts.portal')
@section('title', 'Détails Abonnement - GTS Afrique')
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
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Détails de l'abonnement</h2>
                    <p class="text-lg text-gray-600">{{ $abonnement->service->nom }}</p>
                </div>
                <a href="{{ route('client.abonnements') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 bg-white rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à mes abonnements
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 xl:gap-8">
            <!-- Informations principales -->
            <div class="xl:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">Informations de l'abonnement</h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Service -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Service</label>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gts-primary rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-cog text-white"></i>
                                    </div>
                                    <div>
                                        <div class="text-lg font-medium text-gray-900">{{ $abonnement->service->nom }}</div>
                                        <div class="text-sm text-gray-500">{{ $abonnement->service->description }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Statut -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Statut</label>
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    @if($abonnement->statut === 'actif') bg-green-100 text-green-800
                                    @elseif($abonnement->statut === 'suspendu') bg-yellow-100 text-yellow-800
                                    @elseif($abonnement->statut === 'résilié') bg-red-100 text-red-800
                                    @elseif($abonnement->statut === 'expiré') bg-gray-100 text-gray-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ ucfirst($abonnement->statut) }}
                                </span>
                            </div>

                            <!-- Date de début -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Date de début</label>
                                <div class="text-lg font-medium text-gray-900">{{ $abonnement->date_debut->format('d/m/Y') }}</div>
                            </div>

                            <!-- Date de fin -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Date de fin</label>
                                <div class="text-lg font-medium text-gray-900 
                                    @if($abonnement->date_fin->isPast()) text-red-600 @endif">
                                    {{ $abonnement->date_fin->format('d/m/Y') }}
                                </div>
                                @if($abonnement->date_fin->isPast())
                                    <div class="text-sm text-red-600 mt-1">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Expiré
                                    </div>
                                @else
                                    <div class="text-sm text-gray-500 mt-1">
                                        {{ $abonnement->date_fin->diffForHumans() }}
                                    </div>
                                @endif
                            </div>

                            <!-- Durée -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Durée</label>
                                <div class="text-lg font-medium text-gray-900">{{ $abonnement->duree_mois }} mois</div>
                            </div>

                            <!-- Prix mensuel -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Prix mensuel</label>
                                <div class="text-lg font-medium text-gray-900">{{ number_format($abonnement->prix_mensuel, 0) }} FCFA</div>
                            </div>

                            <!-- Prix total -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Prix total</label>
                                <div class="text-lg font-medium text-gray-900">{{ number_format($abonnement->prix_total, 0) }} FCFA</div>
                            </div>

                            <!-- Renouvellement automatique -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Renouvellement</label>
                                <div class="text-lg font-medium text-gray-900">
                                    @if($abonnement->renouvellement_automatique)
                                        <span class="text-green-600">
                                            <i class="fas fa-check mr-1"></i>Automatique
                                        </span>
                                    @else
                                        <span class="text-gray-600">
                                            <i class="fas fa-times mr-1"></i>Manuel
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        @if($abonnement->notes)
                        <div class="mt-8">
                            <label class="block text-sm font-medium text-gray-500 mb-2">Notes</label>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-900">{{ $abonnement->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informations complémentaires -->
            <div class="space-y-6">
                <!-- Progression -->
                @if($abonnement->statut === 'actif')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-900">Progression</h4>
                    </div>
                    <div class="p-6">
                        @php
                            $totalJours = $abonnement->date_debut->diffInDays($abonnement->date_fin);
                            $joursEcoules = $abonnement->date_debut->diffInDays(now());
                            $progression = $totalJours > 0 ? min(100, ($joursEcoules / $totalJours) * 100) : 0;
                        @endphp
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600">Progression</span>
                                <span class="font-medium">{{ number_format($progression, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gts-primary h-2 rounded-full transition-all duration-300" style="width: {{ $progression }}%"></div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>{{ $joursEcoules }} jours écoulés</span>
                                <span>{{ max(0, $totalJours - $joursEcoules) }} jours restants</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Informations de création -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-900">Informations</h4>
                    </div>
                    <div class="p-6 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Créé le :</span>
                            <span class="text-gray-900">{{ $abonnement->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Modifié le :</span>
                            <span class="text-gray-900">{{ $abonnement->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Référence :</span>
                            <span class="text-gray-900 font-mono">#{{ $abonnement->id }}</span>
                        </div>
                    </div>
                </div>

                <!-- Contact support -->
                <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-question-circle text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-blue-900 mb-2">Besoin d'aide ?</h4>
                            <p class="text-sm text-blue-700 mb-4">
                                Notre équipe support est disponible pour répondre à toutes vos questions concernant votre abonnement.
                            </p>
                            <a href="{{ route('contact') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                <i class="fas fa-envelope mr-2"></i>
                                Contacter le support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
