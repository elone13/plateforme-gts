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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                            <p class="text-xs text-gray-500">Plateforme Manager</p>
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
                    <a href="{{ route('manager.dashboard') }}" 
                       class="sidebar-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Tableau de bord</span>
                    </a>

                    <a href="{{ route('manager.services.index') }}" 
                       class="sidebar-link {{ request()->routeIs('manager.services.*') ? 'active' : '' }}">
                        <i class="fas fa-cogs"></i>
                        <span>Services</span>
                    </a>

                    <a href="{{ route('manager.items.index') }}" 
                       class="sidebar-link {{ request()->routeIs('manager.items.*') ? 'active' : '' }}">
                        <i class="fas fa-boxes"></i>
                        <span>Items</span>
                    </a>

                    <a href="{{ route('manager.analytics.index') }}" 
                       class="sidebar-link {{ request()->routeIs('manager.analytics.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Analytics</span>
                    </a>

                    <a href="{{ route('manager.rapports.index') }}" 
                       class="sidebar-link {{ request()->routeIs('manager.rapports.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i>
                        <span>Rapports</span>
                    </a>

                    <a href="{{ route('manager.commerciaux.index') }}" 
                       class="sidebar-link {{ request()->routeIs('manager.commerciaux.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Commerciaux</span>
                    </a>
                </div>

                <!-- Logout -->
                <div class="sidebar-logout">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-64">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700 mr-4">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="flex items-center text-sm text-gray-700 hover:text-gray-900 focus:outline-none">
                                <span class="mr-2">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        @if (session('success'))
                            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                {{ session('error') }}
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
</body>
</html>
