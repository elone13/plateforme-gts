<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GTS Afrique') }} - @yield('page-title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
            --accent-color: #059669;
        }
        
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
        }
        
        .sidebar-link:hover {
            background-color: #f3f4f6;
            color: #111827;
            transform: translateX(4px);
        }
        
        .sidebar-link.active {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transform: translateX(8px);
        }
        
        .sidebar-link.active:hover {
            background-color: var(--primary-dark);
        }
        
        .sidebar-link i {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            font-size: 18px;
        }
        
        .sidebar-link span {
            font-size: 14px;
        }
        
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
            background-color: #1d4ed8;
        }
        
        /* Amélioration de la sidebar */
        .sidebar-nav {
            margin-top: 24px;
            padding: 0 12px;
        }
        
        .sidebar-nav .space-y-3 > * + * {
            margin-top: 12px;
        }
        
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
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div x-data="{ sidebarOpen: true }" 
             class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out"
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Logo Section -->
            <div class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <img src="{{ asset('images/logo.png') }}" alt="GTS Afrique" class="w-10 h-10 object-contain">
                        </div>
                        <div class="ml-3">
                            <p class="text-xs text-gray-500">Plateforme Commerciale</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav">
                <div class="space-y-3">
                    <a href="{{ route('commercial.dashboard') }}" 
                       class="sidebar-link {{ request()->routeIs('commercial.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Tableau de bord</span>
                    </a>

                    <a href="{{ route('commercial.demandes-demo.index') }}" 
                       class="sidebar-link {{ request()->routeIs('commercial.demandes-demo.*') ? 'active' : '' }}">
                        <i class="fas fa-rocket"></i>
                        <span>Demandes de démo</span>
                    </a>

                    <a href="{{ route('commercial.clients.index') }}" 
                       class="sidebar-link {{ request()->routeIs('commercial.clients.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Gestion Clients</span>
                    </a>

                    <a href="{{ route('commercial.devis.index') }}" 
                       class="sidebar-link {{ request()->routeIs('commercial.devis.*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice"></i>
                        <span>Devis</span>
                    </a>

                    <a href="{{ route('commercial.factures.index') }}" 
                       class="sidebar-link {{ request()->routeIs('commercial.factures.*') ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i>
                        <span>Factures</span>
                    </a>

                    <a href="{{ route('commercial.abonnements.index') }}" 
                       class="sidebar-link {{ request()->routeIs('commercial.abonnements.*') ? 'active' : '' }}">
                        <i class="fas fa-credit-card"></i>
                        <span>Abonnements</span>
                    </a>

                    <a href="{{ route('commercial.planning') }}" 
                       class="sidebar-link {{ request()->routeIs('commercial.planning.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Planning</span>
                    </a>
                </div>

                <!-- Logout Section -->
                <div class="sidebar-logout">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sidebar-link">
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
                        <button class="text-gray-500 hover:text-gray-700 relative">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-gray-700 hover:text-gray-900">
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
