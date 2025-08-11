@extends('layouts.portal')

@section('title', 'Test Services - GTS Afrique')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <h1 class="text-4xl font-bold text-center mb-8">Test de l\'affichage des services</h1>
    
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold mb-4">Services disponibles :</h2>
        
        @if(isset($services) && $services->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                <div class="border rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-primary mb-2">{{ $service->nom }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($service->description, 100) }}</p>
                    
                    @if($service->items->count() > 0)
                        <div class="text-sm">
                            <strong>Composants :</strong>
                            <ul class="list-disc list-inside mt-1">
                                @foreach($service->items->take(3) as $item)
                                    <li>{{ $item->nom }} ({{ $item->statut }})</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Aucun service disponible</p>
        @endif
    </div>
    
    <div class="text-center">
        <a href="{{ route('services') }}" class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
            Voir la page complète des services
        </a>
    </div>
</div>
@endsection
