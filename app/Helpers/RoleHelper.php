<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Administrateur;

class RoleHelper
{
    /**
     * Vérifier si l'utilisateur est un manager
     */
    public static function isManager(User $user): bool
    {
        return $user->role === 'admin' && 
               $user->administrateur && 
               $user->administrateur->type === 'manager';
    }

    /**
     * Vérifier si l'utilisateur est un commercial
     */
    public static function isCommercial(User $user): bool
    {
        return $user->role === 'admin' && 
               $user->administrateur && 
               $user->administrateur->type === 'commercial';
    }

    /**
     * Vérifier si l'utilisateur est un client
     */
    public static function isClient(User $user): bool
    {
        return $user->role === 'client';
    }

    /**
     * Vérifier si l'utilisateur est un administrateur (manager ou commercial)
     */
    public static function isAdmin(User $user): bool
    {
        return $user->role === 'admin' && $user->administrateur;
    }

    /**
     * Obtenir le type d'administrateur de l'utilisateur
     */
    public static function getAdminType(User $user): ?string
    {
        if (self::isAdmin($user)) {
            return $user->administrateur->type;
        }
        return null;
    }

    /**
     * Obtenir la route de redirection appropriée pour l'utilisateur
     */
    public static function getRedirectRoute(User $user): string
    {
        if (self::isManager($user)) {
            return config('roles.redirect_routes.manager');
        }
        
        if (self::isCommercial($user)) {
            return config('roles.redirect_routes.commercial');
        }
        
        if (self::isClient($user)) {
            return config('roles.redirect_routes.client');
        }
        
        // Admin général sans type spécifique
        return config('roles.redirect_routes.admin_general');
    }

    /**
     * Vérifier si l'utilisateur peut accéder à une route spécifique
     */
    public static function canAccessRoute(User $user, string $route): bool
    {
        if (self::isManager($user)) {
            return self::routeMatches($route, config('roles.accessible_routes.manager'));
        }
        
        if (self::isCommercial($user)) {
            return self::routeMatches($route, config('roles.accessible_routes.commercial'));
        }
        
        if (self::isClient($user)) {
            return self::routeMatches($route, config('roles.accessible_routes.client'));
        }
        
        return false;
    }

    /**
     * Vérifier si une route correspond à un pattern
     */
    private static function routeMatches(string $route, array $patterns): bool
    {
        foreach ($patterns as $pattern) {
            if (self::patternMatches($route, $pattern)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Vérifier si une route correspond à un pattern avec wildcards
     */
    private static function patternMatches(string $route, string $pattern): bool
    {
        // Convertir le pattern en regex
        $regex = str_replace('*', '.*', $pattern);
        $regex = '/^' . $regex . '$/';
        
        return preg_match($regex, $route);
    }

    /**
     * Obtenir les permissions de l'utilisateur
     */
    public static function getPermissions(User $user): array
    {
        if (self::isManager($user)) {
            return config('roles.permissions.manager');
        }
        
        if (self::isCommercial($user)) {
            return config('roles.permissions.commercial');
        }
        
        if (self::isClient($user)) {
            return config('roles.permissions.client');
        }
        
        return [];
    }

    /**
     * Vérifier si l'utilisateur a une permission spécifique
     */
    public static function hasPermission(User $user, string $permission): bool
    {
        $permissions = self::getPermissions($user);
        return isset($permissions[$permission]) && $permissions[$permission];
    }

    /**
     * Créer un utilisateur commercial
     */
    public static function createCommercial(array $userData): User
    {
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password']),
            'role' => 'admin', // IMPORTANT: doit être 'admin'
        ]);

        Administrateur::create([
            'user_id' => $user->id,
            'type' => 'commercial',
        ]);

        return $user;
    }

    /**
     * Créer un utilisateur manager
     */
    public static function createManager(array $userData): User
    {
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password']),
            'role' => 'admin', // IMPORTANT: doit être 'admin'
        ]);

        Administrateur::create([
            'user_id' => $user->id,
            'type' => 'manager',
        ]);

        return $user;
    }

    /**
     * Créer un utilisateur client
     */
    public static function createClient(array $userData): User
    {
        return User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password']),
            'role' => 'client', // IMPORTANT: doit être 'client'
        ]);
    }

    /**
     * Valider la structure des rôles
     */
    public static function validateRoleStructure(): array
    {
        $errors = [];
        
        // Vérifier les utilisateurs avec role = 'admin'
        $adminUsers = User::where('role', 'admin')->get();
        
        foreach ($adminUsers as $user) {
            if (!$user->administrateur) {
                $errors[] = "L'utilisateur {$user->email} a le rôle 'admin' mais n'a pas d'enregistrement dans la table administrateurs.";
            }
        }
        
        // Vérifier les utilisateurs avec role = 'client'
        $clientUsers = User::where('role', 'client')->get();
        
        foreach ($clientUsers as $user) {
            if ($user->administrateur) {
                $errors[] = "L'utilisateur {$user->email} a le rôle 'client' mais a un enregistrement dans la table administrateurs.";
            }
        }
        
        return $errors;
    }
}
