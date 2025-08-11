@extends('layouts.app')

@section('title', 'Détail de la demande de démo - GTS Afrique')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Demande de démo</h2>
                        <p class="text-sm text-gray-500">ID: #{{ $demandeDemo->id }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.demandes-demo.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour
                        </a>
                    </div>
                </div>
            </div>

            <!-- Informations du client -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informations du client</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $demandeDemo->nom }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $demandeDemo->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $demandeDemo->telephone }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Source</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $demandeDemo->source }}</p>
                    </div>
                </div>
            </div>

            <!-- Message du client -->
            @if($demandeDemo->message)
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Message du client</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-700">{{ $demandeDemo->message }}</p>
                </div>
            </div>
            @endif

            <!-- Détails de la demande -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Détails de la demande</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date de création</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $demandeDemo->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Statut actuel</label>
                        <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $demandeDemo->statut_class }}">
                            {{ $demandeDemo->statut_formatted }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Priorité</label>
                        <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $demandeDemo->priorite_class }}">
                            {{ $demandeDemo->priorite_formatted }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Formulaire de mise à jour -->
            <div class="px-6 py-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Mettre à jour la demande</h3>
                
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.demandes-demo.update', $demandeDemo) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                                Nouveau statut <span class="text-red-500">*</span>
                            </label>
                            <select name="statut" id="statut" required 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                <option value="en_attente" {{ $demandeDemo->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="acceptee" {{ $demandeDemo->statut === 'acceptee' ? 'selected' : '' }}>Acceptée</option>
                                <option value="refusee" {{ $demandeDemo->statut === 'refusee' ? 'selected' : '' }}>Refusée</option>
                                <option value="en_cours" {{ $demandeDemo->statut === 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="terminee" {{ $demandeDemo->statut === 'terminee' ? 'selected' : '' }}>Terminée</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="priorite" class="block text-sm font-medium text-gray-700 mb-2">
                                Priorité
                            </label>
                            <select name="priorite" id="priorite" 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                <option value="haute" {{ $demandeDemo->priorite === 'haute' ? 'selected' : '' }}>Haute</option>
                                <option value="moyenne" {{ $demandeDemo->priorite === 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                                <option value="basse" {{ $demandeDemo->priorite === 'basse' ? 'selected' : '' }}>Basse</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="date_rdv" class="block text-sm font-medium text-gray-700 mb-2">
                                Date de rendez-vous
                            </label>
                            <input type="date" name="date_rdv" id="date_rdv" 
                                   value="{{ $demandeDemo->date_rdv ? $demandeDemo->date_rdv->format('Y-m-d') : '' }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label for="heure_rdv" class="block text-sm font-medium text-gray-700 mb-2">
                                Heure de rendez-vous
                            </label>
                            <input type="time" name="heure_rdv" id="heure_rdv" 
                                   value="{{ $demandeDemo->heure_rdv ? $demandeDemo->heure_rdv->format('H:i') : '' }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                        </div>
                    </div>

                    <div>
                        <label for="commentaire_admin" class="block text-sm font-medium text-gray-700 mb-2">
                            Commentaire administrateur
                        </label>
                        <textarea name="commentaire_admin" id="commentaire_admin" rows="4"
                                  placeholder="Ajoutez vos notes ou commentaires..."
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">{{ $demandeDemo->commentaire_admin }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="submit" 
                                class="bg-primary hover:bg-primary/90 text-white px-6 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                            <i class="fas fa-save mr-2"></i>
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>

            <!-- Actions rapides -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Actions rapides</h3>
                <div class="flex flex-wrap gap-3">
                    @if($demandeDemo->canBeTraitee())
                        <form action="{{ route('admin.demandes-demo.traiter', $demandeDemo) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-play mr-2"></i>
                                Marquer comme en cours
                            </button>
                        </form>
                    @endif
                    
                    @if($demandeDemo->statut === 'en_cours')
                        <form action="{{ route('admin.demandes-demo.terminer', $demandeDemo) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fas fa-check mr-2"></i>
                                Marquer comme terminée
                            </button>
                        </form>
                    @endif
                    
                    <form action="{{ route('admin.demandes-demo.destroy', $demandeDemo) }}" method="POST" class="inline" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
