@extends('layouts.portal')

@section('title', 'Nos Solutions - GTS Afrique')

@section('content')
    <!-- Nos solutions -->
    <section id="solutions" class="bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <!-- En-tête de section -->
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Nos Solutions Innovantes</h1>
                <div class="w-32 h-1 bg-primary rounded-full mx-auto mb-6"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Découvrez notre gamme complète de solutions de géolocalisation et de gestion de flotte 
                    conçues pour optimiser vos opérations et réduire vos coûts.
                </p>
            </div>

            <!-- Grille des solutions dynamiques depuis la base de données -->
            @if(isset($services) && $services->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($services as $service)
                    <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:border-primary">
                        <!-- Image du service -->
                        <div class="h-56 overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-100">
                            @if($service->image)
                                <img src="{{ Storage::url($service->image) }}" 
                                     alt="{{ $service->nom }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                    <i class="fas fa-satellite-dish text-white text-6xl group-hover:scale-110 transition-transform duration-300"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Contenu du service -->
                        <div class="p-6">
                            <!-- Icône et titre -->
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-satellite-dish text-primary text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-primary transition-colors duration-300">
                                    {{ $service->nom }}
                                </h3>
                            </div>

                            <!-- Description -->
                            <p class="text-gray-600 leading-relaxed mb-6 text-sm">
                                {{ Str::limit($service->description, 150) }}
                            </p>
                            
                            <!-- Composants inclus (aperçu) -->
                            @if($service->items->count() > 0)
                                <div class="space-y-3 mb-6">
                                    <h5 class="text-sm font-semibold text-gray-700 flex items-center">
                                        <i class="fas fa-puzzle-piece mr-2 text-primary"></i>
                                        Composants inclus
                                    </h5>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($service->items->take(4) as $item)
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                                <i class="fas fa-check-circle mr-1.5 text-blue-500"></i>
                                                {{ $item->nom }}
                                            </span>
                                        @endforeach
                                        @if($service->items->count() > 4)
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-50 text-gray-600 border border-gray-200">
                                                +{{ $service->items->count() - 4 }} autres
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- CTA -->
                            <div class="pt-4 border-t border-gray-100">
                                <div class="flex gap-3">
                                    <a href="{{ route('service.detail', $service->id) }}" class="flex-1 bg-primary hover:bg-primary-dark text-gray-900 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center text-sm">
                                        <i class="fas fa-eye mr-2"></i>
                                        Détails
                                    </a>
                                    <a href="{{ route('contact') }}?service={{ $service->id }}" class="flex-1 bg-secondary hover:bg-secondary-dark text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center text-sm">
                                        <i class="fas fa-file-invoice mr-2"></i>
                                        Devis
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <!-- Message si aucun service n'est disponible -->
                <div class="text-center py-16">
                    <div class="text-gray-400 mb-6">
                        <i class="fas fa-cogs text-8xl"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 mb-4">Aucun service disponible</h4>
                    <p class="text-gray-600 text-lg">
                        Nos services sont en cours de préparation. Revenez bientôt pour découvrir nos solutions !
                    </p>
                </div>
            @endif
        </div>

        <!-- CTA Section -->
        <div class="text-center mt-16">
            <a href="{{ route('contact') }}" class="inline-flex items-center px-8 py-4 bg-primary text-gray-900 font-semibold rounded-full hover:bg-primary-dark transform transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl">
                <span>Demander une démo</span>
                <i class="fas fa-arrow-right ml-3 transition-transform duration-300 group-hover:translate-x-1"></i>
            </a>
        </div>
    </section>


@endsection