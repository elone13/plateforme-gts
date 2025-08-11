# Structure des Rôles - GTS Afrique

## Vue d'ensemble

Le système de gestion des rôles de GTS Afrique utilise une architecture à deux niveaux pour une séparation claire des responsabilités.

## Architecture des Rôles

### 1. Table `users` (Rôle global)
```sql
users table:
- id
- name
- email
- password
- role (ENUM: 'admin', 'client') ← RÔLE PRINCIPAL
- ...
```

### 2. Table `administrateurs` (Type d'administrateur)
```sql
administrateurs table:
- idadministrateur (PK)
- user_id (FK vers users.id)
- type (ENUM: 'manager', 'commercial') ← TYPE SPÉCIFIQUE
- created_at
- updated_at
```

## Logique des Rôles

### 🔴 Rôle CLIENT
```php
role = 'client'
// → Accès limité au portail client
// → Redirection vers: client.profile
// → Pas d'enregistrement dans la table administrateurs
```

### 🔵 Rôle ADMIN (avec types)
```php
role = 'admin' + administrateur.type = 'manager'
// → Accès complet à l'espace manager
// → Redirection vers: manager.dashboard
// → Supervision de l'équipe commerciale

role = 'admin' + administrateur.type = 'commercial'
// → Accès à l'espace commercial
// → Redirection vers: commercial.dashboard
// → Gestion des clients et demandes
```

## Exemples Concrets

### Utilisateur Commercial
```php
// Table users
{
    "id": 1,
    "name": "Commercial Test",
    "email": "commercial@test.com",
    "role": "admin"  // ← DOIT ÊTRE 'admin'
}

// Table administrateurs
{
    "idadministrateur": 1,
    "user_id": 1,
    "type": "commercial"  // ← Type spécifique
}
```

### Utilisateur Manager
```php
// Table users
{
    "id": 5,
    "name": "Manager Test",
    "email": "manager@test.com",
    "role": "admin"  // ← DOIT ÊTRE 'admin'
}

// Table administrateurs
{
    "idadministrateur": 3,
    "user_id": 5,
    "type": "manager"  // ← Type spécifique
}
```

### Utilisateur Client
```php
// Table users
{
    "id": 2,
    "name": "Client Test",
    "email": "client@test.com",
    "role": "client"  // ← Rôle client
}

// Pas d'enregistrement dans administrateurs
```

## Middleware RedirectAccordingToRole

```php
public function handle(Request $request, Closure $next): Response
{
    if (auth()->check()) {
        $user = auth()->user();
        
        // 1. Vérifier d'abord si l'utilisateur est un administrateur
        if ($user->administrateur) {
            if ($user->administrateur->type === 'manager') {
                return redirect()->route('manager.dashboard');
            } elseif ($user->administrateur->type === 'commercial') {
                return redirect()->route('commercial.dashboard');
            }
        }
        
        // 2. Si c'est un admin général (sans type spécifique)
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // 3. Clients → profil client
        return redirect()->route('client.profile');
    }

    return $next($request);
}
```

## Routes et Accès

### Manager Routes (`/manager/*`)
- `manager.dashboard` - Tableau de bord
- `manager.commerciaux.index` - Gestion de l'équipe
- `manager.rapports.index` - Rapports et analyses
- `manager.demandes-demo.index` - Supervision des demandes

### Commercial Routes (`/commercial/*`)
- `commercial.dashboard` - Tableau de bord
- `commercial.clients.index` - Gestion des clients
- `commercial.demandes-demo.index` - Traitement des demandes
- `commercial.devis.index` - Gestion des devis

### Client Routes (`/client/*`)
- `client.profile` - Profil utilisateur
- `client.devis` - Consultation des devis
- `client.factures` - Consultation des factures

## Règles Importantes

### ✅ CE QUI EST CORRECT
1. **Commercial** : `role = 'admin'` + `type = 'commercial'`
2. **Manager** : `role = 'admin'` + `type = 'manager'`
3. **Client** : `role = 'client'` (pas d'enregistrement administrateur)

### ❌ CE QUI EST INCORRECT
1. **Commercial** : `role = 'commercial'` (doit être 'admin')
2. **Manager** : `role = 'manager'` (doit être 'admin')
3. **Client** : `role = 'admin'` (doit être 'client')

## Création d'Utilisateurs

### Créer un Commercial
```php
// 1. Créer l'utilisateur
$user = User::create([
    'name' => 'Nouveau Commercial',
    'email' => 'commercial@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin'  // ← IMPORTANT: 'admin'
]);

// 2. Créer l'enregistrement administrateur
Administrateur::create([
    'user_id' => $user->id,
    'type' => 'commercial'
]);
```

### Créer un Manager
```php
// 1. Créer l'utilisateur
$user = User::create([
    'name' => 'Nouveau Manager',
    'email' => 'manager@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin'  // ← IMPORTANT: 'admin'
]);

// 2. Créer l'enregistrement administrateur
Administrateur::create([
    'user_id' => $user->id,
    'type' => 'manager'
]);
```

### Créer un Client
```php
// Créer l'utilisateur (pas d'administrateur)
$user = User::create([
    'name' => 'Nouveau Client',
    'email' => 'client@example.com',
    'password' => bcrypt('password'),
    'role' => 'client'  // ← IMPORTANT: 'client'
]);
```

## Dépannage

### Problème : Commercial redirigé vers profil client
**Cause** : `role != 'admin'` dans la table users
**Solution** : Mettre à jour `role = 'admin'`

### Problème : Manager redirigé vers profil client
**Cause** : `role != 'admin'` dans la table users
**Solution** : Mettre à jour `role = 'admin'`

### Problème : Client redirigé vers dashboard admin
**Cause** : `role = 'admin'` au lieu de `role = 'client'`
**Solution** : Mettre à jour `role = 'client'`

## Vérification des Rôles

```bash
# Vérifier la structure des rôles
php artisan tinker --execute="
use App\Models\User; 
use App\Models\Administrateur; 
echo '=== USERS ==='; 
print_r(User::all(['id', 'name', 'email', 'role'])->toArray()); 
echo '=== ADMINISTRATEURS ==='; 
print_r(Administrateur::with('user')->get()->toArray());
"
```

## Résumé

- **`role = 'admin'`** → Vérifier `administrateurs.type`
- **`role = 'client'`** → Accès client uniquement
- **Jamais** `role = 'manager'` ou `role = 'commercial'` dans users
- **Toujours** utiliser la table `administrateurs` pour les types admin

---

**⚠️ ATTENTION** : Cette structure est définitive et ne doit pas être modifiée sans consultation de l'équipe de développement.
