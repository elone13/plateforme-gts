<div>
    <!-- Alerte Livewire -->
    @if($showAlert)
        <div class="mb-4 p-4 rounded border transition-all duration-300 ease-in-out
                    {{ $alertType === 'success' ? 'bg-green-100 border-green-400 text-green-700' : '' }}
                    {{ $alertType === 'error' ? 'bg-red-100 border-red-400 text-red-700' : '' }}
                    {{ $alertType === 'warning' ? 'bg-yellow-100 border-yellow-400 text-yellow-700' : '' }}"
             wire:ignore.self
             x-data="{ show: true }"
             x-init="setTimeout(() => { show = false; $wire.set('showAlert', false); }, 3000)"
             x-show="show"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            {{ $alertMessage }}
        </div>
    @endif

    <div class="space-y-3 mb-6">
        @if($demandeDemo->statut === 'en_attente')
            <div class="flex flex-col space-y-2">
                <button wire:click="openModal('accepter')" class="btn-primary text-sm py-2 px-3 w-full">
                    <i class="fas fa-check mr-2"></i>Accepter
                </button>
                <button wire:click="openModal('refuser')" class="btn-secondary text-sm py-2 px-3 w-full">
                    <i class="fas fa-times mr-2"></i>Refuser
                </button>
            </div>
        @endif
        
        @if($demandeDemo->statut === 'acceptee')
            <div class="flex flex-col space-y-2">
                <button wire:click="openModal('planifier')" class="btn-primary text-sm py-2 px-3 w-full">
                    <i class="fas fa-calendar-plus mr-2"></i>Planifier RDV
                </button>
            </div>
        @endif
        
        @if($demandeDemo->statut === 'planifiee')
            <div class="flex flex-col space-y-2">
                <button wire:click="openModal('en_cours')" class="btn-primary text-sm py-2 px-3 w-full">
                    <i class="fas fa-play mr-2"></i>Commencer
                </button>
            </div>
        @endif
        
        @if($demandeDemo->statut === 'en_cours')
            <div class="flex flex-col space-y-2">
                <button wire:click="openModal('terminee')" class="btn-primary text-sm py-2 px-3 w-full">
                    <i class="fas fa-check-double mr-2"></i>Terminer
                </button>
            </div>
        @endif
        
        <div class="flex flex-col space-y-2">
            <button wire:click="openModal('en_attente')" class="btn-secondary text-sm py-2 px-3 w-full">
                <i class="fas fa-clock mr-2"></i>Remettre en attente
            </button>
            
            <button wire:click="openModal('priorite')" class="btn-secondary text-sm py-2 px-3 w-full">
                <i class="fas fa-flag mr-2"></i>Modifier priorité
            </button>
        </div>
    </div>

    @if($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    @switch($modalType)
                        @case('accepter')
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Accepter la demande</h3>
                            <div class="mb-4">
                                <label for="commentaire_admin" class="block text-sm font-medium text-gray-700">Commentaire (optionnel)</label>
                                <textarea wire:model="commentaire_admin" id="commentaire_admin" rows="3"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                          placeholder="Commentaire interne..."></textarea>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button wire:click="closeModal()" class="btn-secondary">Annuler</button>
                                <button wire:click="accepter()" class="btn-primary">Accepter</button>
                            </div>
                            @break

                        @case('refuser')
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Refuser la demande</h3>
                            <div class="mb-4">
                                <label for="raison_refus" class="block text-sm font-medium text-gray-700">Raison du refus (optionnel)</label>
                                <textarea wire:model="raison_refus" id="raison_refus" rows="3"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                          placeholder="Expliquez la raison du refus..."></textarea>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button wire:click="closeModal()" class="btn-secondary">Annuler</button>
                                <button wire:click="refuser()" class="btn-primary">Refuser</button>
                            </div>
                            @break

                        @case('planifier')
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Planifier un rendez-vous</h3>
                            <form wire:submit="planifierRendezVous" class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="date_rdv" class="block text-sm font-medium text-gray-700">Date *</label>
                                        <input type="date" wire:model="date_rdv" id="date_rdv" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                        @error('date_rdv') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="heure_rdv" class="block text-sm font-medium text-gray-700">Heure *</label>
                                        <input type="time" wire:model="heure_rdv" id="heure_rdv" required
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                        @error('heure_rdv') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="duree_rdv" class="block text-sm font-medium text-gray-700">Durée (min) *</label>
                                        <select wire:model="duree_rdv" id="duree_rdv" required
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                            <option value="30">30 minutes</option>
                                            <option value="60">1 heure</option>
                                            <option value="90">1h30</option>
                                            <option value="120">2 heures</option>
                                        </select>
                                        @error('duree_rdv') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="type_rdv" class="block text-sm font-medium text-gray-700">Type *</label>
                                        <select wire:model="type_rdv" id="type_rdv" required
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                            <option value="en_ligne">En ligne</option>
                                            <option value="en_presentiel">En présentiel</option>
                                            <option value="telephone">Par téléphone</option>
                                        </select>
                                        @error('type_rdv') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="lien_reunion" class="block text-sm font-medium text-gray-700">Lien de réunion *</label>
                                    <input type="url" wire:model="lien_reunion" id="lien_reunion" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                           placeholder="https://meet.google.com/...">
                                    @error('lien_reunion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="instructions_rdv" class="block text-sm font-medium text-gray-700">Instructions (optionnel)</label>
                                    <textarea wire:model="instructions_rdv" id="instructions_rdv" rows="3"
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                              placeholder="Instructions pour le client..."></textarea>
                                    @error('instructions_rdv') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="flex justify-end space-x-3">
                                    <button type="button" wire:click="closeModal()" class="btn-secondary">Annuler</button>
                                    <button type="submit" class="btn-primary">Planifier</button>
                                </div>
                            </form>
                            @break

                        @case('en_cours')
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Commencer la démonstration</h3>
                            <p class="text-gray-600 mb-4">Êtes-vous sûr de vouloir marquer cette démonstration comme commencée ?</p>
                            <div class="flex justify-end space-x-3">
                                <button wire:click="closeModal()" class="btn-secondary">Annuler</button>
                                <button wire:click="marquerEnCours()" class="btn-primary">Commencer</button>
                            </div>
                            @break

                        @case('terminee')
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Terminer la démonstration</h3>
                            <p class="text-gray-600 mb-4">Êtes-vous sûr de vouloir marquer cette démonstration comme terminée ?</p>
                            <div class="flex justify-end space-x-3">
                                <button wire:click="closeModal()" class="btn-secondary">Annuler</button>
                                <button wire:click="marquerTerminee()" class="btn-primary">Terminer</button>
                            </div>
                            @break

                        @case('en_attente')
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Remettre en attente</h3>
                            <p class="text-gray-600 mb-4">Êtes-vous sûr de vouloir remettre cette demande en attente ?</p>
                            <div class="flex justify-end space-x-3">
                                <button wire:click="closeModal()" class="btn-secondary">Annuler</button>
                                <button wire:click="mettreEnAttente()" class="btn-primary">Remettre en attente</button>
                            </div>
                            @break

                        @case('priorite')
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Modifier la priorité</h3>
                            <div class="mb-4">
                                <label for="nouvelle_priorite" class="block text-sm font-medium text-gray-700">Nouvelle priorité *</label>
                                <select wire:model="nouvelle_priorite" id="nouvelle_priorite" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                    <option value="">Sélectionner...</option>
                                    <option value="haute">Haute</option>
                                    <option value="moyenne">Moyenne</option>
                                    <option value="basse">Basse</option>
                                </select>
                                @error('nouvelle_priorite') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button wire:click="closeModal()" class="btn-secondary">Annuler</button>
                                <button wire:click="modifierPriorite()" class="btn-primary">Modifier</button>
                            </div>
                            @break

                        @default
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Action</h3>
                            <p class="text-gray-600 mb-4">Action non reconnue.</p>
                            <div class="flex justify-end">
                                <button wire:click="closeModal()" class="btn-secondary">Fermer</button>
                            </div>
                    @endswitch
                </div>
            </div>
        </div>
    @endif
</div>
