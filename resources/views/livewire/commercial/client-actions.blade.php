<div>
    <!-- Boutons d'actions rapides -->
    <div class="flex flex-col space-y-2">
        <!-- Planifier RDV -->
        <button wire:click="openModal('rdv')" 
                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center justify-center space-x-2" 
                title="Planifier un rendez-vous">
            <i class="fas fa-calendar-plus text-sm"></i>
            <span>Planifier RDV</span>
        </button>
        
        <!-- Envoyer Email -->
        <button wire:click="openModal('email')" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center justify-center space-x-2" 
                title="Envoyer un email">
            <i class="fas fa-envelope text-sm"></i>
            <span>Envoyer email</span>
        </button>
        
        <!-- Nouvelle demande démo -->
        <button wire:click="openModal('demo')" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center justify-center space-x-2" 
                title="Créer une nouvelle demande de démo">
            <i class="fas fa-desktop text-sm"></i>
            <span>Nouvelle demande démo</span>
        </button>
        
        <!-- Nouveau devis -->
        <button wire:click="openModal('devis')" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center justify-center space-x-2" 
                title="Créer un nouveau devis">
            <i class="fas fa-file-alt text-sm"></i>
            <span>Nouveau devis</span>
        </button>
        
        <!-- Modifier statut -->
        <button wire:click="openModal('statut')" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center justify-center space-x-2" 
                title="Modifier le statut du client">
            <i class="fas fa-edit text-sm"></i>
            <span>Modifier statut</span>
        </button>
    </div>

    <!-- Modal pour les actions -->
    @if($showModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <!-- En-tête du modal -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        @if($modalType === 'rdv')
                            Planifier un rendez-vous
                        @elseif($modalType === 'email')
                            Envoyer un email
                        @elseif($modalType === 'demo')
                            Nouvelle demande de démo
                        @elseif($modalType === 'devis')
                            Nouveau devis
                        @elseif($modalType === 'statut')
                            Modifier le statut
                        @endif
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Formulaire Planifier RDV -->
                @if($modalType === 'rdv')
                <form wire:submit.prevent="planifierRendezVous" class="space-y-4">
                    <div>
                        <label for="date_rdv" class="block text-sm font-medium text-gray-700">Date *</label>
                        <input type="date" wire:model="date_rdv" id="date_rdv" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                        @error('date_rdv') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="heure_rdv" class="block text-sm font-medium text-gray-700">Heure *</label>
                        <input type="time" wire:model="heure_rdv" id="heure_rdv" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                        @error('heure_rdv') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="type_rdv" class="block text-sm font-medium text-gray-700">Type *</label>
                        <select wire:model="type_rdv" id="type_rdv" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                            <option value="">Sélectionner un type</option>
                            <option value="demo">Démonstration</option>
                            <option value="suivi">Suivi commercial</option>
                            <option value="formation">Formation</option>
                            <option value="commercial">Rendez-vous commercial</option>
                        </select>
                        @error('type_rdv') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="notes_rdv" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea wire:model="notes_rdv" id="notes_rdv" rows="3"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                  placeholder="Instructions ou précisions..."></textarea>
                        @error('notes_rdv') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex space-x-3">
                        <button type="submit" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Planifier
                        </button>
                        <button type="button" wire:click="closeModal" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                            Annuler
                        </button>
                    </div>
                </form>
                @endif

                <!-- Formulaire Envoyer Email -->
                @if($modalType === 'email')
                <form wire:submit.prevent="envoyerEmail" class="space-y-4">
                    <div>
                        <label for="type_email" class="block text-sm font-medium text-gray-700">Type d'email *</label>
                        <select wire:model="type_email" id="type_email" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                            <option value="">Sélectionner un type</option>
                            <option value="confirmation">Confirmation</option>
                            <option value="relance">Relance</option>
                            <option value="renouvellement">Renouvellement</option>
                            <option value="information">Information</option>
                        </select>
                        @error('type_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="sujet_email" class="block text-sm font-medium text-gray-700">Sujet *</label>
                        <input type="text" wire:model="sujet_email" id="sujet_email" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                        @error('sujet_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="message_email" class="block text-sm font-medium text-gray-700">Message *</label>
                        <textarea wire:model="message_email" id="message_email" rows="4" required
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                  placeholder="Votre message..."></textarea>
                        @error('message_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex space-x-3">
                        <button type="submit" class="flex-1 bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
                            Envoyer
                        </button>
                        <button type="button" wire:click="closeModal" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                            Annuler
                        </button>
                    </div>
                </form>
                @endif

                <!-- Formulaire Nouvelle demande de démo -->
                @if($modalType === 'demo')
                <div class="space-y-4">
                    <p class="text-gray-600 text-sm">Créer une nouvelle demande de démo pour ce client.</p>
                    <div class="flex space-x-3">
                        <a href="{{ route('commercial.demandes-demo.create') }}?client_id={{ $client->idclient }}" 
                           class="flex-1 bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700 text-center">
                            Créer la demande
                        </a>
                        <button type="button" wire:click="closeModal" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                            Annuler
                        </button>
                    </div>
                </div>
                @endif

                <!-- Formulaire Nouveau devis -->
                @if($modalType === 'devis')
                <div class="space-y-4">
                    <p class="text-gray-600 text-sm">Créer un nouveau devis pour ce client.</p>
                    <div class="flex space-x-3">
                        <a href="{{ route('commercial.devis.create') }}?client_id={{ $client->idclient }}" 
                           class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-center">
                            Créer le devis
                        </a>
                        <button type="button" wire:click="closeModal" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                            Annuler
                        </button>
                    </div>
                </div>
                @endif

                <!-- Formulaire Modifier Statut -->
                @if($modalType === 'statut')
                <form wire:submit.prevent="modifierStatut" class="space-y-4">
                    <div>
                        <label for="nouveau_statut" class="block text-sm font-medium text-gray-700">Nouveau statut *</label>
                        <select wire:model="nouveau_statut" id="nouveau_statut" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                            <option value="prospect" {{ !$this->canChangeStatus('prospect') ? 'disabled' : '' }}>Prospect</option>
                            <option value="actif" {{ !$this->canChangeStatus('actif') ? 'disabled' : '' }}>Client actif</option>
                            <option value="inactif" {{ !$this->canChangeStatus('inactif') ? 'disabled' : '' }}>Client inactif</option>
                            <option value="archive" {{ !$this->canChangeStatus('archive') ? 'disabled' : '' }}>Archivé</option>
                        </select>
                        @error('nouveau_statut') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Message d'aide pour le changement de statut -->
                    @if($nouveau_statut && $this->getStatusChangeHelp($nouveau_statut))
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    {{ $this->getStatusChangeHelp($nouveau_statut) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Informations sur le statut actuel -->
                    @if($client->statut === 'prospect')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Prospect :</strong> Ce client deviendra automatiquement "Client actif" après validation de son premier paiement.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($client->statut === 'actif')
                    <div class="bg-green-50 border border-green-200 rounded-md p-3">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    <strong>Client actif :</strong> Ce client a validé au moins un paiement.
                                    @if($client->getClientSinceDate())
                                        <br>Client depuis le {{ \Carbon\Carbon::parse($client->getClientSinceDate())->format('d/m/Y') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="flex space-x-3">
                        <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Mettre à jour
                        </button>
                        <button type="button" wire:click="closeModal" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                            Annuler
                        </button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Messages de succès -->
    @if(session()->has('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-md shadow-lg z-50">
        {{ session('success') }}
    </div>
    @endif

    <!-- Messages d'erreur -->
    @if(session()->has('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-md shadow-lg z-50">
        {{ session('error') }}
    </div>
    @endif
</div>
