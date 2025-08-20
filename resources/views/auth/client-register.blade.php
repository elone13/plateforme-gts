@extends('layouts.portal')

@section('title', 'Inscription Client - GTS Afrique')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-8 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900">
                Créer votre compte client
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Accédez à votre espace personnel pour consulter vos devis
            </p>
        </div>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="bg-white py-6 px-6 shadow sm:rounded-lg">
            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 rounded-md p-3">
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
                <div class="mb-4 bg-red-50 border border-red-200 rounded-md p-3">
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

            <form class="space-y-4" action="{{ route('client.register') }}" method="POST">
                @csrf
                
                <!-- Première ligne : Nom et Nom entreprise -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700">
                            Nom complet <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="nom" name="nom" type="text" required 
                                   value="{{ old('nom') }}"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="nom_entreprise" class="block text-sm font-medium text-gray-700">
                            Nom de l'entreprise
                        </label>
                        <div class="mt-1">
                            <input id="nom_entreprise" name="nom_entreprise" type="text" 
                                   value="{{ old('nom_entreprise') }}"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Deuxième ligne : Email et Téléphone -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Adresse email <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                   value="{{ old('email') }}"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="telephone" class="block text-sm font-medium text-gray-700">
                            Téléphone
                        </label>
                        <div class="mt-1">
                            <input id="telephone" name="telephone" type="tel" 
                                   value="{{ old('telephone') }}"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Adresse -->
                <div>
                    <label for="adresse" class="block text-sm font-medium text-gray-700">
                        Adresse
                    </label>
                    <div class="mt-1">
                        <textarea id="adresse" name="adresse" rows="2" 
                                  class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('adresse') }}</textarea>
                    </div>
                </div>

                <!-- Mots de passe -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Mot de passe <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="new-password" required 
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            Confirmer le mot de passe <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Conditions d'utilisation -->
                <div class="flex items-start">
                    <input id="terms" name="terms" type="checkbox" required 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1">
                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                        J'accepte les <a href="#" class="text-blue-600 hover:text-blue-500">conditions d'utilisation</a> 
                        et la <a href="#" class="text-blue-600 hover:text-blue-500">politique de confidentialité</a>
                        <span class="text-red-500">*</span>
                    </label>
                </div>

                <!-- Bouton d'inscription -->
                <div>
                    <button type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Créer mon compte
                    </button>
                </div>
            </form>

            <!-- Séparateur et bouton de connexion -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300" />
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Déjà un compte ?</span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('client.profile') }}" 
                       class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Se connecter
                    </a>
                </div>
            </div>

            <!-- Note de confidentialité -->
            <div class="mt-4 text-center">
                <p class="text-xs text-gray-500">
                    En créant un compte, vous acceptez que GTS AFRIQUE traite vos données personnelles 
                    conformément à notre politique de confidentialité.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
