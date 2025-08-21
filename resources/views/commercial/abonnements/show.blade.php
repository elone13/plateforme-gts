@extends('layouts.commercial')
@section('title', 'Détails Abonnement - GTS Afrique')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête de la page -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Détails de l'Abonnement</h1>
                <p class="text-base lg:text-lg text-gray-600">Informations complètes sur l'abonnement</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('abonnements.index') }}" 
                   class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>
                <a href="{{ route('abonnements.edit', $abonnement) }}" 
                   class="btn-gts-primary inline-flex items-center justify-center px-4 py-2 rounded-lg">
                    <i class="fas fa-edit mr-2"></i>
                    Modifier
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 xl:gap-8">
        <!-- Informations principales -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 lg:px-8 py-6 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900">Informations de l'abonnement</h3>
                </div>
                
                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Client -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Client</label>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gts-primary flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ strtoupper(substr($abonnement->client->nom, 0, 2)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4 min-w-0 flex-1">
                                    <div class="text-base lg:text-lg font-medium text-gray-900 truncate">{{ $abonnement->client->nom }}</div>
                                    <div class="text-sm text-gray-500 truncate">{{ $abonnement->client->email }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Service -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Service</label>
                            <div class="text-base lg:text-lg font-medium text-gray-900 truncate">{{ $abonnement->service->nom }}</div>
                            <div class="text-sm text-gray-500 truncate">{{ $abonnement->service->description }}</div>
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

                        <!-- Durée -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Durée</label>
                            <div class="text-base lg:text-lg font-medium text-gray-900">{{ $abonnement->duree_mois }} mois</div>
                        </div>

                        <!-- Date de début -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Date de début</label>
                            <div class="text-base lg:text-lg font-medium text-gray-900">{{ $abonnement->date_debut->format('d/m/Y') }}</div>
                        </div>

                        <!-- Date de fin -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Date de fin</label>
                            <div class="text-base lg:text-lg font-medium text-gray-900 
                                @if($abonnement->date_fin->isPast()) text-red-600 @endif">
                                {{ $abonnement->date_fin->format('d/m/Y') }}
                            </div>
                        </div>

                                                             <!-- Prix mensuel -->
                                     <div>
                                         <label class="block text-sm font-medium text-gray-500 mb-2">Prix mensuel</label>
                                         <div class="text-base lg:text-lg font-medium text-gray-900">{{ number_format($abonnement->prix_mensuel, 0) }} FCFA</div>
                                     </div>
 
                                     <!-- Prix total -->
                                     <div>
                                         <label class="block text-sm font-medium text-gray-500 mb-2">Prix total</label>
                                         <div class="text-base lg:text-lg font-medium text-gray-900">{{ number_format($abonnement->prix_total, 0) }} FCFA</div>
                                     </div>

                        <!-- Renouvellement automatique -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Renouvellement</label>
                            <div class="text-base lg:text-lg font-medium text-gray-900">
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

                        <!-- Date de renouvellement -->
                        @if($abonnement->date_renouvellement)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Date de renouvellement</label>
                            <div class="text-base lg:text-lg font-medium text-gray-900">{{ $abonnement->date_renouvellement->format('d/m/Y') }}</div>
                        </div>
                        @endif
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

        <!-- Actions et informations -->
        <div class="space-y-6">
            <!-- Actions rapides -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900">Actions</h4>
                </div>
                <div class="p-6 space-y-3">
                    @if($abonnement->statut === 'actif')
                        <form action="{{ route('abonnements.renouveler', $abonnement) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full btn-gts-primary px-4 py-2 rounded-lg">
                                <i class="fas fa-sync-alt mr-2"></i>
                                Renouveler
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('abonnements.change-statut', $abonnement) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="statut" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gts-primary focus:border-transparent">
                            <option value="actif" {{ $abonnement->statut === 'actif' ? 'selected' : '' }}>Actif</option>
                            <option value="suspendu" {{ $abonnement->statut === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                            <option value="résilié" {{ $abonnement->statut === 'résilié' ? 'selected' : '' }}>Résilié</option>
                            <option value="expiré" {{ $abonnement->statut === 'expiré' ? 'selected' : '' }}>Expiré</option>
                        </select>
                        <button type="submit" class="w-full mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-save mr-2"></i>
                            Changer le statut
                        </button>
                    </form>

                    <form action="{{ route('abonnements.destroy', $abonnement) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet abonnement ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>

            <!-- Informations de création -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900">Informations système</h4>
                </div>
                <div class="p-6 space-y-3 text-sm">
                    <div>
                        <span class="text-gray-500">Créé le :</span>
                        <span class="text-gray-900">{{ $abonnement->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Modifié le :</span>
                        <span class="text-gray-900">{{ $abonnement->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">ID :</span>
                        <span class="text-gray-900">{{ $abonnement->id }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
