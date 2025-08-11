<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;
use App\Models\Service;

class ItemManager extends Component
{
    public $service;
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    
    // Champs pour création/édition
    public $nom;
    public $description;
    public $prix;
    public $quantite = 1;
    public $statut = 'actif';
    
    // Élément en cours d'édition/suppression
    public $editingItem;
    public $deletingItem;
    
    protected $rules = [
        'nom' => 'required|string|max:255',
        'description' => 'required|string',
        'prix' => 'nullable|numeric|min:0',
        'quantite' => 'required|integer|min:1',
        'statut' => 'required|in:actif,inactif',
    ];

    public function mount(Service $service)
    {
        $this->service = $service;
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function openEditModal(Item $item)
    {
        $this->editingItem = $item;
        $this->nom = $item->nom;
        $this->description = $item->description;
        $this->prix = $item->prix;
        $this->quantite = $item->quantite;
        $this->statut = $item->statut;
        $this->showEditModal = true;
    }

    public function openDeleteModal(Item $item)
    {
        $this->deletingItem = $item;
        $this->showDeleteModal = true;
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->nom = '';
        $this->description = '';
        $this->prix = '';
        $this->quantite = 1;
        $this->statut = 'actif';
        $this->editingItem = null;
        $this->deletingItem = null;
    }

    public function createItem()
    {
        $this->validate();

        $this->service->items()->create([
            'nom' => $this->nom,
            'description' => $this->description,
            'prix' => $this->prix,
            'quantite' => $this->quantite,
            'statut' => $this->statut,
        ]);

        $this->closeModals();
        session()->flash('message', 'Élément créé avec succès !');
    }

    public function updateItem()
    {
        $this->validate();

        if ($this->editingItem) {
            $this->editingItem->update([
                'nom' => $this->nom,
                'description' => $this->description,
                'prix' => $this->prix,
                'quantite' => $this->quantite,
                'statut' => $this->statut,
            ]);
        }

        $this->closeModals();
        session()->flash('message', 'Élément mis à jour avec succès !');
    }

    public function deleteItem()
    {
        if ($this->deletingItem) {
            $this->deletingItem->delete();
        }

        $this->closeModals();
        session()->flash('message', 'Élément supprimé avec succès !');
    }

    public function render()
    {
        return view('livewire.item-manager');
    }
}
