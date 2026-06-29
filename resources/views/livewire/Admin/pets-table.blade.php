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

    @if(session('success'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabla -->
    <div class="border-2 border-[#000066] rounded-2xl overflow-hidden">

    <div class="overflow-x-auto">

        <table class="min-w-[950px] w-full divide-y divide-gray-200">
            <thead class="bg-[#F1F5F9] border-b-2 border-[#000066]">
                <tr class="hover:bg-[#F8FAFC] transition-all duration-200">
                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                        ID
                    </th>

                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                        Nombre
                    </th>

                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                        Raza
                    </th>

                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                        Dueño
                    </th>

                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                        Nacimiento
                    </th>

                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider w-64">
                        Acciones
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($pets as $pet)
                    <tr class="hover:bg-[#F8FAFC] transition-all duration-200">
                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-600 whitespace-nowrap">
                            {{ $pet->id }}
                        </td>

                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm font-semibold text-blue-600 cursor-pointer hover:underline whitespace-nowrap"
                            wire:click="openModal({{ $pet->id }})">
                            {{ $pet->name }}
                        </td>

                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-600 whitespace-nowrap">
                            {{ $pet->breed?->breedName ?? '-' }}
                        </td>

                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-600 whitespace-nowrap">
                            {{ $pet->owner?->fName1 }} {{ $pet->owner?->sName1 }}
                        </td>

                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-600 whitespace-nowrap">
                            {{ $pet->bDate?->format('d/m/Y') ?? '-' }}
                        </td>

                        <td class="px-3 sm:px-6 py-3 sm:py-4 w-64">
                            <div class="flex items-center justify-center gap-2 sm:gap-4">

                                <button
                                    wire:click="openModal({{ $pet->id }})"
                                    class="w-24 px-3 py-1 text-xs sm:text-sm
                                        border-2 border-[#000066]
                                        text-[#000066]
                                        rounded-lg
                                        hover:bg-[#F1F5F9]
                                        transition">
                                    Editar
                                </button>

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
                        <td colspan="6" class="text-center py-6 text-gray-400">
                            No se encontraron mascotas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

<div class="mt-6 border-2 border-[#000066] rounded-2xl p-4 bg-[#F8FAFC]">
        {{ $pets->links() }}
    </div>

    <!-- MODAL -->
    <!-- MODAL CONFIRMAR BORRADO -->
    @if($showDeleteModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-2xl w-full max-w-sm shadow-2xl">

            <div class="flex items-center justify-between px-5 pt-5 pb-3 border-b">
                <h2 class="text-lg font-bold text-gray-800">Eliminar mascota</h2>
                <button wire:click="closeDeleteModal" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>

            <div class="px-5 py-5 text-sm text-gray-600">
                ¿Estás seguro de que querés eliminar a <span class="font-semibold text-gray-800">{{ $deletingPetName }}</span>?
                Esta acción puede revertirse más adelante.
            </div>

            <div class="px-5 pb-5 border-t pt-4 flex justify-end gap-3">
                <button wire:click="closeDeleteModal"
                    class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    Cancelar
                </button>
                <button wire:click="deletePet"
                    class="px-4 py-2 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600 font-medium">
                    Eliminar
                </button>
            </div>

        </div>
    </div>
    @endif

    @if($showModal && $selectedPet)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-2xl w-full max-w-sm max-h-[90vh] overflow-y-auto shadow-2xl">

            <!-- HEADER -->
            <div class="flex items-center justify-between px-5 pt-5 pb-3 border-b">
                <h2 class="text-lg font-bold text-gray-800">
                    {{ $editMode ? 'Editar mascota' : $selectedPet->name }}
                </h2>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>

            <div class="px-5 py-4 space-y-4">

                <!-- FOTO -->
                <div class="flex justify-center">
                    @if($editMode)
                        <div class="text-center">
                            @if($selectedPet->photo_url)
                                <img src="{{ $selectedPet->photo_url }}"
                                     class="w-20 h-20 rounded-full object-cover mx-auto mb-2 border-2 border-gray-200">
                            @else
                                <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-2 border-2 border-dashed border-gray-300">
                                    <span class="text-gray-400 text-xs">Sin foto</span>
                                </div>
                            @endif
                            <label class="text-xs text-blue-600 cursor-pointer hover:underline">
                                Cambiar foto
                                <input type="file" wire:model="photo" accept="image/*" class="hidden">
                            </label>
                            @error('photo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    @else
                        @if($selectedPet->photo_url)
                            <img src="{{ $selectedPet->photo_url }}"
                                 class="w-24 h-24 rounded-full object-cover border-2 border-gray-200">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center border-2 border-dashed border-gray-300">
                                <span class="text-gray-400 text-sm">Sin foto</span>
                            </div>
                        @endif
                    @endif
                </div>

                <!-- CAMPOS MASCOTA -->
                <div class="space-y-3">

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Nombre</label>
                        @if($editMode)
                            <input type="text" wire:model="name"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        @else
                            <p class="text-sm font-semibold text-gray-800">{{ $selectedPet->name }}</p>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Fecha de nacimiento</label>
                        @if($editMode)
                            <input type="date" wire:model="bDate"
                                max="{{ now()->format('Y-m-d') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                            @error('bDate') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        @else
                            <p class="text-sm text-gray-800">{{ $selectedPet->bDate?->format('d/m/Y') ?? '-' }}</p>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Raza</label>
                        @if($editMode)
                            <select wire:model="breed_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                                @foreach($breeds as $breed)
                                    <option value="{{ $breed->id }}">{{ $breed->breedName }}</option>
                                @endforeach
                            </select>
                            @error('breed_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        @else
                            <p class="text-sm text-gray-800">{{ $selectedPet->breed?->breedName ?? '-' }}</p>
                        @endif
                    </div>

                    <!-- Info del dueño (solo vista) -->
                    @if(!$editMode && $selectedPet->owner)
                        <div class="border-t pt-3 mt-3 space-y-2">
                            <p class="text-xs font-medium text-gray-500 uppercase">Dueño</p>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $selectedPet->owner->fName1 }} {{ $selectedPet->owner->sName1 }}
                            </p>
                            @if($selectedPet->owner->user?->email)
                                <p class="text-sm text-gray-600">
                                    <a href="mailto:{{ $selectedPet->owner->user->email }}"
                                       class="text-blue-600 hover:underline">
                                        {{ $selectedPet->owner->user->email }}
                                    </a>
                                </p>
                            @endif
                            @if($selectedPet->owner->user?->phone)
                                <p class="text-sm text-gray-600">
                                    {{ $selectedPet->owner->user->phone }}
                                </p>
                            @endif
                        </div>
                    @endif

                </div>

            </div>

            <!-- FOOTER -->
            <div class="px-5 pb-5 border-t pt-4 flex justify-between gap-3">
                @if($editMode)
                    <button wire:click="$set('editMode', false)"
                        class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                        Cancelar
                    </button>
                    <button wire:click="updatePet"
                        class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        Guardar cambios
                    </button>
                @else
                    <button wire:click="closeModal"
                        class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                        Cerrar
                    </button>
                    <button wire:click="$set('editMode', true)"
                        class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        Editar
                    </button>
                @endif
            </div>

        </div>
    </div>
    @endif

</div>
