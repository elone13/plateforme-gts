@extends('layouts.portal')

@section('title', 'Tableau de bord - GTS Afrique')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header avec navigation -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <h1 class="text-2xl font-bold text-gray-900">Tableau de bord</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">Dernière connexion : {{ \Carbon\Carbon::now()->format('d/m/Y à H:i') }}</span>
                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @php
            $user = auth()->user();
            $client = \App\Models\Client::where('user_id', $user->id)->first();
            $devis = null;
            $factures = null;
            $abonnements = null;
            
            if ($client) {
                $devis = \App\Models\Devis::where('client_idclient', $client->idclient)
                    ->with(['items.service'])
                    ->orderBy('date', 'desc')
                    ->get();
                
                $factures = \App\Models\Facture::whereHas('devis', function($query) use ($client) {
                    $query->where('client_idclient', $client->idclient);
                })->get();
                
                $abonnements = \App\Models\Abonnement::whereHas('item.devis', function($query) use ($client) {
                    $query->where('client_idclient', $client->idclient);
                })->get();
            }
        @endphp

        <!-- Statistiques principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total des devis -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-invoice text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total des devis</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $devis ? $devis->count() : 0 }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-500">
                        @if($devis && $devis->count() > 0)
                            Dernier : {{ \Carbon\Carbon::parse($devis->first()->date)->format('d/m/Y') }}
                        @else
                            Aucun devis
                        @endif
                    </span>
                </div>
            </div>

            <!-- Devis validés -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Devis validés</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $devis ? $devis->where('statut', 'valide')->count() : 0 }}
                        </p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-500">
                        @if($devis && $devis->where('statut', 'valide')->count() > 0)
                            Montant total : {{ number_format($devis->where('statut', 'valide')->sum('total_ttc'), 0, ',', ' ') }} FCFA
                        @else
                            Aucun devis validé
                        @endif
                    </span>
                </div>
            </div>

            <!-- Factures -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-receipt text-purple-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Factures</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $factures ? $factures->count() : 0 }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-500">
                        @if($factures && $factures->count() > 0)
                            Total : {{ number_format($factures->sum('montant'), 0, ',', ' ') }} FCFA
                        @else
                            Aucune facture
                        @endif
                    </span>
                </div>
            </div>

            <!-- Abonnements actifs -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-sync-alt text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Abonnements actifs</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $abonnements ? $abonnements->where('statut', 'actif')->count() : 0 }}
                        </p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-500">
                        @if($abonnements && $abonnements->where('statut', 'actif')->count() > 0)
                            {{ $abonnements->where('statut', 'actif')->count() }} service(s) actif(s)
                        @else
                            Aucun abonnement actif
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Graphique des devis par mois -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Évolution des devis</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="devisChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Activités récentes et actions rapides -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Activités récentes -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Activités récentes</h3>
                <div class="space-y-4">
                    @if($devis && $devis->count() > 0)
                        @foreach($devis->take(5) as $devisItem)
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @switch($devisItem->statut)
                                        @case('en_attente')
                                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-clock text-yellow-600 text-sm"></i>
                                            </div>
                                            @break
                                        @case('valide')
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-check text-green-600 text-sm"></i>
                                            </div>
                                            @break
                                        @case('refuse')
                                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-times text-red-600 text-sm"></i>
                                            </div>
                                            @break
                                        @default
                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-file text-gray-600 text-sm"></i>
                                            </div>
                                    @endswitch
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">
                                        Devis {{ $devisItem->reference }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($devisItem->date)->format('d/m/Y') }} - 
                                        {{ number_format($devisItem->total_ttc, 0, ',', ' ') }} FCFA
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('client.advanced-profile.devis.preview', $devisItem) }}" 
                                       class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                        Voir
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-gray-400 text-4xl mb-2"></i>
                            <p class="text-gray-500">Aucune activité récente</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Actions rapides</h3>
                <div class="space-y-3">
                    <a href="{{ route('client.devis') }}" 
                       class="flex items-center justify-between w-full p-3 text-left text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-file-invoice text-blue-600"></i>
                            <span>Consulter mes devis</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                    
                    <a href="{{ route('client.factures') }}" 
                       class="flex items-center justify-between w-full p-3 text-left text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-receipt text-purple-600"></i>
                            <span>Voir mes factures</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                    
                    <a href="{{ route('client.profile') }}" 
                       class="flex items-center justify-between w-full p-3 text-left text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-user text-green-600"></i>
                            <span>Modifier mon profil</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                    
                    <a href="{{ route('contact') }}" 
                       class="flex items-center justify-between w-full p-3 text-left text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-headset text-yellow-600"></i>
                            <span>Contacter le support</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Services actifs -->
        @if($abonnements && $abonnements->where('statut', 'actif')->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Mes services actifs</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($abonnements->where('statut', 'actif') as $abonnement)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-medium text-gray-900">
                                {{ $abonnement->item->service->nom ?? 'Service' }}
                            </h4>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Actif
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mb-2">
                            {{ $abonnement->item->description ?? 'Aucune description' }}
                        </p>
                        <div class="text-sm text-gray-600">
                            <p>Début : {{ \Carbon\Carbon::parse($abonnement->date_debut)->format('d/m/Y') }}</p>
                            <p>Fin : {{ \Carbon\Carbon::parse($abonnement->date_fin)->format('d/m/Y') }}</p>
                            <p class="font-medium text-gray-900">
                                {{ number_format($abonnement->montant_mensuel, 0, ',', ' ') }} FCFA/mois
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Script pour le graphique Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('devisChart').getContext('2d');
    
    // Données des devis par mois (exemple)
    const data = {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
        datasets: [{
            label: 'Devis créés',
            data: [3, 5, 2, 8, 4, 6],
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4
        }]
    };
    
    new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endsection

