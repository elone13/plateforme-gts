<div>
    <!-- Bouton pour ouvrir le modal de création -->
    <button wire:click="openCreateModal" 
            class="bg-gts-primary hover:bg-gts-primary-dark text-gray-900 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Nouveau créneau
    </button>

    <!-- Modal de création -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 {{ $showCreateModal ? '' : 'hidden' }}">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Nouveau créneau</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <form wire:submit.prevent="store">
                    <div class="space-y-4">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" id="date" wire:model="date" required min="{{ date('Y-m-d') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gts-primary focus:border-gts-primary">
                            @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="heure_debut" class="block text-sm font-medium text-gray-700">Heure début</label>
                                <input type="time" id="heure_debut" wire:model="heure_debut" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gts-primary focus:border-gts-primary">
                                @error('heure_debut') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="heure_fin" class="block text-sm font-medium text-gray-700">Heure fin</label>
                                <input type="time" id="heure_fin" wire:model="heure_fin" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gts-primary focus:border-gts-primary">
                                @error('heure_fin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                            <select id="statut" wire:model="statut" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gts-primary focus:border-gts-primary">
                                <option value="disponible">Disponible</option>
                                <option value="indisponible">Indisponible</option>
                            </select>
                            @error('statut') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes (optionnel)</label>
                            <textarea id="notes" wire:model="notes" rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gts-primary focus:border-gts-primary"
                                      placeholder="Informations supplémentaires..."></textarea>
                            @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        @error('conflict') 
                            <div class="bg-red-50 border border-red-200 rounded-md p-3">
                                <p class="text-red-800 text-sm">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" wire:click="closeModal"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors duration-200">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-gts-primary hover:bg-gts-primary-dark rounded-md transition-colors duration-200">
                            Créer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal d'édition -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 {{ $showEditModal ? '' : 'hidden' }}">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Modifier le créneau</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <form wire:submit.prevent="update">
                    <div class="space-y-4">
                        <div>
                            <label for="edit_date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" id="edit_date" wire:model="date" required min="{{ date('Y-m-d') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gts-primary focus:border-gts-primary">
                            @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="edit_heure_debut" class="block text-sm font-medium text-gray-700">Heure début</label>
                                <input type="time" id="edit_heure_debut" wire:model="heure_debut" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gts-primary focus:border-gts-primary">
                                @error('heure_debut') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="edit_heure_fin" class="block text-sm font-medium text-gray-700">Heure fin</label>
                                <input type="time" id="edit_heure_fin" wire:model="heure_fin" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gts-primary focus:border-gts-primary">
                                @error('heure_fin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="edit_statut" class="block text-sm font-medium text-gray-700">Statut</label>
                            <select id="edit_statut" wire:model="statut" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gts-primary focus:border-gts-primary">
                                <option value="disponible">Disponible</option>
                                <option value="indisponible">Indisponible</option>
                            </select>
                            @error('statut') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label for="edit_notes" class="block text-sm font-medium text-gray-700">Notes (optionnel)</label>
                            <textarea id="edit_notes" wire:model="notes" rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gts-primary focus:border-gts-primary"
                                      placeholder="Informations supplémentaires..."></textarea>
                            @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        @error('conflict') 
                            <div class="bg-red-50 border border-red-200 rounded-md p-3">
                                <p class="text-red-800 text-sm">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" wire:click="closeModal"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors duration-200">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-gts-primary hover:bg-gts-primary-dark rounded-md transition-colors duration-200">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Fermer les modals en cliquant à l'extérieur -->
    <script>
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fixed')) {
                @this.closeModal();
            }
        });
    </script>
</div>

