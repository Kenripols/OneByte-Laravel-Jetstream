<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pet;

class PetsTable extends Component
{
    use WithPagination;

    public $searchId = '';
    public $searchName = '';

    public $selectedPet = null;
    public $showModal = false;
// los updating funcionan para resetear en la medida que se va escribiendo
    public function updatingSearchId()
    {
        $this->resetPage();
    }

    public function updatingSearchName()
    {
        $this->resetPage();
    }
// esta funcion abre el modal, se la llama cuando se hace clic en el nombre de la mascota 
//Modal se actualiza cada vez que se abre 
    public function openModal($petId)
{
    $this->reset('selectedPet');

    $this->selectedPet = Pet::with(['breed', 'currentState', 'owner.user'])
        ->findOrFail($petId);

    $this->showModal = true;
}
// cerrar modal
    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedPet = null;
    }
// esta funcion realiza una consulta cada vez que se escribe, usando el datoq que se escribe, si se escriben ambos, cuenta como AND de los 2 datos
//la busqueda de nombre es parcial (LIKE), pero la de ID es exacta, si se escribe 1, no encuentra 10 ni 501, solo 1
    public function render()
    {
        $query = Pet::with(['breed', 'owner.user']);

        if (!empty($this->searchId)) {
            $query->where('id', $this->searchId);
        }

        if (!empty($this->searchName)) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
        }

        $pets = $query->orderBy('id')->paginate(10);

        return view('livewire.admin.pets-table', compact('pets'));
    }
}
