<?php

namespace App\Livewire\Manager;

use App\Models\Service;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class DeleteServiceModal extends Component
{
    public $showModal = false;
    public $serviceId = null;
    public $serviceName = '';

    protected $listeners = ['open-delete-service-modal' => 'openModal'];

    public function openModal($data)
    {
        $this->serviceId = $data['serviceId'];
        $this->serviceName = $data['serviceName'];
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
        $this->serviceName = '';
    }

    public function deleteService()
    {
        $service = Service::find($this->serviceId);
        
        if ($service) {
            // Supprimer l'image si elle existe
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
            
            $service->delete();
            
            $this->closeModal();
            
            // Émettre un événement pour rafraîchir la liste
            $this->dispatch('service-deleted');
            
            // Message de succès
            session()->flash('success', 'Service supprimé avec succès !');
        }
    }

    public function render()
    {
        return view('livewire.manager.delete-service-modal');
    }
}
