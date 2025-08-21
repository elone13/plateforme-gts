@extends('layouts.commercial')

@section('page-title', 'Gestion Clients')
@section('page-description', 'Gérer efficacement tous les clients et prospects')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header avec actions -->
        <div class="bg-white shadow-lg rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Gestion Clients</h1>
                        <p class="text-sm text-gray-600">Gérez vos clients et prospects</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="openCreateModal()" class="btn-primary">
                            <i class="fas fa-plus mr-2"></i>Nouveau Client
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="stat-card">
                <div class="stat-icon bg-blue-500">
                    <i class="fas fa-users text-white"></i>
                </div>
                <div class="stat-content">
                    <p class="stat-label">Total Clients</p>
                    <p class="stat-value">{{ \App\Models\Client::count() }}</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon bg-green-500">
                    <i class="fas fa-check-circle text-white"></i>
                </div>
                <div class="stat-content">
                    <p class="stat-label">Clients Actifs</p>
                    <p class="stat-value">{{ \App\Models\Client::where('statut', 'actif')->count() }}</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon bg-yellow-500">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <div class="stat-content">
                    <p class="stat-label">Prospects</p>
                    <p class="stat-value">{{ \App\Models\Client::where('statut', 'prospect')->count() }}</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon bg-red-500">
                    <i class="fas fa-pause-circle text-white"></i>
                </div>
                <div class="stat-content">
                    <p class="stat-label">Clients Inactifs</p>
                    <p class="stat-value">{{ \App\Models\Client::where('statut', 'inactif')->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Composant Livewire pour la liste des clients -->
        @livewire('commercial.client-list')
    </div>
</div>

<!-- Modal de création de client -->
<div id="createClientModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Nouveau Client</h3>
            <form id="createClientForm" class="space-y-4">
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom complet *</label>
                    <input type="text" id="nom" name="nom" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                           placeholder="Nom et prénom du contact">
                </div>
                
                <div>
                    <label for="nom_entreprise" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                    <input type="text" id="nom_entreprise" name="nom_entreprise"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                           placeholder="Nom de l'entreprise (optionnel)">
                </div>
                

                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" id="email" name="email" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                </div>
                
                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input type="tel" id="telephone" name="telephone"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                </div>
                
                <div>
                    <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                    <textarea id="adresse" name="adresse" rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"></textarea>
                </div>
                
                <div>
                    <label for="secteur_activite" class="block text-sm font-medium text-gray-700">Secteur d'activité</label>
                    <input type="text" id="secteur_activite" name="secteur_activite"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                </div>
                
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea id="notes" name="notes" rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeCreateModal()" class="btn-secondary">Annuler</button>
                    <button type="submit" class="btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCreateModal() {
    document.getElementById('createClientModal').classList.remove('hidden');
}

function closeCreateModal() {
    document.getElementById('createClientModal').classList.add('hidden');
}

// Gestion du formulaire de création
document.getElementById('createClientForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/commercial/clients', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeCreateModal();
            // Recharger la liste des clients
            window.location.reload();
        } else {
            // Afficher les erreurs de validation
            if (data.errors) {
                let errorMessage = 'Erreurs de validation:\n';
                Object.keys(data.errors).forEach(field => {
                    errorMessage += `- ${field}: ${data.errors[field].join(', ')}\n`;
                });
                alert(errorMessage);
            } else {
                alert('Erreur lors de la création du client');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erreur lors de la création du client: ' + error.message);
    });
});
</script>
@endsection
