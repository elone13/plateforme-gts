@extends('layouts.portal')
@section('title', 'Mes Demandes de Démo - GTS Afrique')
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
                        <a href="{{ route('client.demandes') }}" class="text-gts-primary border-b-2 border-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Mes Demandes
                        </a>
                        <a href="{{ route('client.devis') }}" class="text-gray-600 hover:text-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Devis
                        </a>
                        <a href="{{ route('client.factures') }}" class="text-gray-600 hover:text-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Factures
                        </a>
                        <a href="{{ route('client.abonnements') }}" class="text-gray-600 hover:text-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
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
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Mes Demandes de Démo</h2>
                    <p class="text-lg text-gray-600">Suivi complet de vos demandes et rendez-vous</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('contact') }}" class="btn-gts-primary inline-flex items-center px-6 py-3 rounded-xl">
                        <i class="fas fa-plus mr-2"></i>
                        Nouvelle demande
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <i class="fas fa-desktop text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $demandesDemo->total() }}</p>
                    </div>
                </div>
            </div>

            <!-- En attente -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-xl">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">En attente</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $demandesDemo->where('statut', 'en_attente')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Programmées -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-xl">
                        <i class="fas fa-calendar-check text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Programmées</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $demandesDemo->where('statut', 'planifiee')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Terminées -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-xl">
                        <i class="fas fa-check text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Terminées</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $demandesDemo->where('statut', 'terminee')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($demandesDemo->count() > 0)
            <!-- Rendez-vous programmés avec liens -->
            @php
                $demandesProgrammees = $demandesDemo->where('statut', 'planifiee')->where('lien_reunion', '!=', null);
            @endphp
            @if($demandesProgrammees->count() > 0)
            <div class="bg-purple-50 border border-purple-200 rounded-2xl p-8 mb-8">
                <h3 class="text-xl font-semibold text-purple-800 mb-6 flex items-center">
                    <i class="fas fa-video text-purple-600 mr-3"></i>
                    Rendez-vous programmés ({{ $demandesProgrammees->count() }})
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($demandesProgrammees as $demande)
                    <div class="bg-white rounded-xl p-6 border border-purple-200 shadow-sm">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 text-lg">{{ $demande->societe ?? 'Démo' }}</h4>
                                <div class="mt-2 space-y-1">
                                    <p class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-calendar mr-2 text-purple-500"></i>
                                        {{ $demande->date_rdv ? \Carbon\Carbon::parse($demande->date_rdv)->format('d/m/Y') : 'Date non définie' }}
                                    </p>
                                    <p class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-clock mr-2 text-purple-500"></i>
                                        {{ $demande->heure_rdv ? \Carbon\Carbon::parse($demande->heure_rdv)->format('H:i') : 'Heure non définie' }}
                                    </p>
                                    @if($demande->duree_rdv)
                                    <p class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-hourglass-half mr-2 text-purple-500"></i>
                                        {{ $demande->duree_rdv }} minutes
                                    </p>
                                    @endif
                                </div>
                                @if($demande->instructions_rdv)
                                <p class="text-sm text-gray-600 mt-3 bg-gray-50 p-3 rounded-lg">
                                    <i class="fas fa-info-circle mr-2 text-gray-500"></i>
                                    {{ $demande->instructions_rdv }}
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ $demande->lien_reunion }}" target="_blank" 
                               class="flex-1 bg-purple-600 text-white px-4 py-3 rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors duration-200 text-center">
                                <i class="fas fa-video mr-2"></i>
                                Rejoindre
                            </a>
                            <a href="{{ route('client.demandes-demo.show', $demande) }}" 
                               class="px-4 py-3 border border-purple-600 text-purple-600 rounded-lg text-sm font-medium hover:bg-purple-50 transition-colors duration-200">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Liste complète des demandes -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900">Toutes mes demandes</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Demande
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Société
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date demande
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    RDV prévu
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($demandesDemo as $demande)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                                <i class="fas fa-desktop text-purple-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Demande #{{ $demande->id }}</div>
                                            <div class="text-sm text-gray-500">{{ $demande->nombre_vehicules ?? 'N/A' }} véhicules</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $demande->societe ?? 'Non spécifiée' }}</div>
                                    <div class="text-sm text-gray-500">{{ $demande->jour_prefere ?? 'Aucune préférence' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $demande->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                        @if($demande->statut === 'en_attente') bg-yellow-100 text-yellow-800
                                        @elseif($demande->statut === 'planifiee') bg-purple-100 text-purple-800
                                        @elseif($demande->statut === 'terminee') bg-green-100 text-green-800
                                        @elseif($demande->statut === 'refusee') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        @switch($demande->statut)
                                            @case('en_attente')
                                                En attente
                                                @break
                                            @case('planifiee')
                                                Programmée
                                                @break
                                            @case('terminee')
                                                Terminée
                                                @break
                                            @case('refusee')
                                                Refusée
                                                @break
                                            @default
                                                {{ ucfirst($demande->statut) }}
                                        @endswitch
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($demande->date_rdv)
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-check text-purple-500 mr-2"></i>
                                            {{ \Carbon\Carbon::parse($demande->date_rdv)->format('d/m/Y H:i') }}
                                        </div>
                                    @else
                                        <span class="text-gray-400">Non programmé</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('client.demandes-demo.show', $demande) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($demande->lien_reunion)
                                        <a href="{{ $demande->lien_reunion }}" target="_blank"
                                           class="text-purple-600 hover:text-purple-900 transition-colors duration-200">
                                            <i class="fas fa-video"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($demandesDemo->hasPages())
                <div class="px-8 py-6 border-t border-gray-200">
                    {{ $demandesDemo->links() }}
                </div>
                @endif
            </div>
        @else
            <!-- Message si aucune demande -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12">
                <div class="text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-calendar-plus text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Aucune demande de démo</h3>
                    <p class="text-gray-600 mb-8">Vous n'avez pas encore fait de demande de démonstration de nos services.</p>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Demander une démo
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
