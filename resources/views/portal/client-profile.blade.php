@extends('layouts.portal')
@section('title', 'Mon Profil - GTS Afrique')
@section('content')

<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Mon Profil</h1>
        <p class="text-xl text-blue-100 max-w-2xl mx-auto">
            Gérez vos informations personnelles et vos préférences
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

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Informations actuelles -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Informations actuelles</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom</label>
                                <p class="text-gray-900 font-medium">{{ auth()->user()->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="text-gray-900 font-medium">{{ auth()->user()->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rôle</label>
                                <p class="text-gray-900 font-medium">{{ ucfirst(auth()->user()->role) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Membre depuis</label>
                                <p class="text-gray-900 font-medium">{{ auth()->user()->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions rapides -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Actions rapides</h3>
                        <div class="space-y-3">
                            <a href="{{ route('client.devis') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg text-center transition-colors duration-200">
                                <i class="fas fa-file-invoice mr-2"></i>Voir mes devis
                            </a>
                            <a href="{{ route('client.factures') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg text-center transition-colors duration-200">
                                <i class="fas fa-receipt mr-2"></i>Voir mes factures
                            </a>

                        </div>
                    </div>
                </div>

                <!-- Section statistiques -->
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 text-center">Vos statistiques</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-blue-50 rounded-lg p-6 text-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">Devis</h4>
                            <p class="text-2xl font-bold text-blue-600">0</p>
                            <p class="text-sm text-gray-600">devis créés</p>
                        </div>
                        
                        <div class="bg-green-50 rounded-lg p-6 text-center">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-receipt text-green-600 text-xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">Factures</h4>
                            <p class="text-2xl font-bold text-green-600">0</p>
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
            </div>
        </div>
    </div>
</div>

@endsection