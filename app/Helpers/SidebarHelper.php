<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class SidebarHelper
{
    /**
     * Récupère la configuration de la sidebar pour un rôle donné
     */
    public static function getSidebarConfig(string $role): array
    {
        $config = config("sidebar.{$role}", []);
        
        // Traitement des badges dynamiques
        if (isset($config['mainSections'])) {
            foreach ($config['mainSections'] as $key => $section) {
                if (isset($section['badge']) && is_string($section['badge'])) {
                    $config['mainSections'][$key]['badge'] = self::getBadgeValue($section['badge']);
                }
            }
        }
        
        return $config;
    }
    
    /**
     * Récupère la valeur d'un badge dynamique
     */
    private static function getBadgeValue(string $badgeKey): int
    {
        try {
            switch ($badgeKey) {
                case 'demandes_planifiees_count':
                    if (Auth::check() && Auth::user()->role === 'client') {
                        $user = Auth::user();
                        if (method_exists($user, 'client') && $user->client) {
                            return $user->client->demandeDemos()
                                ->where('statut', 'planifiee')
                                ->count();
                        }
                    }
                    return 0;
                    
                default:
                    return 0;
            }
        } catch (\Exception $e) {
            // En cas d'erreur, retourner 0 pour éviter de casser l'interface
            \Log::warning('Erreur dans SidebarHelper::getBadgeValue: ' . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Récupère la configuration de la sidebar pour l'utilisateur connecté
     */
    public static function getCurrentUserSidebarConfig(): array
    {
        if (!Auth::check()) {
            return [];
        }
        
        $role = Auth::user()->role;
        return self::getSidebarConfig($role);
    }
}
