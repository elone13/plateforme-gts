# Système de Création de Devis GTS AFRIQUE

## 🎯 Vue d'ensemble

Ce document décrit le nouveau système de création de devis qui reproduit fidèlement la structure officielle de GTS AFRIQUE. Le système suit une logique simple en **3 étapes** : **Client → Service → Éléments**.

## 🚀 Fonctionnalités principales

### 1. **Création ultra-rapide en 3 étapes**
- **Étape 1** : Sélection du client (recherche instantanée)
- **Étape 2** : Sélection du service (recherche instantanée)  
- **Étape 3** : Sélection des éléments du service avec quantités et remises

### 2. **Interface intuitive**
- Modal moderne avec indicateurs d'étapes visuels
- Recherche en temps réel avec autocomplétion
- Tableau des éléments avec gestion des quantités et remises
- Calculs automatiques des totaux

### 3. **Structure fidèle au devis GTS AFRIQUE**
- Logo et identité visuelle GTS AFRIQUE
- En-tête avec coordonnées complètes
- Tableau des éléments avec colonnes : Désignation, Remise, Qté, PU HT, Total HT, TVA
- Récapitulatif : Total HT, Remise, Total HT remisé, TVA, Total TTC
- Conditions de paiement et validité
- Pied de page avec informations légales

## 🏗️ Architecture technique

### Composants Livewire

#### `CreateDevisModal`
- Gestion de la création de devis en 3 étapes
- Recherche rapide de clients et services
- Sélection multiple d'éléments avec quantités et remises
- Calculs automatiques des totaux
- Validation et création en base de données

#### `DevisList`
- Liste des devis avec filtres avancés
- Recherche en temps réel
- Tri et pagination
- Statistiques des devis

#### `DevisActions`
- Actions rapides sur les devis
- Changement de statut
- Envoi par email
- Téléchargement

### Modèles et relations

```php
Devis → Client (belongsTo)
Devis → Items (hasMany)
Item → Service (belongsTo)
Service → Items (hasMany)
```

### Base de données

#### Table `devis`
- `reference` : Référence unique (ex: CT 001-12-2024)
- `client_idclient` : ID du client
- `date` : Date de création
- `date_validite` : Date de validité
- `statut` : brouillon, envoye, accepte, refuse, expire
- `total_ht` : Total hors taxes
- `total_remise` : Total des remises
- `total_ht_remise` : Total HT après remises
- `taux_tva` : Taux de TVA (décimal)
- `montant_tva` : Montant de la TVA
- `total_ttc` : Total toutes taxes comprises
- `conditions` : Conditions spéciales

#### Table `items`
- `nom` : Nom de l'élément
- `quantite` : Quantité commandée
- `prix` : Prix unitaire HT
- `remise` : Pourcentage de remise
- `devis_id` : Référence du devis
- `service_id` : Référence du service

## 📋 Processus de création

### 1. Sélection du client
- Recherche par nom, entreprise ou email
- Autocomplétion en temps réel
- Affichage des informations du client sélectionné

### 2. Sélection du service
- Recherche par nom ou description
- Affichage des services disponibles
- Chargement automatique des éléments du service

### 3. Sélection des éléments
- Tableau avec checkboxes pour sélection multiple
- Gestion des quantités par élément
- Gestion des remises par élément (en pourcentage)
- Calcul automatique des totaux en temps réel

### 4. Configuration finale
- Date de validité (par défaut : +30 jours)
- Taux de TVA (par défaut : 18% - TVA sénégalaise)
- Conditions spéciales

### 5. Création du devis
- Validation des données
- Génération de la référence unique
- Création en base de données
- Redirection vers la page du devis

## 🎨 Interface utilisateur

### Modal de création
- **Largeur** : 6xl (max-w-6xl)
- **Header** : Logo GTS AFRIQUE + titre
- **Indicateurs d'étapes** : Cercles colorés avec icônes
- **Sections conditionnelles** : Affichage progressif selon les étapes

### Tableau des éléments
- Colonnes : Sélection, Désignation, Remise (%), Qté, PU HT, Total HT
- Gestion des quantités et remises en ligne
- Calculs automatiques des totaux
- Checkbox "Sélectionner tous"

### Récapitulatif des totaux
- Affichage en grille avec couleurs distinctes
- Total HT, Remise, Total HT remisé, TVA, Total TTC
- Mise en évidence du montant final

## 🔧 Configuration et personnalisation

### Taux de TVA
- **Défaut** : 18% (TVA sénégalaise)
- **Modifiable** : Oui, en temps réel
- **Calcul** : Appliqué sur le total HT remisé

### Références de devis
- **Format** : CT XXX-MM-YYYY
- **Exemple** : CT 001-12-2024
- **Génération** : Automatique par mois

### Validité par défaut
- **Durée** : 30 jours
- **Modifiable** : Oui
- **Validation** : Doit être postérieure à aujourd'hui

## 📱 Responsive et accessibilité

### Breakpoints
- **Mobile** : < 640px (sm)
- **Tablet** : 640px - 1024px (md, lg)
- **Desktop** : > 1024px (xl, 2xl)

### Accessibilité
- Labels explicites pour tous les champs
- Messages d'erreur clairs
- Navigation au clavier
- Contrastes respectés

## 🚀 Utilisation

### 1. Accès au modal
```php
// Depuis le dashboard commercial
wire:click="$dispatch('openCreateDevisModal')"

// Depuis la liste des devis
wire:click="$dispatch('openCreateDevisModal')"
```

### 2. Création d'un devis
1. Cliquer sur "Nouveau devis"
2. Rechercher et sélectionner le client
3. Rechercher et sélectionner le service
4. Cocher les éléments souhaités
5. Ajuster quantités et remises
6. Configurer la validité et conditions
7. Cliquer sur "Créer le devis"

### 3. Aperçu et impression
- Route : `/commercial/devis/{id}/preview`
- Vue optimisée pour l'impression
- Structure identique au devis officiel GTS AFRIQUE

## 🔍 Dépannage

### Problèmes courants

#### Erreur "Column not found"
- Vérifier que la migration `2025_08_13_010551_add_facturation_fields_to_devis_table` a été exécutée
- Exécuter `php artisan migrate` si nécessaire

#### Composant Livewire non trouvé
- Vérifier que les composants sont bien dans `app/Livewire/Commercial/`
- Vérifier que les vues sont dans `resources/views/livewire/commercial/`

#### Erreurs de validation
- Vérifier que tous les champs requis sont remplis
- Vérifier que la date de validité est postérieure à aujourd'hui
- Vérifier qu'au moins un élément est sélectionné

## 📈 Évolutions futures

### Fonctionnalités prévues
- **Templates de devis** : Plusieurs modèles disponibles
- **Historique des modifications** : Traçabilité des changements
- **Approbation en workflow** : Validation par étapes
- **Intégration email** : Envoi automatique des devis
- **Export PDF** : Génération de fichiers PDF

### Optimisations techniques
- **Cache des services** : Mise en cache des services et éléments
- **Lazy loading** : Chargement différé des données
- **Indexation** : Optimisation des requêtes de recherche
- **API REST** : Endpoints pour intégrations externes

## 📞 Support

Pour toute question ou problème :
- **Documentation** : Ce fichier et les commentaires du code
- **Logs** : `storage/logs/laravel.log`
- **Tests** : `php artisan test --filter=Devis`

---

*Documentation mise à jour le {{ date('d/m/Y') }}*
