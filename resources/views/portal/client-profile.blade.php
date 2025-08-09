<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - GTS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="GTS" class="h-12 w-auto" />
                        <span class="sr-only">GTS</span>
                    </div>
                    <div class="hidden md:block ml-10">
                        <div class="flex items-baseline space-x-4">
                            <a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Accueil</a>
                            <a href="{{ route('services') }}" class="text-gray-500 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Services</a>
                            <a href="{{ route('contact') }}" class="text-gray-500 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('contact') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-play mr-2"></i>Demander une démo
                    </a>
                    
                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-gray-500 hover:text-indigo-600 p-2 rounded-md">
                            <i class="fas fa-user-circle text-xl"></i>
                            <span class="ml-2 text-sm">{{ auth()->user()->name }}</span>
                        </button>
                        
                        <!-- Dropdown menu -->
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
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
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-grow py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Mon Profil</h1>
                <p class="text-lg text-gray-600">Gérez vos informations personnelles</p>
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

            <!-- Profile Information -->
            <div class="bg-white shadow-lg rounded-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Personal Information -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Informations personnelles</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                                <p class="text-gray-900">{{ auth()->user()->name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <p class="text-gray-900">{{ auth()->user()->email }}</p>
                            </div>
                            
                            @if(auth()->user()->client)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                    <p class="text-gray-900">{{ auth()->user()->client->telephone ?? 'Non renseigné' }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Entreprise</label>
                                    <p class="text-gray-900">{{ auth()->user()->client->entreprise ?? 'Non renseigné' }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                                    <p class="text-gray-900">{{ auth()->user()->client->adresse ?? 'Non renseigné' }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Account Statistics -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Statistiques du compte</h2>
                        
                        <div class="space-y-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-file-invoice text-blue-600 text-xl mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-blue-900">Devis demandés</p>
                                        <p class="text-2xl font-bold text-blue-600">{{ auth()->user()->client->devis->count() ?? 0 }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-green-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-receipt text-green-600 text-xl mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-green-900">Factures reçues</p>
                                        <p class="text-2xl font-bold text-green-600">{{ auth()->user()->client->factures->count() ?? 0 }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-purple-600 text-xl mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-purple-900">Membre depuis</p>
                                        <p class="text-lg font-semibold text-purple-600">{{ auth()->user()->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('client.devis') }}" class="bg-indigo-50 hover:bg-indigo-100 p-4 rounded-lg text-center transition duration-150">
                            <i class="fas fa-file-invoice text-indigo-600 text-2xl mb-2"></i>
                            <p class="text-sm font-medium text-indigo-900">Voir mes devis</p>
                        </a>
                        
                        <a href="{{ route('client.factures') }}" class="bg-green-50 hover:bg-green-100 p-4 rounded-lg text-center transition duration-150">
                            <i class="fas fa-receipt text-green-600 text-2xl mb-2"></i>
                            <p class="text-sm font-medium text-green-900">Voir mes factures</p>
                        </a>
                        
                        <a href="{{ route('contact') }}" class="bg-blue-50 hover:bg-blue-100 p-4 rounded-lg text-center transition duration-150">
                            <i class="fas fa-headset text-blue-600 text-2xl mb-2"></i>
                            <p class="text-sm font-medium text-blue-900">Demander une démo</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-300">&copy; 2024 GTS. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js for dropdown functionality -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html> 