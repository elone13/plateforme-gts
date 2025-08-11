<?php

namespace App\Livewire\Manager;

use App\Models\Service;
use Livewire\Component;

class ViewServiceModal extends Component
{
    public $showModal = false;
    public $serviceId = null;
    public $service = null;

    protected $listeners = ['open-view-service-modal' => 'openModal'];

    public function openModal($serviceId)
    {
        $this->serviceId = $serviceId;
        $this->service = Service::with('items')->find($serviceId);
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
    }

    public function render()
    {
        return view('livewire.manager.view-service-modal');
    }
}
