<div class="max-w-xl mx-auto p-6 bg-white rounded shadow">

    <h1 class="text-xl font-bold mb-4">
        Asociar QR a mascota
    </h1>

    <!-- SELECT -->
    <div class="mb-4">
        <label class="block font-bold mb-2">Mascota</label>

        <select wire:model="selectedPetId" class="w-full border p-2 rounded">
            <option value="">-- Nueva mascota --</option>

            @foreach($pets as $pet)
                <option value="{{ $pet->id }}">
                    {{ $pet->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- FORM -->
    <div class="mb-4">
        <label>Nombre</label>
        <input type="text" wire:model="name" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label>Fecha</label>
        <input type="date" wire:model="bDate" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label>Raza</label>
        <select wire:model="breed_id" class="w-full border p-2 rounded">
            <option value="">Seleccione</option>

            @foreach($breeds as $breed)
                <option value="{{ $breed->id }}">
                    {{ $breed->breedName }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- BOTÓN -->
    <button wire:click="save"
        class="bg-blue-500 text-white px-4 py-2 rounded">
        Guardar
    </button>

</div>
@if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded">
            <!-- tu form -->
        </div>
    </div>
@endif