<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuration des sidebars
    |--------------------------------------------------------------------------
    |
    | Ce fichier contient la configuration des menus de sidebar pour
    | les différents rôles de l'application.
    |
    */

    'client' => [
        'mainSections' => [
            'profile' => [
                'icon' => 'fas fa-user',
                'label' => 'Mon Profil',
                'active' => true
            ],
            'devis' => [
                'icon' => 'fas fa-file-invoice',
                'label' => 'Mes Devis'
            ],
            'factures' => [
                'icon' => 'fas fa-receipt',
                'label' => 'Mes Factures'
            ],
            'demandes' => [
                'icon' => 'fas fa-desktop',
                'label' => 'Mes Demandes de Démo',
                'badge' => 'demandes_planifiees_count'
            ]
        ],
        'quickActions' => []
    ],

    'commercial' => [
        'mainSections' => [
            'dashboard' => [
                'icon' => 'fas fa-tachometer-alt',
                'label' => 'Tableau de bord',
                'active' => true
            ],
            'demandes-demo' => [
                'icon' => 'fas fa-rocket',
                'label' => 'Demandes de démo'
            ],
            'clients' => [
                'icon' => 'fas fa-users',
                'label' => 'Clients'
            ],
            'devis' => [
                'icon' => 'fas fa-file-invoice',
                'label' => 'Devis'
            ],
            'factures' => [
                'icon' => 'fas fa-receipt',
                'label' => 'Factures'
            ],
            'abonnements' => [
                'icon' => 'fas fa-credit-card',
                'label' => 'Abonnements'
            ],
            'planning' => [
                'icon' => 'fas fa-calendar-alt',
                'label' => 'Planning'
            ]
        ]
    ],

    'manager' => [
        'mainSections' => [
            'dashboard' => [
                'icon' => 'fas fa-tachometer-alt',
                'label' => 'Tableau de bord',
                'active' => true
            ],
            'services' => [
                'icon' => 'fas fa-cogs',
                'label' => 'Services'
            ],
            'items' => [
                'icon' => 'fas fa-boxes',
                'label' => 'Items'
            ],
            'analytics' => [
                'icon' => 'fas fa-chart-line',
                'label' => 'Analytics'
            ],
            'rapports' => [
                'icon' => 'fas fa-file-alt',
                'label' => 'Rapports'
            ],
            'commerciaux' => [
                'icon' => 'fas fa-users',
                'label' => 'Commerciaux'
            ]
        ]
    ]
];
