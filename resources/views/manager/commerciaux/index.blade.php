@extends('layouts.manager')

@section('page-title', 'Gestion des commerciaux')
@section('page-description', 'Superviser et gérer l\'équipe commerciale')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900"></h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">
                            {{ \App\Models\Administrateur::where('type', 'commercial')->count() }} commercial(aux) au total
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des commerciaux -->
        <div class="bg-white shadow-lg rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Équipe commerciale</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse(\App\Models\Administrateur::where('type', 'commercial')->with('user')->get() as $commercial)
                <div class="px-6 py-4 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 h-12 w-12">
                                <div class="h-12 w-12 rounded-full bg-primary/20 flex items-center justify-center">
                                    <span class="text-lg font-medium text-primary">
                                        {{ strtoupper(substr($commercial->user->name, 0, 2)) }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-900">{{ $commercial->user->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $commercial->user->email }}</p>
                                <p class="text-xs text-gray-400">Membre depuis {{ $commercial->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                Commercial
                            </span>
                            <a href="{{ route('manager.commerciaux.show', $commercial) }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                <i class="fas fa-eye mr-2"></i>
                                Voir le profil
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                    <p class="text-lg font-medium">Aucun commercial trouvé</p>
                    <p class="text-sm">Commencez par ajouter des membres à votre équipe commerciale.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
