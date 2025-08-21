@extends('layouts.commercial')

@section('page-title', 'Nouveau Client')
@section('page-description', 'Créer un nouveau client ou prospect')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white shadow-lg rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Nouveau Client</h1>
                        <p class="text-sm text-gray-600">Créer un nouveau client ou prospect</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('commercial.clients.index') }}" class="btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire de création -->
        <div class="bg-white shadow-lg rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Informations du client</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('commercial.clients.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700">Nom complet *</label>
                            <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('nom') border-red-500 @enderror"
                                   placeholder="Nom et prénom du contact">
                            @error('nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="nom_entreprise" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                            <input type="text" id="nom_entreprise" name="nom_entreprise" value="{{ old('nom_entreprise') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('nom_entreprise') border-red-500 @enderror"
                                   placeholder="Nom de l'entreprise (optionnel)">
                            @error('nom_entreprise')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        

                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror"
                                   placeholder="email@exemple.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="tel" id="telephone" name="telephone" value="{{ old('telephone') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('telephone') border-red-500 @enderror"
                                   placeholder="+33 1 23 45 67 89">
                            @error('telephone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="secteur_activite" class="block text-sm font-medium text-gray-700">Secteur d'activité</label>
                            <input type="text" id="secteur_activite" name="secteur_activite" value="{{ old('secteur_activite') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('secteur_activite') border-red-500 @enderror"
                                   placeholder="Ex: Informatique, Commerce, Services...">
                            @error('secteur_activite')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="source" class="block text-sm font-medium text-gray-700">Source</label>
                            <select id="source" name="source"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('source') border-red-500 @enderror">
                                <option value="">Sélectionner une source</option>
                                <option value="site_web" {{ old('source') === 'site_web' ? 'selected' : '' }}>Site web</option>
                                <option value="recommandation" {{ old('source') === 'recommandation' ? 'selected' : '' }}>Recommandation</option>
                                <option value="salon" {{ old('source') === 'salon' ? 'selected' : '' }}>Salon/Événement</option>
                                <option value="prospection" {{ old('source') === 'prospection' ? 'selected' : '' }}>Prospection téléphonique</option>
                                <option value="reseau" {{ old('source') === 'reseau' ? 'selected' : '' }}>Réseau professionnel</option>
                                <option value="autre" {{ old('source') === 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('source')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                        <textarea id="adresse" name="adresse" rows="3"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('adresse') border-red-500 @enderror"
                                  placeholder="Adresse complète du client...">{{ old('adresse') }}</textarea>
                        @error('adresse')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea id="notes" name="notes" rows="4"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('notes') border-red-500 @enderror"
                                  placeholder="Notes internes sur ce client...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('commercial.clients.index') }}" class="btn-secondary">
                            Annuler
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>Créer le client
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informations utiles -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Informations utiles</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Le client sera automatiquement créé avec le statut "Prospect"</li>
                            <li>Vous pourrez modifier toutes les informations après création</li>
                            <li>Les champs marqués d'un * sont obligatoires</li>
                            <li>Le téléphone et l'adresse sont optionnels mais recommandés</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
