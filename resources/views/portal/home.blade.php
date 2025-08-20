@extends('layouts.portal')

@section('title', 'Accueil - GTS Afrique')

@section('content')
        <!-- Banner full-width -->
        <section class="relative overflow-hidden" aria-label="Bannière GTS">
            <div class="absolute inset-0">
                <div class="w-full h-full bg-cover bg-center" style="background-image: url('{{ asset('images/banner.jpg') }}');"></div>
                <div class="absolute inset-0 bg-black/55"></div>
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div class="text-white">
                    <span class="inline-flex items-center bg-white/10 rounded-full px-3 py-1 text-xs uppercase tracking-wide">
                        Géo-services • Sénégal & Ouest Afrique
                    </span>
                    <h1 class="mt-4 text-3xl md:text-5xl font-extrabold leading-tight">
                        Localisez, gérez et optimisez votre flotte en toute simplicité
                    </h1>
                    <p class="mt-4 text-indigo-100 text-lg">
                        GTS Afrique accompagne la digitalisation des entreprises avec des solutions de géolocalisation puissantes et adaptées à votre métier.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('contact') }}" class="inline-flex items-center bg-white text-primary hover:bg-primary/10 px-6 py-3 rounded-md text-sm font-medium">
                            <i class="fas fa-paper-plane mr-2"></i> Demander une démo
                        </a>
                        <a href="{{ route('services') }}" class="inline-flex items-center bg-primary/90 hover:bg-primary text-white px-6 py-3 rounded-md text-sm font-medium border border-white/0">
                            <i class="fas fa-list mr-2"></i> Nos solutions
                        </a>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-4 text-sm text-indigo-100">
                        <div class="inline-flex items-center gap-2"><i class="fas fa-shield-alt"></i> Sécurisation</div>
                        <div class="inline-flex items-center gap-2"><i class="fas fa-leaf"></i> Éco-conduite</div>
                        <div class="inline-flex items-center gap-2"><i class="fas fa-gas-pump"></i> Gestion du carburant</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/95 rounded-xl p-5 shadow-lg border border-white/40">
                        <div class="text-primary text-2xl mb-1"><i class="fas fa-route"></i></div>
                        <p class="text-sm text-gray-600">Trajets optimisés</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">-15% à -20%</p>
                    </div>
                    <div class="bg-white/95 rounded-xl p-5 shadow-lg border border-white/40">
                        <div class="text-primary text-2xl mb-1"><i class="fas fa-tachometer-alt"></i></div>
                        <p class="text-sm text-gray-600">Suivi en temps réel</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">24/7</p>
                    </div>
                    <div class="bg-white/95 rounded-xl p-5 shadow-lg border border-white/40">
                        <div class="text-primary text-2xl mb-1"><i class="fas fa-wallet"></i></div>
                        <p class="text-sm text-gray-600">Réduction des coûts</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">jusqu’à 20%</p>
                    </div>
                    <div class="bg-white/95 rounded-xl p-5 shadow-lg border border-white/40">
                        <div class="text-primary text-2xl mb-1"><i class="fas fa-user-shield"></i></div>
                        <p class="text-sm text-gray-600">Sécurité renforcée</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">Antidémarrage</p>
                    </div>
                </div>
            </div>
        </section>


        <!-- Section 2 colonnes : Jaune + 3 cartes -->
        <section class="bg-white pt-0 pb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-0">
                    <!-- Colonne gauche jaune -->
                    <div class="bg-primary p-12 text-white">
                        <h2 class="text-3xl md:text-4xl font-bold mb-6 leading-tight">
                            Des solutions performantes<br>et un service de proximité
                        </h2>
                        <p class="text-lg leading-relaxed">
                            Global Tracking System Afrique est une entreprise de technologies qui vise à améliorer l'expérience de ses clients dans la digitalisation de leur entreprise. Actuellement, GTS Afrique est un partenaire de référence en Géo-services au Sénégal mais aussi dans la sous-région ouest Africaine.
                        </p>
                    </div>

                    <!-- Colonne droite avec 3 cartes -->
                    <div class="lg:col-span-2 bg-gray-50 p-12 relative">
                        <!-- Fond carte en arrière-plan -->
                        <div class="absolute inset-0 bg-cover bg-center opacity-10" style="background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><rect width=\"100\" height=\"100\" fill=\"%23cccccc\"/><circle cx=\"20\" cy=\"20\" r=\"2\" fill=\"%23999999\"/><circle cx=\"80\" cy=\"40\" r=\"2\" fill=\"%23999999\"/><circle cx=\"40\" cy=\"80\" r=\"2\" fill=\"%23999999\"/><line x1=\"10\" y1=\"50\" x2=\"90\" y2=\"50\" stroke=\"%23999999\" stroke-width=\"1\"/><line x1=\"50\" y1=\"10\" x2=\"50\" y2=\"90\" stroke=\"%23999999\" stroke-width=\"1\"/></svg>');"></div>
                        
                        <div class="relative z-10 space-y-6">
                            <!-- Carte 1 -->
                            <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-100 transform transition-all duration-700 hover:scale-105 hover:shadow-2xl hover:border-primary cursor-pointer group animate-fade-in-up" style="animation-delay: 0ms; animation-fill-mode: both;">
                                <div class="flex items-start space-x-4">
                                    <div class="text-primary text-3xl transform transition-all duration-300 group-hover:scale-110 group-hover:rotate-12">
                                        <i class="fas fa-crosshairs"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 transition-colors duration-300 group-hover:text-primary">
                                            Localiser, gérer et piloter votre flotte automobile
                                        </h3>
                                        <p class="text-gray-600 leading-relaxed transition-colors duration-300 group-hover:text-gray-800">
                                            Vos équipes sur le terrain et votre parc de véhicules débordent d'informations stratégiques
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Carte 2 -->
                            <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-100 transform transition-all duration-700 hover:scale-105 hover:shadow-2xl hover:border-primary cursor-pointer group animate-fade-in-up" style="animation-delay: 200ms; animation-fill-mode: both;">
                                <div class="flex items-start space-x-4">
                                    <div class="text-primary text-3xl transform transition-all duration-300 group-hover:scale-110 group-hover:-rotate-12">
                                        <i class="fas fa-sync-alt"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 transition-colors duration-300 group-hover:text-primary">
                                            Analysez et Perfectionnez la flotte de votre entreprise
                                        </h3>
                                        <p class="text-gray-600 leading-relaxed transition-colors duration-300 group-hover:text-gray-800">
                                            Une solution « prête à l'emploi » pour analyser et reprendre le contrôle de votre flotte sur le terrain
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Carte 3 -->
                            <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-100 transform transition-all duration-700 hover:scale-105 hover:shadow-2xl hover:border-primary cursor-pointer group animate-fade-in-up" style="animation-delay: 400ms; animation-fill-mode: both;">
                                <div class="flex items-start space-x-4">
                                    <div class="text-primary text-3xl transform transition-all duration-300 group-hover:scale-110 group-hover:rotate-6">
                                        <i class="fas fa-server"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 transition-colors duration-300 group-hover:text-primary">
                                            Profitez des fonctionnalités utiles & adaptées
                                        </h3>
                                        <p class="text-gray-600 leading-relaxed transition-colors duration-300 group-hover:text-gray-800">
                                            Des fonctionnalités spécialement conçues pour aider au quotidien les chefs d'entreprises et les gestionnaires de flottes
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Notre objectif -->
        <section id="objectif" class="bg-white">
            <di v class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
                <!-- Titre principal de la section -->
                <div class="text-center mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Notre objectif
                    </h2>
                    <div class="w-32 h-1 bg-primary rounded-full mx-auto mb-6"></div>
                    <p class="text-lg max-w-4xl mx-auto">
                    Accompagner toutes les entreprises qui le souhaitent dans la digitalisation de leurs activités grâce aux technologies de géolocalisation innovantes. Nos solutions contribuent grandement à la réduction des coûts et à la productivité des entreprises.

GTS Afrique offre aux entreprises un accompagnement sur mesure afin d'optimiser la gestion de leurs véhicules, équipes et équipements.
                    </p>
                </div>
                <div class="w-full">

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 lg:gap-8 w-full">
                        <div class="bg-white rounded-2xl shadow-xl p-10 border border-gray-100 transform transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:border-primary cursor-pointer group animate-fade-in-up" style="animation-delay: 500ms; animation-fill-mode: both;">
                            <div class="flex flex-col items-center text-center space-y-4">
                                <div class="text-primary text-5xl transform transition-all duration-300 group-hover:scale-110 group-hover:rotate-12">
                                    <i class="fas fa-fingerprint"></i>
                                </div>
                                <div class="w-full">
                                    <h3 class="text-xl font-bold text-gray-900 mb-4 transition-colors duration-300 group-hover:text-primary">
                                        Analyse Métier
                                    </h3>
                                    <p class="text-gray-600 leading-relaxed transition-colors duration-300 group-hover:text-gray-800">
                                        Votre secteur d'activité a des besoins spécifiques, notre solution de gestion de flotte vous accompagne chaque jour pour faciliter votre métier.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-xl p-10 border border-gray-100 transform transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:border-primary cursor-pointer group animate-fade-in-up" style="animation-delay: 700ms; animation-fill-mode: both;">
                            <div class="flex flex-col items-center text-center space-y-4">
                                <div class="text-primary text-5xl transform transition-all duration-300 group-hover:scale-110 group-hover:-rotate-12">
                                    <i class="fas fa-gift"></i>
                                </div>
                                <div class="w-full">
                                    <h3 class="text-xl font-bold text-gray-900 mb-4 transition-colors duration-300 group-hover:text-primary">
                                        Préconisation & Optimisation
                                    </h3>
                                    <p class="text-gray-600 leading-relaxed transition-colors duration-300 group-hover:text-gray-800">
                                        Vous conseiller et vous apporter les outils nécessaires pour répondre à vos besoins est notre priorité numéro 1.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-xl p-10 border border-gray-100 transform transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:border-primary cursor-pointer group animate-fade-in-up" style="animation-delay: 900ms; animation-fill-mode: both;">
                            <div class="flex flex-col items-center text-center space-y-4">
                                <div class="text-primary text-5xl transform transition-all duration-300 group-hover:scale-110 group-hover:rotate-6">
                                    <i class="fas fa-network-wired"></i>
                                </div>
                                <div class="w-full">
                                    <h3 class="text-xl font-bold text-gray-900 mb-4 transition-colors duration-300 group-hover:text-primary">
                                        Exploitation Des Données
                                    </h3>
                                    <p class="text-gray-600 leading-relaxed transition-colors duration-300 group-hover:text-gray-800">
                                        Transformez vos données en insights actionnables pour des décisions éclairées et stratégiques.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Inscription Client -->
        <section class="bg-gray-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Accédez à votre espace client
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Créez votre compte pour consulter vos devis, suivre vos projets et accéder à votre espace personnel
                    </p>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Informations -->
                    <div class="text-left">
                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-file-invoice text-primary text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Consultez vos devis</h3>
                                    <p class="text-gray-600">Accédez à l'historique complet de vos devis et téléchargez-les en PDF</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-chart-line text-primary text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Suivez vos projets</h3>
                                    <p class="text-gray-600">Gardez un œil sur l'avancement de vos projets et services</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-bell text-primary text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Notifications en temps réel</h3>
                                    <p class="text-gray-600">Recevez des alertes sur l'état de vos devis et projets</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Formulaire d'inscription rapide -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Créer mon compte</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Votre nom">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="votre@email.com">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone (optionnel)</label>
                                <input type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Votre téléphone">
                            </div>
                            
                            <button type="button" class="w-full bg-primary text-white font-semibold py-3 px-6 rounded-lg hover:bg-gray-800 transition-colors duration-300">
                                Créer mon compte
                            </button>
                        </div>
                        
                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-600">
                                Déjà un compte ? 
                                <a href="{{ route('login') }}" class="text-primary hover:text-gray-800 font-medium">Se connecter</a>
                            </p>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <a href="{{ route('client.register') }}" class="text-sm text-primary hover:text-gray-800 font-medium">
                                Voir le formulaire complet →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Demande de démo -->
        <section class="bg-[#e2e0c7] relative overflow-hidden">
            <!-- Éléments décoratifs -->
            <div class="absolute top-0 left-0 w-32 h-32 bg-primary/10 rounded-full -translate-x-16 -translate-y-16"></div>
            <div class="absolute bottom-0 right-0 w-24 h-24 bg-primary/10 rounded-full translate-x-12 translate-y-12"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
                <div class="text-center">
                    <!-- Icône principale -->
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-primary/20 rounded-full mb-8">
                        <i class="fas fa-rocket text-4xl text-primary"></i>
                    </div>
                    
                    <!-- Titre principal -->
                    <h2 class="text-3xl md:text-5xl font-bold text-gray-800 mb-6">
                        Demandez votre 
                        <span class="block text-primary">démo gratuite</span>
                    </h2>
                    
                    <!-- Description améliorée -->
                    <p class="text-xl text-gray-700 max-w-3xl mx-auto mb-8 leading-relaxed">
                        Découvrez comment nos solutions de géolocalisation peuvent 
                        <span class="font-semibold text-primary">réduire vos coûts de 15-20%</span> 
                        et améliorer significativement votre productivité
                    </p>
                    
                    <!-- Avantages clés -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 max-w-4xl mx-auto">
                        <div class="flex items-center justify-center space-x-3 text-gray-700">
                            <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-chart-line text-primary"></i>
                            </div>
                            <span class="font-medium">Économies garanties</span>
                        </div>
                        <div class="flex items-center justify-center space-x-3 text-gray-700">
                            <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-clock text-primary"></i>
                            </div>
                            <span class="font-medium">Installation rapide</span>
                        </div>
                        <div class="flex items-center justify-center space-x-3 text-gray-700">
                            <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-headset text-primary"></i>
                            </div>
                            <span class="font-medium">Support 24/7</span>
                        </div>
                    </div>
                    
                    <!-- Bouton CTA principal -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="{{ route('contact') }}" 
                           class="group inline-flex items-center px-8 py-4 bg-primary text-white font-bold rounded-full hover:bg-gray-800 transform transition-all duration-300 hover:scale-105 shadow-xl hover:shadow-2xl">
                            <i class="fas fa-play-circle mr-3 text-lg group-hover:animate-pulse"></i>
                            <span>Démarrer ma démo gratuite</span>
                            <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                        </a>
                        
                        <a href="{{ route('services') }}" 
                           class="inline-flex items-center px-6 py-3 border-2 border-primary/30 text-primary hover:bg-primary/10 rounded-full transition-all duration-300">
                            <i class="fas fa-info-circle mr-2"></i>
                            En savoir plus
                        </a>
                    </div>
                    
                    <!-- Texte de confiance -->
                    <p class="text-gray-600 text-sm mt-8">
                        <i class="fas fa-shield-alt mr-2 text-primary"></i>
                        Plus de 500 entreprises nous font confiance • Démo sans engagement • Support technique inclus
                    </p>
                </div>
            </div>
        </section>

        

@endsection

