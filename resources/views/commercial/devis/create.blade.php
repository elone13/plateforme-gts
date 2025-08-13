@extends('layouts.commercial')

@section('page-title', 'Créer un devis')
@section('page-description', 'Générer un nouveau devis pour un client')

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Créer un devis</h1>
                    <p class="mt-1 text-sm text-gray-600">Générer un nouveau devis pour un client</p>
                </div>
                <a href="{{ route('commercial.devis.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour aux devis
                </a>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="bg-white shadow-lg rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Informations du devis</h3>
            </div>
            
            <form action="{{ route('commercial.devis.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                
                <!-- Client -->
                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Client <span class="text-red-500">*</span>
                    </label>
                    <select id="client_id" name="client_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        <option value="">Sélectionner un client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->idclient }}">{{ $client->nom_entreprise }} ({{ $client->email }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Référence -->
                <div>
                    <label for="reference" class="block text-sm font-medium text-gray-700 mb-2">
                        Référence du devis
                    </label>
                    <input type="text" id="reference" name="reference" 
                           value="DEV-{{ date('Ymd') }}-{{ str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                           readonly>
                </div>

                <!-- Date de validité -->
                <div>
                    <label for="date_validite" class="block text-sm font-medium text-gray-700 mb-2">
                        Date de validité <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="date_validite" name="date_validite" required
                           value="{{ date('Y-m-d', strtotime('+30 days')) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description du projet <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                              placeholder="Décrivez le projet ou les services à facturer..."></textarea>
                </div>

                <!-- Sélection de services -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Sélection de services</h4>
                    
                    <!-- Service -->
                    <div class="mb-4">
                        <label for="service_select" class="block text-sm font-medium text-gray-700 mb-2">
                            Service
                        </label>
                        <select id="service_select" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <option value="">Sélectionner un service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" data-items="{{ $service->items->toJson() }}">
                                    {{ $service->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Éléments du service -->
                    <div id="service_items" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Éléments du service
                        </label>
                        <div id="items_list" class="space-y-2">
                            <!-- Les éléments seront ajoutés ici dynamiquement -->
                        </div>
                    </div>
                </div>

                <!-- Lignes de devis -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Lignes de devis
                    </label>
                    <div id="lignes" class="space-y-3">
                        <div class="ligne flex space-x-3 items-center">
                            <select name="lignes[0][service_id]" class="service-select flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                <option value="">Service (optionnel)</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" ${itemData.service_id == {{ $service->id }} ? 'selected' : ''}>{{ $service->nom }}</option>
                                @endforeach
                            </select>
                            <select name="lignes[0][item_id]" class="item-select flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                <option value="">Élément (optionnel)</option>
                            </select>
                            <input type="text" name="lignes[0][description]" placeholder="Description" required
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <input type="number" name="lignes[0][quantite]" placeholder="Qté" value="1" min="1" required
                                   class="w-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <input type="number" name="lignes[0][prix_unitaire]" placeholder="Prix unit." step="0.01" min="0" required
                                   class="w-32 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <span class="ligne-total w-24 px-3 py-2 bg-gray-100 rounded-md text-center font-medium">0.00</span>
                            <button type="button" class="supprimer-ligne text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="button" id="ajouter-ligne" 
                            class="mt-3 inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-plus mr-2"></i>
                        Ajouter une ligne
                    </button>
                </div>

                <!-- Totaux -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Sous-total HT :</span>
                        <span id="sous-total" class="text-lg font-semibold text-gray-900">0.00 €</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">TVA (20%) :</span>
                        <span id="tva" class="text-lg font-semibold text-gray-900">0.00 €</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                        <span class="text-lg font-bold text-gray-900">Total TTC :</span>
                        <span id="total-ttc" class="text-2xl font-bold text-primary">0.00 €</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <button type="button" onclick="window.history.back()" 
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-md shadow-sm">
                        <i class="fas fa-save mr-2"></i>
                        Créer le devis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let ligneIndex = 1;
    const services = @json($services);
    
    // Gestion de la sélection de service
    document.getElementById('service_select').addEventListener('change', function() {
        const serviceId = this.value;
        const itemsContainer = document.getElementById('service_items');
        const itemsList = document.getElementById('items_list');
        
        if (serviceId) {
            const service = services.find(s => s.id == serviceId);
            if (service && service.items.length > 0) {
                itemsList.innerHTML = '';
                service.items.forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'flex items-center space-x-3 p-3 bg-white rounded border';
                    itemDiv.innerHTML = `
                        <div class="flex-1">
                            <div class="font-medium">${item.nom}</div>
                            <div class="text-sm text-gray-600">${item.description || ''}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-medium">${item.prix} €</div>
                            <button type="button" class="ajouter-item text-sm text-primary hover:text-primary-dark" 
                                    data-item='${JSON.stringify(item)}'>
                                Ajouter
                            </button>
                        </div>
                    `;
                    itemsList.appendChild(itemDiv);
                });
                itemsContainer.classList.remove('hidden');
            } else {
                itemsContainer.classList.add('hidden');
            }
        } else {
            itemsContainer.classList.add('hidden');
        }
    });
    
    // Ajouter un élément depuis la sélection de service
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('ajouter-item')) {
            const itemData = JSON.parse(e.target.dataset.item);
            ajouterLigneAvecItem(itemData);
        }
    });
    
    // Fonction pour ajouter une ligne avec un élément
    function ajouterLigneAvecItem(itemData) {
        const lignesContainer = document.getElementById('lignes');
        const nouvelleLigne = document.createElement('div');
        nouvelleLigne.className = 'ligne flex space-x-3 items-center';
        nouvelleLigne.innerHTML = `
            <select name="lignes[${ligneIndex}][service_id]" class="service-select flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                <option value="">Service (optionnel)</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" ${itemData.service_id == {{ $service->id }} ? 'selected' : ''}>{{ $service->nom }}</option>
                @endforeach
            </select>
            <select name="lignes[${ligneIndex}][item_id]" class="item-select flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                <option value="">Élément (optionnel)</option>
                <option value="${itemData.iditem}" selected>${itemData.nom}</option>
            </select>
            <input type="text" name="lignes[${ligneIndex}][description]" value="${itemData.nom}" required
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
            <input type="number" name="lignes[${ligneIndex}][quantite]" value="1" min="1" required
                   class="w-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
            <input type="number" name="lignes[${ligneIndex}][prix_unitaire]" value="${itemData.prix}" step="0.01" min="0" required
                   class="w-32 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
            <span class="ligne-total w-24 px-3 py-2 bg-gray-100 rounded-md text-center font-medium">${itemData.prix}</span>
            <button type="button" class="supprimer-ligne text-red-500 hover:text-red-700">
                <i class="fas fa-trash"></i>
            </button>
        `;
        
        lignesContainer.appendChild(nouvelleLigne);
        ligneIndex++;
        updateTotals();
    }
    
    // Ajouter une ligne manuelle
    document.getElementById('ajouter-ligne').addEventListener('click', function() {
        const lignesContainer = document.getElementById('lignes');
        const nouvelleLigne = document.createElement('div');
        nouvelleLigne.className = 'ligne flex space-x-3 items-center';
        nouvelleLigne.innerHTML = `
            <select name="lignes[${ligneIndex}][service_id]" class="service-select flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                <option value="">Service (optionnel)</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->nom }}</option>
                @endforeach
            </select>
            <select name="lignes[${ligneIndex}][item_id]" class="item-select flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                <option value="">Élément (optionnel)</option>
            </select>
            <input type="text" name="lignes[${ligneIndex}][description]" placeholder="Description" required
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
            <input type="number" name="lignes[${ligneIndex}][quantite]" placeholder="Qté" value="1" min="1" required
                   class="w-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
            <input type="number" name="lignes[${ligneIndex}][prix_unitaire]" placeholder="Prix unit." step="0.01" min="0" required
                   class="w-32 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
            <span class="ligne-total w-24 px-3 py-2 bg-gray-100 rounded-md text-center font-medium">0.00</span>
            <button type="button" class="supprimer-ligne text-red-500 hover:text-red-700">
                <i class="fas fa-trash"></i>
            </button>
        `;
        
        lignesContainer.appendChild(nouvelleLigne);
        ligneIndex++;
        updateTotals();
    });
    
    // Supprimer une ligne
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('supprimer-ligne')) {
            e.target.closest('.ligne').remove();
            updateTotals();
        }
    });
    
    // Gestion de la sélection de service dans les lignes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('service-select')) {
            const ligne = e.target.closest('.ligne');
            const itemSelect = ligne.querySelector('.item-select');
            const serviceId = e.target.value;
            
            // Vider la liste des éléments
            itemSelect.innerHTML = '<option value="">Élément (optionnel)</option>';
            
            if (serviceId) {
                const service = services.find(s => s.id == serviceId);
                if (service && service.items.length > 0) {
                    service.items.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.iditem;
                        option.textContent = item.nom;
                        itemSelect.appendChild(option);
                    });
                }
            }
        }
    });
    
    // Gestion de la sélection d'élément dans les lignes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('item-select')) {
            const ligne = e.target.closest('.ligne');
            const itemId = e.target.value;
            const descriptionInput = ligne.querySelector('input[name*="[description]"]');
            const prixInput = ligne.querySelector('input[name*="[prix_unitaire]"]');
            
            if (itemId) {
                // Trouver l'élément dans tous les services
                let selectedItem = null;
                services.forEach(service => {
                    service.items.forEach(item => {
                        if (item.iditem == itemId) {
                            selectedItem = item;
                        }
                    });
                });
                
                if (selectedItem) {
                    descriptionInput.value = selectedItem.nom;
                    prixInput.value = selectedItem.prix;
                    updateTotals();
                }
            }
        }
    });
    
    // Calculer les totaux
    function updateTotals() {
        let sousTotal = 0;
        
        document.querySelectorAll('.ligne').forEach(function(ligne) {
            const quantite = parseFloat(ligne.querySelector('input[name*="[quantite]"]').value) || 0;
            const prixUnitaire = parseFloat(ligne.querySelector('input[name*="[prix_unitaire]"]').value) || 0;
            const total = quantite * prixUnitaire;
            
            ligne.querySelector('.ligne-total').textContent = total.toFixed(2);
            sousTotal += total;
        });
        
        const tva = sousTotal * 0.20;
        const totalTTC = sousTotal + tva;
        
        document.getElementById('sous-total').textContent = sousTotal.toFixed(2) + ' €';
        document.getElementById('tva').textContent = tva.toFixed(2) + ' €';
        document.getElementById('total-ttc').textContent = totalTTC.toFixed(2) + ' €';
    }
    
    // Écouter les changements
    document.addEventListener('input', function(e) {
        if (e.target.name.includes('[quantite]') || e.target.name.includes('[prix_unitaire]')) {
            updateTotals();
        }
    });
    
    // Initialiser les totaux
    updateTotals();
});
</script>
@endsection
