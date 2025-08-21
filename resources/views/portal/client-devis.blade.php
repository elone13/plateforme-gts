@extends('layouts.portal')
@section('title', 'Mes Devis - GTS Afrique')
@section('content')

<div class="min-h-screen bg-gray-50">
    <!-- Header de l'espace client -->
    <div class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-semibold text-gray-900">Mon Espace Client</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Navigation principale -->
                    <nav class="hidden md:flex space-x-8">
                        <a href="{{ route('client.profile') }}" class="text-gray-600 hover:text-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Tableau de bord
                        </a>
                        <a href="{{ route('client.demandes') }}" class="text-gray-600 hover:text-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Mes Demandes
                        </a>
                        <a href="{{ route('client.devis') }}" class="text-gts-primary border-b-2 border-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Devis
                        </a>
                        <a href="{{ route('client.factures') }}" class="text-gray-600 hover:text-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Factures
                        </a>
                        <a href="{{ route('client.abonnements') }}" class="text-gray-600 hover:text-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Abonnements
                        </a>
                    </nav>
                    
                    <!-- Bouton retour à l'accueil -->
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gts-primary text-white text-sm font-medium rounded-lg hover:bg-gts-primary/90 transition-colors duration-200">
                        <i class="fas fa-home mr-2"></i>
                        Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" style="padding-top: 8rem; margin-top: 2rem;">
        
        <!-- En-tête de la page -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Mes Devis</h2>
                    <p class="text-lg text-gray-600">Consultez et gérez vos devis</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('contact') }}" class="btn-gts-primary inline-flex items-center px-6 py-3 rounded-xl">
                        <i class="fas fa-plus mr-2"></i>
                        Demander un devis
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total devis -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total devis</p>
                        <p class="text-3xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>

            <!-- En attente -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-xl">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">En attente</p>
                        <p class="text-3xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>

            <!-- Validés -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-xl">
                        <i class="fas fa-check text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Validés</p>
                        <p class="text-3xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message si aucun devis -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12">
            <div class="text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-file-invoice text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Aucun devis</h3>
                <p class="text-gray-600 mb-8">Vous n'avez pas encore reçu de devis de notre part.</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-gts-primary text-gray-900 rounded-xl hover:bg-opacity-80 transition-colors duration-200">
                    <i class="fas fa-envelope mr-2"></i>
                    Demander un devis
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
