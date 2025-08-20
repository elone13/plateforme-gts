<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header avec actions -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Gestion des devis</h2>
                <p class="mt-1 text-sm text-gray-500">Créez et gérez tous vos devis</p>
            </div>
            <div class="flex space-x-3">
                <button wire:click="toggleFilters" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <i class="fas fa-filter mr-2"></i>
                    {{ $showFilters ? 'Masquer' : 'Afficher' }} les filtres
                </button>
                <button wire:click="$dispatch('openCreateDevisModal')" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Nouveau devis
                </button>
            </div>
        </div>

        <!-- Filtres -->
        @if($showFilters)
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Recherche -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                    <input type="text" id="search" wire:model.live.debounce.300ms="search" 
                           placeholder="Référence, client, description..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary text-sm">
                </div>

                <!-- Statut -->
                <div>
                    <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select id="statusFilter" wire:model.live="statusFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary text-sm">
                        <option value="">Tous les statuts</option>
                        <option value="brouillon">Brouillon</option>
                        <option value="envoye">Envoyé</option>
                        <option value="accepte">Accepté</option>
                        <option value="refuse">Refusé</option>
                        <option value="expire">Expiré</option>
                    </select>
                </div>

                <!-- Date de début -->
                <div>
                    <label for="dateFrom" class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                    <input type="date" id="dateFrom" wire:model.live="dateFrom"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary text-sm">
                </div>

                <!-- Date de fin -->
                <div>
                    <label for="dateTo" class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                    <input type="date" id="dateTo" wire:model.live="dateTo"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary text-sm">
                </div>

                <!-- Actions des filtres -->
                <div class="flex items-end">
                    <button wire:click="clearFilters" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Effacer
                    </button>
                </div>
            </div>
        </div>
        @endif

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-file-invoice text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total devis</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['total'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">En attente</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['en_attente'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Acceptés</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['acceptes'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-times text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Refusés</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['refuses'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-euro-sign text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Montant total</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['montant_total'], 2) }}€</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table des devis -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Liste des devis</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                wire:click="sortBy('reference')">
                                <div class="flex items-center">
                                    Référence
                                    @if($sortField === 'reference')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-gray-400"></i>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                wire:click="sortBy('client_idclient')">
                                <div class="flex items-center">
                                    Client
                                    @if($sortField === 'client_idclient')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-gray-400"></i>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                wire:click="sortBy('date')">
                                <div class="flex items-center">
                                    Date création
                                    @if($sortField === 'date')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-gray-400"></i>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                wire:click="sortBy('total_ht')">
                                <div class="flex items-center">
                                    Montant HT
                                    @if($sortField === 'total_ht')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-gray-400"></i>
                                    @endif
                                </div>
                            </th>
                                                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                 wire:click="sortBy('total_ttc')">
                                 <div class="flex items-center">
                                     Montant TTC
                                     @if($sortField === 'total_ttc')
                                         <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                     @else
                                         <i class="fas fa-sort ml-1 text-gray-400"></i>
                                     @endif
                                 </div>
                             </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                wire:click="sortBy('statut')">
                                <div class="flex items-center">
                                    Statut
                                    @if($sortField === 'statut')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-gray-400"></i>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                wire:click="sortBy('date_validite')">
                                <div class="flex items-center">
                                    Validité
                                    @if($sortField === 'date_validite')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-gray-400"></i>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($devis as $devisItem)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $devisItem->reference ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <div class="h-8 w-8 rounded-full bg-primary/20 flex items-center justify-center">
                                            <span class="text-xs font-medium text-primary">
                                                {{ strtoupper(substr($devisItem->client->nom_entreprise ?? $devisItem->client->nom ?? 'N/A', 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $devisItem->client->nom_entreprise ?? $devisItem->client->nom ?? 'N/A' }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $devisItem->client->email ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $devisItem->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($devisItem->total_ht ?? 0, 2) }}€
                            </td>
                                                         <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                 {{ number_format($devisItem->total_ttc ?? $devisItem->montant_total ?? 0, 2) }}€
                             </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($devisItem->statut === 'brouillon') bg-yellow-100 text-yellow-800
                                    @elseif($devisItem->statut === 'envoye') bg-blue-100 text-blue-800
                                    @elseif($devisItem->statut === 'accepte') bg-green-100 text-green-800
                                    @elseif($devisItem->statut === 'refuse') bg-red-100 text-red-800
                                    @elseif($devisItem->statut === 'expire') bg-gray-100 text-gray-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($devisItem->statut ?? 'N/A') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($devisItem->date_validite)
                                    {{ \Carbon\Carbon::parse($devisItem->date_validite)->format('d/m/Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('commercial.devis.show', $devisItem) }}" 
                                       class="text-primary hover:text-primary-dark" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('commercial.devis.edit', $devisItem) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('commercial.devis.download', $devisItem) }}" 
                                       class="text-green-600 hover:text-green-900" title="Télécharger">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <form action="{{ route('commercial.devis.destroy', $devisItem) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce devis ?')"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                @if($search || $statusFilter || $dateFrom || $dateTo)
                                    Aucun devis ne correspond aux critères de recherche.
                                @else
                                    Aucun devis trouvé.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($devis->hasPages())
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $devis->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
