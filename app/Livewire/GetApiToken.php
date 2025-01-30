<?php

namespace App\Livewire;

use Livewire\Component;

class GetApiToken extends Component
{
    public function getApiToken()
    {
        $user = auth()->user();
        $token = $user->createToken('api-token')->plainTextToken;

        session()->flash('api-token', $token);
    }

    public function render()
    {
        return view('livewire.get-api-token');
    }
}
