<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GTS Afrique') }} - @yield('page-title', 'Dashboard Manager')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles personnalisés GTS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Tailwind CSS -->
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

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #fcd61b;
            --primary-dark: #e6c200;
            --secondary-color: #1e40af;
            --secondary-dark: #1e3a8a;
            --accent-color: #059669;
        }
        
        /* Sidebar principale */
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #374151;
            background-color: transparent;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 4px;
            width: 100%;
            border: 1px solid transparent;
        }
        
        .sidebar-link:hover {
            background-color: #f3f4f6;
            color: #111827;
            transform: translateX(4px);
            border-color: #e5e7eb;
        }
        
        .sidebar-link.active {
            background-color: var(--primary-color);
            color: #111827;
            box-shadow: 0 4px 6px -1px rgba(252, 214, 27, 0.3);
            transform: translateX(8px);
            border-color: var(--primary-color);
        }
        
        .sidebar-link.active:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        .sidebar-link.secondary.active {
            background-color: var(--secondary-color);
            color: white;
            border-color: var(--secondary-color);
        }
        
        .sidebar-link.secondary.active:hover {
            background-color: var(--secondary-dark);
            border-color: var(--secondary-dark);
        }
        
        .sidebar-link i {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            font-size: 18px;
            flex-shrink: 0;
        }
        
        .sidebar-link span {
            font-size: 14px;
            white-space: nowrap;
        }
        
        /* Sections de la sidebar */
        .sidebar-section {
            margin-bottom: 24px;
        }
        
        .sidebar-section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            margin-bottom: 8px;
            padding-left: 16px;
        }
        
        /* Bouton de déconnexion */
        .sidebar-logout {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
        }
        
        .sidebar-logout button {
            width: 100%;
            text-align: left;
            color: #dc2626;
            background-color: transparent;
            border: none;
            cursor: pointer;
            padding: 12px 16px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .sidebar-logout button:hover {
            background-color: #fef2f2;
            color: #b91c1c;
        }
        
        /* Amélioration de la sidebar */
        .sidebar-nav {
            margin-top: 24px;
            padding: 0 12px;
        }
        
        /* Scrollbar personnalisée */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar-link {
                padding: 14px 16px;
            }
            
            .sidebar-link span {
                font-size: 15px;
            }
        }
        
        /* Stat cards et boutons */
        .stat-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 24px;
            border: 1px solid #e5e7eb;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        
        .btn-secondary:hover {
            background-color: var(--secondary-dark);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div x-data="{ sidebarOpen: true }" 
             class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out overflow-y-auto"
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Logo Section -->
            <div class="bg-white border-b border-gray-200 px-6 py-4 sticky top-0 z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <img src="{{ asset('images/logo.png') }}" alt="GTS Afrique" class="w-10 h-10 object-contain">
                        </div>
                        <div class="ml-3">
                            <p class="text-xs text-gray-500">Espace Manager</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="px-4 py-6 space-y-6">
                <!-- Tableau de bord -->
                <div class="space-y-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3">Tableau de bord</h3>
                    <a href="{{ route('manager.dashboard') }}" 
                       class="sidebar-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Vue d'ensemble</span>
                    </a>
                </div>

                <!-- Gestion des équipes -->
                <div class="space-y-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3">Gestion des équipes</h3>
                    <a href="{{ route('manager.commerciaux.index') }}" 
                       class="sidebar-link secondary {{ request()->routeIs('manager.commerciaux.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Commerciaux</span>
                    </a>
                </div>

                <!-- Supervision commerciale -->
                <div class="space-y-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3">Supervision commerciale</h3>
                    <a href="{{ route('manager.demandes-demo.index') }}" 
                       class="sidebar-link {{ request()->routeIs('manager.demandes-demo.*') ? 'active' : '' }}">
                        <i class="fas fa-rocket"></i>
                        <span>Demandes de démo</span>
                    </a>
                    
                    <a href="{{ route('manager.devis.index') }}" 
                       class="sidebar-link {{ request()->routeIs('manager.devis.*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice"></i>
                        <span>Devis</span>
                    </a>
                    
                    <a href="{{ route('manager.factures.index') }}" 
                       class="sidebar-link {{ request()->routeIs('manager.factures.*') ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i>
                        <span>Factures</span>
                    </a>
                </div>

                <!-- Gestion des services -->
                <div class="space-y-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3">Gestion des services</h3>
                    <a href="{{ route('manager.services.index') }}" 
                       class="sidebar-link {{ request()->routeIs('manager.services.*') ? 'active' : '' }}">
                        <i class="fas fa-cogs"></i>
                        <span>Services</span>
                    </a>
                </div>

                <!-- Rapports et analyses -->
                <div class="space-y-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3">Rapports et analyses</h3>
                    <a href="{{ route('manager.rapports.index') }}" 
                       class="sidebar-link {{ request()->routeIs('manager.rapports.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Rapports</span>
                    </a>
                    
                    <a href="{{ route('manager.analytics.index') }}" 
                       class="sidebar-link {{ request()->routeIs('manager.analytics.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Analytics</span>
                    </a>
                </div>

                <!-- Déconnexion - Toujours visible en bas -->
                <div class="pt-6 mt-6 border-t border-gray-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full sidebar-link text-red-600 hover:text-red-700 hover:bg-red-50">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-primary">
                <div class="flex items-center justify-between px-6 py-4">
                    <!-- Left side -->
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-primary mr-4">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                            <p class="text-sm text-gray-600">@yield('page-description', '')</p>
                        </div>
                    </div>

                    <!-- Right side -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="text-gray-500 hover:text-primary relative">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-primary rounded-full"></span>
                        </button>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-gray-700 hover:text-primary">
                                <img class="w-8 h-8 rounded-full" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}">
                                <span class="ml-2 text-sm font-medium">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down ml-1 text-xs"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Mon profil
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i>Paramètres
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    @livewireScripts
</body>
</html>
