<?php

namespace App\Livewire\Commercial;

use App\Models\Client;
use App\Models\Devis;
use App\Models\Service;
use App\Models\Item;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreateDevisModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $clients = [];
    public $services = [];
    
    // ÉTAPE 1: Sélection du client
    public $searchClient = '';
    public $selectedClient = null;
    
    // ÉTAPE 2: Sélection des services
    public $searchService = '';
    public $selectedServices = []; // Maintenant on peut sélectionner plusieurs services
    
    // ÉTAPE 3: Sélection des éléments de tous les services
    public $selectedItems = []; // Éléments de tous les services sélectionnés
    public $itemQuantities = [];
    public $itemRemises = [];
    public $itemDurees = []; // Durée en mois pour chaque élément (pour les abonnements)
    public $itemServices = []; // Pour savoir de quel service vient chaque élément
    
    // Configuration du devis
    public $date_validite = '';
    public $taux_tva = 18; // TVA sénégalaise
    public $conditions = '';
    public $mode_paiement = '100% à la commande par chèque au nom de GTS Afrique SARL';
    
    // Calculs automatiques
    public $total_ht = 0;
    public $total_remise = 0;
    public $total_ht_remise = 0;
    public $montant_tva = 0;
    public $total_ttc = 0;

    protected $listeners = ['openCreateDevisModal'];

    public function mount()
    {
        $this->loadData();
    }
    
    public function hydrate()
    {
        // S'assurer que les données sont chargées lors de l'hydratation
        if (empty($this->clients)) {
            $this->loadData();
        }
    }
    
    public function loadData()
    {
        $this->clients = Client::orderBy('nom_entreprise')->get();
        $this->services = Service::with('items')->get();
        $this->date_validite = now()->addDays(30)->format('Y-m-d');
    }
    
    public function refreshData()
    {
        $this->loadData();
        $this->dispatch('dataRefreshed');
    }

    public function openCreateDevisModal()
    {
        // S'assurer que les données sont chargées
        if (empty($this->clients)) {
            $this->loadData();
        }
        
        $this->showModal = true;
        $this->resetForm();
        
        // S'assurer que les données sont bien chargées après le reset
        if (empty($this->clients)) {
            $this->loadData();
        }
        
        // Initialiser les calculs
        $this->calculateTotals();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->searchClient = '';
        $this->searchService = '';
        $this->selectedClient = null;
        $this->selectedServices = [];
        $this->selectedItems = [];
        $this->itemQuantities = [];
        $this->itemRemises = [];
        $this->itemDurees = [];
        $this->itemServices = [];
        $this->date_validite = now()->addDays(30)->format('Y-m-d');
        $this->taux_tva = 18;
        $this->conditions = '';
        // Ne pas appeler calculateTotals() ici car les données ne sont pas encore chargées
    }

    // ÉTAPE 1: Recherche et sélection du client
    public function getFilteredClientsProperty()
    {
        if (empty($this->searchClient)) {
            return collect($this->clients)->take(10);
        }
        
        return collect($this->clients)->filter(function ($client) {
            $search = strtolower($this->searchClient);
            return str_contains(strtolower($client->nom_entreprise ?? ''), $search) ||
                   str_contains(strtolower($client->nom ?? ''), $search) ||
                   str_contains(strtolower($client->email ?? ''), $search);
        })->take(10);
    }

    public function selectClient($clientId)
    {
        $this->selectedClient = collect($this->clients)->firstWhere('idclient', $clientId);
        
        if ($this->selectedClient) {
            $this->searchClient = $this->selectedClient->nom_entreprise ?? $this->selectedClient->nom;
            $this->dispatch('clientSelected');
        } else {
            // Si le client n'est pas trouvé, essayer de le charger directement depuis la base
            $client = Client::find($clientId);
            if ($client) {
                $this->selectedClient = $client;
                $this->searchClient = $client->nom_entreprise ?? $client->nom;
                $this->dispatch('clientSelected');
            }
        }
    }

    // ÉTAPE 2: Recherche et sélection du service
    public function getFilteredServicesProperty()
    {
        if (empty($this->searchService)) {
            return collect($this->services)->take(10);
        }
        
        return collect($this->services)->filter(function ($service) {
            $search = strtolower($this->searchService);
            return str_contains(strtolower($service->nom), $search) ||
                   str_contains(strtolower($service->description ?? ''), $search);
        })->take(10);
    }

    // Obtenir tous les éléments de tous les services sélectionnés
    public function getAvailableItemsProperty()
    {
        $allItems = collect();
        
        if (empty($this->selectedServices)) {
            return $allItems;
        }
        
        foreach ($this->selectedServices as $serviceId) {
            $service = collect($this->services)->firstWhere('id', $serviceId);
            if ($service && $service->items) {
                foreach ($service->items as $item) {
                    $item->service_name = $service->nom; // Ajouter le nom du service à l'item
                    $allItems->push($item);
                }
            }
        }
        
        return $allItems;
    }

    public function selectService($serviceId)
    {
        $service = collect($this->services)->firstWhere('id', $serviceId);
        
        // Vérifier si le service est déjà sélectionné
        if (in_array($serviceId, $this->selectedServices)) {
            // Désélectionner le service et retirer ses éléments
            $this->selectedServices = array_diff($this->selectedServices, [$serviceId]);
            
            // Retirer tous les éléments de ce service
            foreach ($this->selectedItems as $key => $itemId) {
                if ($this->itemServices[$itemId] == $serviceId) {
                    unset($this->selectedItems[$key]);
                    unset($this->itemQuantities[$itemId]);
                    unset($this->itemRemises[$itemId]);
                    unset($this->itemDurees[$itemId]);
                    unset($this->itemServices[$itemId]);
                }
            }
            $this->selectedItems = array_values($this->selectedItems); // Réindexer
        } else {
            // Ajouter le service à la sélection
            $this->selectedServices[] = $serviceId;
            $this->searchService = ''; // Réinitialiser la recherche
        }
        
        $this->dispatch('servicesUpdated');
    }

    // ÉTAPE 3: Gestion des éléments de tous les services
    public function toggleItem($itemId, $serviceId)
    {
        if (in_array($itemId, $this->selectedItems)) {
            // Désélectionner l'élément
            $this->selectedItems = array_diff($this->selectedItems, [$itemId]);
            unset($this->itemQuantities[$itemId]);
            unset($this->itemRemises[$itemId]);
            unset($this->itemDurees[$itemId]);
            unset($this->itemServices[$itemId]);
        } else {
            // Sélectionner l'élément
            $this->selectedItems[] = $itemId;
            $this->itemQuantities[$itemId] = 1; // Quantité par défaut
            $this->itemRemises[$itemId] = 0; // Remise par défaut
            $this->itemDurees[$itemId] = 12; // Durée par défaut (12 mois)
            $this->itemServices[$itemId] = $serviceId; // Associer l'élément à son service
        }
        $this->calculateTotals();
    }

    // Sélectionner/désélectionner tous les éléments d'un service
    public function toggleAllItemsOfService($serviceId)
    {
        $service = collect($this->services)->firstWhere('id', $serviceId);
        $serviceItems = $service->items->pluck('iditem')->toArray();
        
        // Vérifier si tous les éléments de ce service sont sélectionnés
        $allSelected = true;
        foreach ($serviceItems as $itemId) {
            if (!in_array($itemId, $this->selectedItems)) {
                $allSelected = false;
                break;
            }
        }
        
        if ($allSelected) {
            // Désélectionner tous les éléments de ce service
            foreach ($serviceItems as $itemId) {
                $this->selectedItems = array_diff($this->selectedItems, [$itemId]);
                unset($this->itemQuantities[$itemId]);
                unset($this->itemRemises[$itemId]);
                unset($this->itemDurees[$itemId]);
                unset($this->itemServices[$itemId]);
            }
        } else {
            // Sélectionner tous les éléments de ce service
            foreach ($serviceItems as $itemId) {
                if (!in_array($itemId, $this->selectedItems)) {
                    $this->selectedItems[] = $itemId;
                    $this->itemQuantities[$itemId] = 1;
                    $this->itemRemises[$itemId] = 0;
                    $this->itemDurees[$itemId] = 12; // Durée par défaut (12 mois)
                    $this->itemServices[$itemId] = $serviceId;
                }
            }
        }
        
        $this->selectedItems = array_values($this->selectedItems); // Réindexer
        $this->calculateTotals();
    }

    public function updateItemQuantity($itemId, $quantity)
    {
        $this->itemQuantities[$itemId] = max(1, intval($quantity));
        $this->calculateTotals();
    }

    public function updateItemRemise($itemId, $remise)
    {
        // S'assurer que la remise est un nombre valide
        $remise = floatval($remise);
        if ($remise < 0 || $remise > 100) {
            $remise = 0; // Valeur par défaut si invalide
        }
        $this->itemRemises[$itemId] = $remise;
        $this->calculateTotals();
    }

    public function updateItemDuree($itemId, $duree)
    {
        // S'assurer que la durée est un nombre valide
        $duree = max(1, intval($duree)); // Minimum 1 mois
        $this->itemDurees[$itemId] = $duree;
        $this->calculateTotals();
    }

    // Calculs automatiques comme dans le devis GTS AFRIQUE
    public function calculateTotals()
    {
        $this->total_ht = 0;
        $this->total_remise = 0;
        
        if (!empty($this->selectedItems)) {
            foreach ($this->selectedItems as $itemId) {
                // Trouver le service de cet élément
                $serviceId = $this->itemServices[$itemId] ?? null;
                if ($serviceId) {
                    $service = collect($this->services)->firstWhere('id', $serviceId);
                    if ($service) {
                        $item = $service->items->firstWhere('iditem', $itemId);
                        if ($item) {
                            $quantite = $this->itemQuantities[$itemId] ?? 1;
                            $remise = $this->itemRemises[$itemId] ?? 0;
                            $duree = $this->itemDurees[$itemId] ?? 12; // Durée par défaut
                            $prix_unitaire = floatval($item->prix);
                            
                            // Total HT de l'élément (prix * quantité * durée)
                            $total_element = $prix_unitaire * $quantite * $duree;
                            
                            // Remise sur l'élément
                            $remise_element = $total_element * (floatval($remise) / 100);
                            
                            $this->total_ht += $total_element;
                            $this->total_remise += $remise_element;
                        }
                    }
                }
            }
        }
        
        // S'assurer que taux_tva est un nombre valide
        $taux_tva = floatval($this->taux_tva);
        if ($taux_tva <= 0 || $taux_tva > 100) {
            $taux_tva = 18; // Valeur par défaut si invalide
            $this->taux_tva = $taux_tva;
        }
        
        // Calculs comme dans le devis GTS AFRIQUE
        $this->total_ht_remise = $this->total_ht - $this->total_remise;
        $this->montant_tva = $this->total_ht_remise * ($taux_tva / 100);
        $this->total_ttc = $this->total_ht_remise + $this->montant_tva;
    }

    // Créer le devis avec la structure GTS AFRIQUE
    public function createDevis()
    {
        // Validation
        $validator = Validator::make([
            'selectedClient' => $this->selectedClient,
            'selectedServices' => $this->selectedServices,
            'selectedItems' => $this->selectedItems,
            'date_validite' => $this->date_validite,
        ], [
            'selectedClient' => 'required',
            'selectedServices' => 'required|array|min:1',
            'selectedItems' => 'required|array|min:1',
            'date_validite' => 'required|date|after:today',
        ]);

        if ($validator->fails()) {
            $this->addError('validation', $validator->errors()->first());
            return;
        }

        try {
            DB::beginTransaction();

            // Créer le devis avec la structure GTS AFRIQUE
            $devis = Devis::create([
                'reference' => $this->generateReference(),
                'date' => now(),
                'client_idclient' => $this->selectedClient->idclient,
                'statut' => 'en_attente',
                'date_validite' => $this->date_validite,
                'conditions' => $this->conditions,
                'total_ht' => $this->total_ht,
                'total_remise' => $this->total_remise,
                'total_ht_remise' => $this->total_ht_remise,
                'taux_tva' => floatval($this->taux_tva) / 100,
                'montant_tva' => $this->montant_tva,
                'total_ttc' => $this->total_ttc,
                'montant_total' => $this->total_ttc,
            ]);

            // Créer les items du devis avec quantités et remises
            foreach ($this->selectedItems as $itemId) {
                $serviceId = $this->itemServices[$itemId] ?? null;
                if ($serviceId) {
                    $service = collect($this->services)->firstWhere('id', $serviceId);
                    if ($service) {
                        $item = $service->items->firstWhere('iditem', $itemId);
                        if ($item) {
                            $quantite = $this->itemQuantities[$itemId] ?? 1;
                            $remise = $this->itemRemises[$itemId] ?? 0;
                            $duree = $this->itemDurees[$itemId] ?? 12; // Durée par défaut
                            $prix_unitaire = floatval($item->prix);
                            
                            Item::create([
                                'nom' => $item->nom,
                                'quantite' => $quantite,
                                'prix' => $prix_unitaire,
                                'devis_id' => $devis->id,
                                'service_id' => $serviceId,
                                'description' => $item->description ?? $item->nom,
                                'remise' => $remise,
                                'duree_mois' => $duree, // Ajouter la durée en mois
                                'statut' => 'actif',
                                'avancement' => 0,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            $this->closeModal();
            $this->dispatch('devisCreated', $devis->id);
            session()->flash('success', 'Devis créé avec succès ! Le PDF sera généré automatiquement.');
            
            // Rediriger vers la page de détail du devis
            return redirect()->route('commercial.devis.show', $devis);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('error', 'Erreur lors de la création du devis : ' . $e->getMessage());
        }
    }

    // Générer une référence de devis comme GTS AFRIQUE
    private function generateReference()
    {
        $prefix = 'CT';
        $year = date('Y');
        $month = date('m');
        $sequence = Devis::whereYear('date', $year)
                        ->whereMonth('date', $month)
                        ->count() + 1;
        
        return sprintf('%s %03d-%s-%s', $prefix, $sequence, $month, $year);
    }

    public function render()
    {
        return view('livewire.commercial.create-devis-modal');
    }
}

