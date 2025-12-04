<div>
    <!-- Filtros -->
    <div class="flex space-x-4 mb-4">
        <input type="text" wire:model.live="searchId" placeholder="Buscar por ID" class="border p-2" />
        <input type="text" wire:model.live="searchName" placeholder="Buscar por Nombre" class="border p-2" />
    </div>

    <!-- Tabla -->
    <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
        <thead class="bg-gray-100">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Nacimiento</th>            
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
                {{ $pet->bDate->format('d/m/Y') }}
            </td>

            <td class="px-6 py-4 whitespace-nowrap">
                <button wire:click="openModal({{ $pet->id }})"
                        class="text-blue-600 hover:text-blue-900">
                    Ver Detalles
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
        <p><strong>ID:</strong> {{ $selectedPet->id }}</p>
        <p><strong>Fecha de nacimiento:</strong> {{ $selectedPet->bDate->format('d/m/Y') }}</p>
        <p><strong>Especie:</strong> {{ $selectedPet->breed ? $selectedPet->breed->animalType : 'Sin Especie' }}</p>
        <p><strong>Raza:</strong> {{ $selectedPet->breed ? $selectedPet->breed->breedName : 'Sin raza' }}</p>
        <p><strong>Estado Actual:</strong> 
            @php
                $latestHistory = $selectedPet->pet_state_histories()->orderBy('created_at', 'desc')->first();
            @endphp
            {{ $latestHistory ? $latestHistory->state : 'Sin historial de estado' }}
        <p><strong>Dueño:</strong>  @if($pet->owner)
                                        {{ $pet->owner->fName1 }}
                                        {{ $pet->owner->sName1 }}     
        <br><p><strong>Email:</strong>                                   
         <a href="mailto:{{ $pet->owner?->user?->email }}" class="text-blue-600 hover:underline">
            {{ $pet->owner?->user?->email ?? 'No disponible' }}
        </a>
        <br><p><strong>Teléfono:</strong>
    <a href="https://wa.me/59894971648" target="_blank" class="text-green-600 hover:underline">
preciso telefono de Owner
    </a>
</p>
            @else
                Sin dueño asignado
            @endif</p>
        <button wire:click="closeModal"
                class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
            Cerrar
        </button>
    </div>
</div>
@endif
</div>


