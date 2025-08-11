@extends('layouts.manager')

@section('page-title', 'Gestion des Services')
@section('page-description', 'Gérer tous les services de GTS Afrique')

@section('content')
<style>
    /* Optimisation du tableau pour éviter le défilement horizontal */
    .services-table {
        table-layout: fixed;
        width: 100%;
    }
    
    .services-table th,
    .services-table td {
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    /* Masquer la barre de défilement horizontale */
    .overflow-x-auto {
        overflow-x: hidden;
    }
    
    /* Responsive pour les petits écrans */
    @media (max-width: 1024px) {
        .services-table th,
        .services-table td {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
    }
</style>

<div class="py-6" x-data="{ 
    showCreateModal: false, 
    showEditModal: false, 
    showDeleteModal: false,
    editingService: null,
    deletingService: null 
}">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white shadow-lg rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900"></h1>
                        <p class="text-sm text-gray-600">Gérer tous les services de géolocalisation GPS</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button @click="showCreateModal = true" class="bg-primary hover:bg-primary-dark text-gray-900 px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>Nouveau Service
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages de succès/erreur -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
        @endif

        <!-- Liste des services -->
        <div class="bg-white shadow-lg rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Services disponibles</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="services-table w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Service</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">Description</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">Image</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">Éléments</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">Créé le</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($services as $service)
                        <tr>
                            <td class="px-4 py-4">
                                <div class="text-sm font-medium text-gray-900 break-words">{{ $service->nom }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-sm text-gray-900 break-words">{{ Str::limit($service->description, 80) }}</div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                @if($service->image)
                                <img src="{{ Storage::url($service->image) }}" alt="{{ $service->nom }}" class="w-10 h-10 rounded object-cover mx-auto">
                                @else
                                <div class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center mx-auto">
                                    <i class="fas fa-image text-gray-400 text-sm"></i>
                                </div>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-primary/10 text-gray-900 border border-primary/20">
                                    {{ $service->items->count() }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center text-sm text-gray-500">
                                {{ $service->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('manager.services.show', $service) }}" 
                                       class="text-primary hover:text-primary-dark p-1" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button @click="editingService = {{ $service->id }}; showEditModal = true" 
                                            class="text-secondary hover:text-secondary-dark p-1" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="deletingService = {id: {{ $service->id }}, nom: '{{ $service->nom }}'}; showDeleteModal = true" 
                                            class="text-red-600 hover:text-red-900 p-1" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                <div class="py-8">
                                    <i class="fas fa-cogs text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-lg font-medium text-gray-900 mb-2">Aucun service</p>
                                    <p class="text-gray-500 mb-4">Commencez par créer votre premier service de géolocalisation GPS.</p>
                                    <button @click="showCreateModal = true" class="bg-primary hover:bg-primary-dark text-gray-900 px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                        <i class="fas fa-plus mr-2"></i>Créer le premier service
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($services->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $services->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Modal Création Service -->
    <div x-show="showCreateModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
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
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-plus text-blue-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Nouveau Service</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Créez un nouveau service de géolocalisation GPS.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenu -->
                <div class="bg-white px-4 pb-4 sm:px-6 sm:pb-6">
                    <form action="{{ route('manager.services.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <!-- Nom du service -->
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom du service *</label>
                                <input type="text" 
                                       name="nom"
                                       id="nom" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                       placeholder="Ex: Suivi de flotte, Gestion carburant..."
                                       required>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                                <textarea name="description"
                                          id="description" 
                                          rows="4"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                          placeholder="Décrivez ce service de géolocalisation GPS..."
                                          required></textarea>
                            </div>

                            <!-- Image -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700">Image du service</label>
                                <input type="file" 
                                       name="image"
                                       id="image" 
                                       accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse mt-6">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                <i class="fas fa-save mr-2"></i>Créer le service
                            </button>
                            <button type="button" @click="showCreateModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Édition Service -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
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
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-edit text-indigo-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Modifier le Service</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Modifiez les informations du service.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenu -->
                <div class="bg-white px-4 pb-4 sm:px-6 sm:pb-6">
                    <form :action="`/manager/services/${editingService}`" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <!-- Nom du service -->
                            <div>
                                <label for="edit_nom" class="block text-sm font-medium text-gray-700">Nom du service *</label>
                                <input type="text" 
                                       name="nom"
                                       id="edit_nom" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                       placeholder="Ex: Suivi de flotte, Gestion carburant..."
                                       required>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="edit_description" class="block text-sm font-medium text-gray-700">Description *</label>
                                <textarea name="description"
                                          id="edit_description" 
                                          rows="4"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                          placeholder="Décrivez ce service de géolocalisation GPS..."
                                          required></textarea>
                            </div>

                            <!-- Image -->
                            <div>
                                <label for="edit_image" class="block text-sm font-medium text-gray-700">Image du service</label>
                                <input type="file" 
                                       name="image"
                                       id="edit_image" 
                                       accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="mt-1 text-sm text-gray-500">Laissez vide pour conserver l'image actuelle</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse mt-6">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                <i class="fas fa-save mr-2"></i>Mettre à jour
                            </button>
                            <button type="button" @click="showEditModal = false; editingService = null" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Suppression Service -->
    <div x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
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
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Confirmer la suppression</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Êtes-vous sûr de vouloir supprimer le service <strong x-text="deletingService ? deletingService.nom : ''"></strong> ?
                                </p>
                                <p class="mt-2 text-sm text-red-600">
                                    <strong>Attention :</strong> Cette action est irréversible et supprimera également tous les éléments associés.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form :action="`/manager/services/${deletingService ? deletingService.id : ''}`" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <i class="fas fa-trash mr-2"></i>Supprimer définitivement
                        </button>
                    </form>
                    <button type="button" @click="showDeleteModal = false; deletingService = null" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
