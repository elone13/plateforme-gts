<?php

namespace App\Livewire\Commercial;

use Livewire\Component;

class TestDemandeDemo extends Component
{
    public $message = 'Test composant commercial';

    public function testAction()
    {
        $this->message = 'Action testée avec succès !';
        session()->flash('success', 'Action testée !');
    }

    public function render()
    {
        return view('livewire.commercial.test-demande-demo');
    }
}
