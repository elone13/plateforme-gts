@props([
    'mainSections' => [],
    'quickActions' => [],
    'showLogout' => true
])

<nav class="sidebar-nav">
    <div class="space-y-3">
        <!-- Sections principales -->
        @foreach($mainSections as $section => $config)
            <button onclick="showSection('{{ $section }}')" 
                    id="nav-{{ $section }}"
                    class="sidebar-link {{ $config['active'] ?? false ? 'active' : '' }} w-full text-left">
                <i class="{{ $config['icon'] ?? 'fas fa-circle' }}"></i>
                <span>{{ $config['label'] ?? 'Section' }}</span>
                @if(isset($config['badge']) && is_numeric($config['badge']) && $config['badge'] > 0)
                    <span class="ml-auto bg-purple-100 text-purple-800 text-xs font-medium px-2 py-1 rounded-full">
                        {{ $config['badge'] }}
                    </span>
                @endif
            </button>
        @endforeach

        <!-- Pas d'actions rapides pour simplifier la sidebar -->
    </div>

    <!-- Logout -->
    @if($showLogout)
        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-full text-left">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    @endif
</nav>
