@extends('layouts.commercial')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Nouvelle Demande de Démo</h1>
        <p class="text-gray-600 mt-2">Créer une nouvelle demande de démonstration</p>
    </div>

    <div class="bg-white shadow-lg rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Informations de la demande</h3>
        </div>
        
        <div class="p-6">
            <form action="{{ route('commercial.demandes-demo.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Client -->
                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700">Client *</label>
                    <select name="client_id" id="client_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                        <option value="">Sélectionner un client</option>
                        @foreach(\App\Models\Client::orderBy('nom_entreprise')->get() as $client)
                            <option value="{{ $client->idclient }}" 
                                    {{ request('client_id') == $client->idclient ? 'selected' : '' }}>
                                {{ $client->nom_entreprise }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Nom du contact -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom du contact *</label>
                    <input type="text" name="nom" id="nom" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                           placeholder="Nom complet du contact">
                    @error('nom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" name="email" id="email" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                           placeholder="email@exemple.com">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Téléphone -->
                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input type="tel" name="telephone" id="telephone"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                           placeholder="+33 1 23 45 67 89">
                    @error('telephone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Message *</label>
                    <textarea name="message" id="message" rows="4" required
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                              placeholder="Décrivez vos besoins et attentes..."></textarea>
                    @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Priorité -->
                <div>
                    <label for="priorite" class="block text-sm font-medium text-gray-700">Priorité</label>
                    <select name="priorite" id="priorite"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                        <option value="basse">Basse</option>
                        <option value="normale" selected>Normale</option>
                        <option value="haute">Haute</option>
                        <option value="urgente">Urgente</option>
                    </select>
                    @error('priorite') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Source -->
                <div>
                    <label for="source" class="block text-sm font-medium text-gray-700">Source</label>
                    <select name="source" id="source"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                        <option value="">Sélectionner une source</option>
                        <option value="site_web">Site web</option>
                        <option value="reseau_social">Réseau social</option>
                        <option value="recommandation">Recommandation</option>
                        <option value="salon">Salon/Événement</option>
                        <option value="prospection">Prospection</option>
                        <option value="autre">Autre</option>
                    </select>
                    @error('source') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-3 pt-6">
                    <a href="{{ route('commercial.demandes-demo.index') }}" 
                       class="btn-secondary">
                        Annuler
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Créer la demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Auto-remplir les informations du client si sélectionné
document.getElementById('client_id').addEventListener('change', function() {
    const clientId = this.value;
    if (clientId) {
        // Ici on pourrait faire un appel AJAX pour récupérer les infos du client
        // et auto-remplir les champs nom, email, téléphone
    }
});
</script>
@endsection
