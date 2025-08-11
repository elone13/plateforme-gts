<div>
    <!-- Modal Visualisation Service -->
    <div x-data="{ open: @entangle('showModal') }" 
         x-show="open" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 transition-opacity" 
                 aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div x-show="open" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                
                <!-- Header -->
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-eye text-blue-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Détails du Service</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Visualisez les informations de ce service.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenu -->
                @if($service)
                <div class="bg-white px-4 pb-4 sm:px-6 sm:pb-6">
                    <div class="space-y-4">
                        <!-- Image et description -->
                        <div class="flex items-start space-x-4">
                            @if($service->image)
                            <div class="flex-shrink-0">
                                <img src="{{ Storage::url($service->image) }}" 
                                     alt="{{ $service->nom }}" 
                                     class="w-32 h-32 rounded-lg object-cover">
                            </div>
                            @else
                            <div class="flex-shrink-0">
                                <div class="w-32 h-32 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-cogs text-blue-400 text-4xl"></i>
                                </div>
                            </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="text-lg font-medium text-gray-900 mb-2">{{ $service->nom }}</h4>
                                <p class="text-gray-700 leading-relaxed">{{ $service->description }}</p>
                            </div>
                        </div>

                        <!-- Informations -->
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">ID du service</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $service->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombre d'éléments</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $service->items->count() }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de création</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $service->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dernière modification</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $service->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Éléments -->
                        @if($service->items->count() > 0)
                        <div class="pt-4 border-t border-gray-200">
                            <h5 class="text-sm font-medium text-gray-900 mb-3">Éléments du service</h5>
                            <div class="space-y-2 max-h-32 overflow-y-auto">
                                @foreach($service->items->take(5) as $item)
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $item->nom }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->description }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if($item->prix)
                                        <span class="text-xs text-green-600 font-medium">{{ number_format($item->prix, 2) }}€</span>
                                        @endif
                                        <span class="text-xs text-blue-600 font-medium">Qté: {{ $item->quantite }}</span>
                                    </div>
                                </div>
                                @endforeach
                                @if($service->items->count() > 5)
                                <p class="text-xs text-gray-500 text-center">... et {{ $service->items->count() - 5 }} autres éléments</p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @if($service)
                    <a href="{{ route('manager.services.show', $service) }}" 
                       class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        <i class="fas fa-external-link-alt mr-2"></i>Voir en détail
                    </a>
                    @endif
                    <button type="button" 
                            wire:click="closeModal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
