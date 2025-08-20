@extends('layouts.commercial')

@section('page-title', 'Modifier Client - ' . $client->nom)
@section('page-description', 'Modifier les informations de ce client')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white shadow-lg rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Modifier le client</h1>
                        <p class="text-sm text-gray-600">{{ $client->nom }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('commercial.clients.show', $client) }}" class="btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire d'édition -->
        <div class="bg-white shadow-lg rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Informations du client</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('commercial.clients.update', $client) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700">Nom complet *</label>
                            <input type="text" id="nom" name="nom" value="{{ old('nom', $client->nom) }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('nom') border-red-500 @enderror">
                            @error('nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="nom_entreprise" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                            <input type="text" id="nom_entreprise" name="nom_entreprise" value="{{ old('nom_entreprise', $client->nom_entreprise) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('nom_entreprise') border-red-500 @enderror">
                            @error('nom_entreprise')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="contact_principal" class="block text-sm font-medium text-gray-700">Contact principal *</label>
                            <input type="text" id="contact_principal" name="contact_principal" value="{{ old('contact_principal', $client->contact_principal) }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('contact_principal') border-red-500 @enderror">
                            @error('contact_principal')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $client->email) }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="tel" id="telephone" name="telephone" value="{{ old('telephone', $client->telephone) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('telephone') border-red-500 @enderror">
                            @error('telephone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="secteur_activite" class="block text-sm font-medium text-gray-700">Secteur d'activité</label>
                            <input type="text" id="secteur_activite" name="secteur_activite" value="{{ old('secteur_activite', $client->secteur_activite) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('secteur_activite') border-red-500 @enderror">
                            @error('secteur_activite')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="statut" class="block text-sm font-medium text-gray-700">Statut *</label>
                            <select id="statut" name="statut" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('statut') border-red-500 @enderror">
                                <option value="prospect" {{ old('statut', $client->statut) === 'prospect' ? 'selected' : '' }}>Prospect</option>
                                <option value="actif" {{ old('statut', $client->statut) === 'actif' ? 'selected' : '' }}>Client actif</option>
                                <option value="inactif" {{ old('statut', $client->statut) === 'inactif' ? 'selected' : '' }}>Client inactif</option>
                                <option value="archive" {{ old('statut', $client->statut) === 'archive' ? 'selected' : '' }}>Archivé</option>
                            </select>
                            @error('statut')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                        <textarea id="adresse" name="adresse" rows="3"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('adresse') border-red-500 @enderror"
                                  placeholder="Adresse complète du client...">{{ old('adresse', $client->adresse) }}</textarea>
                        @error('adresse')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea id="notes" name="notes" rows="4"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary @error('notes') border-red-500 @enderror"
                                  placeholder="Notes internes sur ce client...">{{ old('notes', $client->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('commercial.clients.show', $client) }}" class="btn-secondary">
                            Annuler
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Section de suppression -->
        <div class="bg-white shadow-lg rounded-lg mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 text-red-600">Zone dangereuse</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">Archiver ce client</h4>
                        <p class="text-sm text-gray-500">Le client sera archivé et ne sera plus visible dans la liste principale.</p>
                    </div>
                    <form action="{{ route('commercial.clients.destroy', $client) }}" method="POST" class="inline"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir archiver ce client ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700 border-red-600">
                            <i class="fas fa-archive mr-2"></i>Archiver
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
