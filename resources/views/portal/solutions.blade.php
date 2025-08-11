<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nos Solutions - GTS Afrique</title>
    <meta name="description" content="Découvrez nos solutions de géolocalisation GPS, gestion de flotte et suivi carburant pour optimiser votre entreprise.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        'primary-dark': '#2563eb',
                        secondary: '#FFC107',
                        'secondary-dark': '#E6A800',
                        accent: '#10B981'
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS -->
    <style>
        .service-card {
            transition: all 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="gradient-bg text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="GTS Afrique" class="h-12 w-auto mr-4">
                    <h1 class="text-2xl font-bold">GTS Afrique</h1>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-white hover:text-blue-200 transition-colors">Accueil</a>
                    <a href="{{ route('solutions') }}" class="text-blue-200 font-semibold">Nos Solutions</a>
                    <a href="#contact" class="text-white hover:text-blue-200 transition-colors">Contact</a>
                </nav>
                <div class="md:hidden">
                    <button class="text-white hover:text-blue-200">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="gradient-bg text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-6xl font-bold mb-6">
                Nos Solutions de Géolocalisation
            </h2>
            <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
                Découvrez nos services innovants de suivi GPS, gestion de flotte et optimisation carburant pour propulser votre entreprise vers l'excellence opérationnelle.
            </p>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Solutions Complètes
                </h3>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Des services sur mesure pour répondre aux défis de la logistique moderne et de la gestion de flotte.
                </p>
            </div>

            <!-- Services Grid -->
            @if($services->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($services as $service)
                    <div class="service-card bg-white rounded-2xl shadow-lg overflow-hidden">
                        <!-- Service Image -->
                        @if($service->image)
                            <div class="h-48 bg-gray-200 overflow-hidden">
                                <img src="{{ Storage::url($service->image) }}" 
                                     alt="{{ $service->nom }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                <i class="fas fa-cogs text-white text-6xl"></i>
                            </div>
                        @endif

                        <!-- Service Content -->
                        <div class="p-6">
                            <h4 class="text-xl font-bold text-gray-900 mb-3">
                                {{ $service->nom }}
                            </h4>
                            <p class="text-gray-600 leading-relaxed mb-4">
                                {{ Str::limit($service->description, 120) }}
                            </p>

                            <!-- Service Items -->
                            @if($service->items->count() > 0)
                                <div class="space-y-2 mb-4">
                                    <h5 class="text-sm font-semibold text-gray-700">Composants inclus :</h5>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($service->items->take(3) as $item)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                {{ $item->nom }}
                                            </span>
                                        @endforeach
                                        @if($service->items->count() > 3)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                +{{ $service->items->count() - 3 }} autres
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Call to Action -->
                            <div class="flex items-center justify-between">
                                <button class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    En savoir plus
                                </button>
                                @if($service->items->where('prix', '>', 0)->count() > 0)
                                    <span class="text-sm text-gray-500">
                                        À partir de {{ number_format($service->items->where('prix', '>', 0)->min('prix'), 2) }}€
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <!-- No Services Message -->
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
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Pourquoi Choisir GTS Afrique ?
                </h3>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Une expertise reconnue dans la géolocalisation et la gestion de flotte en Afrique.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-satellite text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Technologie GPS Avancée</h4>
                    <p class="text-gray-600">Suivi en temps réel avec précision métrique et couverture panafricaine.</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Optimisation Continue</h4>
                    <p class="text-gray-600">Analyses et rapports détaillés pour améliorer vos performances opérationnelles.</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-accent rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Support 24/7</h4>
                    <p class="text-gray-600">Équipe technique disponible en permanence pour vous accompagner.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-3xl md:text-4xl font-bold mb-4">
                Prêt à Optimiser Votre Flotte ?
            </h3>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Contactez-nous pour découvrir comment nos solutions peuvent transformer vos opérations logistiques.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:contact@gts-afrique.com" 
                   class="bg-primary hover:bg-primary-dark text-white px-8 py-3 rounded-lg font-medium transition-colors duration-200 inline-flex items-center justify-center">
                    <i class="fas fa-envelope mr-2"></i>
                    Nous Contacter
                </a>
                <a href="tel:+22500000000" 
                   class="bg-secondary hover:bg-secondary-dark text-white px-8 py-3 rounded-lg font-medium transition-colors duration-200 inline-flex items-center justify-center">
                    <i class="fas fa-phone mr-2"></i>
                    Appeler Maintenant
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <img src="{{ asset('images/logo.png') }}" alt="GTS Afrique" class="h-12 w-auto mb-4">
                    <p class="text-gray-300">
                        Leader en solutions de géolocalisation GPS et gestion de flotte en Afrique.
                    </p>
                </div>
                <div>
                    <h5 class="font-semibold mb-4">Solutions</h5>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors">Géolocalisation GPS</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Gestion de Flotte</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Suivi Carburant</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Rapports Analytiques</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-semibold mb-4">Entreprise</h5>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors">À propos</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Équipe</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Carrières</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Actualités</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-semibold mb-4">Contact</h5>
                    <ul class="space-y-2 text-gray-300">
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Abidjan, Côte d'Ivoire</li>
                        <li><i class="fas fa-phone mr-2"></i> +225 00 00 00 00</li>
                        <li><i class="fas fa-envelope mr-2"></i> contact@gts-afrique.com</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; {{ date('Y') }} GTS Afrique. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>
