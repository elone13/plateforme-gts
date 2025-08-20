# Guide de Gestion des Abonnements - GTS AFRIQUE

## 🎯 Nouvelle Fonctionnalité : Durée d'Abonnement

### 📋 **Vue d'ensemble**
Le système de création de devis a été enrichi avec la possibilité de spécifier la **durée en mois** pour chaque élément de service. Cette fonctionnalité facilite grandement la gestion des abonnements récurrents.

### ✨ **Fonctionnalités Ajoutées**

#### **1. Champ "Durée (mois)"**
- **Emplacement** : Nouvelle colonne dans le tableau des éléments
- **Valeur par défaut** : 12 mois
- **Plage** : 1 mois minimum
- **Calcul** : Prix × Quantité × Durée × (1 - Remise/100)

#### **2. Calculs Automatiques**
- **Total HT** : Prend en compte la durée d'abonnement
- **Remise** : Appliquée sur le total avec durée
- **TVA** : Calculée sur le total remisé
- **Total TTC** : Final avec tous les paramètres

#### **3. Sauvegarde en Base**
- **Colonne** : `duree_mois` dans la table `items`
- **Valeur** : Nombre entier de mois
- **Utilisation** : Pour la gestion future des abonnements

### 🔧 **Utilisation Pratique**

#### **Étape 1 : Sélection du Client**
1. Ouvrir le modal de création de devis
2. Rechercher et sélectionner le client

#### **Étape 2 : Sélection des Services**
1. Choisir un ou plusieurs services
2. Les éléments apparaissent avec leurs durées par défaut

#### **Étape 3 : Configuration des Éléments**
Pour chaque élément sélectionné, vous pouvez ajuster :
- **Quantité** : Nombre d'unités
- **Durée** : Nombre de mois d'abonnement
- **Remise** : Pourcentage de réduction

#### **Étape 4 : Calculs Automatiques**
Le système calcule automatiquement :
```
Total HT = Prix × Quantité × Durée
Remise = Total HT × (Remise % / 100)
Total HT remisé = Total HT - Remise
TVA = Total HT remisé × (TVA % / 100)
Total TTC = Total HT remisé + TVA
```

### 📊 **Exemples de Calculs**

#### **Exemple 1 : Abonnement GPS**
- **Élément** : Installation balise GPS
- **Prix** : 100 FCFA/mois
- **Quantité** : 1
- **Durée** : 12 mois
- **Remise** : 0%

**Calcul** :
- Total HT = 100 × 1 × 12 = 1,200 FCFA
- Remise = 1,200 × 0% = 0 FCFA
- Total HT remisé = 1,200 FCFA
- TVA (18%) = 1,200 × 18% = 216 FCFA
- **Total TTC = 1,416 FCFA**

#### **Exemple 2 : Abonnement avec Remise**
- **Élément** : Service de maintenance
- **Prix** : 50 FCFA/mois
- **Quantité** : 2
- **Durée** : 24 mois
- **Remise** : 10%

**Calcul** :
- Total HT = 50 × 2 × 24 = 2,400 FCFA
- Remise = 2,400 × 10% = 240 FCFA
- Total HT remisé = 2,400 - 240 = 2,160 FCFA
- TVA (18%) = 2,160 × 18% = 388.8 FCFA
- **Total TTC = 2,548.8 FCFA**

### 🎛️ **Avantages pour la Gestion des Abonnements**

#### **1. Flexibilité Tarifaire**
- Possibilité d'offrir des tarifs différents selon la durée
- Gestion des remises sur abonnements longs
- Calcul automatique des économies

#### **2. Planification Financière**
- Prévision des revenus récurrents
- Gestion des échéances de paiement
- Suivi des durées d'engagement

#### **3. Gestion Client**
- Historique des abonnements
- Renouvellement automatique
- Facturation récurrente

### 🔄 **Workflow Complet**

1. **Création du Devis**
   - Sélection client
   - Choix des services
   - Configuration des durées
   - Validation des calculs

2. **Validation Client**
   - Envoi du devis
   - Acceptation/Refus
   - Modifications si nécessaire

3. **Création de l'Abonnement**
   - Génération de la facture
   - Planification des échéances
   - Suivi des paiements

4. **Gestion Continue**
   - Renouvellement automatique
   - Modifications de durée
   - Résiliation d'abonnement

### 💡 **Bonnes Pratiques**

#### **1. Configuration des Durées**
- **Court terme** : 1-6 mois (essais, projets ponctuels)
- **Moyen terme** : 12 mois (abonnements standards)
- **Long terme** : 24+ mois (engagements, remises)

#### **2. Gestion des Remises**
- **Remises progressives** selon la durée
- **Remises de fidélité** pour renouvellements
- **Remises de volume** pour quantités importantes

#### **3. Communication Client**
- **Clarifier la durée** d'engagement
- **Expliquer les avantages** des abonnements longs
- **Préciser les conditions** de résiliation

### 🚀 **Prochaines Évolutions**

#### **Fonctionnalités Prévues**
- **Renouvellement automatique** des abonnements
- **Alertes d'échéance** pour les commerciaux
- **Tableaux de bord** de suivi des abonnements
- **Rapports de rentabilité** par durée d'abonnement

#### **Intégrations Futures**
- **Système de facturation** récurrente
- **Gestion des prélèvements** automatiques
- **Interface client** pour gestion des abonnements
- **Notifications** automatiques

---

**GTS AFRIQUE** - Système de Gestion des Abonnements
*Version 1.0 - Août 2025*
