<div>
    @if($creneaux->count() > 0)
        <div class="divide-y divide-gray-200">
            @foreach($creneaux as $creneau)
                <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 rounded-full {{ $creneau->statut === 'disponible' ? 'bg-green-400' : 'bg-red-400' }}"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($creneau->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($creneau->heure_fin)->format('H:i') }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $creneau->duree }} minutes
                                    </p>
                                </div>
                            </div>
                            
                            @if($creneau->notes)
                                <p class="text-sm text-gray-600 mt-2">{{ $creneau->notes }}</p>
                            @endif
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $creneau->statut === 'disponible' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $creneau->statut_formatted }}
                            </span>
                            
                            @if(!Carbon\Carbon::parse($date)->isPast())
                                <button wire:click="openEditModal({{ $creneau->id }})" 
                                        class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                
                                <button wire:click="deleteCreneau({{ $creneau->id }})" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce créneau ?')"
                                        class="text-red-400 hover:text-red-600 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="p-6 text-center text-gray-500">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p>Aucun créneau défini pour cette journée</p>
        </div>
    @endif

    <!-- Modal d'édition -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 {{ $showEditModal ? '' : 'hidden' }}">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Modifier le créneau</h3>
                    <button wire:click="closeEditModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <form wire:submit.prevent="updateCreneau">
                    <div class="space-y-4">
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
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" wire:click="closeEditModal"
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

    <!-- Fermer le modal en cliquant à l'extérieur -->
    <script>
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fixed')) {
                @this.closeEditModal();
            }
        });
    </script>
</div>

