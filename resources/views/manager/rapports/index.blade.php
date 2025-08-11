@extends('layouts.manager')

@section('page-title', 'Rapports et analyses')
@section('page-description', 'Analyser les performances de l\'équipe commerciale')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">Rapports et analyses</h2>
                </div>
            </div>
        </div>

        <!-- Statistiques détaillées -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Performance des commerciaux -->
            <div class="bg-white shadow-lg rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Performance des commerciaux</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach(\App\Models\Administrateur::where('type', 'commercial')->with('user')->get() as $commercial)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="h-8 w-8 rounded-full bg-primary/20 flex items-center justify-center">
                                    <span class="text-xs font-medium text-primary">
                                        {{ strtoupper(substr($commercial->user->name, 0, 2)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $commercial->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $commercial->user->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">0</p>
                                <p class="text-xs text-gray-500">demandes traitées</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Statistiques des demandes -->
            <div class="bg-white shadow-lg rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Statistiques des demandes</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-clock text-blue-600"></i>
                                <span class="text-sm font-medium text-blue-900">En attente</span>
                            </div>
                            <span class="text-lg font-bold text-blue-900">{{ \App\Models\DemandeDemo::where('statut', 'en_attente')->count() }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-check text-green-600"></i>
                                <span class="text-sm font-medium text-green-900">Acceptées</span>
                            </div>
                            <span class="text-lg font-bold text-green-900">{{ \App\Models\DemandeDemo::where('statut', 'acceptee')->count() }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-play text-yellow-600"></i>
                                <span class="text-sm font-medium text-yellow-900">En cours</span>
                            </div>
                            <span class="text-lg font-bold text-yellow-900">{{ \App\Models\DemandeDemo::where('statut', 'en_cours')->count() }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-check-double text-purple-600"></i>
                                <span class="text-sm font-medium text-purple-900">Terminées</span>
                            </div>
                            <span class="text-lg font-bold text-purple-900">{{ \App\Models\DemandeDemo::where('statut', 'terminee')->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphique des performances -->
        <div class="bg-white shadow-lg rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Évolution des demandes</h3>
            </div>
            <div class="p-6">
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-chart-line text-4xl text-gray-300 mb-4"></i>
                    <p class="text-lg font-medium">Graphiques en cours de développement</p>
                    <p class="text-sm">Les graphiques et analyses avancées seront bientôt disponibles.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
