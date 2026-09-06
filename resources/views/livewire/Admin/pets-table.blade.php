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

                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider ">
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

                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm font-semibold text-blue-600 cursor-pointer whitespace-nowrap"
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

    <!-- Modal -->
    @if($showModal && $selectedPet)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4 py-6">

        <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl w-full max-w-lg max-h-[90vh] flex flex-col shadow-2xl">

            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-200 shrink-0">

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Información de mascota
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-[#000066]">
                        {{ $editMode ? 'Editar mascota' : $selectedPet->name }}
                    </h2>
                </div>

                <button
                    wire:click="closeModal"
                    type="button"
                    class="flex items-center justify-center w-9 h-9 rounded-xl border-2 border-[#000066] bg-white text-[#000066] text-xl leading-none transition hover:bg-[#F1F5F9]"
                >
                    &times;
                </button>

            </div>

            <!-- Contenido scrolleable -->
            <div class="px-6 py-6 space-y-6 overflow-y-auto flex-1">

                <!-- Foto -->
                <div class="flex justify-center">

                    @if($editMode)

                        <div class="text-center">

                            @if($selectedPet->photo_url)

                                <img
                                    src="{{ $selectedPet->photo_url }}"
                                    class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-[#000066]"
                                >

                            @else

                                <div class="w-24 h-24 rounded-full bg-white flex items-center justify-center mx-auto border-2 border-dashed border-gray-300">
                                    <span class="text-gray-400 text-sm">
                                        Sin foto
                                    </span>
                                </div>

                            @endif

                            <label class="inline-block mt-3 text-sm font-semibold text-[#000066] cursor-pointer hover:underline">
                                Cambiar foto

                                <input
                                    type="file"
                                    wire:model="photo"
                                    accept="image/*"
                                    class="hidden"
                                >
                            </label>

                            @error('photo')
                                <p class="text-xs text-red-500 mt-2">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    @else

                        @if($selectedPet->photo_url)

                            <img
                                src="{{ $selectedPet->photo_url }}"
                                class="w-28 h-28 rounded-full object-cover border-2 border-[#000066]"
                            >

                        @else

                            <div class="w-28 h-28 rounded-full bg-white flex items-center justify-center border-2 border-dashed border-gray-300">
                                <span class="text-gray-400 text-sm">
                                    Sin foto
                                </span>
                            </div>

                        @endif

                    @endif

                </div>

                <!-- Campos Mascota -->
                <div class="space-y-5">

                    <div>
                        <label class="block text-sm font-semibold text-[#000066] mb-2">
                            Nombre
                        </label>

                        @if($editMode)

                            <input
                                type="text"
                                wire:model="name"
                                class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:ring-1 focus:ring-[#000066] focus:border-[#000066]"
                            >

                            @error('name')
                                <p class="text-xs text-red-500 mt-2">
                                    {{ $message }}
                                </p>
                            @enderror

                        @else

                            <div class="bg-white rounded-xl border border-gray-200 px-4 py-3">
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $selectedPet->name }}
                                </p>
                            </div>

                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#000066] mb-2">
                            Fecha de nacimiento
                        </label>

                        @if($editMode)

                            <input
                                type="date"
                                wire:model="bDate"
                                max="{{ now()->format('Y-m-d') }}"
                                class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:ring-1 focus:ring-[#000066] focus:border-[#000066]"
                            >

                            @error('bDate')
                                <p class="text-xs text-red-500 mt-2">
                                    {{ $message }}
                                </p>
                            @enderror

                        @else

                            <div class="bg-white rounded-xl border border-gray-200 px-4 py-3">
                                <p class="text-sm text-gray-800">
                                    {{ $selectedPet->bDate?->format('d/m/Y') ?? '-' }}
                                </p>
                            </div>

                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#000066] mb-2">
                            Raza
                        </label>

                        @if($editMode)

                            <select
                                wire:model="breed_id"
                                class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:ring-1 focus:ring-[#000066] focus:border-[#000066]"
                            >
                                @foreach($breeds as $breed)
                                    <option value="{{ $breed->id }}">
                                        {{ $breed->breedName }}
                                    </option>
                                @endforeach
                            </select>

                            @error('breed_id')
                                <p class="text-xs text-red-500 mt-2">
                                    {{ $message }}
                                </p>
                            @enderror

                        @else

                            <div class="bg-white rounded-xl border border-gray-200 px-4 py-3">
                                <p class="text-sm text-gray-800">
                                    {{ $selectedPet->breed?->breedName ?? '-' }}
                                </p>
                            </div>

                        @endif
                    </div>

                    <!-- Info del dueño (solo vista) -->
                    @if(!$editMode && $selectedPet->owner)

                        <div class="pt-5 border-t border-gray-200 space-y-3">

                            <p class="text-xs font-semibold text-[#000066] uppercase tracking-wider">
                                Dueño
                            </p>

                            <div class="bg-white rounded-xl border border-gray-200 px-4 py-3 space-y-2">

                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $selectedPet->owner->fName1 }} {{ $selectedPet->owner->sName1 }}
                                </p>

                                @if($selectedPet->owner->user?->email)

                                    <p class="text-sm text-gray-600">
                                        <a
                                            href="mailto:{{ $selectedPet->owner->user->email }}"
                                            class="text-[#000066] hover:underline"
                                        >
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

                        </div>

                    @endif

                </div>

            </div>

            <!-- Footer -->
            <div class="px-6 py-5 border-t border-gray-200 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 shrink-0">

                @if($editMode)

                    <button
                        wire:click="$set('editMode', false)"
                        type="button"
                        class="inline-flex items-center justify-center rounded-xl border-2 border-[#000066] bg-white px-5 py-2 text-sm font-semibold text-[#000066] transition hover:bg-[#F1F5F9]"
                    >
                        Cancelar
                    </button>

                    <button
                        wire:click="updatePet"
                        type="button"
                        class="inline-flex items-center justify-center rounded-xl border-2 border-[#000066] bg-white px-5 py-2 text-sm font-semibold text-[#000066] transition hover:bg-[#F1F5F9]"
                    >
                        Guardar cambios
                    </button>

                @else

                    <button
                        wire:click="closeModal"
                        type="button"
                        class="inline-flex items-center justify-center rounded-xl border-2 border-[#000066] bg-white px-5 py-2 text-sm font-semibold text-[#000066] transition hover:bg-[#F1F5F9]"
                    >
                        Cerrar
                    </button>

                    <button
                        wire:click="$set('editMode', true)"
                        type="button"
                        class="inline-flex items-center justify-center rounded-xl border-2 border-[#000066] bg-white px-5 py-2 text-sm font-semibold text-[#000066] transition hover:bg-[#F1F5F9]"
                    >
                        Editar
                    </button>

                @endif

            </div>

        </div>

    </div>
    @endif

</div>
