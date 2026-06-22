<?php

namespace App\Livewire\Qr;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pet;
use App\Models\Breed;
use App\Models\QrPlate;

class PetAssign extends Component
{
    use WithFileUploads;

    public $pets;
    public $breeds;

    public $selectedPetId = null;

    public $name;
    public $bDate;
    public $breed_id;
    public $photo;
    public $showModal = false;
    protected $listeners = ['openQrModal' => 'openModal'];
    public $qr;
    
    public function mount()
    {
        $this->pets = Pet::where('owner_id', auth()->id())->get();
        $this->breeds = Breed::all();
    }

    public function updatedSelectedPetId($value)
    {
        if (!$value) {
            $this->reset(['name', 'bDate', 'breed_id', 'photo']);
            return;
        }

        $pet = $this->pets->find($value);

        if ($pet) {
            $this->name = $pet->name;
            $this->bDate = $pet->bDate;
            $this->breed_id = $pet->breed_id;
            $this->photo = null;
        }
    }

    public function save()
    {
        if ($this->selectedPetId) {
            $pet = Pet::where('id', $this->selectedPetId)
                ->where('owner_id', auth()->id())
                ->firstOrFail();
        } else {
            $this->validate([
                'name' => 'required|string|max:255',
                'bDate' => 'nullable|date',
                'breed_id' => 'required|exists:breeds,id',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $data = [
                'owner_id' => auth()->id(),
                'name' => $this->name,
                'bDate' => $this->bDate,
                'breed_id' => $this->breed_id,
            ];

            // Manejar la foto
            if ($this->photo) {
                $data['photo'] = $this->photo->store('pets', 'public');
            }

            $pet = Pet::create($data);
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