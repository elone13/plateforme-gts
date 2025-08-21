@extends('layouts.commercial')

@section('title', 'Planning - GTS Afrique')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-semibold text-gray-900">Planning Commercial</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Navigation des mois -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('planning.index', ['date' => $month->copy()->subMonth()->format('Y-m')]) }}" 
                           class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200 rounded-full hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                        
                        <h2 class="text-xl font-bold text-gray-900 px-4 py-2 bg-gray-50 rounded-lg">
                            {{ $month->format('F Y') }}
                        </h2>
                        
                        <a href="{{ route('planning.index', ['date' => $month->copy()->addMonth()->format('Y-m')]) }}" 
                           class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200 rounded-full hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    
                    <!-- Composant Livewire pour la gestion du planning -->
                    @livewire('planning-manager')
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques du mois -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Créneaux</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_creneaux'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-xl">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Disponibles</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['creneaux_disponibles'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-xl">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Réservés</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['creneaux_reserves'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-xl">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Rendez-vous</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_rendez_vous'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="p-3 bg-indigo-100 rounded-xl">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Taux Occupation</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['taux_occupation'] }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendrier du mois - Version Colonnes de Semaines -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- En-tête du calendrier -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800 text-center">Vue par Semaines - {{ $month->format('F Y') }}</h3>
            </div>

            <!-- Grille des semaines en colonnes -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
                    @php
                        $firstDay = $month->copy()->startOfMonth()->startOfWeek(Carbon\Carbon::MONDAY);
                        $lastDay = $month->copy()->endOfMonth()->endOfWeek(Carbon\Carbon::SUNDAY);
                        $currentDate = $firstDay->copy();
                        $weekNumber = 1;
                    @endphp

                    @while($currentDate <= $lastDay)
                        @php
                            $weekStart = $currentDate->copy();
                            $weekEnd = $currentDate->copy()->addDays(6);
                            $isCurrentWeek = $currentDate->isBetween(now()->startOfWeek(), now()->endOfWeek());
                        @endphp

                        <!-- Colonne de semaine -->
                        <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden {{ $isCurrentWeek ? 'ring-2 ring-gts-primary' : '' }}">
                            <!-- En-tête de la semaine -->
                            <div class="bg-white border-b border-gray-200 px-4 py-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Semaine {{ $weekNumber }}</h4>
                                        <p class="text-sm text-gray-600">
                                            {{ $weekStart->format('d/m') }} - {{ $weekEnd->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    @if($isCurrentWeek)
                                        <span class="px-2 py-1 text-xs font-medium bg-gts-primary text-gray-900 rounded-full">Cette semaine</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Jours de la semaine -->
                            <div class="p-3 space-y-2">
                                @for($i = 0; $i < 7; $i++)
                                    @php
                                        $dayDate = $currentDate->copy()->addDays($i);
                                        $dateStr = $dayDate->format('Y-m-d');
                                        $dayData = $calendar[$dateStr] ?? null;
                                        $isCurrentMonth = $dayDate->month === $month->month;
                                        $isToday = $dayDate->isToday();
                                        $isWeekend = $dayDate->isWeekend();
                                        $isPast = $dayDate->isPast();
                                    @endphp

                                    <div class="bg-white rounded-lg border border-gray-200 p-3 hover:shadow-sm transition-shadow duration-150 {{ $isToday ? 'ring-2 ring-gts-primary bg-gts-primary/5' : '' }} {{ $isWeekend ? 'bg-gray-50' : '' }}">
                                        <!-- En-tête du jour -->
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm font-semibold {{ $isCurrentMonth ? 'text-gray-900' : 'text-gray-400' }} {{ $isToday ? 'text-gts-primary' : '' }}">
                                                    {{ $dayDate->format('d') }}
                                                </span>
                                                <span class="text-xs text-gray-500 font-medium">
                                                    {{ $dayDate->format('D') }}
                                                </span>
                                                @if($isToday)
                                                    <span class="px-1.5 py-0.5 text-xs font-medium bg-gts-primary text-gray-900 rounded-full">Aujourd'hui</span>
                                                @endif
                                            </div>
                                            
                                            @if($isWeekend)
                                                <span class="text-xs text-gray-400 font-medium">Weekend</span>
                                            @endif
                                        </div>

                                        <!-- Contenu de la journée -->
                                        <div class="space-y-2">
                                            @if($dayData)
                                                <!-- Créneaux du jour -->
                                                @if($dayData['creneaux']->count() > 0)
                                                    <div class="mb-2">
                                                        <div class="text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Créneaux</div>
                                                        @foreach($dayData['creneaux']->take(2) as $creneau)
                                                            <div class="mb-1">
                                                                <div class="text-xs p-2 rounded {{ $creneau->statut === 'disponible' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                                                    <div class="font-medium">{{ \Carbon\Carbon::parse($creneau->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($creneau->heure_fin)->format('H:i') }}</div>
                                                                    <div class="text-xs opacity-75">{{ $creneau->statut === 'disponible' ? 'Disponible' : 'Indisponible' }}</div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        @if($dayData['creneaux']->count() > 2)
                                                            <div class="text-xs text-gray-500 text-center py-1 bg-gray-100 rounded">
                                                                +{{ $dayData['creneaux']->count() - 2 }} autres
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif

                                                <!-- Rendez-vous du jour -->
                                                @if($dayData['rendez_vous']->count() > 0)
                                                    <div class="mb-2">
                                                        <div class="text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Rendez-vous</div>
                                                        @foreach($dayData['rendez_vous']->take(2) as $rdv)
                                                            <div class="mb-1">
                                                                <div class="text-xs p-2 rounded bg-blue-100 text-blue-800 border border-blue-200">
                                                                    <div class="font-medium">{{ \Carbon\Carbon::parse($rdv->heure_rdv)->format('H:i') }}</div>
                                                                    <div class="text-xs opacity-75">{{ Str::limit($rdv->nom, 15) }}</div>
                                                                    <div class="text-xs opacity-75">{{ $rdv->duree_rdv }}min</div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        @if($dayData['rendez_vous']->count() > 2)
                                                            <div class="text-xs text-gray-500 text-center py-1 bg-gray-100 rounded">
                                                                +{{ $dayData['rendez_vous']->count() - 2 }} autres
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            @else
                                                <!-- Journée vide -->
                                                <div class="text-center py-2">
                                                    <div class="text-gray-300 text-xs">Aucun créneau</div>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Actions -->
                                        @if($isCurrentMonth && !$isPast)
                                            <div class="mt-2 pt-2 border-t border-gray-100">
                                                <a href="{{ route('planning.show-day', $dateStr) }}" 
                                                   class="block w-full text-center text-xs text-gts-primary hover:text-gts-primary-dark font-medium py-1 px-2 rounded hover:bg-gts-primary/10 transition-colors duration-150">
                                                    Voir détails
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </div>

                        @php
                            $currentDate->addDays(7);
                            $weekNumber++;
                        @endphp
                    @endwhile
                </div>
            </div>
        </div>

        <!-- Légende -->
        <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Légende</h3>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-green-100 border border-green-200 rounded"></div>
                    <span class="text-sm text-gray-600">Créneau disponible</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-red-100 border border-red-200 rounded"></div>
                    <span class="text-sm text-gray-600">Créneau indisponible</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-blue-100 border border-blue-200 rounded"></div>
                    <span class="text-sm text-gray-600">Rendez-vous</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-gray-100 border border-gray-200 rounded"></div>
                    <span class="text-sm text-gray-600">Journée passée</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
