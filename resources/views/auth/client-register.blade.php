@extends('layouts.portal')

@section('title', 'Inscription Client - GTS Afrique')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-8 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900">
                Créer votre compte client
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Accédez à votre espace personnel pour consulter vos devis et demandes de démo
            </p>
                  
            <!-- Information sur l'inscription -->
            <div class="mt-4 bg-blue-50 border border-blue-200 rounded-md p-4 max-w-2xl mx-auto">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">
                            Inscription ouverte à tous
                        </h3>
                        <div class="mt-1 text-sm text-blue-700">
                            <p>Créez votre compte client pour accéder à votre espace personnel. Si vous avez déjà fait une demande de démo, elle sera automatiquement associée à votre compte.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Onglet des avantages -->
        <div class="mt-6">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- En-tête de l'onglet -->
                <button id="avantagesToggle" class="w-full px-6 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-left hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-lg font-semibold">Pourquoi s'inscrire ? Découvrez tous les avantages</h3>
                        </div>
                        <svg id="avantagesIcon" class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>

                <!-- Contenu de l'onglet (initialement fermé) -->
                <div id="avantagesContent" class="hidden px-6 py-6 bg-gray-50 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Avantage 1 -->
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Suivi en temps réel</h4>
                                    <p class="text-xs text-gray-600">Consultez l'état de vos demandes de démo, devis et factures en temps réel</p>
                                </div>
                            </div>
                        </div>

                        <!-- Avantage 2 -->
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 5.477 5.754 5 7.5 5s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.523 18.246 19 16.5 19c-1.746 0-3.332-.477-4.5-1.253" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Historique complet</h4>
                                    <p class="text-xs text-gray-600">Accédez à tout votre historique d'interactions avec GTS Afrique</p>
                                </div>
                            </div>
                        </div>

                        <!-- Avantage 3 -->
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Communication directe</h4>
                                    <p class="text-xs text-gray-600">Échangez directement avec nos équipes commerciales</p>
                                </div>
                            </div>
                        </div>

                        <!-- Avantage 4 -->
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Rapidité d'exécution</h4>
                                    <p class="text-xs text-gray-600">Accélérez vos processus grâce à l'accès direct à vos documents</p>
                                </div>
                            </div>
                        </div>

                        <!-- Avantage 5 -->
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Sécurité garantie</h4>
                                    <p class="text-xs text-gray-600">Vos données sont protégées et accessibles uniquement par vous</p>
                                </div>
                            </div>
                        </div>

                        <!-- Call-to-action -->
                        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 p-4 rounded-lg shadow-sm border border-yellow-200 md:col-span-2 lg:col-span-3">
                            <div class="text-center">
                                <h4 class="text-sm font-semibold text-yellow-900 mb-2">Prêt à commencer ?</h4>
                                <p class="text-xs text-yellow-700 mb-3">Créez votre compte en moins de 2 minutes et accédez immédiatement à votre espace client</p>
                                <div class="flex items-center justify-center text-xs text-yellow-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Inscription gratuite et sans engagement
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire d'inscription -->
        <div class="mt-6">
            <div class="bg-white py-8 px-8 shadow-lg rounded-lg">
                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Erreurs de validation
                                </h3>
                                <div class="mt-1 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form class="space-y-6" action="{{ route('register.post') }}" method="POST">
                    @csrf
                    
                    <!-- Informations du client -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informations du client</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom complet *</label>
                                <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required
                                       class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                       placeholder="Nom et prénom du contact">
                            </div>
                            
                            <div>
                                <label for="nom_entreprise" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                                <input type="text" id="nom_entreprise" name="nom_entreprise" value="{{ old('nom_entreprise') }}"
                                       class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                       placeholder="Nom de l'entreprise (optionnel)">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                       class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                       placeholder="email@exemple.com">
                                <p class="mt-1 text-xs text-gray-500">Votre email sera utilisé pour la vérification de votre compte</p>
                            </div>
                            
                            <div>
                                <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                <input type="tel" id="telephone" name="telephone" value="{{ old('telephone') }}"
                                       class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                       placeholder="+33 1 23 45 67 89">
                            </div>
                            
                            <div>
                                <label for="secteur_activite" class="block text-sm font-medium text-gray-700">Secteur d'activité</label>
                                <input type="text" id="secteur_activite" name="secteur_activite" value="{{ old('secteur_activite') }}"
                                       class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                       placeholder="Ex: Informatique, Commerce, Services...">
                            </div>
                            
                            <div>
                                <label for="source" class="block text-sm font-medium text-gray-700">Source</label>
                                <select id="source" name="source"
                                        class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                    <option value="">Sélectionner une source</option>
                                    <option value="site_web" {{ old('source') === 'site_web' ? 'selected' : '' }}>Site web</option>
                                    <option value="recommandation" {{ old('source') === 'recommandation' ? 'selected' : '' }}>Recommandation</option>
                                    <option value="salon" {{ old('source') === 'salon' ? 'selected' : '' }}>Salon/Événement</option>
                                    <option value="prospection" {{ old('source') === 'prospection' ? 'selected' : '' }}>Prospection téléphonique</option>
                                    <option value="reseau" {{ old('source') === 'reseau' ? 'selected' : '' }}>Réseau professionnel</option>
                                    <option value="autre" {{ old('source') === 'autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                            <textarea id="adresse" name="adresse" rows="3"
                                      class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                      placeholder="Adresse complète du client...">{{ old('adresse') }}</textarea>
                        </div>
                        
                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea id="notes" name="notes" rows="4"
                                      class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                      placeholder="Notes internes sur ce client...">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Sécurité du compte -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Sécurité du compte</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Mot de passe <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1">
                                    <input id="password" name="password" type="password" autocomplete="new-password" required 
                                           class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Minimum 8 caractères avec lettres et chiffres</p>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                    Confirmer le mot de passe <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1">
                                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                                           class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conditions et finalisation -->
                    <div class="space-y-6">
                        <!-- Conditions d'utilisation -->
                        <div class="flex items-start">
                            <input id="terms" name="terms" type="checkbox" required 
                                   class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded mt-1">
                            <label for="terms" class="ml-3 block text-sm text-gray-900">
                                J'accepte les <a href="#" class="text-yellow-600 hover:text-yellow-500 underline">conditions d'utilisation</a> 
                                et la <a href="#" class="text-yellow-600 hover:text-yellow-500 underline">politique de confidentialité</a>
                                <span class="text-red-500">*</span>
                            </label>
                        </div>

                        <!-- Bouton d'inscription -->
                        <div>
                            <button type="submit" 
                                    class="w-full flex justify-center py-3 px-6 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Créer mon compte client
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Séparateur et bouton de connexion -->
                <div class="mt-8">
                    <div class="text-center">
                        <span class="text-gray-500">Déjà un compte ?</span>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('login') }}" 
                           class="w-full flex justify-center py-3 px-6 border border-gray-300 rounded-lg shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Se connecter
                        </a>
                    </div>
                </div>

                <!-- Note de confidentialité -->
                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500">
                        En créant un compte, vous acceptez que GTS AFRIQUE traite vos données personnelles 
                        conformément à notre politique de confidentialité.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script pour l'accordéon -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('avantagesToggle');
    const content = document.getElementById('avantagesContent');
    const icon = document.getElementById('avantagesIcon');
    
    toggleButton.addEventListener('click', function() {
        const isHidden = content.classList.contains('hidden');
        
        if (isHidden) {
            // Ouvrir l'onglet
            content.classList.remove('hidden');
            icon.style.transform = 'rotate(180deg)';
            toggleButton.classList.remove('from-yellow-500', 'to-yellow-600');
            toggleButton.classList.add('from-yellow-600', 'to-yellow-700');
        } else {
            // Fermer l'onglet
            content.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
            toggleButton.classList.remove('from-yellow-600', 'to-yellow-700');
            toggleButton.classList.add('from-yellow-500', 'to-yellow-600');
        }
    });
});
</script>
@endsection
