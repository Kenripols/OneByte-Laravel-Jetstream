<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pet;

class PetsTable extends Component
{
    use WithPagination;

    public $searchId = '';
    public $searchName = '';

    public function render()
    {
        $query = Pet::query();

        if ($this->searchId) {
            $query->where('id', $this->searchId);
        }

        if ($this->searchName) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
        }

        $pets = $query->paginate(10);

        return view('livewire.pets-table', compact('pets'));
    }
}
