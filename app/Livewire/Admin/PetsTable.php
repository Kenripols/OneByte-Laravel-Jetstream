<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Breed;
use App\Models\Pet;

class PetsTable extends Component
{
    use WithPagination, WithFileUploads;

    public $searchId = '';
    public $searchName = '';

    public $selectedPet = null;
    public $showModal = false;
    public $editMode = false;

    public $editingPetId = null;
    public $name = '';
    public $bDate = '';
    public $breed_id = '';
    public $photo;

    public function updatingSearchId()
    {
        $this->resetPage();
    }

    public function updatingSearchName()
    {
        $this->resetPage();
    }

    public function openModal($petId)
    {
        $pet = Pet::with(['breed', 'currentState', 'owner.user'])->findOrFail($petId);

        $this->selectedPet  = $pet;
        $this->editingPetId = $pet->id;
        $this->name         = $pet->name;
        $this->bDate        = $pet->bDate?->format('Y-m-d');
        $this->breed_id     = $pet->breed_id;
        $this->photo        = null;
        $this->editMode     = false;

        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal    = false;
        $this->selectedPet  = null;
        $this->editMode     = false;
        $this->editingPetId = null;
        $this->reset(['name', 'bDate', 'breed_id', 'photo']);
        $this->resetValidation();
    }

    public function updatePet()
    {
        $this->validate([
            'name'     => ['required', 'string', 'max:255'],
            'bDate'    => ['nullable', 'date', 'before_or_equal:today'],
            'breed_id' => ['required', 'exists:breeds,id'],
            'photo'    => ['nullable', 'image', 'max:2048'],
        ]);

        $pet = Pet::findOrFail($this->editingPetId);

        $data = [
            'name'     => $this->name,
            'bDate'    => $this->bDate ?: null,
            'breed_id' => $this->breed_id,
        ];

        if ($this->photo) {
            $data['photo'] = $this->photo->store('pets', 'public');
        }

        $pet->update($data);

        $this->closeModal();
        session()->flash('success', 'Mascota actualizada correctamente.');
    }

    public function render()
    {
        $query = Pet::with(['breed', 'owner.user']);

        if (!empty($this->searchId)) {
            $query->where('id', $this->searchId);
        }

        if (!empty($this->searchName)) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
        }

        $pets   = $query->orderBy('id')->paginate(10);
        $breeds = Breed::orderBy('breedName')->get();

        return view('livewire.admin.pets-table', compact('pets', 'breeds'));
    }
}
