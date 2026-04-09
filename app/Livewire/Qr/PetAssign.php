<?php

namespace App\Livewire\Qr;

use Livewire\Component;
use App\Models\Pet;
use App\Models\Breed;
use App\Models\QrPlate;





class PetAssign extends Component
{
    public $pets;
    public $breeds;

    public $selectedPetId = null;

    public $name;
    public $bDate;
    public $breed_id;
    public $showModal = false;
    protected $listeners = ['openQrModal' => 'openModal'];
    public function mount()
    {
        $this->pets = Pet::where('owner_id', auth()->id())->get();
        $this->breeds = Breed::all();
    }

    public function updatedSelectedPetId($value)
    {
        if (!$value) {
            $this->reset(['name', 'bDate', 'breed_id']);
            return;
        }

        $pet = $this->pets->find($value);

        if ($pet) {
            $this->name = $pet->name;
            $this->bDate = $pet->bDate;
            $this->breed_id = $pet->breed_id;
        }
    }

    public function save()
    {
        if ($this->selectedPetId) {
            $pet = Pet::where('id', $this->selectedPetId)
                ->where('owner_id', auth()->id())
                ->firstOrFail();
        } else {
            $pet = Pet::create([
                'user_id' => auth()->id(),
                'name' => $this->name,
                'bDate' => $this->bDate,
                'breed_id' => $this->breed_id,
            ]);
        }

        $qr = QrPlate::findOrFail(session('claimed_qr_id'));

        app(\App\Services\QrAssignmentService::class)
            ->assignToPet($qr, $pet);

        session()->forget('claimed_qr_id');

        return redirect()->route('owner.dashboard')
            ->with('success', 'QR asociado correctamente');
    }

    public function render()
    {
        return view('livewire.qr.pet-assign');
    }
    public function openModal()
        {
        $this->showModal = true;
    }
}