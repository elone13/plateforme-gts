@extends('layouts.portal')
@section('title', 'Mon Profil - GTS Afrique')
@section('content')

<!-- Hero Section -->
<div class="bg-gradient-to-r from-primary-soft to-primary-muted text-gray-900 py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Mon Profil</h1>
        <p class="text-xl text-gray-700 max-w-2xl mx-auto">
            Gérez vos informations personnelles et consultez vos devis
        </p>
    </div>
</div>

<!-- Contenu du profil -->
<div class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Informations du profil</h2>
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @php
                    // Récupérer les informations du client
                    $user = auth()->user();
                    $client = \App\Models\Client::where('user_id', $user->id)->first();
                    $devis = null;
                    $factures = null;
                    
                    if ($client) {
                        $devis = \App\Models\Devis::where('client_idclient', $client->idclient)->get();
                        // Pour l'instant, on met factures à 0, mais on peut l'implémenter plus tard
                        $factures = collect([]);
                    }
                @endphp

                @if($client)
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Informations actuelles -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">Informations actuelles</h3>
                            <button onclick="openEditModal()" 
                                    class="inline-flex items-center px-3 py-2 border border-primary/30 rounded-md text-sm font-medium text-primary-dark bg-primary-soft hover:bg-primary-muted transition-colors duration-200">
                                <i class="fas fa-edit mr-2"></i>Modifier
                            </button>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                                <p class="text-gray-900 font-medium">{{ $client->nom ?? 'Non renseigné' }}</p>
                            </div>
                            @if($client && $client->nom_entreprise)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Entreprise</label>
                                <p class="text-gray-900 font-medium">{{ $client->nom_entreprise }}</p>
                            </div>
                            @endif
                            @if($client && $client->contact_principal)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Contact principal</label>
                                <p class="text-gray-900 font-medium">{{ $client->contact_principal }}</p>
                            </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="text-gray-900 font-medium">{{ $client->email }}</p>
                            </div>
                            @if($client && $client->telephone)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                                <p class="text-gray-900 font-medium">{{ $client->telephone }}</p>
                            </div>
                            @endif
                            @if($client && $client->adresse)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Adresse</label>
                                <p class="text-gray-900 font-medium">{{ $client->adresse }}</p>
                            </div>
                            @endif
                            @if($client && $client->secteur_activite)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Secteur d'activité</label>
                                <p class="text-gray-900 font-medium">{{ $client->secteur_activite }}</p>
                            </div>
                            @endif
                            @if($client && $client->notes)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Notes</label>
                                <p class="text-gray-900 font-medium">{{ $client->notes }}</p>
                            </div>
                            @endif
                            @if($client)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Statut</label>
                                <p class="text-gray-900 font-medium">{{ ucfirst($client->statut) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date d'inscription</label>
                                <p class="text-gray-900 font-medium">{{ $client->date_inscription ? \Carbon\Carbon::parse($client->date_inscription)->format('d/m/Y') : 'N/A' }}</p>
                            </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rôle</label>
                                <p class="text-gray-900 font-medium">{{ ucfirst($user->role) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Membre depuis</label>
                                <p class="text-gray-900 font-medium">{{ $user->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions rapides -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Actions rapides</h3>
                        <div class="space-y-3">
                            <a href="{{ route('client.devis') }}" class="block w-full bg-primary hover:bg-primary-dark text-gray-900 font-medium py-3 px-4 rounded-lg text-center transition-colors duration-200 shadow-sm">
                                <i class="fas fa-file-invoice mr-2"></i>Voir mes devis
                            </a>
                            <a href="{{ route('client.factures') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg text-center transition-colors duration-200">
                                <i class="fas fa-receipt mr-2"></i>Voir mes factures
                            </a>
                            <a href="{{ route('contact') }}" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-lg text-center transition-colors duration-200">
                                <i class="fas fa-envelope mr-2"></i>Nous contacter
                            </a>
                        </div>
                    </div>
                </div>
                @else
                <!-- Message si aucun profil client trouvé -->
                <div class="text-center py-12">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-8">
                        <svg class="mx-auto h-16 w-16 text-yellow-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-yellow-800 mb-2">Profil client non trouvé</h3>
                        <p class="text-yellow-700 mb-6">Il semble qu'il y ait un problème avec votre profil client. Veuillez contacter l'administrateur.</p>
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-yellow-800 bg-yellow-100 hover:bg-yellow-200">
                            Contacter l'administrateur
                        </a>
                    </div>
                </div>
                @endif

                <!-- Section statistiques -->
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 text-center">Vos statistiques</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-primary-soft rounded-lg p-6 text-center">
                            <div class="w-12 h-12 bg-primary-muted rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-file-invoice text-primary-dark text-xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">Devis</h4>
                            <p class="text-2xl font-bold text-primary-dark">{{ $devis ? $devis->count() : 0 }}</p>
                            <p class="text-sm text-gray-600">devis créés</p>
                            @if($devis && $devis->count() > 0)
                            <div class="mt-2 text-xs text-gray-500">
                                <p>✅ {{ $devis->where('statut', 'valide')->count() }} validés</p>
                                <p>⏳ {{ $devis->where('statut', 'en_attente')->count() }} en attente</p>
                            </div>
                            @endif
                        </div>
                        
                        <div class="bg-green-50 rounded-lg p-6 text-center">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-receipt text-green-600 text-xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">Factures</h4>
                            <p class="text-2xl font-bold text-green-600">{{ $factures ? $factures->count() : 0 }}</p>
                            <p class="text-sm text-gray-600">factures émises</p>
                        </div>
                        
                        <div class="bg-purple-50 rounded-lg p-6 text-center">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-play-circle text-purple-600 text-xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">Démos</h4>
                            <p class="text-2xl font-bold text-purple-600">0</p>
                            <p class="text-sm text-gray-600">demandes envoyées</p>
                        </div>
                    </div>
                </div>
                
                <!-- Derniers devis -->
                @if($devis && $devis->count() > 0)
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 text-center">Derniers devis</h3>
                    <div class="space-y-3">
                        @foreach($devis->take(3) as $devisItem)
                        <div class="bg-gray-50 rounded-lg p-4 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                                        <div class="w-10 h-10 bg-primary-muted rounded-full flex items-center justify-center">
                            <i class="fas fa-file-invoice text-primary-dark"></i>
                        </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $devisItem->reference }}</p>
                                    <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($devisItem->date)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $devisItem->statut === 'valide' ? 'bg-green-100 text-green-800' : 
                                       ($devisItem->statut === 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 
                                       'bg-gray-100 text-gray-800') }}">
                                    @switch($devisItem->statut)
                                        @case('en_attente')
                                            En attente
                                            @break
                                        @case('valide')
                                            Validé
                                            @break
                                        @default
                                            {{ ucfirst($devisItem->statut) }}
                                    @endswitch
                                </span>
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ number_format($devisItem->total_ttc, 0, ',', ' ') }} FCFA
                                </span>
                                <div class="flex space-x-2">
                                    <a href="{{ route('client.advanced-profile.devis.preview', $devisItem) }}" 
                                       class="inline-flex items-center px-2 py-1 text-xs font-medium text-primary-dark bg-primary-soft hover:bg-primary-muted rounded-md transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Aperçu
                                    </a>
                                    <a href="{{ route('client.advanced-profile.devis.download', $devisItem) }}" 
                                       class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 hover:bg-green-200 rounded-md transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        PDF
                                    </a>
                                    @if($devisItem->statut === 'en_attente')
                                        <button onclick="openValidationModal('{{ $devisItem->reference }}', '{{ number_format($devisItem->total_ttc, 0, ',', ' ') }}', '{{ $devisItem->id }}')" 
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Valider
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        @if($devis->count() > 3)
                        <div class="text-center">
                            <a href="{{ route('client.devis') }}" class="text-primary-dark hover:text-primary font-medium">
                                Voir tous mes devis →
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal d'édition du profil -->
<div id="editProfileModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Header du modal -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Modifier mon profil</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Messages d'erreur et de succès -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Formulaire d'édition -->
            <form action="{{ route('client.advanced-profile.update') }}" method="POST" id="editProfileForm">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Informations personnelles -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Informations personnelles</h4>
                        
                        <div class="space-y-4">
                            <!-- Nom -->
                            <div>
                                <label for="edit_nom" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nom complet <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="edit_nom" 
                                       name="nom" 
                                       value="{{ $client->nom ?? '' }}"
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary/50 focus:border-primary/50">
                            </div>

                            <!-- Nom entreprise -->
                            <div>
                                <label for="edit_nom_entreprise" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nom de l'entreprise
                                </label>
                                <input type="text" 
                                       id="edit_nom_entreprise" 
                                       name="nom_entreprise" 
                                       value="{{ $client->nom_entreprise ?? '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary/50 focus:border-primary/50">
                            </div>

                            <!-- Contact principal -->
                            <div>
                                <label for="edit_contact_principal" class="block text-sm font-medium text-gray-700 mb-2">
                                    Contact principal
                                </label>
                                <input type="text" 
                                       id="edit_contact_principal" 
                                       name="contact_principal" 
                                       value="{{ $client->contact_principal ?? '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary/50 focus:border-primary/50">
                            </div>

                            <!-- Email (lecture seule) -->
                            <div>
                                <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Adresse email
                                </label>
                                <input type="email" 
                                       id="edit_email" 
                                       value="{{ $client->email ?? '' }}"
                                       disabled
                                       class="w-full px-3 py-2 border border-gray-200 rounded-md bg-gray-50 text-gray-500">
                                <p class="mt-1 text-xs text-gray-500">L'email ne peut pas être modifié</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informations de contact et professionnelles -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Contact et profession</h4>
                        
                        <div class="space-y-4">
                            <!-- Téléphone -->
                            <div>
                                <label for="edit_telephone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Téléphone
                                </label>
                                <input type="tel" 
                                       id="edit_telephone" 
                                       name="telephone" 
                                       value="{{ $client->telephone ?? '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary/50 focus:border-primary/50">
                            </div>

                            <!-- Adresse -->
                            <div>
                                <label for="edit_adresse" class="block text-sm font-medium text-gray-700 mb-2">
                                    Adresse
                                </label>
                                <textarea id="edit_adresse" 
                                          name="adresse" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary/50 focus:border-primary/50">{{ $client->adresse ?? '' }}</textarea>
                            </div>

                            <!-- Secteur d'activité -->
                            <div>
                                <label for="edit_secteur_activite" class="block text-sm font-medium text-gray-700 mb-2">
                                    Secteur d'activité
                                </label>
                                <input type="text" 
                                       id="edit_secteur_activite" 
                                       name="secteur_activite" 
                                       value="{{ $client->secteur_activite ?? '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary/50 focus:border-primary/50">
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="edit_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Notes et commentaires
                                </label>
                                <textarea id="edit_notes" 
                                          name="notes" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary/50 focus:border-primary/50">{{ $client->notes ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" 
                            onclick="closeEditModal()"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-primary hover:bg-primary-dark border border-transparent rounded-md text-sm font-medium text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary/50 transition-colors duration-200 shadow-sm">
                        Sauvegarder les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de validation des devis -->
<div id="validationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Header du modal -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Validation de Devis</h3>
                    <p class="mt-2 text-gray-600">Confirmez la validation de ce devis</p>
                </div>
                <button onclick="closeValidationModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Informations du devis -->
            <div class="bg-primary-soft border border-primary/30 rounded-lg p-6 mb-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Détails du Devis
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Référence</p>
                        <p class="text-lg font-bold text-gray-900" id="modalDevisReference">-</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Montant Total</p>
                        <p class="text-lg font-bold text-gray-900" id="modalDevisMontant">-</p>
                    </div>
                </div>
            </div>

            <!-- Avertissements et informations -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                <h4 class="text-lg font-semibold text-yellow-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Informations Importantes
                </h4>
                <div class="text-sm text-yellow-800 space-y-3">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-yellow-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                        </svg>
                        <p>La validation d'un devis engage votre entreprise à respecter les conditions et tarifs indiqués.</p>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-yellow-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p>Cette action ne peut pas être annulée une fois confirmée.</p>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-yellow-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p>Le statut du devis passera de "En attente" à "Validé" dans notre système.</p>
                    </div>
                </div>
            </div>

            <!-- Formulaire de validation -->
            <form id="validationForm" method="POST" class="mb-6">
                @csrf
                <input type="hidden" id="modalDevisId" name="devis_id" value="">
                
                <!-- Checkbox de confirmation -->
                <div class="mb-6">
                    <label class="flex items-start">
                        <input type="checkbox" id="confirmationCheckbox" class="mt-1 mr-3 w-4 h-4 text-yellow-600 bg-yellow-100 border-yellow-300 rounded focus:ring-yellow-500 focus:ring-2" style="accent-color: #eab308;" required>
                        <span class="text-sm text-gray-700">
                            Je confirme avoir lu et compris les informations ci-dessus et j'accepte de valider ce devis.
                        </span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" 
                            onclick="closeValidationModal()"
                            class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                        Annuler
                    </button>
                    <button type="submit" 
                            id="submitValidationBtn"
                            disabled
                            class="px-6 py-2 bg-orange-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200">
                        Confirmer la Validation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts JavaScript pour les modals -->
<script>
// Modal d'édition
function openEditModal() {
    document.getElementById('editProfileModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('editProfileModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Modal de validation
function openValidationModal(reference, montant, devisId) {
    document.getElementById('modalDevisReference').textContent = reference;
    document.getElementById('modalDevisMontant').textContent = montant + ' FCFA';
    document.getElementById('modalDevisId').value = devisId;
    
    // Mettre à jour l'action du formulaire
    document.getElementById('validationForm').action = `/client/advanced-profile/devis/${devisId}/validate`;
    
    document.getElementById('validationModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Réinitialiser le formulaire
    document.getElementById('confirmationCheckbox').checked = false;
    document.getElementById('submitValidationBtn').disabled = true;
}

function closeValidationModal() {
    document.getElementById('validationModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Gestion de la checkbox de confirmation
document.getElementById('confirmationCheckbox').addEventListener('change', function() {
    document.getElementById('submitValidationBtn').disabled = !this.checked;
});

// Fermer les modals en cliquant à l'extérieur
document.getElementById('editProfileModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

document.getElementById('validationModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeValidationModal();
    }
});

// Fermer les modals avec la touche Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
        closeValidationModal();
    }
});
</script>

@endsection