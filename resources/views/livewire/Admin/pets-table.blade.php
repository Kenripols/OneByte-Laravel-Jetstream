<div>
    <!-- Filtros -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div class="flex flex-wrap gap-3">
            <input
                type="text"
                wire:model.live="searchId"
                placeholder="ID"
                class="w-full sm:w-24 rounded-xl border border-gray-300 px-3 py-2
                    focus:ring-1 focus:ring-[#000066] focus:border-[#000066]"/>
            <input
                type="text"
                wire:model.live="searchName"
                placeholder="Nombre"
                class="w-full sm:w-72 rounded-xl border border-gray-300 px-3 py-2
                    focus:ring-1 focus:ring-[#000066] focus:border-[#000066]"/>
        </div>
    </div>

    <!-- Tabla -->
    <div class="border-2 border-[#000066] rounded-2xl overflow-hidden">

    <div class="overflow-x-auto">

        <table class="min-w-[850px] w-full divide-y divide-gray-200">
            <thead class="bg-[#F1F5F9] border-b-2 border-[#000066]">
            <tr class="hover:bg-[#F8FAFC] transition-all duration-200">
                <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">ID </th>
                <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">Nombre</th>
                <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">Fecha de Nacimiento</th>
                <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider w-64">Acciones</th>           
            </tr>
            </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($pets as $pet)
            <tr>
                <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm whitespace-nowrap">{{ $pet->id }}</td>

                <!-- Nombre clickeable -->
                <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm whitespace-nowrap text-blue-600 cursor-pointer"
                    wire:click="openModal({{ $pet->id }})">
                    {{ $pet->name }}
                </td>

                <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm whitespace-nowrap">
                    {{ $pet->bDate->format('d/m/Y') }}
                </td>

                <td class="px-3 sm:px-6 py-3 sm:py-4 w-64">
                <div class="flex items-center justify-center gap-2 sm:gap-4">

                        {{-- Botón Ver (por ahora comentado) --}}
                        {{--
                        <button
                            wire:click="openModal({{ $pet->id }})"
                            class="w-24 px-3 py-1 text-sm
                                border-2 border-[#000066]
                                text-[#000066]
                                rounded-lg
                                hover:bg-[#F1F5F9]
                                transition">
                            Ver
                        </button>
                        --}}

                        <button
                            wire:click="openDeleteModal({{ $pet->id }})"
                            class="w-24 px-3 py-1 text-xs sm:text-sm
                                border-2 border-[#000066]
                                text-[#000066]
                                rounded-lg
                                hover:bg-[#ff5555]
                                transition">
                            Eliminar
                        </button>

                    </div>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-4">No se encontraron mascotas</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
    <div class="mt-6 border-2 border-[#000066] rounded-2xl p-4 bg-[#F8FAFC]">
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
        <p><strong>Estado Actual:</strong> {{ $selectedPet->currentState?->state ?? 'Sin historial de estado' }}</p>

@if($selectedPet->owner)
    <p><strong>Dueño:</strong> {{ $selectedPet->owner->fName1 }} {{ $selectedPet->owner->sName1 }}</p>
    <p>
        <strong>Email:</strong>
        <a href="mailto:{{ $selectedPet->owner?->user?->email }}" class="text-blue-600 hover:underline">
            {{ $selectedPet->owner?->user?->email ?? 'No disponible' }}
        </a>
    </p>
    <p>
        <strong>Teléfono:</strong>
        <a href="https://wa.me/598{{ $selectedPet->owner?->user?->phone }}" target="_blank" class="text-green-600 hover:underline">
            {{ $selectedPet->owner?->user?->phone ?? 'No disponible' }}
        </a>
    </p>
@else
    <p><strong>Dueño:</strong> Sin dueño asignado</p>
@endif
        <button wire:click="closeModal"
                class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
            Cerrar
        </button>
    </div>
</div>
@endif
</div>


