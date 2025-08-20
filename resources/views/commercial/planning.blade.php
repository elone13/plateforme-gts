@extends('layouts.commercial')

@section('title', 'Planning - GTS Afrique')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Mon Planning</h1>
        <button onclick="document.getElementById('modal-creneau').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i>Ajouter un créneau
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                <input type="date" id="filter-date" class="w-full border border-gray-300 rounded-md px-3 py-2" value="{{ request('date', now()->format('Y-m-d')) }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                <select id="filter-statut" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">Tous</option>
                    <option value="disponible">Disponible</option>
                    <option value="reserve">Réservé</option>
                    <option value="indisponible">Indisponible</option>
                </select>
            </div>
            <div class="flex items-end">
                <button onclick="filtrerCreneaux()" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition-colors duration-200">
                    <i class="fas fa-filter mr-2"></i>Filtrer
                </button>
            </div>
        </div>
    </div>

    <!-- Liste des créneaux -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Créneaux disponibles</h2>
        </div>
        
        @if($creneaux->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Heure</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durée</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($creneaux as $creneau)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $creneau->date->format('d/m/Y') }}
                                        @if($creneau->isAujourdhui())
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Aujourd'hui
                                            </span>
                                        @elseif($creneau->isDemain())
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Demain
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $creneau->heure_debut->format('H:i') }} - {{ $creneau->heure_fin->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $creneau->duree }} min
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $creneau->statut_class }}">
                                        {{ $creneau->statut_formatted }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $creneau->notes ?: 'Aucune note' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($creneau->isDisponible())
                                        <button onclick="modifierCreneau({{ $creneau->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="supprimerCreneau({{ $creneau->id }})" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $creneaux->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <div class="text-gray-500">
                    <i class="fas fa-calendar-times text-4xl mb-4"></i>
                    <p class="text-lg font-medium">Aucun créneau disponible</p>
                    <p class="text-sm">Commencez par ajouter des créneaux dans votre planning.</p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal pour ajouter un créneau -->
<div id="modal-creneau" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Ajouter un créneau disponible</h3>
            
            <form action="{{ route('commercial.planning.creer') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" name="date" required min="{{ now()->addDay()->format('Y-m-d') }}" class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Heure début</label>
                        <input type="time" name="heure_debut" required class="w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Heure fin</label>
                        <input type="time" name="heure_fin" required class="w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes (optionnel)</label>
                    <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Informations supplémentaires..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="document.getElementById('modal-creneau').classList.add('hidden')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md transition-colors duration-200">
                        Annuler
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors duration-200">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function filtrerCreneaux() {
    const date = document.getElementById('filter-date').value;
    const statut = document.getElementById('filter-statut').value;
    
    let url = '{{ route("commercial.planning") }}?';
    if (date) url += 'date=' + date + '&';
    if (statut) url += 'statut=' + statut + '&';
    
    window.location.href = url;
}

function modifierCreneau(id) {
    // TODO: Implémenter la modification
    alert('Fonctionnalité de modification à implémenter');
}

function supprimerCreneau(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce créneau ?')) {
        // TODO: Implémenter la suppression
        alert('Fonctionnalité de suppression à implémenter');
    }
}
</script>
@endsection





