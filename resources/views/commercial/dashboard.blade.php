<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tableau de bord Commercial
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Bienvenue Commercial {{ auth()->user()->name }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Mes clients -->
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-purple-800">Mes Clients</h4>
                        <div class="mt-2 text-sm text-purple-600">
                            <p>Clients assignés: <span class="font-bold">0</span></p>
                            <p>Nouveaux prospects: <span class="font-bold">0</span></p>
                            <p>Devis en attente: <span class="font-bold">0</span></p>
                        </div>
                    </div>

                    <!-- Actions commerciales -->
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-orange-800">Actions Commerciales</h4>
                        <div class="mt-2 space-y-2">
                            <a href="#" class="block text-sm text-orange-600 hover:text-orange-800">Créer un devis</a>
                            <a href="#" class="block text-sm text-orange-600 hover:text-orange-800">Suivre les demandes</a>
                            <a href="#" class="block text-sm text-orange-600 hover:text-orange-800">Gérer les factures</a>
                        </div>
                    </div>

                    <!-- Objectifs -->
                    <div class="bg-indigo-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-indigo-800">Objectifs</h4>
                        <div class="mt-2 text-sm text-indigo-600">
                            <p>CA du mois: <span class="font-bold">0 €</span></p>
                            <p>Devis convertis: <span class="font-bold">0%</span></p>
                            <p>Nouveaux clients: <span class="font-bold">0</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 