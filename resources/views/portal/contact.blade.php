@extends('layouts.portal')

@section('title', 'Contact - GTS Afrique')

@section('content')
    <div class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Contactez-nous</h1>
                <p class="text-lg text-gray-600">Demandez une démonstration de nos services</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-8 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Contact Form -->
            <div class="bg-white shadow-lg rounded-lg p-8">
                <form action="{{ route('demande-demo.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Champs cachés pour la gestion -->
                    <input type="hidden" name="source" value="site_web">
                    <input type="hidden" name="priorite" value="moyenne">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom complet <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="nom" 
                                   name="nom" 
                                   value="{{ old('nom') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('nom') border-red-500 @enderror"
                                   placeholder="Votre nom complet">
                            @error('nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror"
                                   placeholder="votre@email.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                            Téléphone <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               id="telephone" 
                               name="telephone" 
                               value="{{ old('telephone') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('telephone') border-red-500 @enderror"
                               placeholder="+33 1 23 45 67 89">
                        @error('telephone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Message (optionnel)
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="4"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('message') border-red-500 @enderror"
                                  placeholder="Décrivez vos besoins ou posez vos questions...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center">
                        <button type="submit" 
                                class="bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                            <i class="fas fa-paper-plane mr-2"></i>Envoyer ma demande de démo
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-primary/10 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-primary text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Email</h3>
                    <p class="text-gray-600">contact@globaltrackings.com</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-primary/10 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-primary text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Téléphone</h3>
                    <p class="text-gray-600">+221 33 871 01 83</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-primary/10 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fab fa-whatsapp text-primary text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">WhatsApp</h3>
                    <p class="text-gray-600">+221 77 523 37 97</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-primary/10 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-primary text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Siège social</h3>
                    <p class="text-gray-600">Cité Sipres Alhazar N303<br>25000 Rufisque, Sénégal</p>
                </div>
            </div>

            <!-- Horaires d'ouverture -->
            <div class="mt-12 bg-white shadow-lg rounded-lg p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Horaires d'ouverture</h2>
                    <p class="text-gray-600">Nos équipes sont disponibles pour vous accompagner</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-2xl mx-auto">
                    <div class="text-center">
                        <div class="bg-green-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-clock text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Lundi - Vendredi</h3>
                        <p class="text-gray-600 font-semibold">09:00 - 18:00</p>
                        <p class="text-sm text-green-600 mt-1">Ouvert</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-red-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-times text-red-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Samedi - Dimanche</h3>
                        <p class="text-gray-600 font-semibold">Fermé</p>
                        <p class="text-sm text-red-600 mt-1">Fermé</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection