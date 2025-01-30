<?php

namespace App\Livewire;

use Livewire\Component;

class FunFact extends Component
{
    public string $funFact;

    public function mount()
    {
        $this->getFunFact();
    }

    public function getFunFact()
    {
        $this->funFact = \App\Services\FunFactService::getFunFact();
        $this->render();
    }

    public function render()
    {
        return view('livewire.fun-fact');
    }
}
