<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header avec actions -->
            <div class="bg-white shadow-lg rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $service->nom }}</h1>
                            <p class="text-sm text-gray-600">Détails du service</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('manager.services.edit', $service) }}" class="btn-primary">
                                <i class="fas fa-edit mr-2"></i>Modifier
                            </a>
                            <a href="{{ route('manager.services.index') }}" class="btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i>Retour
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages de succès -->
            @if(session('message'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Colonne principale -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Image et description -->
                    <div class="bg-white shadow-lg rounded-lg">
                        <div class="p-6">
                            <div class="flex items-start space-x-6">
                                @if($service->image)
                                <div class="flex-shrink-0">
                                    <img src="{{ Storage::url($service->image) }}" 
                                         alt="{{ $service->nom }}" 
                                         class="w-48 h-48 rounded-lg object-cover">
                                </div>
                                @else
                                <div class="flex-shrink-0">
                                    <div class="w-48 h-48 rounded-lg bg-primary/20 flex items-center justify-center">
                                        <i class="fas fa-cogs text-primary text-6xl"></i>
                                    </div>
                                </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
                                    <p class="text-gray-700 leading-relaxed">{{ $service->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Éléments du service -->
                    <div class="bg-white shadow-lg rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">Éléments du service</h3>
                                <button wire:click="openCreateModal" class="btn-primary">
                                    <i class="fas fa-plus mr-2"></i>Ajouter un élément
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($service->items->count() > 0)
                                <div class="space-y-4">
                                    @foreach($service->items as $item)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900">{{ $item->nom }}</h4>
                                            <p class="text-xs text-gray-500 mt-1">{{ $item->description }}</p>
                                            <div class="flex items-center space-x-4 mt-2">
                                                @if($item->prix)
                                                <p class="text-sm text-green-600 font-medium">{{ number_format($item->prix, 2) }}€</p>
                                                @endif
                                                <p class="text-sm text-blue-600 font-medium">Qté: {{ $item->quantite }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($item->statut === 'actif') bg-green-100 text-green-800
                                                @elseif($item->statut === 'inactif') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($item->statut ?? 'N/A') }}
                                            </span>
                                            
                                            <!-- Actions sur l'élément -->
                                            <div class="flex items-center space-x-1 ml-4">
                                                <button wire:click="openEditModal({{ $item->id }})" 
                                                        class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50" title="Modifier">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </button>
                                                
                                                <button wire:click="openDeleteModal({{ $item->id }})" 
                                                        class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50" 
                                                        title="Supprimer">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="text-gray-400 mb-4">
                                        <i class="fas fa-list text-4xl"></i>
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-900 mb-2">Aucun élément</h4>
                                    <p class="text-gray-500 mb-6">Ce service n'a pas encore d'éléments associés.</p>
                                    <button wire:click="openCreateModal" class="btn-primary">
                                        <i class="fas fa-plus mr-2"></i>Ajouter le premier élément
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Informations du service -->
                    <div class="bg-white shadow-lg rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Informations</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">ID du service</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $service->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de création</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $service->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dernière modification</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $service->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombre d'éléments</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $service->items->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions rapides -->
                    <div class="bg-white shadow-lg rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Actions rapides</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('manager.services.edit', $service) }}" 
                               class="w-full bg-primary hover:bg-primary-dark text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                <i class="fas fa-edit text-sm"></i>
                                <span>Modifier le service</span>
                            </a>
                            
                            <form action="{{ route('manager.services.destroy', $service) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?')"
                                  class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                    <i class="fas fa-trash text-sm"></i>
                                    <span>Supprimer le service</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Création Élément -->
    @if($showCreateModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <form wire:submit.prevent="createItem">
                    <!-- Header -->
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-plus text-blue-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Nouvel Élément</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Ajoutez un nouvel élément au service : {{ $service->nom }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="bg-white px-4 pb-4 sm:px-6 sm:pb-6">
                        <div class="space-y-4">
                            <!-- Nom de l'élément -->
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom de l'élément *</label>
                                <input type="text" 
                                       wire:model="nom"
                                       id="nom" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                       placeholder="Ex: Installation balise GPS, Suivi temps réel, Rapport consommation..."
                                       required>
                                @error('nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Quantité -->
                            <div>
                                <label for="quantite" class="block text-sm font-medium text-gray-700">Quantité *</label>
                                <input type="number" 
                                       wire:model="quantite"
                                       id="quantite" 
                                       min="1"
                                       max="9999"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                       placeholder="1"
                                       required>
                                @error('quantite')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                                <textarea wire:model="description"
                                          id="description" 
                                          rows="4"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                          placeholder="Décrivez cet élément de géolocalisation GPS en détail..."
                                          required></textarea>
                                @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prix -->
                            <div>
                                <label for="prix" class="block text-sm font-medium text-gray-700">Prix (€)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">€</span>
                                    </div>
                                    <input type="number" 
                                           wire:model="prix"
                                           id="prix" 
                                           step="0.01"
                                           min="0"
                                           max="999999.99"
                                           class="pl-8 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                           placeholder="0.00">
                                </div>
                                @error('prix')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Statut -->
                            <div>
                                <label for="statut" class="block text-sm font-medium text-gray-700">Statut *</label>
                                <select wire:model="statut"
                                        id="statut" 
                                        required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                    <option value="">Sélectionnez un statut</option>
                                    <option value="actif">Actif</option>
                                    <option value="inactif">Inactif</option>
                                </select>
                                @error('statut')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <i class="fas fa-save mr-2"></i>Créer l'élément
                        </button>
                        <button type="button" wire:click="closeModals" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal Édition Élément -->
    @if($showEditModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <form wire:submit.prevent="updateItem">
                    <!-- Header -->
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-edit text-yellow-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Modifier l'Élément</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Modifiez l'élément : {{ $editingItem->nom ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="bg-white px-4 pb-4 sm:px-6 sm:pb-6">
                        <div class="space-y-4">
                            <!-- Nom de l'élément -->
                            <div>
                                <label for="edit_nom" class="block text-sm font-medium text-gray-700">Nom de l'élément *</label>
                                <input type="text" 
                                       wire:model="nom"
                                       id="edit_nom" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                       placeholder="Ex: Installation balise GPS, Suivi temps réel, Rapport consommation..."
                                       required>
                                @error('nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Quantité -->
                            <div>
                                <label for="edit_quantite" class="block text-sm font-medium text-gray-700">Quantité *</label>
                                <input type="number" 
                                       wire:model="quantite"
                                       id="edit_quantite" 
                                       min="1"
                                       max="9999"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                       placeholder="1"
                                       required>
                                @error('quantite')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="edit_description" class="block text-sm font-medium text-gray-700">Description *</label>
                                <textarea wire:model="description"
                                          id="edit_description" 
                                          rows="4"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                          placeholder="Décrivez cet élément de géolocalisation GPS en détail..."
                                          required></textarea>
                                @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prix -->
                            <div>
                                <label for="edit_prix" class="block text-sm font-medium text-gray-700">Prix (€)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">€</span>
                                    </div>
                                    <input type="number" 
                                           wire:model="prix"
                                           id="edit_prix" 
                                           step="0.01"
                                           min="0"
                                           max="999999.99"
                                           class="pl-8 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                           placeholder="0.00">
                                </div>
                                @error('prix')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Statut -->
                            <div>
                                <label for="edit_statut" class="block text-sm font-medium text-gray-700">Statut *</label>
                                <select wire:model="statut"
                                        id="edit_statut" 
                                        required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                    <option value="">Sélectionnez un statut</option>
                                    <option value="actif">Actif</option>
                                    <option value="inactif">Inactif</option>
                                </select>
                                @error('statut')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <i class="fas fa-save mr-2"></i>Mettre à jour
                        </button>
                        <button type="button" wire:click="closeModals" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal Suppression Élément -->
    @if($showDeleteModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <!-- Header -->
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Supprimer l'élément</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Êtes-vous sûr de vouloir supprimer l'élément <strong>{{ $deletingItem->nom ?? '' }}</strong> ? 
                                    Cette action est irréversible.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="deleteItem" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        <i class="fas fa-trash mr-2"></i>Supprimer
                    </button>
                    <button wire:click="closeModals" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
