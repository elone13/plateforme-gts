<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class PublicController extends Controller
{
    /**
     * Page d'accueil
     */
    public function home()
    {
        return view('portal.home');
    }

    /**
     * Page "Nos solutions" - Affichage automatique des services
     */
    public function solutions()
    {
        // Récupérer tous les services actifs avec leurs éléments
        $services = Service::with('items')
            ->whereHas('items', function($query) {
                $query->where('statut', 'actif');
            })
            ->orWhereDoesntHave('items')
            ->get();

        return view('portal.solutions', compact('services'));
    }

    /**
     * Page "Nos solutions" - Affichage automatique des services (route /services)
     */
    public function services()
    {
        // Récupérer tous les services actifs avec leurs éléments
        $services = Service::with('items')
            ->whereHas('items', function($query) {
                $query->where('statut', 'actif');
            })
            ->orWhereDoesntHave('items')
            ->get();

        return view('portal.services', compact('services'));
    }

    /**
     * Page de test des services
     */
    public function testServices()
    {
        // Récupérer tous les services actifs avec leurs éléments
        $services = Service::with('items')
            ->whereHas('items', function($query) {
                $query->where('statut', 'actif');
            })
            ->orWhereDoesntHave('items')
            ->get();

        return view('portal.test-services', compact('services'));
    }

    /**
     * Page de détail d'un service
     */
    public function serviceDetail(Service $service)
    {
        // Charger les items du service
        $service->load('items');
        
        return view('portal.service-detail', compact('service'));
    }
}
