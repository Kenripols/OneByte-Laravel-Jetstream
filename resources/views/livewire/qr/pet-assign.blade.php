<div class="max-w-xl mx-auto p-6 bg-white rounded shadow">

    <h1 class="text-xl font-bold mb-4">
        Asociar QR a mascota
    </h1>

    {{-- CONTEXTO QR --}}
    @if($qr)
        <div class="mb-4 text-sm text-gray-600 bg-gray-100 p-3 rounded">
            QR: <strong>{{ $qr->uuid }}</strong>
        </div>
    @endif

    <!-- SELECT MASCOTA -->
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

    <!-- SI SELECCIONO UNA MASCOTA -->
    @if($selectedPetId)
        <div class="mb-4 p-3 bg-gray-100 rounded">
            Asociando a:
            <strong>
                {{ $pets->firstWhere('id', $selectedPetId)?->name }}
            </strong>
        </div>
    @endif

    <!-- FORM SOLO SI ES NUEVA -->
    @if(!$selectedPetId)

        <div class="mb-4">
            <label class="block mb-1">Nombre</label>
            <input type="text" wire:model="name" class="w-full border p-2 rounded">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Fecha de nacimiento</label>
            <input type="date" wire:model="bDate" class="w-full border p-2 rounded">
            @error('bDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Raza</label>
            <select wire:model="breed_id" class="w-full border p-2 rounded">
                <option value="">Seleccione</option>

                @foreach($breeds as $breed)
                    <option value="{{ $breed->id }}">
                        {{ $breed->breedName }}
                    </option>
                @endforeach
            </select>
            @error('breed_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

    @endif

    <!-- BOTÓN -->
    <div class="flex justify-end">
        <button wire:click="save"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
            {{ $selectedPetId ? 'Asociar a mascota' : 'Crear y asociar' }}
        </button>
    </div>

</div>