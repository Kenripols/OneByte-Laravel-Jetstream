<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pet;

class OwnerPetsTable extends Component
{
    public function render()
    {
        $pets = Pet::all(); // O la query que uses

        return view('livewire.owner-pets-table', [
            'pets' => $pets
        ]);
    }
}
