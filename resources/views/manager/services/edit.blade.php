@extends('layouts.manager')

@section('page-title', 'Modifier le Service')
@section('page-description', 'Modifier le service : ' . $service->nom)

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white shadow-lg rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Modifier le Service</h1>
                        <p class="text-sm text-gray-600">{{ $service->nom }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('manager.services.show', $service) }}" class="btn-secondary">
                            <i class="fas fa-eye mr-2"></i>Voir
                        </a>
                        <a href="{{ route('manager.services.index') }}" class="btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="bg-white shadow-lg rounded-lg">
            <form action="{{ route('manager.services.update', $service) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="p-6 space-y-6">
                    <!-- Nom du service -->
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom du service *</label>
                        <input type="text" 
                               name="nom" 
                               id="nom" 
                               value="{{ old('nom', $service->nom) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                               placeholder="Ex: Suivi de flotte, Gestion carburant, Surveillance GPS..."
                               required>
                        @error('nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="6"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                  placeholder="Décrivez ce service de géolocalisation GPS, ses fonctionnalités, ses avantages pour la gestion de flotte..."
                                  required>{{ old('description', $service->description) }}</textarea>
                        @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Minimum 10 caractères, maximum 1000 caractères.</p>
                    </div>

                    <!-- Image actuelle -->
                    @if($service->image)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Image actuelle</label>
                        <div class="flex items-center space-x-4">
                            <div class="w-32 h-32 rounded-lg overflow-hidden border border-gray-300">
                                <img src="{{ Storage::url($service->image) }}" 
                                     alt="{{ $service->nom }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Image actuelle du service</p>
                                <p class="text-xs text-gray-500">Sélectionnez une nouvelle image pour la remplacer</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Nouvelle image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">
                            {{ $service->image ? 'Nouvelle image' : 'Image du service' }}
                        </label>
                        <div class="mt-1 flex items-center">
                            <div class="w-32 h-32 border-2 border-gray-300 border-dashed rounded-lg flex items-center justify-center bg-gray-50">
                                <div class="text-center">
                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                                    <p class="text-xs text-gray-500">Cliquez pour sélectionner</p>
                                </div>
                            </div>
                            <div class="ml-4">
                                <input type="file" 
                                       name="image" 
                                       id="image" 
                                       accept="image/*"
                                       class="sr-only"
                                       onchange="previewImage(this)">
                                <button type="button" 
                                        onclick="document.getElementById('image').click()"
                                        class="btn-secondary">
                                    <i class="fas fa-upload mr-2"></i>Sélectionner une image
                                </button>
                                <p class="mt-2 text-xs text-gray-500">
                                    Formats acceptés : JPEG, PNG, JPG, GIF. Taille max : 2MB.
                                </p>
                            </div>
                        </div>
                        @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Aperçu de la nouvelle image -->
                    <div id="imagePreview" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Aperçu de la nouvelle image</label>
                        <div class="w-32 h-32 rounded-lg overflow-hidden border border-gray-300">
                            <img id="preview" src="" alt="Aperçu" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end space-x-3">
                    <a href="{{ route('manager.services.index') }}" class="btn-secondary">
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

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
