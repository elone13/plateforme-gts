@extends('layouts.commercial')
@section('title', 'Gestion des Abonnements - GTS Afrique')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête de la page -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Abonnements</h1>
                <p class="text-lg text-gray-600">Suivi et gestion des abonnements clients</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('abonnements.create') }}" 
                   class="btn-gts-primary inline-flex items-center px-6 py-3 rounded-xl">
                    <i class="fas fa-plus mr-2"></i>
                    Nouvel Abonnement
                </a>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-xl">
                    <i class="fas fa-list text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <!-- Actifs -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-xl">
                    <i class="fas fa-check text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Actifs</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $stats['actifs'] }}</p>
                </div>
            </div>
        </div>

        <!-- Expirés -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-xl">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Expirés</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $stats['expires'] }}</p>
                </div>
            </div>
        </div>

        <!-- À renouveler -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-xl">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">À renouveler</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $stats['a_renouveler'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" 
                       placeholder="Rechercher par client, service..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gts-primary focus:border-transparent">
            </div>
            <div class="flex gap-3">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gts-primary focus:border-transparent">
                    <option value="">Tous les statuts</option>
                    <option value="actif">Actif</option>
                    <option value="suspendu">Suspendu</option>
                    <option value="résilié">Résilié</option>
                    <option value="expiré">Expiré</option>
                </select>
                <button class="btn-gts-primary px-6 py-2 rounded-lg">
                    <i class="fas fa-search mr-2"></i>
                    Filtrer
                </button>
            </div>
        </div>
    </div>

    <!-- Liste des abonnements -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 lg:px-8 py-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900">Tous les abonnements</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Client
                        </th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                            Service
                        </th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                            Prix
                        </th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden xl:table-cell">
                            Dates
                        </th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($abonnements as $abonnement)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-3 lg:px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 lg:h-10 lg:w-10">
                                    <div class="h-8 w-8 lg:h-10 lg:w-10 rounded-full bg-gts-primary flex items-center justify-center">
                                        <span class="text-xs lg:text-sm font-medium text-gray-900">
                                            {{ strtoupper(substr($abonnement->client->nom, 0, 2)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-3 lg:ml-4 min-w-0 flex-1">
                                    <div class="text-sm font-medium text-gray-900 truncate">{{ $abonnement->client->nom }}</div>
                                    <div class="text-xs lg:text-sm text-gray-500 truncate">{{ $abonnement->client->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 lg:px-6 py-4 hidden lg:table-cell">
                            <div class="text-sm text-gray-900 truncate">{{ $abonnement->service->nom }}</div>
                            <div class="text-xs text-gray-500 truncate max-w-xs">{{ $abonnement->service->description }}</div>
                        </td>
                        <td class="px-3 lg:px-6 py-4">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($abonnement->statut === 'actif') bg-green-100 text-green-800
                                @elseif($abonnement->statut === 'suspendu') bg-yellow-100 text-yellow-800
                                @elseif($abonnement->statut === 'résilié') bg-red-100 text-red-800
                                @elseif($abonnement->statut === 'expiré') bg-gray-100 text-gray-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ ucfirst($abonnement->statut) }}
                            </span>
                        </td>
                                                        <td class="px-3 lg:px-6 py-4 hidden md:table-cell">
                                    <div class="text-sm text-gray-900">{{ number_format($abonnement->prix_mensuel, 0) }} FCFA/mois</div>
                                    <div class="text-xs text-gray-500">{{ number_format($abonnement->prix_total, 0) }} FCFA total</div>
                                </td>
                        <td class="px-3 lg:px-6 py-4 hidden xl:table-cell text-sm text-gray-500">
                            <div class="text-xs">Début: {{ $abonnement->date_debut->format('d/m/Y') }}</div>
                            <div class="text-xs">Fin: {{ $abonnement->date_debut->addMonths($abonnement->duree_mois)->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-3 lg:px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('abonnements.show', $abonnement) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200 p-1"
                                   title="Voir">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('abonnements.edit', $abonnement) }}" 
                                   class="text-blue-600 hover:text-blue-900 transition-colors duration-200 p-1"
                                   title="Modifier">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                @if($abonnement->statut === 'actif')
                                <form action="{{ route('abonnements.renouveler', $abonnement) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900 transition-colors duration-200 p-1"
                                            title="Renouveler">
                                        <i class="fas fa-sync-alt text-sm"></i>
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('abonnements.destroy', $abonnement) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 transition-colors duration-200 p-1"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet abonnement ?')"
                                            title="Supprimer">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-4"></i>
                                <p class="text-lg">Aucun abonnement trouvé</p>
                                <p class="text-sm">Commencez par créer votre premier abonnement</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($abonnements->hasPages())
        <div class="px-6 lg:px-8 py-6 border-t border-gray-200">
            {{ $abonnements->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
