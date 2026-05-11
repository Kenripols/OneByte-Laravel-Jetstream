<?php

namespace App\Livewire\Owner;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Pet;
use App\Models\Breed;
use App\Models\PetStateHistory;
use App\Models\Reading;
use App\Models\Post;

class PetsTable extends Component
{
   use WithPagination, WithFileUploads;

    public $searchId = '';
    public $searchName = '';
    public $selectedPet = null;
    public $showModal = false;
    //agrego variables para el modal de creación de mascota
    public $showCreateModal = false;
    public $name = '';
    public $bDate = '';
    public $breed_id = '';
    public $photo;
    public $showEditModal = false;
    public $editingPetId = null;
    public $editMode =false;
    public $readings = [];

    public $selectedPetIdForReadings = null;

    public $points = []; // para el mapa

    /** Solo true cuando se abre el modal desde «Historial / Ubicaciones» (incluye mapa). */
    public $showReadingsMap = false;

    // Modal de confirmación para marcar como perdida
    public $showLostConfirmModal = false;
    public $petIdToMarkLost = null;
    public $petNameToMarkLost = '';
    public $descriptionLost = '';
    public $showDescriptionForm = false;
    
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
    public function openModal($petId)
{
    $pet = Pet::with(['breed', 'currentStateModel', 'owner.user'])
        ->findOrFail($petId);

    $this->selectedPet = $pet;

    $this->name = $pet->name;
    $this->bDate = $pet->bDate?->format('Y-m-d');
    $this->breed_id = $pet->breed_id;

    $this->editMode = false;

    $this->readings = [];
    $this->showReadingsMap = false;

    $this->showModal = true;
}
    // cerrar modal
    public function closeModal()
{
    $this->showModal = false;
    $this->selectedPet = null;
    $this->editMode = false;
    $this->readings = [];
    $this->showReadingsMap = false;
}
//Modal de crear mascota
    public function openCreateModal()
    {
        $this->closeModal();
        $this->closeEditModal();
        $this->resetCreateForm();
        $this->showCreateModal = true;
    }

     public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetCreateForm();
    }
//Modal para editar mascota
    public function openEditModal($petId)
{
    $this->closeModal();
    $this->closeCreateModal();

    $pet = Pet::with(['breed', 'owner.user'])
        ->findOrFail($petId);

    abort_unless(Auth::user()->can('update', $pet), 403);

    $this->editingPetId = $pet->id;
    $this->name = $pet->name;
    $this->bDate = $pet->bDate ? $pet->bDate->format('Y-m-d') : '';
    $this->breed_id = $pet->breed_id;
    $this->photo = null; // importante: no cargar string vieja en input file
    $this->resetValidation();

    $this->showEditModal = true;
}

public function closeEditModal()
{
    $this->showEditModal = false;
    $this->editingPetId = null;
    $this->resetCreateForm();
}
//Actualizar datos de mascota y foto
public function updatePet()
{
    $pet = Pet::findOrFail($this->editingPetId);

    abort_unless(Auth::user()->can('update', $pet), 403);

    $data = $this->validate($this->updateRules());

    $updateData = [
        'name' => $data['name'],
        'bDate' => $data['bDate'] ?: null,
        'breed_id' => $data['breed_id'],
    ];

    if ($this->photo) {
        $updateData['photo'] = $this->photo->store('pets', 'public');
    }

    $pet->update($updateData);

    $this->closeEditModal();
    session()->flash('success', 'Mascota actualizada correctamente.');
}
//Reglas para validar el formulario de creación de mascota
    protected function createRules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'bDate' => ['nullable', 'date'],
            'breed_id' => ['required', 'exists:breeds,id'],
            'photo' => ['required', 'image', 'max:2048'],
        ];
    }
//Reglas para validar el formulario de edición de mascota la foto no es obligatoria ya que se puede mantener la misma
    protected function updateRules()
{
    return [
        'name' => ['required', 'string', 'max:255'],
        'bDate' => ['nullable', 'date'],
        'breed_id' => ['required', 'exists:breeds,id'],
        'photo' => ['nullable', 'image', 'max:2048'],
    ];
}
//Chequeo que el usuario tenga permisos para crear mascotas, sino error 403
    protected function authorizeCreate()
    {
        abort_unless(Auth::user()->can('create', Pet::class), 403);
    }

    protected function resetCreateForm()
    {
        $this->reset(['name', 'bDate', 'breed_id', 'photo']);
        $this->resetValidation();
    }
// Guardo la mascota
    public function savePet()
    {
        $this->authorizeCreate();

        $data = $this->validate($this->createRules());
        $photoPath = $this->photo->store('pets', 'public');
        $pet =Pet::create([
            'name' => $data['name'],
            'bDate' => $data['bDate'] ?: null,
            'breed_id' => $data['breed_id'],
            'owner_id' => Auth::id(),
            'photo' => $photoPath,
        ]);

        PetStateHistory::create([
        'pet_id' => $pet->id,
        'state' => 'NORMAL',
        'started_at' => now(),
        'ended_at' => null,
    ]);

        $this->closeCreateModal();
        session()->flash('success', 'Mascota creada correctamente.');
    }

    public function markAsDeceased($petId)
    {
        $pet = Pet::with('currentStateModel')->findOrFail($petId);
        abort_unless(Auth::user()->can('update', $pet), 403);
        if ($pet->currentStateModel) {
            $pet->currentStateModel->update([
                'ended_at' => now(),
            ]);
    }

    PetStateHistory::create([
        'pet_id' => $pet->id,
        'state' => 'FALLECIDA',
        'started_at' => now(),
        'ended_at' => null,
    ]);

    if ($this->selectedPet && $this->selectedPet->id === $pet->id) {
$this->selectedPet = Pet::with(['breed', 'currentStateModel', 'owner.user'])->find($pet->id);
    }

    session()->flash('success', 'La mascota fue marcada como fallecida.');
}
// Marco la mascota como perdida - Abre modal de confirmación
    // Nota: el método no puede llamarse igual que la propiedad $showLostConfirmModal (Livewire).
    public function openLostConfirmModal($petId)
    {
        $pet = Pet::findOrFail($petId);
        abort_unless(Auth::user()->can('update', $pet), 403);

        $this->petIdToMarkLost = $petId;
        $this->petNameToMarkLost = $pet->name;
        $this->descriptionLost = '';
        $this->showDescriptionForm = false;
        $this->showLostConfirmModal = true;
    }

//Cerrar modal de confirmación
public function closeLostConfirmModal()
{
    $this->showLostConfirmModal = false;
    $this->petIdToMarkLost = null;
    $this->petNameToMarkLost = '';
    $this->descriptionLost = '';
    $this->showDescriptionForm = false;
    $this->resetValidation();
}

//Marcar como perdida SIN publicar
public function markAsLostWithoutPost()
{
    $pet = Pet::with('currentStateModel')->findOrFail($this->petIdToMarkLost);
    abort_unless(Auth::user()->can('update', $pet), 403);

    if ($pet->currentStateModel) {
        $pet->currentStateModel->update([
            'ended_at' => now(),
        ]);
    }

    PetStateHistory::create([
        'pet_id' => $pet->id,
        'state' => \App\Enums\PetState::LOST,
        'started_at' => now(),
        'ended_at' => null,
    ]);

    $this->closeLostConfirmModal();
    session()->flash('success', 'La mascota fue marcada como perdida.');
}

//Marcar como perdida Y publicar alerta
public function markAsLostWithPost()
{
    $this->validate([
        'descriptionLost' => ['required', 'string', 'max:80'],
    ]);

    $pet = Pet::with('currentStateModel')->findOrFail($this->petIdToMarkLost);
    abort_unless(Auth::user()->can('update', $pet), 403);

    if ($pet->currentStateModel) {
        $pet->currentStateModel->update([
            'ended_at' => now(),
        ]);
    }

    PetStateHistory::create([
        'pet_id' => $pet->id,
        'state' => \App\Enums\PetState::LOST,
        'started_at' => now(),
        'ended_at' => null,
    ]);

    Post::create([
        'pet_id' => $pet->id,
        'title' => $this->descriptionLost,
        'type' => 'lost',
        'image' => null,
        'is_active' => true,
        'publish_at' => now(),
    ]);

    $this->closeLostConfirmModal();
    session()->flash('success', 'La mascota fue marcada como perdida y la alerta fue publicada.');
}

public function markAsLost($petId)
{
    $this->openLostConfirmModal($petId);
}

//Marco la mascota como encontrada
public function markAsFound($petId)
{
    $pet = Pet::with('currentStateModel')->findOrFail($petId);

    abort_unless(Auth::user()->can('update', $pet), 403);

    if ($pet->currentStateModel) {
        $pet->currentStateModel->update([
            'ended_at' => now(),
        ]);
    }

    PetStateHistory::create([
        'pet_id' => $pet->id,
        'state' => \App\Enums\PetState::NORMAL,
        'started_at' => now(),
        'ended_at' => null,
    ]);

    // Desactivar posts de tipo 'lost' cuando la mascota se marca como encontrada
    Post::where('pet_id', $petId)
        ->where('type', 'lost')
        ->update(['is_active' => false]);

    session()->flash('success', 'La mascota fue marcada como encontrada.');
}

    // esta funcion realiza una consulta cada vez que se escribe, usando el dato que se escribe, si se escriben ambos, cuenta como AND de los 2 datos
    // la busqueda de nombre es parcial (LIKE), pero la de ID es exacta, si se escribe 1, no encuentra 10 ni 501, solo 1
    // Solo muestra mascotas del owner autenticado
    public function render()
    {
       $ownerId = Auth::id(); // el owner_id en pets es el id del usuario autenticado

        $query = Pet::with(['breed', 'owner'])->where('owner_id', $ownerId); 

        if (!empty($this->searchId)) {
            $query->where('id', $this->searchId);
        }

        if (!empty($this->searchName)) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
        }

        $pets = $query->orderBy('id')->paginate(10);

        $breeds = Breed::orderBy('animalType')->get();

        return view('livewire.owner.pets-table', compact('pets', 'breeds'));
    }


    public function showReadings($petId)
    {
        logger("CLICK showReadings: " . $petId);

        // Cargar mascota (igual que openModal)
        $pet = Pet::with(['breed', 'currentStateModel', 'owner.user'])
            ->findOrFail($petId);

        $this->selectedPet = $pet;

        $this->name = $pet->name;
        $this->bDate = $pet->bDate?->format('Y-m-d');
        $this->breed_id = $pet->breed_id;

        $this->editMode = false;
        $this->showReadingsMap = true;

        $this->showModal = true;

        // Traer lecturas
        $readings = Reading::with('messages')
        ->whereHas('qrPlate', function ($q) use ($petId) {
        $q->where('pet_id', $petId);
        })
        ->orderBy('created_at')
        ->get();

        $this->readings = $readings->map(function ($r) {
            return [
                'created_at' => $r->created_at->toDateTimeString(),
                'lat' => $r->lat,
                'lng' => $r->lng,
            ];
        })->values()->all();

        $points = $readings->map(function ($r) {
            $message = $r->messages->first();
            return [
                'lat' => $r->lat,
                'lng' => $r->lng,
                'time' => $r->created_at->toDateTimeString(),

                'message' => $message?->message,
                'photo' => $message?->photo_path,
                'seen' => $message?->seen,
            ];
        })->values()->toArray();

logger("POINTS:", $points);
        //  Esperar a que el modal exista en el DOM
        $this->dispatch('show-map', points: $points);
    }
}