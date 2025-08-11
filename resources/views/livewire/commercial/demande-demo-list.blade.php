<div>
    <!-- Filtres et recherche -->
    <div class="bg-white shadow-lg rounded-lg mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Recherche -->
                <div>
                    <label for="recherche" class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                    <input type="text" wire:model.live.debounce.300ms="recherche" id="recherche"
                           placeholder="Nom, email, message..."
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <!-- Filtre statut -->
                <div>
                    <label for="filterStatut" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select wire:model.live="filterStatut" id="filterStatut"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                        <option value="">Tous les statuts</option>
                        <option value="en_attente">En attente</option>
                        <option value="acceptee">Acceptée</option>
                        <option value="planifiee">Planifiée</option>
                        <option value="en_cours">En cours</option>
                        <option value="terminee">Terminée</option>
                        <option value="refusee">Refusée</option>
                    </select>
                </div>

                <!-- Filtre priorité -->
                <div>
                    <label for="filterPriorite" class="block text-sm font-medium text-gray-700 mb-2">Priorité</label>
                    <select wire:model.live="filterPriorite" id="filterPriorite"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                        <option value="">Toutes les priorités</option>
                        <option value="haute">Haute</option>
                        <option value="moyenne">Moyenne</option>
                        <option value="basse">Basse</option>
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

    <!-- Liste des demandes -->
    <div class="bg-white shadow-lg rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                Demandes de démo 
                @if($demandes->total() > 0)
                    <span class="text-sm text-gray-500">({{ $demandes->total() }} résultat{{ $demandes->total() > 1 ? 's' : '' }})</span>
                @endif
            </h3>
        </div>

        @if($demandes->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Priorité
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rendez-vous
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($demandes as $demande)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $demande->nom }}</div>
                                        <div class="text-sm text-gray-500">{{ $demande->email }}</div>
                                        @if($demande->telephone)
                                            <div class="text-sm text-gray-500">{{ $demande->telephone }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $demande->statut_class }}">
                                        {{ $demande->statut_formatted }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $demande->priorite_class }}">
                                        {{ $demande->priorite_formatted }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $demande->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($demande->statut === 'planifiee' && $demande->date_rdv && $demande->heure_rdv)
                                        <div class="text-center">
                                            <div class="font-medium text-green-600">
                                                {{ \Carbon\Carbon::parse($demande->date_rdv)->format('d/m/Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($demande->heure_rdv)->format('H:i') }}
                                            </div>
                                            @if($demande->duree_rdv)
                                                <div class="text-xs text-blue-600">
                                                    {{ $demande->duree_rdv }} min
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="{{ route('commercial.demandes-demo.show', $demande) }}" class="text-primary hover:text-primary-dark">
                                        <i class="fas fa-eye mr-1"></i>Voir
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $demandes->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <div class="text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-4"></i>
                    <p class="text-lg font-medium text-gray-900 mb-2">Aucune demande trouvée</p>
                    <p class="text-gray-500">
                        @if($recherche || $filterStatut || $filterPriorite)
                            Essayez de modifier vos filtres ou votre recherche.
                        @else
                            Aucune demande de démo n'a encore été soumise.
                        @endif
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
