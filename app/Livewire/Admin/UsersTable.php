<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Livewire\PetViewerModal;

class UsersTable extends Component
{
    use WithPagination;
// Variables para el modal de edición
    public $showEditModal = false;
    public $editingUserId = null;
    public $editDocType = '';
    public $editDocNum = '';
    public $editEmail = '';
    public $editPhone = '';
    public $editFName1 = '';
    public $editFName2 = '';
    public $editSName1 = '';
    public $editSName2 = '';
// Variables para búsqueda
    public $searchId = '';
    public $searchEmail = '';
// Variable para el modal de ver datos
    public $selectedUser = null;
    public $showModal = false;
// Variable para eliminar usuario, se la asigna el id del usuario a eliminar cuando se hace clic en el botón eliminar, y se muestra un modal de confirmación
    public $deleteUserId = null;
    public $showDeleteModal = false;
    public $deleteUserEmail = '';
// los updating funcionan para resetear en la medida que se va escribiendo
    public function updatingSearchId()
    {
        $this->resetPage();
    }

    public function updatingSearchEmail()
    {
        $this->resetPage();
    }
// esta funcion abre el modal para visualizar datos de usuario, se la llama cuando se hace clic en el nombre del usuario
//Modal se actualiza cada vez que se abre 
    public function openModal($userId)
{
    $this->reset('selectedUser');

    $this->selectedUser = User::with(['owner.user',
    'owner.pets.breed',
    'owner.pets.currentState',
    'owner.pets.qrPlate',])->findOrFail($userId);

    $this->showModal = true;
}
// cerrar modal
    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedUser = null;
    }

// esta función abre el modal de edición, se la llama cuando se hace clic en el botón editar, se carga la información del usuario a editar en las variables correspondientes para mostrarla en el modal
public function openEditModal($userId)
{
    $user = User::with('owner')->findOrFail($userId);

    $this->editingUserId = $user->id;
    $this->editEmail = $user->email;
    $this->editPhone = $user->phone;

    $this->editDocType = (string) ($user->owner?->docType ?? '');
    $this->editDocNum = (string) ($user->owner?->docNum ?? '');
    $this->editFName1 = $user->owner?->fName1 ?? '';
    $this->editFName2 = $user->owner?->fName2 ?? '';
    $this->editSName1 = $user->owner?->sName1 ?? '';
    $this->editSName2 = $user->owner?->sName2 ?? '';

    $this->showEditModal = true;
}

public function closeEditModal()
{
    $this->showEditModal = false;
    $this->editingUserId = null;
}

// Función para actualizar datos de usuario (Botón guardar)
public function updateUser()
{
    $this->validate([
        'editEmail' => 'required|email',
        'editPhone' => 'nullable|string|max:30', // Falta agregar el teléfono a la BD, por eso es nullable
        'editFName1' => 'required|string|max:255',
        'editFName2' => 'nullable|string|max:255',
        'editSName1' => 'required|string|max:255',
        'editSName2' => 'nullable|string|max:255',
        'editDocType' => 'required|integer|in:1,2',
        'editDocNum' => 'required|numeric',
    ]);

    $user = User::with('owner')->findOrFail($this->editingUserId);

    $user->update([
        'email' => $this->editEmail, // Al actualizar el mail tambien debería llegar una nueva verificación?
        'phone' => $this->editPhone, // Lo mismo con el teléfono, si se cambia, debería llegar una verificación?
    ]);

    if ($user->owner) {
        $user->owner->update([
            'fName1' => $this->editFName1,
            'fName2' => $this->editFName2,
            'sName1' => $this->editSName1,
            'sName2' => $this->editSName2,
            'docType' => (int) $this->editDocType,
            'docNum' => (int) $this->editDocNum,
        ]);
    }

    $this->closeEditModal();

    session()->flash('message', 'Usuario actualizado correctamente.');
}
// Función para abrir el modal de eliminación, se la llama cuando se hace clic en el botón eliminar, se asigna el id del usuario a eliminar a la variable deleteUserId y se muestra un modal de confirmación
public function openDeleteModal($userId)
{
    $user = User::findOrFail($userId);

    $this->deleteUserId = $user->id;
    $this->deleteUserEmail = $user->email;

    $this->showDeleteModal = true;
}
public function closeDeleteModal()
{
    $this->showDeleteModal = false;
    $this->deleteUserId = null;
}

public function deleteUser()
{
    $user = User::findOrFail($this->deleteUserId);

    $user->delete(); // soft delete

    $this->closeDeleteModal();

    session()->flash('message', 'Usuario eliminado (borrado lógico).');
}

// esta función se llama desde el modal de usuario para abrir el modal de la mascota, se cierra el modal de usuario y se dispara un evento para abrir el modal de la mascota con el id de la mascota a mostrar
public function openPetFromUser($petId)
{
    $this->closeModal(); // cerrar modal de usuario

    $this->dispatch('openPetModal', petId: $petId)->to(PetViewerModal::class);
}

// esta funcion realiza una consulta cada vez que se escribe, usando el datoq que se escribe, si se escriben ambos, cuenta como AND de los 2 datos
//la busqueda de nombre es parcial (LIKE), pero la de ID es exacta, si se escribe 1, no encuentra 10 ni 501, solo 1
    public function render()
    {
        $query = User::with(['owner.user']);

        if (!empty($this->searchId)) {
            $query->where('id', $this->searchId);
        }

        if (!empty($this->searchEmail)) {
            $query->where('email', 'like', '%' . $this->searchEmail . '%');
        }

        $users = $query->orderBy('id')->paginate(10);

        return view('livewire.admin.users-table', compact('users'));
    }
}
