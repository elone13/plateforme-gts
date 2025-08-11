@extends('layouts.commercial')

@section('page-title', 'Détail de la demande de démo')
@section('page-description', 'Gérer et traiter cette demande de démonstration')

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header avec actions -->
        <div class="bg-white shadow-lg rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Demande de démo #{{ $demandeDemo->id }}</h1>
                        <p class="text-sm text-gray-600">{{ $demandeDemo->nom }} - {{ $demandeDemo->email }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('commercial.demandes-demo.index') }}" class="btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Colonne principale -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations du client -->
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Informations du client</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $demandeDemo->nom }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $demandeDemo->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $demandeDemo->telephone }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message du client -->
                @if($demandeDemo->message)
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Message du client</h3>
                    </div>
                    <div class="p-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-700">{{ $demandeDemo->message }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Détails de la demande -->
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Détails de la demande</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de création</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $demandeDemo->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Statut actuel</label>
                                <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $demandeDemo->statut_class }}">
                                    {{ $demandeDemo->statut_formatted }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Priorité</label>
                                <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $demandeDemo->priorite_class }}">
                                    {{ $demandeDemo->priorite_formatted }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rendez-vous planifié -->
                @if($demandeDemo->date_rdv && $demandeDemo->statut === 'planifiee')
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Rendez-vous planifié</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date et heure</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($demandeDemo->date_rdv)->format('d/m/Y') }} 
                                    à {{ \Carbon\Carbon::parse($demandeDemo->heure_rdv)->format('H:i') }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Durée</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $demandeDemo->duree_rdv }} minutes</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type</label>
                                <p class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $demandeDemo->type_rdv)) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lien de réunion</label>
                                <a href="{{ $demandeDemo->lien_reunion }}" target="_blank" class="mt-1 text-sm text-blue-600 hover:text-blue-800">
                                    {{ $demandeDemo->lien_reunion }}
                                </a>
                            </div>
                        </div>
                        @if($demandeDemo->instructions_rdv)
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Instructions</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $demandeDemo->instructions_rdv }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Commentaires internes -->
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Commentaires internes</h3>
                    </div>
                    <div class="p-6">
                        @if($demandeDemo->commentaire_admin)
                            <p class="text-sm text-gray-700">{{ $demandeDemo->commentaire_admin }}</p>
                        @else
                            <p class="text-sm text-gray-500 italic">Aucun commentaire interne</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar avec actions rapides -->
            <div class="space-y-6">
                <!-- Actions rapides -->
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Actions rapides</h3>
                    </div>
                    <div class="p-6">
                        <!-- Composant Livewire pour les actions -->
                        @livewire('commercial.demande-demo-manager', ['demandeDemo' => $demandeDemo])
                    </div>
                </div>

                <!-- Historique des actions -->
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Historique</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex items-center text-sm">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                <span class="text-gray-600">Créée le {{ $demandeDemo->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($demandeDemo->updated_at !== $demandeDemo->created_at)
                                <div class="flex items-center text-sm">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-gray-600">Modifiée le {{ $demandeDemo->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

