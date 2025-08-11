@extends('layouts.manager')

@section('page-title', 'Modifier l\'Élément')
@section('page-description', 'Modifier l\'élément : ' . $item->nom)

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white shadow-lg rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Modifier l'Élément</h1>
                        <p class="text-sm text-gray-600">{{ $item->nom }} - Service : {{ $service->nom }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('manager.services.show', $service) }}" class="btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Retour au service
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="bg-white shadow-lg rounded-lg">
            <form action="{{ route('manager.services.items.update', [$service, $item]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="p-6 space-y-6">
                    <!-- Nom de l'élément -->
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom de l'élément *</label>
                        <input type="text" 
                               name="nom" 
                               id="nom" 
                               value="{{ old('nom', $item->nom) }}"
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
                               name="quantite" 
                               id="quantite" 
                               value="{{ old('quantite', $item->quantite) }}"
                               min="1"
                               max="9999"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                               placeholder="1"
                               required>
                        @error('quantite')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Nombre d'unités disponibles ou incluses dans ce service.</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                  placeholder="Décrivez cet élément de géolocalisation GPS en détail..."
                                  required>{{ old('description', $item->description) }}</textarea>
                        @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Minimum 10 caractères, maximum 1000 caractères.</p>
                    </div>

                    <!-- Prix -->
                    <div>
                        <label for="prix" class="block text-sm font-medium text-gray-700">Prix (€)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">€</span>
                            </div>
                            <input type="number" 
                                   name="prix" 
                                   id="prix" 
                                   value="{{ old('prix', $item->prix) }}"
                                   step="0.01"
                                   min="0"
                                   max="999999.99"
                                   class="pl-8 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                   placeholder="0.00">
                        </div>
                        @error('prix')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Laissez vide si le prix n'est pas défini.</p>
                    </div>

                    <!-- Statut -->
                    <div>
                        <label for="statut" class="block text-sm font-medium text-gray-700">Statut *</label>
                        <select name="statut" 
                                id="statut" 
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                            <option value="">Sélectionnez un statut</option>
                            <option value="actif" {{ (old('statut', $item->statut) === 'actif') ? 'selected' : '' }}>Actif</option>
                            <option value="inactif" {{ (old('statut', $item->statut) === 'inactif') ? 'selected' : '' }}>Inactif</option>
                        </select>
                        @error('statut')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end space-x-3">
                    <a href="{{ route('manager.services.show', $service) }}" class="btn-secondary">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
