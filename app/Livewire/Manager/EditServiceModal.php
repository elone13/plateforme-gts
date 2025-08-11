<?php

namespace App\Livewire\Manager;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditServiceModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $serviceId = null;
    public $service = null;
    public $nom = '';
    public $description = '';
    public $image;
    public $currentImage = '';

    protected $listeners = ['open-edit-service-modal' => 'openModal'];

    protected $rules = [
        'nom' => 'required|string|max:255',
        'description' => 'required|string|min:10|max:1000',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ];

    protected $messages = [
        'nom.required' => 'Le nom du service est requis.',
        'description.required' => 'La description est requise.',
        'description.min' => 'La description doit contenir au moins 10 caractères.',
        'image.image' => 'Le fichier doit être une image.',
        'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou GIF.',
        'image.max' => 'L\'image ne doit pas dépasser 2MB.'
    ];

    public function openModal($serviceId)
    {
        $this->serviceId = $serviceId;
        $this->service = Service::find($serviceId);
        
        if ($this->service) {
            $this->nom = $this->service->nom;
            $this->description = $this->service->description;
            $this->currentImage = $this->service->image;
        }
        
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->serviceId = null;
        $this->service = null;
        $this->nom = '';
        $this->description = '';
        $this->image = null;
        $this->currentImage = '';
        $this->resetErrorBag();
    }

    public function updateService()
    {
        $this->validate([
            'nom' => 'required|string|max:255|unique:services,nom,' . $this->serviceId,
            'description' => 'required|string|min:10|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'nom' => $this->nom,
            'description' => $this->description,
        ];

        // Gestion de l'image
        if ($this->image) {
            // Supprimer l'ancienne image si elle existe
            if ($this->currentImage && Storage::disk('public')->exists($this->currentImage)) {
                Storage::disk('public')->delete($this->currentImage);
            }
            
            $imagePath = $this->image->store('services', 'public');
            $data['image'] = $imagePath;
        }

        $this->service->update($data);

        $this->closeModal();
        
        // Émettre un événement pour rafraîchir la liste
        $this->dispatch('service-updated');
        
        // Message de succès
        session()->flash('success', 'Service modifié avec succès !');
    }

    public function render()
    {
        return view('livewire.manager.edit-service-modal');
    }
}
