@props(['sidebarId' => 'sidebar'])

<button @click="$store.sidebar.isOpen = !$store.sidebar.isOpen" 
        class="lg:hidden p-2 text-gray-500 hover:text-gray-700 transition-colors duration-200">
    <i class="fas fa-bars text-lg"></i>
</button>
