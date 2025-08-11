<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tableau de bord Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistiques rapides -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-users text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Clients</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Client::count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-file-invoice text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Devis</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Devis::count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-rocket text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Demandes Démo</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\DemandeDemo::count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">En Attente</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\DemandeDemo::where('statut', 'en_attente')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Actions rapides</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('admin.demandes-demo.index') }}" 
                       class="group relative bg-gradient-to-r from-primary to-primary/80 p-6 rounded-lg hover:from-primary/90 hover:to-primary transition-all duration-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-rocket text-2xl text-white group-hover:scale-110 transition-transform duration-200"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-white">Gérer les demandes de démo</h4>
                                <p class="text-primary-100 text-sm">Traiter et suivre les demandes</p>
                            </div>
                        </div>
                        <div class="absolute top-4 right-4">
                            <i class="fas fa-arrow-right text-white/60 group-hover:text-white group-hover:translate-x-1 transition-all duration-200"></i>
                        </div>
                    </a>

                    <a href="#" 
                       class="group relative bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-users text-2xl text-white group-hover:scale-110 transition-transform duration-200"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-white">Gérer les clients</h4>
                                <p class="text-blue-100 text-sm">Voir et modifier les profils clients</p>
                            </div>
                        </div>
                        <div class="absolute top-4 right-4">
                            <i class="fas fa-arrow-right text-white/60 group-hover:text-white group-hover:translate-x-1 transition-all duration-200"></i>
                        </div>
                    </a>

                    <a href="#" 
                       class="group relative bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-file-invoice text-2xl text-white group-hover:scale-110 transition-transform duration-200"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-white">Gérer les devis</h4>
                                <p class="text-green-100 text-sm">Créer et suivre les devis</p>
                            </div>
                        </div>
                        <div class="absolute top-4 right-4">
                            <i class="fas fa-arrow-right text-white/60 group-hover:text-white group-hover:translate-x-1 transition-all duration-200"></i>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Demandes récentes -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Demandes de démo récentes</h3>
                    <a href="{{ route('admin.demandes-demo.index') }}" class="text-primary hover:text-primary/80 text-sm font-medium">
                        Voir toutes →
                    </a>
                </div>
                
                @php
                    $recentDemandes = \App\Models\DemandeDemo::orderBy('created_at', 'desc')->limit(5)->get();
                @endphp
                
                @if($recentDemandes->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentDemandes as $demande)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-medium text-primary">
                                        {{ strtoupper(substr($demande->nom, 0, 2)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $demande->nom }}</p>
                                    <p class="text-xs text-gray-500">{{ $demande->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $demande->statut_class }}">
                                    {{ $demande->statut_formatted }}
                                </span>
                                <a href="{{ route('admin.demandes-demo.show', $demande) }}" 
                                   class="text-primary hover:text-primary/80">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Aucune demande de démo pour le moment.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

