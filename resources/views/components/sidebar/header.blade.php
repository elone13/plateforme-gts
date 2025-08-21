@props([
    'logo' => 'images/logo.png',
    'title' => 'Espace Client',
    'showCloseButton' => false
])

<div class="bg-white border-b border-gray-200 px-6 py-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-10 h-10 flex items-center justify-center">
                <img src="{{ asset($logo) }}" alt="GTS Afrique" class="w-10 h-10 object-contain">
            </div>
            <div class="ml-3">
                <p class="text-xs text-gray-500">{{ $title }}</p>
            </div>
        </div>
        @if($showCloseButton)
            <button @click="$store.sidebar.isOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>
</div>
