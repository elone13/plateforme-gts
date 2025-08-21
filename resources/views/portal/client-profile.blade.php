@extends('layouts.portal')
@section('title', 'Mon Espace Client - GTS Afrique')
@section('content')

<div class="min-h-screen bg-gray-50">
    <!-- Header de l'espace client -->
    <div class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-semibold text-gray-900">Mon Espace Client</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Navigation principale -->
                    <nav class="hidden md:flex space-x-8">
                        <a href="{{ route('client.profile') }}" class="text-gts-primary border-b-2 border-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Tableau de bord
                        </a>
                        <a href="{{ route('client.demandes') }}" class="text-gray-600 hover:text-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Mes Demandes
                        </a>
                        <a href="{{ route('client.devis') }}" class="text-gray-600 hover:text-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Devis
                        </a>
                        <a href="{{ route('client.factures') }}" class="text-gray-600 hover:text-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Factures
                        </a>
                        <a href="{{ route('client.abonnements') }}" class="text-gray-600 hover:text-gts-primary px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Abonnements
                        </a>
                    </nav>
                    
                    <!-- Bouton retour à l'accueil -->
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gts-primary text-white text-sm font-medium rounded-lg hover:bg-gts-primary/90 transition-colors duration-200">
                        <i class="fas fa-home mr-2"></i>
                        Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" style="padding-top: 8rem; margin-top: 2rem;">
        
        <!-- Messages de succès/erreur -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span class="font-medium">Erreurs de validation :</span>
                </div>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Section Dashboard -->
        <section id="dashboard" class="mb-12">
            <!-- En-tête de bienvenue -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    Bonjour, {{ $client->nom ?? auth()->user()->name }} ! 👋
                </h2>
                <p class="text-lg text-gray-600">
                    Bienvenue dans votre espace client GTS Afrique
                </p>
            </div>
            
            <!-- Layout principal : Profil à gauche, Actions à droite -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Colonne de gauche : Profil -->
                <div class="lg:col-span-2">
                    <!-- Statistiques principales -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Total demandes -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center">
                                <div class="p-3 bg-blue-100 rounded-xl">
                                    <i class="fas fa-desktop text-blue-600 text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Total demandes</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $demandesDemo->count() ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- En attente -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center">
                                <div class="p-3 bg-yellow-100 rounded-xl">
                                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">En attente</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $demandesDemo->where('statut', 'en_attente')->count() ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Programmées -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center">
                                <div class="p-3 bg-purple-100 rounded-xl">
                                    <i class="fas fa-calendar-check text-purple-600 text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Programmées</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $demandesDemo->where('statut', 'planifiee')->count() ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Terminées -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center">
                                <div class="p-3 bg-green-100 rounded-xl">
                                    <i class="fas fa-check text-green-600 text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Terminées</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $demandesDemo->where('statut', 'terminee')->count() ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Aperçu du profil -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-900">Aperçu de mon profil</h3>
                            <button onclick="scrollToSection('profile')" class="text-gts-primary hover:text-gts-primary-dark text-sm font-medium transition-colors duration-200">
                                Voir tout <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="fas fa-user text-gray-400 w-5 mr-3"></i>
                                <span class="text-gray-700">{{ $client->nom ?? 'Non renseigné' }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-gray-400 w-5 mr-3"></i>
                                <span class="text-gray-700">{{ $client->email ?? 'Non renseigné' }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-building text-gray-400 w-5 mr-3"></i>
                                <span class="text-gray-700">{{ $client->nom_entreprise ?? 'Non renseigné' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Colonne de droite : Actions rapides -->
                <div class="lg:col-span-1">
                    <div class="space-y-6">
                        <!-- Actions rapides -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
                            <div class="space-y-4">
                                <!-- Mon Profil -->
                                <div class="bg-gts-primary rounded-xl p-4 text-gray-900 cursor-pointer hover:scale-105 transition-transform duration-300" onclick="scrollToSection('profile')">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold mb-1">Mon Profil</h4>
                                            <p class="text-sm text-gray-800">Gérer mes informations</p>
                                        </div>
                                        <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                            <i class="fas fa-user text-lg"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Mes Devis -->
                                <div class="bg-gray-600 rounded-xl p-4 text-white cursor-pointer hover:scale-105 transition-transform duration-300" onclick="window.location='{{ route('client.devis') }}'">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold mb-1">Mes Devis</h4>
                                            <p class="text-sm text-gray-200">Consulter mes estimations</p>
                                        </div>
                                        <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                            <i class="fas fa-file-invoice text-lg"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Mes Demandes -->
                                <div class="bg-gray-600 rounded-xl p-4 text-white cursor-pointer hover:scale-105 transition-transform duration-300" onclick="window.location='{{ route('client.demandes') }}'">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold mb-1">Mes Demandes</h4>
                                            <p class="text-sm text-gray-200">Suivi de mes demandes</p>
                                        </div>
                                        <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                            <i class="fas fa-desktop text-lg"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Mes Abonnements -->
                                <div class="bg-green-600 rounded-xl p-4 text-white cursor-pointer hover:scale-105 transition-transform duration-300" onclick="window.location='{{ route('client.abonnements') }}'">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold mb-1">Mes Abonnements</h4>
                                            <p class="text-sm text-green-200">Consulter mes services</p>
                                        </div>
                                        <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                            <i class="fas fa-credit-card text-lg"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Nouvelle demande -->
                                <div class="bg-blue-600 rounded-xl p-4 text-white cursor-pointer hover:scale-105 transition-transform duration-300" onclick="window.location='{{ route('contact') }}'">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold mb-1">Nouvelle demande</h4>
                                            <p class="text-sm text-blue-200">Demander une démo</p>
                                        </div>
                                        <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                            <i class="fas fa-plus text-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Statistiques rapides -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Résumé</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Demandes actives</span>
                                    <span class="font-semibold text-gray-900">{{ $demandesDemo->whereIn('statut', ['en_attente', 'en_cours', 'planifiee'])->count() ?? 0 }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Dernière activité</span>
                                    <span class="font-semibold text-gray-900">{{ $client->derniere_interaction ? $client->derniere_interaction->diffForHumans() : 'Jamais' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Mon Profil -->
        <section id="profile" class="mb-12">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- En-tête -->
                <div class="bg-gts-primary px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-1">Mon Profil</h2>
                            <p class="text-gray-800">Informations personnelles et entreprise</p>
                        </div>
                        <button onclick="openEditModal()" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-gray-900 px-6 py-3 rounded-xl font-medium transition-all duration-200">
                            <i class="fas fa-edit mr-2"></i>
                            Modifier
                        </button>
                    </div>
                </div>
                
                <!-- Contenu -->
                <div class="p-8">
                    @if($client)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Informations personnelles -->
                        <div class="space-y-6">
                            <div class="flex items-center mb-6">
                                <div class="p-2 rounded-lg mr-3" style="background-color: rgba(252, 214, 27, 0.2);">
                                    <i class="fas fa-user text-gts-primary"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Informations personnelles</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center py-3 border-b border-gray-100">
                                    <span class="w-28 text-sm font-medium text-gray-500">Nom complet</span>
                                    <span class="flex-1 text-gray-900 font-medium">{{ $client->nom ?? 'Non renseigné' }}</span>
                                </div>
                                <div class="flex items-center py-3 border-b border-gray-100">
                                    <span class="w-28 text-sm font-medium text-gray-500">Email</span>
                                    <span class="flex-1 text-gray-900">{{ $client->email }}</span>
                                </div>
                                @if($client->telephone)
                                <div class="flex items-center py-3 border-b border-gray-100">
                                    <span class="w-28 text-sm font-medium text-gray-500">Téléphone</span>
                                    <span class="flex-1 text-gray-900">{{ $client->telephone }}</span>
                                </div>
                                @endif
                                @if($client->adresse)
                                <div class="flex items-center py-3 border-b border-gray-100">
                                    <span class="w-28 text-sm font-medium text-gray-500">Adresse</span>
                                    <span class="flex-1 text-gray-900">{{ $client->adresse }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Informations entreprise -->
                        <div class="space-y-6">
                            <div class="flex items-center mb-6">
                                <div class="p-2 bg-gray-100 rounded-lg mr-3">
                                    <i class="fas fa-building text-gray-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Informations entreprise</h3>
                            </div>
                            
                            <div class="space-y-4">
                                @if($client->nom_entreprise)
                                <div class="flex items-center py-3 border-b border-gray-100">
                                    <span class="w-28 text-sm font-medium text-gray-500">Entreprise</span>
                                    <span class="flex-1 text-gray-900 font-medium">{{ $client->nom_entreprise }}</span>
                                </div>
                                @endif

                                @if($client->secteur_activite)
                                <div class="flex items-center py-3 border-b border-gray-100">
                                    <span class="w-28 text-sm font-medium text-gray-500">Secteur</span>
                                    <span class="flex-1 text-gray-900">{{ $client->secteur_activite }}</span>
                                </div>
                                @endif
                                <div class="flex items-center py-3 border-b border-gray-100">
                                    <span class="w-28 text-sm font-medium text-gray-500">Statut</span>
                                    <span class="flex-1">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ ucfirst($client->statut) }}
                                        </span>
                                    </span>
                                </div>
                                <div class="flex items-center py-3">
                                    <span class="w-28 text-sm font-medium text-gray-500">Membre depuis</span>
                                    <span class="flex-1 text-gray-900">{{ auth()->user()->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- Message si aucun profil -->
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Profil client non trouvé</h3>
                        <p class="text-gray-600 mb-6">Il semble qu'il y ait un problème avec votre profil client.</p>
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-yellow-600 text-white rounded-xl hover:bg-yellow-700 transition-colors duration-200">
                            <i class="fas fa-envelope mr-2"></i>
                            Contacter l'administrateur
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Modal d'édition du profil -->
<div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-screen overflow-y-auto">
            <!-- En-tête du modal -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-white">Modifier mon profil</h3>
                    <button onclick="closeEditModal()" class="text-white hover:text-gray-200 transition-colors duration-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Formulaire -->
            <form action="{{ route('client.profile.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nom complet -->
                    <div>
                        <label for="edit_nom" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom complet <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="edit_nom" 
                               name="nom" 
                               value="{{ $client->nom ?? '' }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Nom de l'entreprise -->
                    <div>
                        <label for="edit_nom_entreprise" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom de l'entreprise
                        </label>
                        <input type="text" 
                               id="edit_nom_entreprise" 
                               name="nom_entreprise" 
                               value="{{ $client->nom_entreprise ?? '' }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>



                    <!-- Téléphone -->
                    <div>
                        <label for="edit_telephone" class="block text-sm font-medium text-gray-700 mb-2">
                            Téléphone
                        </label>
                        <input type="tel" 
                               id="edit_telephone" 
                               name="telephone" 
                               value="{{ $client->telephone ?? '' }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Adresse -->
                    <div class="md:col-span-2">
                        <label for="edit_adresse" class="block text-sm font-medium text-gray-700 mb-2">
                            Adresse
                        </label>
                        <textarea id="edit_adresse" 
                                  name="adresse" 
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ $client->adresse ?? '' }}</textarea>
                    </div>

                    <!-- Secteur d'activité -->
                    <div>
                        <label for="edit_secteur_activite" class="block text-sm font-medium text-gray-700 mb-2">
                            Secteur d'activité
                        </label>
                        <input type="text" 
                               id="edit_secteur_activite" 
                               name="secteur_activite" 
                               value="{{ $client->secteur_activite ?? '' }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="edit_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes et commentaires
                        </label>
                        <textarea id="edit_notes" 
                                  name="notes" 
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ $client->notes ?? '' }}</textarea>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <button type="button" 
                            onclick="closeEditModal()"
                            class="px-6 py-3 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-medium transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Sauvegarder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts JavaScript -->
<script>
// Fonction de défilement vers une section
function scrollToSection(sectionName) {
    const element = document.getElementById(sectionName);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
        
        // Mettre à jour la navigation active
        document.querySelectorAll('nav a').forEach(link => {
            link.classList.remove('text-indigo-600', 'border-b-2', 'border-indigo-600');
            link.classList.add('text-gray-600');
        });
        
        const activeLink = document.querySelector(`nav a[href="#${sectionName}"]`);
        if (activeLink) {
            activeLink.classList.remove('text-gray-600');
            activeLink.classList.add('text-indigo-600', 'border-b-2', 'border-indigo-600');
        }
    }
}

// Modal d'édition
function openEditModal() {
    document.getElementById('editProfileModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('editProfileModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('editProfileModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

// Fermer le modal avec la touche Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
    }
});

// Scroll spy pour mettre à jour la navigation
window.addEventListener('scroll', function() {
    const sections = ['dashboard', 'profile', 'demandes'];
    const scrollPosition = window.scrollY + 100;
    
    sections.forEach(section => {
        const element = document.getElementById(section);
        if (element) {
            const top = element.offsetTop;
            const bottom = top + element.offsetHeight;
            
            if (scrollPosition >= top && scrollPosition <= bottom) {
                document.querySelectorAll('nav a').forEach(link => {
                    link.classList.remove('text-indigo-600', 'border-b-2', 'border-indigo-600');
                    link.classList.add('text-gray-600');
                });
                
                const activeLink = document.querySelector(`nav a[href="#${section}"]`);
                if (activeLink) {
                    activeLink.classList.remove('text-gray-600');
                    activeLink.classList.add('text-indigo-600', 'border-b-2', 'text-indigo-600');
                }
            }
        }
    });
});
</script>

@endsection