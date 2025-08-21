@extends('layouts.commercial')

@section('title', 'Planning du ' . $dateObj->format('d/m/Y') . ' - GTS Afrique')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('planning.index') }}" class="text-gray-400 hover:text-gray-600 mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                        <h1 class="text-xl font-semibold text-gray-900">
                            Planning du {{ $dateObj->format('d/m/Y') }}
                        </h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Bouton créer créneau -->
                    <button onclick="openCreateModal()" 
                            class="bg-gts-primary hover:bg-gts-primary-dark text-gray-900 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Nouveau créneau
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Informations de la journée -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $dateObj->format('l d F Y') }}</h2>
                    <p class="text-gray-600">
                        @if($dateObj->isToday())
                            <span class="text-gts-primary font-medium">Aujourd'hui</span>
                        @elseif($dateObj->isTomorrow())
                            <span class="text-blue-600 font-medium">Demain</span>
                        @elseif($dateObj->isPast())
                            <span class="text-gray-500">Journée passée</span>
                        @else
                            <span class="text-green-600 font-medium">Journée à venir</span>
                        @endif
                    </p>
                </div>
                
                <div class="text-right">
                    <p class="text-sm text-gray-500">Jour de la semaine</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $dateObj->format('l') }}</p>
                </div>
            </div>
        </div>

        <!-- Grille horaire -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Créneaux de la journée -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">Créneaux</h3>
                </div>
                
                @livewire('App\Http\Livewire\Commercial\CreneauList', ['date' => $dateObj->format('Y-m-d')])
            </div>

            <!-- Rendez-vous de la journée -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">Rendez-vous</h3>
                </div>
                
                @if($rendezVous->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($rendezVous as $rdv)
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-3 h-3 rounded-full bg-blue-400"></div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $rdv->nom }}</p>
                                                <p class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($rdv->heure_rdv)->format('H:i') }} ({{ $rdv->duree_rdv }} min)
                                                </p>
                                                <p class="text-xs text-gray-400">{{ $rdv->email }}</p>
                                            </div>
                                        </div>
                                        
                                        @if($rdv->message)
                                            <p class="text-sm text-gray-600 mt-2">{{ Str::limit($rdv->message, 100) }}</p>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Rendez-vous
                                        </span>
                                        
                                        <a href="{{ route('commercial.demandes-demo.show', $rdv) }}" 
                                           class="text-blue-400 hover:text-blue-600 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p>Aucun rendez-vous programmé pour cette journée</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
