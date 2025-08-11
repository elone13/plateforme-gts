<?php

namespace App\Livewire;

use Livewire\Component;

class SolutionsCarousel extends Component
{
    public $isManualScrolling = false;
    public $scrollPosition = 0;
    public $isPaused = false;

    public function render()
    {
        return view('livewire.solutions-carousel');
    }

    public function startManualScroll()
    {
        $this->isManualScrolling = true;
        $this->isPaused = true;
        $this->dispatch('carousel-paused');
    }

    public function stopManualScroll()
    {
        $this->isManualScrolling = false;
        
        // Réinitialiser la position et reprendre l'animation après 2 secondes
        $this->dispatch('carousel-reset-position');
        $this->dispatch('carousel-resume-delayed');
    }

    public function updateScrollPosition($position)
    {
        $this->scrollPosition = $position;
    }

    public function pauseAnimation()
    {
        $this->isPaused = true;
        $this->dispatch('carousel-paused');
    }

    public function resumeAnimation()
    {
        $this->isPaused = false;
        $this->dispatch('carousel-resume');
    }

    public function resetCarouselPosition()
    {
        $this->dispatch('carousel-reset-position');
    }
}
