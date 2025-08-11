@extends('layouts.portal')

@section('title', $service->nom . ' - GTS Afrique')

@section('content')
    <!-- En-tête de la page -->
    <section class="bg-gradient-to-br from-blue-50 to-indigo-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary">
                            <i class="fas fa-home mr-2"></i>
                            Accueil
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="{{ route('services') }}" class="text-sm font-medium text-gray-700 hover:text-primary">
                                Services
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-sm font-medium text-gray-500">{{ $service->nom }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Titre et description -->
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">{{ $service->nom }}</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    {{ $service->description }}
                </p>
            </div>
        </div>
    </section>

    <!-- Contenu principal -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Colonne principale -->
                <div class="lg:col-span-2">
                    <!-- Image du service -->
                    @if($service->image)
                        <div class="mb-8">
                            <img src="{{ Storage::url($service->image) }}" 
                                 alt="{{ $service->nom }}" 
                                 class="w-full h-96 object-cover rounded-2xl shadow-lg">
                        </div>
                    @else
                        <div class="mb-8 h-96 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl shadow-lg flex items-center justify-center">
                            <i class="fas fa-satellite-dish text-white text-8xl"></i>
                        </div>
                    @endif

                    <!-- Description détaillée -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-info-circle text-primary mr-3"></i>
                            Description détaillée
                        </h2>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            {{ $service->description }}
                        </p>
                    </div>

                    <!-- Composants du service -->
                    @if($service->items->count() > 0)
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-puzzle-piece text-primary mr-3"></i>
                                Composants inclus ({{ $service->items->count() }})
                            </h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($service->items as $item)
                                <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow duration-300">
                                    <div class="flex items-start justify-between mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $item->nom }}</h3>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $item->statut }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-gray-600 mb-4">{{ $item->description }}</p>
                                    
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>Quantité: {{ $item->quantite }}</span>
                                        @if($item->prix)
                                            <span class="font-semibold text-primary">{{ number_format($item->prix, 2) }}€</span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-puzzle-piece text-6xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun composant</h3>
                            <p class="text-gray-600">Ce service n'a pas encore de composants associés.</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Carte d'action -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Intéressé par ce service ?</h3>
                        
                        <div class="space-y-4">
                            <a href="{{ route('contact') }}?service={{ $service->id }}" 
                               class="w-full bg-primary hover:bg-primary-dark text-gray-900 px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-file-invoice mr-2"></i>
                                Demander un devis
                            </a>
                            
                            <a href="mailto:contact@gts-afrique.com?subject=Demande d'information - {{ $service->nom }}" 
                               class="w-full bg-secondary hover:bg-secondary-dark text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-envelope mr-2"></i>
                                Nous contacter
                            </a>
                            
                            <a href="tel:+22500000000" 
                               class="w-full bg-accent hover:bg-accent-dark text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-phone mr-2"></i>
                                Appeler maintenant
                            </a>
                        </div>

                        <!-- Informations de contact -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h4 class="font-semibold text-gray-900 mb-3">Informations de contact</h4>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                                    <span>Abidjan, Côte d'Ivoire</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-primary mr-2"></i>
                                    <span>+225 00 00 00 00</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-primary mr-2"></i>
                                    <span>contact@gts-afrique.com</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section CTA -->
    <section class="bg-gray-900 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Prêt à optimiser votre flotte ?
            </h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Contactez-nous pour découvrir comment {{ $service->nom }} peut transformer vos opérations logistiques.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}?service={{ $service->id }}" 
                   class="bg-primary hover:bg-primary-dark text-gray-900 px-8 py-3 rounded-lg font-medium transition-colors duration-200 inline-flex items-center justify-center">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Demander un devis
                </a>
                <a href="{{ route('services') }}" 
                   class="bg-secondary hover:bg-secondary-dark text-white px-8 py-3 rounded-lg font-medium transition-colors duration-200 inline-flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voir tous nos services
                </a>
            </div>
        </div>
    </section>
@endsection
