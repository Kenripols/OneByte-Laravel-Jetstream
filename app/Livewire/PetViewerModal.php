<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Pet;

class PetViewerModal extends Component
{
    public $showModal = false;
    public $pet = null;

    #[On('openPetModal')]
    public function openPetModal($petId)
    {
        $this->pet = Pet::with([
            'breed',
            'owner.user',
            'currentState',
            'qrPlate.lastReading',
        ])->findOrFail($petId);

        $this->showModal = true;
    }

    public function closePetModal()
    {
        $this->showModal = false;
        $this->pet = null;
    }

    public function render()
    {
        return view('livewire.pet-viewer-modal');
    }
}
