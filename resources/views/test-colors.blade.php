<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Couleurs GTS Afrique</title>
    
    <!-- Styles personnalisés GTS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#fcd61b',
                        'primary-dark': '#e6c200',
                        'primary-light': '#fde047',
                        secondary: '#1e40af',
                        'secondary-dark': '#1e3a8a',
                        'secondary-light': '#3b82f6',
                        accent: '#059669',
                        'accent-dark': '#047857',
                        'accent-light': '#10b981'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 p-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-bold text-center mb-12 text-gray-900">
            🎨 Test des Couleurs GTS Afrique
        </h1>
        
        <!-- Couleurs principales -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Couleurs Principales</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Jaune GTS -->
                <div class="bg-primary p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Jaune GTS (Primary)</h3>
                    <p class="text-gray-900 mb-2">#fcd61b</p>
                    <p class="text-sm text-gray-700">Couleur dominante de GTS Afrique</p>
                </div>
                
                <!-- Bleu -->
                <div class="bg-secondary p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-semibold text-white mb-2">Bleu (Secondary)</h3>
                    <p class="text-white mb-2">#1e40af</p>
                    <p class="text-sm text-blue-100">Couleur secondaire</p>
                </div>
                
                <!-- Vert -->
                <div class="bg-accent p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-semibold text-white mb-2">Vert (Accent)</h3>
                    <p class="text-white mb-2">#059669</p>
                    <p class="text-sm text-green-100">Couleur d'accent</p>
                </div>
            </div>
        </div>
        
        <!-- Boutons -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Boutons</h2>
            <div class="flex flex-wrap gap-4">
                <button class="bg-primary hover:bg-primary-dark text-gray-900 px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    Bouton Principal
                </button>
                
                <button class="bg-secondary hover:bg-secondary-dark text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    Bouton Secondaire
                </button>
                
                <button class="bg-accent hover:bg-accent-dark text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    Bouton Accent
                </button>
                
                <button class="bg-primary-light hover:bg-primary text-gray-900 px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    Bouton Light
                </button>
            </div>
        </div>
        
        <!-- Cartes -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Cartes</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-primary">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Carte avec Bordure Jaune</h3>
                    <p class="text-gray-600">Cette carte utilise la couleur primaire GTS pour la bordure gauche.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-secondary">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Carte avec Bordure Bleue</h3>
                    <p class="text-gray-600">Cette carte utilise la couleur secondaire pour la bordure gauche.</p>
                </div>
            </div>
        </div>
        
        <!-- Icônes -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Icônes</h2>
            <div class="flex flex-wrap gap-6">
                <div class="text-center">
                    <i class="fas fa-satellite-dish text-4xl text-primary mb-2"></i>
                    <p class="text-sm text-gray-600">Icône Jaune</p>
                </div>
                
                <div class="text-center">
                    <i class="fas fa-map-marker-alt text-4xl text-secondary mb-2"></i>
                    <p class="text-sm text-gray-600">Icône Bleue</p>
                </div>
                
                <div class="text-center">
                    <i class="fas fa-check-circle text-4xl text-accent mb-2"></i>
                    <p class="text-sm text-gray-600">Icône Verte</p>
                </div>
                
                <div class="text-center">
                    <i class="fas fa-star text-4xl text-primary-light mb-2"></i>
                    <p class="text-sm text-gray-600">Icône Jaune Light</p>
                </div>
            </div>
        </div>
        
        <!-- Badges -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Badges</h2>
            <div class="flex flex-wrap gap-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary text-gray-900">
                    Badge Jaune
                </span>
                
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-secondary text-white">
                    Badge Bleu
                </span>
                
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-accent text-white">
                    Badge Vert
                </span>
                
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary/10 text-gray-900 border border-primary/20">
                    Badge Transparent
                </span>
            </div>
        </div>
        
        <!-- Navigation -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Navigation</h2>
            <nav class="flex space-x-4">
                <a href="#" class="text-gray-600 hover:text-primary transition-colors duration-200">Accueil</a>
                <a href="#" class="text-gray-600 hover:text-primary transition-colors duration-200">Services</a>
                <a href="#" class="text-gray-600 hover:text-primary transition-colors duration-200">Contact</a>
                <a href="#" class="text-primary font-medium">Page Active</a>
            </nav>
        </div>
        
        <!-- Footer -->
        <div class="text-center text-gray-600">
            <p>🎯 Design harmonisé avec l'identité visuelle de GTS Afrique</p>
            <p class="text-sm mt-2">Palette de couleurs officielle : Jaune #fcd61b dominant</p>
        </div>
    </div>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>
