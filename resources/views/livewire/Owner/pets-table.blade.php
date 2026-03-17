<div>
    <!-- Filtros -->
    <div class="flex space-x-4 mb-4">
        <input type="text" wire:model.live="searchId" placeholder="Buscar por ID" class="border p-2" />
        <input type="text" wire:model.live="searchName" placeholder="Buscar por Nombre" class="border p-2" />
    </div>

    <div class="mb-4">
   <button type="button" wire:click="openCreateModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Agregar nueva mascota
</button>
</div>

    <!-- Tabla -->
    <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
        <thead class="bg-gray-100">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Nacimiento</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>           
        </tr>
        </thead>
       <tbody>
    @forelse ($pets as $pet)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">{{ $pet->id }}</td>

            <!-- Nombre clickeable -->
            <td class="px-6 py-4 whitespace-nowrap text-blue-600 cursor-pointer"
                wire:click="openModal({{ $pet->id }})">
                {{ $pet->name }}
            </td>

            <td class="px-6 py-4 whitespace-nowrap">
                {{ $pet->bDate?->format('d/m/Y') ?? '-' }}
            </td>

            <td class="px-6 py-4 whitespace-nowrap">
                <button wire:click="openModal({{ $pet->id }})"
                        class="text-blue-600 hover:text-blue-900">
                    Ver Detalles
                </button>
                <button type="button"
        wire:click="openEditModal({{ $pet->id }})"
        class="text-yellow-600 hover:text-yellow-800 ml-3">
    Editar
</button>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center py-4">No se encontraron mascotas</td>
        </tr>
    @endforelse
</tbody>
    </table>
    
    <div class="mt-4">
        {{ $pets->links() }}
    </div>

    @if($showModal && $selectedPet)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
                <h2 class="text-xl font-bold mb-2">{{ $selectedPet->name }}</h2>

                @if($selectedPet->photo)
                    @php
                        $photoUrl = \Illuminate\Support\Str::startsWith($selectedPet->photo, ['http://','https://','//'])
                            ? $selectedPet->photo
                            : asset('storage/' . $selectedPet->photo);
                    @endphp

                    <div class="mx-auto mb-4 w-[200px] h-[200px] sm:w-[240px] sm:h-[240px] rounded overflow-hidden shadow">
                        <img
                            src="{{ $photoUrl }}"
                            alt="Foto de {{ $selectedPet->name }}"
                            class="w-full h-full object-cover"
                            loading="lazy"
                        >
                    </div>
                @endif

                <p><strong>ID:</strong> {{ $selectedPet->id }}</p>
                <p><strong>Fecha de nacimiento:</strong> {{ $selectedPet->bDate?->format('d/m/Y') ?? '-' }}</p>
                <p><strong>Especie:</strong> {{ $selectedPet->breed?->animalType ?? 'Sin Especie' }}</p>
                <p><strong>Raza:</strong> {{ $selectedPet->breed?->breedName ?? 'Sin raza' }}</p>
                <p><strong>Estado Actual:</strong> {{ $selectedPet->currentState?->state ?? 'Sin historial de estado' }}</p>

                <button type="button"
                        wire:click="closeModal"
                        class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Cerrar
                </button>
                @if(($selectedPet->currentState?->state ?? null) !== 'FALLECIDA')
        <button type="button"
                wire:click="markAsDeceased({{ $selectedPet->id }})"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            Marcar como fallecida
        </button>
    @endif
                
            </div>
        </div>
    @endif

    @if($showCreateModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
                <h2 class="text-xl font-bold mb-4">Agregar nueva mascota</h2>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text" wire:model.defer="name" class="w-full border rounded p-2">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Fecha de nacimiento</label>
                    <input type="date" wire:model.defer="bDate" class="w-full border rounded p-2">
                    @error('bDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Raza</label>
                    <select wire:model.defer="breed_id" class="w-full border rounded p-2">
                        <option value="">Seleccione una raza</option>
                        @foreach($breeds as $breed)
                            <option value="{{ $breed->id }}">
                                {{ $breed->animalType }} - {{ $breed->breedName }}
                            </option>
                        @endforeach
                    </select>
                    @error('breed_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
    <label class="block text-sm font-medium mb-1">Foto</label>
    <input type="file" wire:model="photo" accept="image/*" class="w-full border rounded p-2">
    @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>

@if ($photo)
<div class="mx-auto mb-4 w-[200px] h-[200px] sm:w-[240px] sm:h-[240px] rounded overflow-hidden shadow">
    <img
        src="{{ $photo->temporaryUrl() }}"
        class="w-full h-full object-cover"
    >
</div>
@else
<div class="mx-auto mb-4 w-[200px] h-[200px] sm:w-[240px] sm:h-[240px] rounded bg-gray-200 flex items-center justify-center text-gray-500">
    Sin foto
</div>
@endif
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button"
                            wire:click="closeCreateModal"
                            class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                        Cancelar
                    </button>

                   <button type="button"
        wire:click="savePet"
        class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
    Guardar
</button>
                </div>
            </div>
        </div>
    @endif

    @if($showEditModal)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
        <h2 class="text-xl font-bold mb-4">Editar mascota</h2>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Nombre</label>
            <input type="text" wire:model.defer="name" class="w-full border rounded p-2">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Fecha de nacimiento</label>
            <input type="date" wire:model.defer="bDate" class="w-full border rounded p-2">
            @error('bDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Raza</label>
            <select wire:model.defer="breed_id" class="w-full border rounded p-2">
                <option value="">Seleccione una raza</option>
                @foreach($breeds as $breed)
                    <option value="{{ $breed->id }}">
                        {{ $breed->animalType }} - {{ $breed->breedName }}
                    </option>
                @endforeach
            </select>
            @error('breed_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Nueva foto (opcional)</label>
            <input type="file" wire:model="photo" accept="image/*" class="w-full border rounded p-2">
            @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        @if ($photo)
            <div class="mx-auto mb-4 w-[200px] h-[200px] sm:w-[240px] sm:h-[240px] rounded overflow-hidden shadow">
                <img
                    src="{{ $photo->temporaryUrl() }}"
                    alt="Vista previa"
                    class="w-full h-full object-cover"
                >
            </div>
        @endif

        <div class="flex justify-end space-x-2">
            <button type="button"
                    wire:click="closeEditModal"
                    class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                Cancelar
            </button>

            <button type="button"
                    wire:click="updatePet"
                    class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                Actualizar
            </button>
        </div>
    </div>
</div>
@endif
</div>
    

    
