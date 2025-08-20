<div>
    <!-- Modal de création de devis GTS AFRIQUE - Version simplifiée -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal - Taille standard, plus haut que large -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-6 pt-6 pb-6 sm:p-6">
                    <!-- Header avec logo GTS AFRIQUE -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center mr-3">
                                <span class="text-2xl font-bold text-gray-700">G</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">GTS AFRIQUE</h2>
                                <p class="text-base text-gray-600">Création de devis</p>
                            </div>
                        </div>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-2xl"></i>
                        </button>
                    </div>

                    <!-- Contenu principal en une seule colonne -->
                    <div class="space-y-6">
                        
                        <!-- Sélection du client -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">1. Client</h3>
                            

                            
                            <div class="relative">
                                <input type="text" 
                                       wire:model.live.debounce.300ms="searchClient"
                                       placeholder="Rechercher un client..."
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       {{ $selectedClient ? 'disabled' : '' }}>
                                
                                @if($selectedClient)
                                    <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-medium text-green-900">{{ $selectedClient->nom_entreprise ?? $selectedClient->nom }}</p>
                                                <p class="text-sm text-green-700">{{ $selectedClient->email }}</p>
                                            </div>
                                            <button wire:click="selectedClient = null" class="text-green-600 hover:text-green-800">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                @elseif(!empty($searchClient))
                                    <div class="absolute z-50 w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-2xl max-h-80 overflow-auto">
                                        @foreach($this->filteredClients as $client)
                                            <button wire:click="selectClient({{ $client->idclient }})" 
                                                    class="w-full text-left px-4 py-3 hover:bg-gray-100 border-b border-gray-100 last:border-b-0">
                                                <div class="font-medium text-gray-900">{{ $client->nom_entreprise ?? $client->nom }}</div>
                                                <div class="text-sm text-gray-600">{{ $client->email }}</div>
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Sélection des services -->
                        @if($selectedClient)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">2. Services</h3>
                            
                            <!-- Services sélectionnés -->
                            @if(!empty($selectedServices))
                            <div class="mb-3">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Services sélectionnés :</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($selectedServices as $serviceId)
                                        @php
                                            $service = collect($services)->firstWhere('id', $serviceId);
                                        @endphp
                                        @if($service)
                                        <div class="flex items-center bg-blue-100 text-blue-800 px-3 py-2 rounded-lg">
                                            <span class="text-sm font-medium">{{ $service->nom }}</span>
                                            <button wire:click="selectService({{ $service->id }})" class="ml-2 text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            <!-- Recherche de services -->
                            <div class="relative">
                                <input type="text" 
                                       wire:model.live.debounce.300ms="searchService"
                                       placeholder="Rechercher des services..."
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                
                                @if(!empty($searchService))
                                    <div class="absolute z-50 w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-2xl max-h-80 overflow-auto">
                                        @foreach($this->filteredServices as $service)
                                            @if(!in_array($service->id, $selectedServices))
                                            <button wire:click="selectService({{ $service->id }})" 
                                                    class="w-full text-left px-4 py-3 hover:bg-gray-100 border-b border-gray-100 last:border-b-0">
                                                <div class="font-medium text-gray-900">{{ $service->nom }}</div>
                                                <div class="text-sm text-gray-600">{{ $service->description }}</div>
                                            </button>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Configuration du devis -->
                        @if(!empty($selectedItems))
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">3. Configuration</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de validité</label>
                                    <input type="date" wire:model="date_validite" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Taux TVA (%)</label>
                                    <input type="number" wire:model.live="taux_tva" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Conditions</label>
                                    <input type="text" wire:model="conditions" 
                                           placeholder="Conditions spéciales..."
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Sélection des éléments des services -->
                        @if(!empty($selectedServices))
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">4. Éléments des services</h3>
                            
                            <!-- Affichage par service -->
                            @foreach($selectedServices as $serviceId)
                                @php
                                    $service = collect($services)->firstWhere('id', $serviceId);
                                @endphp
                                @if($service)
                                <div class="mb-4 border border-gray-200 rounded-lg">
                                    <div class="bg-gray-50 px-3 py-2 border-b border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-medium text-gray-900">{{ $service->nom }}</h4>
                                            <button wire:click="toggleAllItemsOfService({{ $service->id }})" 
                                                    class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <i class="fas fa-check-double mr-1"></i>
                                                Tout sélectionner
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Tableau des éléments du service -->
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                        <input type="checkbox" 
                                                               wire:click="toggleAllItemsOfService({{ $service->id }})"
                                                               @if(count(array_intersect($service->items->pluck('iditem')->toArray(), $selectedItems)) === count($service->items)) checked @endif
                                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                    </th>
                                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase">Désignation</th>
                                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase">PU HT</th>
                                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase">Qté</th>
                                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase">Durée (mois)</th>
                                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase">Remise %</th>
                                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total HT</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($service->items as $item)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-2 py-2">
                                                        <input type="checkbox" 
                                                               wire:click="toggleItem({{ $item->iditem }}, {{ $service->id }})"
                                                               @if(in_array($item->iditem, $selectedItems)) checked @endif
                                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                    </td>
                                                    <td class="px-2 py-2 text-sm text-gray-900">
                                                        <div class="font-medium">{{ $item->nom }}</div>
                                                        @if($item->description)
                                                            <div class="text-xs text-gray-500">{{ $item->description }}</div>
                                                        @endif
                                                    </td>
                                                    <td class="px-2 py-2 text-sm text-gray-900">{{ number_format($item->prix, 0) }} FCFA</td>
                                                    <td class="px-2 py-2">
                                                        @if(in_array($item->iditem, $selectedItems))
                                                            <input type="number" 
                                                                   wire:model.live="itemQuantities.{{ $item->iditem }}"
                                                                   wire:change="updateItemQuantity({{ $item->iditem }}, $event.target.value)"
                                                                   min="1" step="1"
                                                                   class="w-14 px-2 py-1 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                                                        @else
                                                            <span class="text-gray-400">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-2 py-2">
                                                        @if(in_array($item->iditem, $selectedItems))
                                                            <input type="number" 
                                                                   wire:model.live="itemDurees.{{ $item->iditem }}"
                                                                   wire:change="updateItemDuree({{ $item->iditem }}, $event.target.value)"
                                                                   min="1" step="1"
                                                                   class="w-14 px-2 py-1 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                                                        @else
                                                            <span class="text-gray-400">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-2 py-2">
                                                        @if(in_array($item->iditem, $selectedItems))
                                                            <input type="number" 
                                                                   wire:model.live="itemRemises.{{ $item->iditem }}"
                                                                   wire:change="updateItemRemise({{ $item->iditem }}, $event.target.value)"
                                                                   min="0" max="100" step="0.1"
                                                                   class="w-14 px-2 py-1 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                                                        @else
                                                            <span class="text-gray-400">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-2 py-2 text-sm font-medium text-gray-900">
                                                        @if(in_array($item->iditem, $selectedItems))
                                                            @php
                                                                $quantite = $itemQuantities[$item->iditem] ?? 1;
                                                                $duree = $itemDurees[$item->iditem] ?? 12;
                                                                $remise = $itemRemises[$item->iditem] ?? 0;
                                                                $total = $item->prix * $quantite * $duree * (1 - $remise / 100);
                                                            @endphp
                                                            {{ number_format($total, 0) }} FCFA
                                                        @else
                                                            <span class="text-gray-400">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        @endif

                        <!-- Récapitulatif des totaux -->
                        @if(!empty($selectedItems))
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Récapitulatif</h3>
                            <div class="grid grid-cols-2 gap-4 mb-3">
                                <div class="text-center">
                                    <p class="text-sm text-gray-600">Total HT</p>
                                    <p class="text-lg font-bold text-gray-900">{{ number_format($total_ht, 0) }} FCFA</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm text-gray-600">Remise</p>
                                    <p class="text-lg font-bold text-red-600">{{ number_format($total_remise, 0) }} FCFA</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm text-gray-600">Total HT remisé</p>
                                    <p class="text-lg font-bold text-blue-600">{{ number_format($total_ht_remise, 0) }} FCFA</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm text-gray-600">TVA ({{ $taux_tva }}%)</p>
                                    <p class="text-lg font-bold text-purple-600">{{ number_format($montant_tva, 0) }} FCFA</p>
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="text-base text-gray-600">Total TTC</p>
                                <p class="text-2xl font-bold text-green-600">{{ number_format($total_ttc, 0) }} FCFA</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                        <button wire:click="closeModal" 
                                class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Annuler
                        </button>
                        @if(!empty($selectedItems))
                        <button wire:click="createDevis" 
                                class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i>
                            Créer le devis
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Messages d'erreur -->
    @if($errors->any())
        <div class="fixed bottom-4 right-4 z-50">
            @foreach($errors->all() as $error)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-2">
                    {{ $error }}
                </div>
            @endforeach
        </div>
    @endif

    <!-- Message de succès -->
    @if(session('success'))
        <div class="fixed bottom-4 right-4 z-50">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif
</div>
