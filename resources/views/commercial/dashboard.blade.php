@extends('layouts.commercial')

@section('page-title', 'Tableau de bord Commercial')
@section('page-description', 'Vue d\'ensemble de vos activités commerciales')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Statistiques rapides -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Clients</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Client::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-file-invoice text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Devis</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Devis::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-rocket text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Demandes Démo</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\DemandeDemo::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">En Attente</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\DemandeDemo::where('statut', 'en_attente')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-200 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Actions rapides</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('commercial.demandes-demo.index') }}" 
                   class="group relative bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-rocket text-2xl text-white group-hover:scale-110 transition-transform duration-200"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-white">Gérer les demandes de démo</h4>
                            <p class="text-green-100 text-sm">Traiter et confirmer les rendez-vous</p>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4">
                        <i class="fas fa-arrow-right text-white/60 group-hover:text-white group-hover:translate-x-1 transition-all duration-200"></i>
                    </div>
                </a>

                <button wire:click="$dispatch('openCreateDevisModal')" class="group relative bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-file-invoice text-2xl text-white group-hover:scale-110 transition-transform duration-200"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-white">Créer un devis</h4>
                            <p class="text-blue-100 text-sm">Générer des devis pour les clients</p>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4">
                        <i class="fas fa-arrow-right text-white/60 group-hover:text-white group-hover:translate-x-1 transition-all duration-200"></i>
                    </div>
                </button>

                <a href="{{ route('commercial.clients.create') }}" class="group relative bg-gradient-to-r from-purple-500 to-purple-600 p-6 rounded-lg hover:from-purple-600 hover:to-purple-700 transition-all duration-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-2xl text-white group-hover:scale-110 transition-transform duration-200"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-white">Nouveau client</h4>
                            <p class="text-purple-100 text-sm">Ajouter un nouveau client</p>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4">
                        <i class="fas fa-arrow-right text-white/60 group-hover:text-white group-hover:translate-x-1 transition-all duration-200"></i>
                    </div>
                </a>
            </div>
        </div>

        <!-- Demandes de démo récentes -->
        <div class="bg-white shadow-lg rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Demandes de démo récentes</h3>
                    <a href="{{ route('commercial.demandes-demo.index') }}" class="text-sm text-primary hover:text-primary/80">
                        Voir toutes →
                    </a>
                </div>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse(\App\Models\DemandeDemo::latest()->take(5)->get() as $demande)
                <div class="px-6 py-4 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 h-8 w-8">
                                <div class="h-8 w-8 rounded-full bg-primary/20 flex items-center justify-center">
                                    <span class="text-xs font-medium text-primary">
                                        {{ strtoupper(substr($demande->nom, 0, 2)) }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $demande->nom }}</p>
                                <p class="text-sm text-gray-500">{{ $demande->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $demande->statut_class }}">
                                {{ $demande->statut_formatted }}
                            </span>
                            <a href="{{ route('commercial.demandes-demo.show', $demande) }}" 
                               class="text-primary hover:text-primary/80">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-4 text-center text-gray-500">
                    Aucune demande de démo pour le moment.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Composant Livewire pour le modal de création de devis -->
@livewire('commercial.create-devis-modal')
@endsection 