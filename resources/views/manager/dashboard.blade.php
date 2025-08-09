<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tableau de bord Manager
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Bienvenue Manager {{ auth()->user()->name }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Statistiques générales -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-blue-800">Statistiques Générales</h4>
                        <div class="mt-2 text-sm text-blue-600">
                            <p>Clients actifs: <span class="font-bold">0</span></p>
                            <p>Devis en cours: <span class="font-bold">0</span></p>
                            <p>Factures impayées: <span class="font-bold">0</span></p>
                        </div>
                    </div>

                    <!-- Actions rapides -->
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-green-800">Actions Rapides</h4>
                        <div class="mt-2 space-y-2">
                            <a href="#" class="block text-sm text-green-600 hover:text-green-800">Gérer les services</a>
                            <a href="#" class="block text-sm text-green-600 hover:text-green-800">Voir les demandes</a>
                            <a href="#" class="block text-sm text-green-600 hover:text-green-800">Gérer les utilisateurs</a>
                        </div>
                    </div>

                    <!-- Alertes -->
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-yellow-800">Alertes</h4>
                        <div class="mt-2 text-sm text-yellow-600">
                            <p>Aucune alerte pour le moment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 