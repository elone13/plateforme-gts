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
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    @if(!request()->routeIs('client.*'))
    <nav class="bg-white shadow-lg border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
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

                                <!-- Côté droit : Simple info utilisateur -->
                <div class="flex items-center">
                                        @auth
                        <div class="flex items-center space-x-4">
                            <!-- Bouton Demander une démo -->
                            <a href="{{ route('contact') }}" class="bg-white hover:bg-primary text-primary hover:text-white border-2 border-primary px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                                <i class="fas fa-rocket mr-2"></i>Demander une démo
                            </a>
                            
                            <!-- Menu utilisateur avec dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                        @click.away="open = false"
                                        class="flex items-center space-x-2 text-gray-700 hover:text-primary transition-colors duration-200 focus:outline-none">
                                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <span class="hidden md:block text-sm font-medium">{{ auth()->user()->name }}</span>
                                    <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                                </button>
                                
                                <!-- Dropdown menu -->
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                                    
                                    <!-- Profil -->
                                    <a href="{{ route('client.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                        <i class="fas fa-user mr-3 text-gray-400"></i>
                                        Mon Profil
                                    </a>
                                    
                                    <!-- Séparateur -->
                                    <div class="border-t border-gray-200 my-1"></div>
                                    
                                    <!-- Déconnexion -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                            <i class="fas fa-sign-out-alt mr-3 text-gray-400"></i>
                                            Déconnexion
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
    @endif

    <!-- Menu mobile -->
    @if(!request()->routeIs('client.*'))
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
            
            @auth
            <!-- Séparateur pour utilisateur connecté -->
            <div class="border-t border-gray-200 my-2"></div>
            
            <!-- Profil utilisateur -->
            <a href="{{ route('client.profile') }}" class="block px-3 py-2 text-base font-medium text-gray-900 hover:text-primary hover:bg-gray-50 rounded-md">
                <i class="fas fa-user mr-2"></i>Mon Profil
            </a>
            
            <!-- Déconnexion -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left block px-3 py-2 text-base font-medium text-gray-900 hover:text-primary hover:bg-gray-50 rounded-md">
                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                </button>
            </form>
            @endauth
        </div>
    </div>
    @endif

    <!-- Contenu principal -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center text-gray-400">
                <p>&copy; {{ date('Y') }} GTS Afrique. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    @stack('modals')

    <!-- JavaScript pour le menu mobile -->
    @if(!request()->routeIs('client.*'))
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
    @endif
</body>
</html>
