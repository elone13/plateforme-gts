<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Http\Livewire\ItemManager;
use App\Livewire\Commercial\CreateDevisModal;
use App\Livewire\Commercial\DevisList;
use App\Livewire\Commercial\DevisActions;

class LivewireServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Livewire::component('item-manager', ItemManager::class);
        Livewire::component('commercial.create-devis-modal', CreateDevisModal::class);
        Livewire::component('commercial.devis-list', DevisList::class);
        Livewire::component('commercial.devis-actions', DevisActions::class);
    }
}
