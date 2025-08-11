# Structure Commercial - Plateforme GTS

## Vue d'ensemble

Cette documentation décrit la structure mise en place pour la partie commerciale de la plateforme GTS, incluant un menu sidebar avec toutes les fonctionnalités nécessaires.

## Architecture

### Layout Principal
- **Fichier**: `resources/views/layouts/commercial.blade.php`
- **Description**: Layout principal avec sidebar fixe et contenu principal
- **Fonctionnalités**:
  - Sidebar avec navigation
  - Header avec titre de page et actions
  - Zone de contenu principal
  - Informations utilisateur en bas de sidebar

### Sidebar Navigation

#### 1. Tableau de bord
- **Route**: `commercial.dashboard`
- **Icône**: `fas fa-tachometer-alt`
- **Description**: Vue d'ensemble des activités commerciales

#### 2. Gestion des clients
- **Route**: `commercial.clients.index`
- **Icône**: `fas fa-users`
- **Description**: Gestion du portefeuille client

#### 3. Demandes
- **Demandes de démo**: `commercial.demandes-demo.index`
- **Demandes de devis**: `commercial.demandes-devis.index`

#### 4. Gestion commerciale
- **Devis**: `commercial.devis.index`
- **Factures**: `commercial.factures.index`
- **Abonnements**: `commercial.abonnements.index`

#### 5. Planning
- **Route**: `commercial.planning`
- **Icône**: `fas fa-calendar`
- **Description**: Gestion du planning et des créneaux

## Vues Créées

### 1. Dashboard Commercial
- **Fichier**: `resources/views/commercial/dashboard.blade.php`
- **Fonctionnalités**:
  - Statistiques rapides (clients, devis, demandes)
  - Actions rapides avec liens directs
  - Liste des demandes de démo récentes

### 2. Gestion des Clients
- **Fichier**: `resources/views/commercial/clients/index.blade.php`
- **Fonctionnalités**:
  - Statistiques clients (total, actifs, premium, CA)
  - Tableau des clients avec actions
  - Filtres et recherche

### 3. Demandes de Devis
- **Fichier**: `resources/views/commercial/demandes-devis/index.blade.php`
- **Fonctionnalités**:
  - Statistiques des demandes
  - Tableau des demandes avec statuts
  - Actions de traitement

### 4. Gestion des Devis
- **Fichier**: `resources/views/commercial/devis/index.blade.php`
- **Fonctionnalités**:
  - Statistiques des devis
  - Tableau des devis avec montants
  - Actions (voir, éditer, télécharger)

### 5. Gestion des Factures
- **Fichier**: `resources/views/commercial/factures/index.blade.php`
- **Fonctionnalités**:
  - Statistiques des factures
  - Tableau des factures avec échéances
  - Gestion des statuts de paiement

### 6. Gestion des Abonnements
- **Fichier**: `resources/views/commercial/abonnements/index.blade.php`
- **Fonctionnalités**:
  - Statistiques des abonnements
  - Tableau des abonnements avec dates
  - Gestion des renouvellements

## Routes Configurées

### Routes Principales
```php
// Dashboard
Route::get('/dashboard', 'commercial.dashboard');

// Clients
Route::prefix('clients')->group(function () {
    Route::get('/', 'commercial.clients.index');
    Route::get('/create', 'commercial.clients.create');
    Route::get('/{client}', 'commercial.clients.show');
    Route::get('/{client}/edit', 'commercial.clients.edit');
    Route::get('/{client}/abonnements', 'commercial.clients.abonnements');
});

// Demandes de devis
Route::prefix('demandes-devis')->group(function () {
    Route::get('/', 'commercial.demandes-devis.index');
    Route::get('/create', 'commercial.demandes-devis.create');
    Route::get('/{demandeDevis}', 'commercial.demandes-devis.show');
    Route::get('/{demandeDevis}/edit', 'commercial.demandes-devis.edit');
});

// Devis
Route::prefix('devis')->group(function () {
    Route::get('/', 'commercial.devis.index');
    Route::get('/create', 'commercial.devis.create');
    Route::get('/{devis}', 'commercial.devis.show');
    Route::get('/{devis}/edit', 'commercial.devis.edit');
    Route::get('/{devis}/download', 'commercial.devis.download');
});

// Factures
Route::prefix('factures')->group(function () {
    Route::get('/', 'commercial.factures.index');
    Route::get('/create', 'commercial.factures.create');
    Route::get('/{facture}', 'commercial.factures.show');
    Route::get('/{facture}/edit', 'commercial.factures.edit');
    Route::get('/{facture}/download', 'commercial.factures.download');
});

// Abonnements
Route::prefix('abonnements')->group(function () {
    Route::get('/', 'commercial.abonnements.index');
    Route::get('/create', 'commercial.abonnements.create');
    Route::get('/{abonnement}', 'commercial.abonnements.show');
    Route::get('/{abonnement}/edit', 'commercial.abonnements.edit');
});
```

## Styles CSS

### Variables CSS
- **Couleur primaire**: `#3b82f6` (bleu)
- **Couleur primaire sombre**: `#2563eb`
- **Couleur primaire claire**: `#60a5fa`

### Classes Utilitaires
- `.bg-primary`, `.text-primary` pour les couleurs principales
- `.stat-card` pour les cartes de statistiques
- `.table-container` pour les tableaux
- `.action-button` pour les boutons d'action
- `.status-badge` pour les badges de statut

## Fonctionnalités Clés

### 1. Navigation Intuitive
- Sidebar fixe avec icônes claires
- Navigation par sections logiques
- Indicateurs visuels pour la page active

### 2. Tableaux de Bord
- Statistiques en temps réel
- Actions rapides accessibles
- Vue d'ensemble des activités

### 3. Gestion Complète
- CRUD pour toutes les entités
- Filtres et recherche
- Actions contextuelles

### 4. Interface Responsive
- Adaptation mobile
- Grilles flexibles
- Navigation adaptative

## Utilisation

### Accès
1. Se connecter avec un compte commercial
2. Être redirigé vers `/commercial/dashboard`
3. Utiliser la sidebar pour naviguer entre les sections

### Permissions
- **Middleware**: `role:admin` (pour les commerciaux)
- **Accès**: Restreint aux utilisateurs avec rôle commercial
- **Fonctionnalités**: Complètes pour la gestion commerciale

## Développement Futur

### Fonctionnalités à Ajouter
- [ ] Formulaires de création/édition
- [ ] Système de notifications
- [ ] Export de données
- [ ] Intégration avec calendrier
- [ ] Système de rapports

### Améliorations Techniques
- [ ] Contrôleurs dédiés
- [ ] Validation des formulaires
- [ ] Gestion des erreurs
- [ ] Tests unitaires
- [ ] Documentation API

## Support

Pour toute question ou problème concernant la structure commerciale, consulter :
- La documentation Laravel
- Les modèles Eloquent
- Les vues Blade
- Les routes web.php
