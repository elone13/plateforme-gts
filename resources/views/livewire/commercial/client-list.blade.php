<div>
    <!-- Filtres et recherche -->
    <div class="bg-white shadow-lg rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Filtres et recherche</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Recherche -->
                <div>
                    <label for="recherche" class="block text-sm font-medium text-gray-700">Recherche</label>
                    <input type="text" wire:model.live.debounce.300ms="recherche" id="recherche"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                           placeholder="Nom, contact, email...">
                </div>

                <!-- Filtre par statut -->
                <div>
                    <label for="filterStatut" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select wire:model.live="filterStatut" id="filterStatut"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                        <option value="">Tous les statuts</option>
                        <option value="prospect">Prospect</option>
                        <option value="actif">Client actif</option>
                        <option value="inactif">Client inactif</option>
                        <option value="archive">Archivé</option>
                    </select>
                </div>

                <!-- Filtre par secteur -->
                <div>
                    <label for="filterSecteur" class="block text-sm font-medium text-gray-700">Secteur</label>
                    <select wire:model.live="filterSecteur" id="filterSecteur"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                        <option value="">Tous les secteurs</option>
                        @foreach($secteurs as $secteur)
                            <option value="{{ $secteur }}">{{ $secteur }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Bouton reset -->
                <div class="flex items-end">
                    <button wire:click="resetFilters" class="btn-secondary w-full">
                        <i class="fas fa-times mr-2"></i>Réinitialiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des clients -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Client
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Activité
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dernière interaction
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($clients as $client)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center">
                                        <span class="text-sm font-medium text-primary">
                                            {{ strtoupper(substr($client->nom_entreprise ?? $client->contact_principal, 0, 2)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $client->nom_entreprise ?? 'Particulier' }}</div>
                                    <div class="text-sm text-gray-500">{{ $client->secteur_activite ?? 'Secteur non défini' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $client->contact_principal }}</div>
                            <div class="text-sm text-gray-500">{{ $client->email }}</div>
                            @if($client->telephone)
                                <div class="text-sm text-gray-500">{{ $client->telephone }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($client->statut === 'actif') bg-green-100 text-green-800
                                @elseif($client->statut === 'inactif') bg-red-100 text-red-800
                                @elseif($client->statut === 'prospect') bg-yellow-100 text-yellow-800
                                @elseif($client->statut === 'archive') bg-gray-100 text-gray-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($client->statut ?? 'N/A') }}
                            </span>
                            
                            <!-- Indicateur pour les prospects prêts à devenir clients -->
                            @if($client->statut === 'prospect' && $client->canBecomeClient())
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    Prêt à devenir client
                                </span>
                            </div>
                            @endif
                            
                            <!-- Date de passage prospect → client -->
                            @if($client->statut === 'actif' && $client->getClientSinceDate())
                            <div class="mt-1 text-xs text-gray-500">
                                Client depuis le {{ \Carbon\Carbon::parse($client->getClientSinceDate())->format('d/m/Y') }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <div class="flex items-center space-x-4">
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar-check text-green-500 mr-1"></i>
                                        {{ $client->abonnements_count }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-file-invoice text-blue-500 mr-1"></i>
                                        {{ $client->factures_count }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-desktop text-purple-500 mr-1"></i>
                                        {{ $client->demandeDemos->count() }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($client->derniere_interaction)
                                {{ \Carbon\Carbon::parse($client->derniere_interaction)->diffForHumans() }}
                            @else
                                <span class="text-gray-400">Jamais</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <!-- Voir le client -->
                                <a href="{{ route('commercial.clients.show', $client) }}" 
                                   class="text-primary hover:text-primary-dark p-2 rounded-full hover:bg-primary/10" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <!-- Modifier le client -->
                                <a href="{{ route('commercial.clients.edit', $client) }}" 
                                   class="text-blue-600 hover:text-blue-900 p-2 rounded-full hover:bg-blue-50" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Aucun client trouvé.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-3 border-t border-gray-200">
            {{ $clients->links() }}
        </div>
    </div>
</div>
