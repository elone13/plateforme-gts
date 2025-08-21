@props(['sidebarOpen' => true])

<button @click="$store.sidebar.isOpen = !$store.sidebar.isOpen" 
        class="hidden lg:flex fixed top-4 right-4 z-30 p-2 bg-white rounded-full shadow-lg text-gray-600 hover:text-gray-800 hover:bg-gray-50 transition-all duration-200">
    <i class="fas fa-chevron-left text-sm" :class="$store.sidebar.isOpen ? 'rotate-180' : ''"></i>
</button>


