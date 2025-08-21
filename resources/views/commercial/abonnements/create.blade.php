@extends('layouts.commercial')
@section('title', 'Nouvel Abonnement - GTS Afrique')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête de la page -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Nouvel Abonnement</h1>
                <p class="text-base lg:text-lg text-gray-600">Créer un nouvel abonnement pour un client</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('abonnements.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>
            </div>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 lg:px-8 py-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">Informations de l'abonnement</h3>
            </div>
            
            <form action="{{ route('abonnements.store') }}" method="POST" class="p-6 lg:p-8">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Client -->
                    <div class="lg:col-span-2">
                        <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Client <span class="text-red-500">*</span>
                        </label>
                        <select name="client_id" id="client_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gts-primary focus:border-transparent">
                            <option value="">Sélectionner un client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->idclient }}" {{ old('client_id') == $client->idclient ? 'selected' : '' }}>
                                    {{ $client->nom }} - {{ $client->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Service -->
                    <div class="lg:col-span-2">
                        <label for="service_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Service <span class="text-red-500">*</span>
                        </label>
                        <select name="service_id" id="service_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gts-primary focus:border-transparent">
                            <option value="">Sélectionner un service</option>
                                                         @foreach($services as $service)
                                 <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                     {{ $service->nom }} - {{ $service->prix }} FCFA/mois
                                 </option>
                             @endforeach
                        </select>
                        @error('service_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date de début -->
                    <div>
                        <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-2">
                            Date de début <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date_debut" id="date_debut" required
                               value="{{ old('date_debut', date('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gts-primary focus:border-transparent">
                        @error('date_debut')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Durée en mois -->
                    <div>
                        <label for="duree_mois" class="block text-sm font-medium text-gray-700 mb-2">
                            Durée (mois) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="duree_mois" id="duree_mois" required min="1" max="120"
                               value="{{ old('duree_mois', 12) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gts-primary focus:border-transparent">
                        @error('duree_mois')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                                         <!-- Prix mensuel -->
                     <div>
                         <label for="prix_mensuel" class="block text-sm font-medium text-gray-700 mb-2">
                             Prix mensuel (FCFA) <span class="text-red-500">*</span>
                         </label>
                        <input type="number" name="prix_mensuel" id="prix_mensuel" required step="1" min="0"
                               value="{{ old('prix_mensuel') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gts-primary focus:border-transparent">
                        @error('prix_mensuel')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                                         <!-- Prix total (calculé automatiquement) -->
                     <div>
                         <label class="block text-sm font-medium text-gray-700 mb-2">
                             Prix total (FCFA)
                         </label>
                         <div class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-600">
                             <span id="prix_total">0</span> FCFA
                         </div>
                     </div>

                    <!-- Renouvellement automatique -->
                    <div class="lg:col-span-2">
                        <div class="flex items-center">
                            <input type="checkbox" name="renouvellement_automatique" id="renouvellement_automatique" 
                                   {{ old('renouvellement_automatique', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-gts-primary focus:ring-gts-primary border-gray-300 rounded">
                            <label for="renouvellement_automatique" class="ml-2 block text-sm text-gray-700">
                                Renouvellement automatique
                            </label>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            L'abonnement sera automatiquement renouvelé à la date d'expiration
                        </p>
                    </div>

                    <!-- Notes -->
                    <div class="lg:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes (optionnel)
                        </label>
                        <textarea name="notes" id="notes" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gts-primary focus:border-transparent"
                                  placeholder="Informations supplémentaires sur cet abonnement...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-8 border-t border-gray-200">
                    <a href="{{ route('abonnements.index') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto btn-gts-primary inline-flex items-center justify-center px-6 py-3 rounded-lg">
                        <i class="fas fa-save mr-2"></i>
                        Créer l'abonnement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const prixMensuel = document.getElementById('prix_mensuel');
    const dureeMois = document.getElementById('duree_mois');
    const prixTotal = document.getElementById('prix_total');

    function calculerPrixTotal() {
        const prix = parseFloat(prixMensuel.value) || 0;
        const duree = parseInt(dureeMois.value) || 0;
        const total = prix * duree;
        prixTotal.textContent = Math.round(total);
    }

    prixMensuel.addEventListener('input', calculerPrixTotal);
    dureeMois.addEventListener('input', calculerPrixTotal);

    // Calcul initial
    calculerPrixTotal();
});
</script>
@endsection
