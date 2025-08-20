@extends('layouts.portal')

@section('title', 'Mes Devis - GTS Afrique')

@section('content')
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Mes Devis</h1>
                <p class="text-lg text-gray-600">Consultez l'historique de vos devis et téléchargez-les</p>
            </div>

            <!-- Devis List -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                @php
                    // Récupérer les devis du client connecté
                    $user = auth()->user();
                    $client = \App\Models\Client::where('user_id', $user->id)->first();
                    $devis = null;
                    
                    if ($client) {
                        $devis = \App\Models\Devis::where('client_idclient', $client->idclient)
                            ->with(['items.service'])
                            ->orderBy('date', 'desc')
                            ->get();
                    }
                @endphp
                
                @if($devis && $devis->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total TTC</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prestations</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($devis as $devisItem)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $devisItem->reference }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($devisItem->date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            {{ number_format($devisItem->total_ttc, 0, ',', ' ') }} FCFA
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $devisItem->items->count() }} service(s)
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @switch($devisItem->statut)
                                                @case('en_attente')
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        En attente
                                                    </span>
                                                    @break
                                                @case('valide')
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Validé
                                                    </span>
                                                    @break
                                                @case('refuse')
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Refusé
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        {{ ucfirst($devisItem->statut) }}
                                                    </span>
                                            @endswitch
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('client.advanced-profile.devis.preview', $devisItem) }}" 
                                                   target="_blank"
                                                   class="inline-flex items-center px-3 py-1 border border-blue-300 shadow-sm text-xs font-medium rounded text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Aperçu
                                                </a>
                                                <a href="{{ route('client.advanced-profile.devis.download', $devisItem) }}" 
                                                   class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                    </svg>
                                                    PDF
                                                </a>
                                                @if($devisItem->statut === 'en_attente')
                                                    <button onclick="openValidationModal('{{ $devisItem->reference }}', '{{ number_format($devisItem->total_ttc, 0, ',', ' ') }}', '{{ $devisItem->id }}')" 
                                                            class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-orange-600 hover:bg-orange-700 transition-colors duration-200">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                        Valider
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Statistiques -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <div class="flex justify-between items-center text-sm text-gray-600">
                            <span>Total: <strong>{{ $devis->count() }}</strong> devis</span>
                            <span>Validés: <strong class="text-green-600">{{ $devis->where('statut', 'valide')->count() }}</strong></span>
                            <span>En attente: <strong class="text-yellow-600">{{ $devis->where('statut', 'en_attente')->count() }}</strong></span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun devis trouvé</h3>
                        <p class="text-gray-500 mb-6">Vous n'avez pas encore de devis. Contactez-nous pour en demander un.</p>
                        <a href="{{ route('contact') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-md text-sm font-medium">
                            <i class="fas fa-plus mr-2"></i>Demander un devis
                        </a>
                    </div>
                @endif
            </div>
            
            <!-- Informations supplémentaires -->
            @if($devis && $devis->count() > 0)
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">💡 Informations utiles</h3>
                <div class="text-sm text-blue-800 space-y-2">
                    <p>• <strong>Aperçu :</strong> Visualisez votre devis dans un format optimisé pour l'écran</p>
                    <p>• <strong>PDF :</strong> Téléchargez votre devis au format PDF pour impression ou archivage</p>
                    <p>• Les devis sont valables selon les conditions indiquées dans chaque document</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal de validation des devis -->
    <div id="validationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <!-- Header du modal -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Validation de Devis</h3>
                        <p class="mt-2 text-gray-600">Confirmez la validation de ce devis</p>
                    </div>
                    <button onclick="closeValidationModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Informations du devis -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                    <h4 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Détails du Devis
                </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-blue-800">Référence</p>
                            <p class="text-lg font-bold text-blue-900" id="modalDevisReference">-</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-800">Montant Total</p>
                            <p class="text-lg font-bold text-blue-900" id="modalDevisMontant">-</p>
                        </div>
                    </div>
                </div>

                            <!-- Avertissements et informations -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                <h4 class="text-lg font-semibold text-yellow-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Informations Importantes
                </h4>
                <div class="text-sm text-yellow-800 space-y-3">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-yellow-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                        </svg>
                        <p>La validation d'un devis engage votre entreprise à respecter les conditions et tarifs indiqués.</p>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-yellow-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p>Cette action ne peut pas être annulée une fois confirmée.</p>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-yellow-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p>Le statut du devis passera de "En attente" à "Validé" dans notre système.</p>
                    </div>
                </div>
            </div>

                <!-- Formulaire de validation -->
                <form id="validationForm" method="POST" class="mb-6">
                    @csrf
                    <input type="hidden" id="modalDevisId" name="devis_id" value="">
                    
                    <!-- Checkbox de confirmation -->
                    <div class="mb-6">
                        <label class="flex items-start">
                            <input type="checkbox" id="confirmationCheckbox" class="mt-1 mr-3 w-4 h-4 text-yellow-600 bg-yellow-100 border-yellow-300 rounded focus:ring-yellow-500 focus:ring-2" style="accent-color: #eab308;" required>
                            <span class="text-sm text-gray-700">
                                Je confirme avoir lu et compris les informations ci-dessus et j'accepte de valider ce devis.
                            </span>
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" 
                                onclick="closeValidationModal()"
                                class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            Annuler
                        </button>
                        <button type="submit" 
                                id="submitValidationBtn"
                                disabled
                                class="px-6 py-2 bg-orange-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200">
                            Confirmer la Validation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts JavaScript pour le modal de validation -->
    <script>
    function openValidationModal(reference, montant, devisId) {
        document.getElementById('modalDevisReference').textContent = reference;
        document.getElementById('modalDevisMontant').textContent = montant + ' FCFA';
        document.getElementById('modalDevisId').value = devisId;
        
        // Mettre à jour l'action du formulaire
        document.getElementById('validationForm').action = `/client/advanced-profile/devis/${devisId}/validate`;
        
        document.getElementById('validationModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Réinitialiser le formulaire
        document.getElementById('confirmationCheckbox').checked = false;
        document.getElementById('submitValidationBtn').disabled = true;
    }

    function closeValidationModal() {
        document.getElementById('validationModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Gestion de la checkbox de confirmation
    document.getElementById('confirmationCheckbox').addEventListener('change', function() {
        document.getElementById('submitValidationBtn').disabled = !this.checked;
    });

    // Fermer le modal en cliquant à l'extérieur
    document.getElementById('validationModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeValidationModal();
        }
    });

    // Fermer le modal avec la touche Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeValidationModal();
        }
    });
    </script>
@endsection