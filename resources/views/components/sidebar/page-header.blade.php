@props([
    'title' => 'Page',
    'userName' => null,
    'userEmail' => null
])

<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="flex items-center justify-between px-6 py-4">
        <div class="flex items-center">
            <h1 class="text-2xl font-semibold text-gray-900">{{ $title }}</h1>
        </div>
        
        <div class="flex items-center space-x-4">
            <x-sidebar.mobile-toggle />
        
        <!-- User Info -->
        @if($userName || $userEmail)
        <a href="#" onclick="showSection('profile')" class="flex items-center space-x-3 hover:bg-gray-50 px-3 py-2 rounded-lg transition-colors duration-200">
            <div class="text-right">
                @if($userName)
                    <p class="text-sm font-medium text-gray-900">{{ $userName }}</p>
                @endif
                @if($userEmail)
                    <p class="text-xs text-gray-500">{{ $userEmail }}</p>
                @endif
            </div>
            <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                <i class="fas fa-user text-white text-sm"></i>
            </div>
        </a>
        @endif
    </div>
</header>
