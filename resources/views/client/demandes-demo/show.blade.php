@extends('layouts.portal')

@section('title', 'Détails de la demande de démo')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Demande de démo #{{ $demandeDemo->id }}</h1>
                    <p class="mt-1 text-sm text-gray-600">Détails complets de votre demande</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('client.demandes-demo.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour à la liste
                    </a>
                    <a href="{{ route('client.profile') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="fas fa-user mr-2"></i>
                        Mon profil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statut et informations principales -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Informations générales</h3>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                        {{ $demandeDemo->statut === 'acceptee' ? 'bg-green-100 text-green-800' : 
                           ($demandeDemo->statut === 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 
                           ($demandeDemo->statut === 'en_cours' ? 'bg-blue-100 text-blue-800' :
                           ($demandeDemo->statut === 'terminee' ? 'bg-gray-100 text-gray-800' :
                           ($demandeDemo->statut === 'planifiee' ? 'bg-purple-100 text-purple-800' :
                           'bg-red-100 text-red-800')))) }}">
                        @switch($demandeDemo->statut)
                            @case('en_attente')
                                En attente
                                @break
                            @case('acceptee')
                                Acceptée
                                @break
                            @case('en_cours')
                                En cours
                                @break
                            @case('terminee')
                                Terminée
                                @break
                            @case('planifiee')
                                Rendez-vous programmé
                                @break
                            @case('refusee')
                                Refusée
                                @break
                            @default
                                {{ ucfirst($demandeDemo->statut) }}
                        @endswitch
                    </span>
                </div>
            </div>
            
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date de création</label>
                        <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($demandeDemo->created_at)->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Source</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $demandeDemo->source)) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Priorité</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($demandeDemo->priorite) }}</p>
                    </div>
                    @if($demandeDemo->societe)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Société</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $demandeDemo->societe }}</p>
                    </div>
                    @endif
                    @if($demandeDemo->nombre_vehicules)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre de véhicules</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $demandeDemo->nombre_vehicules }}</p>
                    </div>
                    @endif
                    @if($demandeDemo->jour_prefere)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jour préféré</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($demandeDemo->jour_prefere) }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Détails du rendez-vous si programmé -->
        @if($demandeDemo->statut === 'planifiee' && $demandeDemo->date_rdv)
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-calendar-check text-purple-600 mr-2"></i>
                    Rendez-vous programmé
                </h3>
            </div>
            
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($demandeDemo->date_rdv)->format('d/m/Y') }}
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Heure</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($demandeDemo->heure_rdv)->format('H:i') }}
                        </p>
                    </div>
                    @if($demandeDemo->duree_rdv)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Durée</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $demandeDemo->duree_rdv }} minutes</p>
                    </div>
                    @endif
                    @if($demandeDemo->type_rdv)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Type de rendez-vous</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $demandeDemo->type_rdv)) }}</p>
                    </div>
                    @endif
                </div>
                
                @if($demandeDemo->lien_reunion)
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700">Lien de réunion</label>
                    <div class="mt-2">
                        <a href="{{ $demandeDemo->lien_reunion }}" target="_blank" 
                           class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                            <i class="fas fa-video mr-2"></i>
                            Rejoindre la réunion
                        </a>
                    </div>
                </div>
                @endif
                
                @if($demandeDemo->instructions_rdv)
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700">Instructions pour le rendez-vous</label>
                    <div class="mt-2 bg-purple-50 border border-purple-200 rounded-md p-4">
                        <p class="text-sm text-purple-800">{{ $demandeDemo->instructions_rdv }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Message de la demande -->
        @if($demandeDemo->message)
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-comment text-blue-600 mr-2"></i>
                    Votre message
                </h3>
            </div>
            
            <div class="px-6 py-4">
                <div class="bg-gray-50 rounded-md p-4">
                    <p class="text-sm text-gray-700">{{ $demandeDemo->message }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Commentaires de l'équipe -->
        @if($demandeDemo->commentaire_admin)
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-comments text-green-600 mr-2"></i>
                    Commentaires de l'équipe
                </h3>
            </div>
            
            <div class="px-6 py-4">
                <div class="bg-green-50 border border-green-200 rounded-md p-4">
                    <p class="text-sm text-green-800">{{ $demandeDemo->commentaire_admin }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Raison du refus si applicable -->
        @if($demandeDemo->statut === 'refusee' && $demandeDemo->raison_refus)
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-info-circle text-red-600 mr-2"></i>
                    Raison du refus
                </h3>
            </div>
            
            <div class="px-6 py-4">
                <div class="bg-red-50 border border-red-200 rounded-md p-4">
                    <p class="text-sm text-red-800">{{ $demandeDemo->raison_refus }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Actions</h3>
            </div>
            
            <div class="px-6 py-4">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('client.demandes-demo.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="fas fa-list mr-2"></i>
                        Voir toutes mes demandes
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Nouvelle demande de démo
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


