<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'GTS Afrique'))</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles personnalisés GTS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#fcd61b',
                        'primary-dark': '#e6c200',
                        'primary-light': '#fde047',
                        secondary: '#1e40af',
                        'secondary-dark': '#1e3a8a',
                        'secondary-light': '#3b82f6',
                        accent: '#059669',
                        'accent-dark': '#047857',
                        'accent-light': '#10b981'
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo et navigation principale -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <img class="h-10 w-auto" src="{{ asset('images/logo.png') }}" alt="GTS Afrique">
                        </a>
                    </div>
                    
                                         <!-- Navigation desktop -->
                     <div class="hidden md:ml-10 md:flex md:space-x-8">
                         <a href="{{ route('home') }}" class="text-gray-900 hover:text-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                             Accueil
                         </a>
                         <a href="{{ route('services') }}" class="text-gray-900 hover:text-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                             Services
                         </a>
                         <a href="{{ route('contact') }}" class="text-gray-900 hover:text-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                             Contact
                         </a>
                     </div>
                </div>

                <!-- Bouton mobile -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700" aria-label="Menu mobile" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>

                <!-- Côté droit : Profil utilisateur -->
                <div class="flex items-center">
                                         @auth
                         <div class="flex items-center space-x-4">
                             <!-- Bouton Demander une démo -->
                             <a href="{{ route('contact') }}" class="bg-white hover:bg-primary text-primary hover:text-white border-2 border-primary px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                                 <i class="fas fa-rocket mr-2"></i>Demander une démo
                             </a>
                             
                             <!-- Notifications -->
                             <button class="p-2 text-gray-400 hover:text-gray-500 transition-colors duration-200">
                                 <i class="fas fa-bell text-lg"></i>
                             </button>
                            
                            <!-- Menu profil -->
                            <div class="relative group">
                                <button class="flex items-center space-x-2 text-gray-700 hover:text-primary transition-colors duration-200">
                                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <span class="hidden md:block text-sm font-medium">{{ auth()->user()->name }}</span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                
                                <!-- Dropdown menu -->
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <a href="{{ route('client.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i>Mon Profil
                                    </a>
                                    <a href="{{ route('client.devis') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-file-invoice mr-2"></i>Mes Devis
                                    </a>
                                    <a href="{{ route('client.factures') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-receipt mr-2"></i>Mes Factures
                                    </a>
                                    <hr class="my-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                                         @else
                         <div class="flex items-center space-x-4">
                             <!-- Bouton Demander une démo -->
                             <a href="{{ route('contact') }}" class="bg-white hover:bg-primary text-primary hover:text-white border-2 border-primary px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                                 <i class="fas fa-rocket mr-2"></i>Demander une démo
                             </a>
                             
                             <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                                 Connexion
                             </a>
                             <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                 Inscription
                             </a>
                         </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Menu mobile -->
    <div id="mobileMenu" class="hidden md:hidden bg-white border-b border-gray-200">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-medium text-gray-900 hover:text-primary hover:bg-gray-50 rounded-md">
                Accueil
            </a>
            <a href="{{ route('services') }}" class="block px-3 py-2 text-base font-medium text-gray-900 hover:text-primary hover:bg-gray-50 rounded-md">
                Services
            </a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 text-base font-medium text-gray-900 hover:text-primary hover:bg-gray-50 rounded-md">
                Contact
            </a>
                         <a href="{{ route('contact') }}" class="block px-3 py-2 text-base font-medium bg-white text-primary hover:bg-primary hover:text-white border-2 border-primary rounded-md">
                 <i class="fas fa-rocket mr-2"></i>Demander une démo
             </a>
        </div>
    </div>

    <!-- Contenu principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo et description -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <img class="h-10 w-auto" src="{{ asset('images/logo.png') }}" alt="GTS Afrique">
                    </div>
                    <p class="text-gray-300 mb-4">
                        Solutions de géolocalisation et de gestion de flotte pour entreprises en Afrique de l'Ouest.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Services -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Nos Services</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors duration-200">Géolocalisation GPS</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-200">Gestion de flotte</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-200">Suivi en temps réel</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-200">Rapports et analyses</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                            Dakar, Sénégal
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2 text-primary"></i>
                            +221 XX XXX XX XX
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2 text-primary"></i>
                            contact@gts-afrique.com
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} GTS Afrique. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    @stack('modals')

    <!-- JavaScript pour le menu mobile -->
    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        }

        // Fermer le menu mobile quand on clique sur un lien
        document.addEventListener('DOMContentLoaded', function() {
            const mobileLinks = document.querySelectorAll('#mobileMenu a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    document.getElementById('mobileMenu').classList.add('hidden');
                });
            });
        });
    </script>
</body>
</html>
