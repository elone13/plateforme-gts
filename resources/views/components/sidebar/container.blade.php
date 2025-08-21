@props([
    'mainSections' => [],
    'quickActions' => [],
    'showLogout' => true,
    'logo' => 'images/logo.png',
    'title' => 'Espace Client',
    'showCloseButton' => true
])

<!-- Overlay pour mobile -->
<x-sidebar.overlay x-data="{}" x-show="$store.sidebar.isOpen" />

<!-- Sidebar -->
<div x-data="{ sidebarOpen: true }" 
     x-init="$store.sidebar = { isOpen: $data.sidebarOpen }"
     @keydown.escape.window="sidebarOpen = false"
     class="fixed inset-y-0 right-0 z-50 w-64 bg-white shadow-2xl transform transition-all duration-300 ease-in-out"
     :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'">
    
    <!-- En-tête de la sidebar -->
    <x-sidebar.header :logo="$logo" :title="$title" :showCloseButton="$showCloseButton" />

    <!-- Navigation -->
    @if(count($mainSections) > 0)
        <x-sidebar.navigation 
            :mainSections="$mainSections" 
            :quickActions="$quickActions" 
            :showLogout="$showLogout" />
    @else
        <x-sidebar.fallback :role="$title" />
    @endif
</div>
