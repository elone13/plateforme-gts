@extends('layouts.portal')

@section('title', 'Mes demandes de démo')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Mes demandes de démo</h1>
                    <p class="mt-1 text-sm text-gray-600">Consultez l'état de vos demandes de démonstration</p>
                </div>
                <a href="{{ route('client.profile') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour au profil
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($demandesDemo->count() > 0)
            <!-- Statistiques rapides -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">En attente</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $demandesDemo->where('statut', 'en_attente')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar-check text-purple-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Programmées</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $demandesDemo->where('statut', 'planifiee')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Terminées</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $demandesDemo->where('statut', 'terminee')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-total text-blue-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $demandesDemo->total() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des demandes -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Toutes vos demandes</h3>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @foreach($demandesDemo as $demande)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-desktop text-primary-600"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-3">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">
                                                Demande #{{ $demande->id }}
                                            </h4>
                                            <span class="inline-flex px-2.5 py-0.5 text-xs font-medium rounded-full
                                                {{ $demande->statut === 'acceptee' ? 'bg-green-100 text-green-800' : 
                                                   ($demande->statut === 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($demande->statut === 'en_cours' ? 'bg-blue-100 text-blue-800' :
                                                   ($demande->statut === 'terminee' ? 'bg-gray-100 text-gray-800' :
                                                   ($demande->statut === 'planifiee' ? 'bg-purple-100 text-purple-800' :
                                                   'bg-red-100 text-red-800')))) }}">
                                                @switch($demande->statut)
                                                    @case('en_attente')
                                                        En attente
                                                        @break
                                                    @case('acceptee')
                                                        Acceptée
                                                        @break
                                                    @case('en_cours')
                                                        En cours
                                                        @break
                                                    @case('terminee')
                                                        Terminée
                                                        @break
                                                    @case('planifiee')
                                                        Rendez-vous programmé
                                                        @break
                                                    @case('refusee')
                                                        Refusée
                                                        @break
                                                    @default
                                                        {{ ucfirst($demande->statut) }}
                                                @endswitch
                                            </span>
                                        </div>
                                        <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500">
                                            <span>
                                                <i class="fas fa-calendar mr-1"></i>
                                                {{ \Carbon\Carbon::parse($demande->created_at)->format('d/m/Y H:i') }}
                                            </span>
                                            @if($demande->societe)
                                            <span>
                                                <i class="fas fa-building mr-1"></i>
                                                {{ $demande->societe }}
                                            </span>
                                            @endif
                                            @if($demande->nombre_vehicules)
                                            <span>
                                                <i class="fas fa-truck mr-1"></i>
                                                {{ $demande->nombre_vehicules }}
                                            </span>
                                            @endif
                                        </div>
                                        @if($demande->message)
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($demande->message, 120) }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                @if($demande->statut === 'planifiee' && $demande->date_rdv)
                                <div class="text-right">
                                    <div class="text-sm font-medium text-purple-600">
                                        <i class="fas fa-calendar-check mr-1"></i>
                                        RDV le {{ \Carbon\Carbon::parse($demande->date_rdv)->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($demande->heure_rdv)->format('H:i') }}
                                    </div>
                                    @if($demande->lien_reunion)
                                    <div class="mt-2">
                                        <a href="{{ $demande->lien_reunion }}" target="_blank" 
                                           class="inline-flex items-center px-2 py-1 bg-purple-600 text-white text-xs font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                                            <i class="fas fa-video mr-1"></i>
                                            Rejoindre
                                        </a>
                                    </div>
                                    @endif
                                </div>
                                @endif
                                <a href="{{ route('client.demandes-demo.show', $demande) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    <i class="fas fa-eye mr-2"></i>
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($demandesDemo->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $demandesDemo->links() }}
                </div>
                @endif
            </div>
        @else
            <!-- Aucune demande -->
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-desktop text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune demande de démo</h3>
                <p class="text-gray-500 mb-6">Vous n'avez pas encore fait de demande de démonstration.</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Faire une demande de démo
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
