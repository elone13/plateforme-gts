<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuration des Rôles - GTS Afrique
    |--------------------------------------------------------------------------
    |
    | Ce fichier définit la structure et la logique des rôles utilisateurs
    | pour l'application GTS Afrique.
    |
    */

    // Rôles principaux dans la table users
    'main_roles' => [
        'admin' => 'admin',
        'client' => 'client',
    ],

    // Types d'administrateurs dans la table administrateurs
    'admin_types' => [
        'manager' => 'manager',
        'commercial' => 'commercial',
    ],

    // Mapping des rôles vers les routes de redirection
    'redirect_routes' => [
        'manager' => 'manager.dashboard',
        'commercial' => 'commercial.dashboard',
        'client' => 'client.profile',
        'admin_general' => 'admin.dashboard',
    ],

    // Permissions par type d'administrateur
    'permissions' => [
        'manager' => [
            'can_manage_team' => true,
            'can_view_reports' => true,
            'can_supervise_commercial' => true,
            'can_access_all_data' => true,
        ],
        'commercial' => [
            'can_manage_clients' => true,
            'can_process_demos' => true,
            'can_create_quotes' => true,
            'can_manage_invoices' => true,
        ],
        'client' => [
            'can_view_profile' => true,
            'can_view_quotes' => true,
            'can_view_invoices' => true,
            'can_request_demo' => true,
        ],
    ],

    // Routes accessibles par type
    'accessible_routes' => [
        'manager' => [
            'manager.dashboard',
            'manager.commerciaux.*',
            'manager.rapports.*',
            'manager.demandes-demo.*',
            'manager.devis.*',
            'manager.factures.*',
        ],
        'commercial' => [
            'commercial.dashboard',
            'commercial.clients.*',
            'commercial.demandes-demo.*',
            'commercial.devis.*',
            'commercial.factures.*',
            'commercial.abonnements.*',
        ],
        'client' => [
            'client.profile',
            'client.devis.*',
            'client.factures.*',
            'home',
            'services',
            'contact',
        ],
    ],

    // Validation des rôles
    'validation_rules' => [
        'user_role' => 'in:admin,client',
        'admin_type' => 'in:manager,commercial',
    ],

    // Messages d'erreur
    'error_messages' => [
        'invalid_role' => 'Rôle invalide. Doit être "admin" ou "client".',
        'invalid_admin_type' => 'Type d\'administrateur invalide. Doit être "manager" ou "commercial".',
        'missing_admin_record' => 'L\'utilisateur admin doit avoir un enregistrement dans la table administrateurs.',
        'client_cannot_be_admin' => 'Un client ne peut pas avoir le rôle admin.',
    ],
];
