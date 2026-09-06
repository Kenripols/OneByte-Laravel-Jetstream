<div>
    <!-- Filtros -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div class="flex flex-wrap gap-3">
        <input
            type="text"
            wire:model.live="searchName"
            placeholder="Nombre"
            class="w-full sm:w-72 rounded-xl border border-gray-300 px-3 py-2 text-sm
                focus:ring-1 focus:ring-[#000066] focus:border-[#000066]" />
    </div>
    
    <!-- Acción -->
    <a href="{{ route('owner.qrplates.create') }}"
        class="inline-flex items-center justify-center
            h-[38px]
            px-4
            rounded-xl
            border-2 border-[#000066]
            bg-white
            text-sm font-medium text-[#000066]
            transition
            hover:bg-[#F1F5F9]
            whitespace-nowrap">
        Asociar QR a Mascota
    </a>

</div>

<!-- Tabla -->
<div class="border-2 border-[#000066] rounded-2xl overflow-hidden bg-white">

    <div class="overflow-x-auto">

        <table class="min-w-[900px] w-full divide-y divide-gray-200">
            <thead class="bg-[#F1F5F9] border-b-2 border-[#000066]">
                <tr>
                    <th class="px-2 sm:px-3 py-2.5 text-center text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                        ID
                    </th>

                    <th class="px-2 sm:px-3 py-2.5 text-center text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                        Nombre
                    </th>

                    <th class="px-2 sm:px-3 py-2.5 text-center text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                        Estado Actual
                    </th>

                    <th class="px-2 sm:px-3 py-2.5 text-center text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                        QR
                    </th>

                    <th class="px-2 sm:px-3 py-2.5 text-center text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                        Nacimiento
                    </th>

                    <th class="px-2 sm:px-3 py-2.5 text-center text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                        Seguimiento
                    </th>

                    <th class="px-2 sm:px-3 py-2.5 text-center text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                        
                        ¿Que pasó?
                    </th>

                    <th class="px-2 sm:px-3 py-2.5 text-center text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                        
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($pets as $pet)
                    <tr class="hover:bg-[#F8FAFC] transition-all duration-200">
                        <!-- ID -->
                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-600 text-center whitespace-nowrap">
                            {{ $pet->id }}
                        </td>
                        <!-- Nombre -->
                        <td wire:click="openModal({{ $pet->id }})"
                            class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm font-semibold text-blue-600 cursor-pointer whitespace-nowrap">
                            {{ $pet->name }}
                        </td>

                        <!-- Estado -->
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-center">
                            <div class="flex justify-center">
                            <span class="inline-block px-2 py-1 text-xs rounded-full font-medium
                                @if($pet->isLost()) bg-red-100 text-red-600
                                @elseif($pet->current_state === \App\Enums\PetState::DEAD) bg-gray-200 text-gray-600
                                @else bg-green-100 text-green-600
                                @endif">

                                {{ $pet->current_state?->label() ?? 'Sin estado' }}

                            </span>
                            </div>
                        </td>

                        <!-- QR -->
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-center">
                            @if($pet->hasQR())
                                <div class="flex justify-center">
                                <span class="inline-block px-2 py-1 text-xs rounded-full font-medium bg-green-100 text-green-600">
                                    Activo
                                </span>
                                </div>
                            @elseif($pet->isExpired())
                                <div class="flex justify-center">
                                <span class="inline-block px-2 py-1 text-xs rounded-full font-medium bg-gray-200 text-gray-600">
                                    Caducado
                                </span>
                                </div>
                            @else
                                <div class="flex justify-center">
                                <span class="inline-block px-2 py-1 text-xs rounded-full font-medium bg-yellow-100 text-yellow-600">
                                    Pendiente
                                </span>
                                </div>
                            @endif
                        </td>

                        <!-- Fecha -->
                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-600 text-center whitespace-nowrap">
                            {{ $pet->bDate?->format('d/m/Y') ?? '-' }}
                        </td>

                        <!-- Historial -->
                        <td class="px-2 sm:px-3 py-2.5 whitespace-nowrap">
                            <div class="flex justify-center">
                            @if($pet->hasQR())
                                <button
                                    wire:click.stop="showReadings({{ $pet->id }})"
                                    class="px-3 py-1 text-xs sm:text-sm
                                        border-2 border-[#000066]
                                        text-[#000066]
                                        rounded-lg
                                        hover:bg-[#F1F5F9]
                                        transition">
                                    @if($pet->isLost())
                                        Ubicaciones
                                    @else
                                        Historial
                                    @endif
                                </button>
                            @else
                            <div class="flex justify-center">
                                <span class="text-gray-400">-</span>
                            </div>
                            @endif
                            </div>
                        </td>

                        <!-- Acciones -->
                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                            <div class="flex items-center justify-center gap-2 sm:gap-4">

                                @if($pet->isLost())
                                    <button
                                        wire:click.stop="markAsFound({{ $pet->id }})"
                                        class="px-3 py-1 text-xs sm:text-sm
                                            border-2 border-green-600
                                            text-green-700
                                            rounded-lg
                                            hover:bg-green-50
                                            transition">
                                        Fue Encontrada
                                    </button>
                                @else
                                    <button
                                        wire:click.stop="openLostConfirmModal({{ $pet->id }})"
                                        class="px-3 py-1 text-xs sm:text-sm
                                            border-2 border-red-600
                                            text-red-700
                                            rounded-lg
                                            hover:bg-red-50
                                            transition">
                                        Se ha Perdido
                                    </button>
                                @endif

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

<!-- Paginación -->
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

                        @if($showReadingsMap)
                            Historial de {{ $selectedPet->name }}
                        @elseif($editMode)
                            Editar mascota
                        @else
                            {{ $selectedPet->name }}
                        @endif

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

                @if(!$showReadingsMap)

                    <!-- Imagen -->
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


                                <label class="inline-block mt-3 text-sm font-semibold text-[#000066] cursor-pointer">

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


                    <!-- Campos -->
                    <div class="space-y-5">

                        <!-- Nombre -->
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


                        <!-- Fecha de nacimiento -->
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


                        <!-- Raza -->
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


                        <!-- Estado -->
                        @if(!$editMode)

                            <div>

                                <label class="block text-sm font-semibold text-[#000066] mb-2">
                                    Estado
                                </label>

                                @php

                                    $stateClass = $selectedPet->isLost()
                                        ? 'bg-red-100 text-red-600'
                                        : ($selectedPet->current_state === \App\Enums\PetState::DEAD
                                            ? 'bg-gray-200 text-gray-600'
                                            : 'bg-green-100 text-green-600');

                                @endphp

                                <span class="inline-block px-3 py-1.5 text-xs font-semibold rounded-full {{ $stateClass }}">

                                    {{ $selectedPet->current_state?->label() ?? 'Sin estado' }}

                                </span>

                            </div>

                        @endif

                    </div>

                @endif


                <!-- Mapa de lecturas -->
                @if($showReadingsMap)

                    <div class="border-t border-gray-200 pt-5">

                        <h3 class="text-lg font-semibold text-[#000066] mb-3">
                            Mapa de lecturas QR
                        </h3>

                        <div
                            id="map"
                            wire:ignore
                            class="w-full rounded-xl border-2 border-[#000066]"
                            style="height: 220px;"
                        ></div>

                    </div>


                    @if(!empty($readings))

                        <div class="bg-white border border-gray-200 rounded-xl p-4">

                            <p class="text-sm font-semibold text-[#000066] mb-3">
                                Historial
                            </p>

                            <div class="max-h-40 overflow-y-auto space-y-2">

                                @foreach($readings as $r)

                                    <div class="text-xs text-gray-600 border-b border-gray-100 pb-2 last:border-0">

                                        {{ $r['created_at'] ?? '' }}
                                        —
                                        {{ $r['lat'] ?? '' }},
                                        {{ $r['lng'] ?? '' }}

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    @endif

                @endif

            </div>


            <!-- Footer -->
            <div class="px-6 py-5 border-t border-gray-200 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 shrink-0">

                @if($showReadingsMap)

                    <button
                        wire:click="closeModal"
                        type="button"
                        class="inline-flex items-center justify-center rounded-xl border-2 border-[#000066] bg-white px-5 py-2 text-sm font-semibold text-[#000066] transition hover:bg-[#F1F5F9]"
                    >
                        Cerrar
                    </button>


                @elseif($editMode)

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

<!-- Modal de confirmación para marcar como perdida -->
    @if($showLostConfirmModal)
    <div class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 px-4 py-6">

        <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl w-full max-w-lg max-h-[90vh] flex flex-col shadow-2xl">

            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-200 shrink-0">

                <div>

                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Estado de la mascota
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-[#000066]">
                        Marcar como perdida
                    </h2>

                </div>

                <button
                    wire:click="closeLostConfirmModal"
                    type="button"
                    class="flex items-center justify-center w-9 h-9 rounded-xl border-2 border-[#000066] bg-white text-[#000066] text-xl leading-none transition hover:bg-[#F1F5F9]"
                >
                    &times;
                </button>

            </div>


            <!-- Contenido -->
            <div class="px-6 py-6 space-y-6 overflow-y-auto flex-1">

                <!-- Mascota -->
                <div class="bg-[#EEF5FF] border border-[#000066]/20 rounded-2xl px-5 py-4">

                    <p class="text-xs font-semibold text-[#000066] uppercase tracking-wider">
                        Mascota
                    </p>

                    <p class="mt-2 text-base font-bold text-[#000066]">
                        {{ $petNameToMarkLost }}
                    </p>

                </div>


                <!-- Información -->
                <div>

                    <p class="text-sm text-gray-600 leading-relaxed">
                        ¿Querés publicar una alerta para que otras personas puedan ayudar a encontrar a
                        <strong class="text-gray-800">{{ $petNameToMarkLost }}</strong>?
                    </p>

                </div>


                <!-- Formulario de publicación -->
                @if($showDescriptionForm)

                    <div class="bg-white border border-gray-200 rounded-2xl p-5">

                        <div class="mb-4">

                            <h3 class="text-base font-semibold text-[#000066]">
                                Publicar alerta
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Escribí un breve mensaje para acompañar la alerta.
                            </p>

                        </div>


                        <div>

                            <label
                                for="descriptionLost"
                                class="block text-sm font-semibold text-[#000066] mb-2"
                            >
                                Mensaje de la alerta
                            </label>

                            <textarea
                                wire:model.live="descriptionLost"
                                id="descriptionLost"
                                rows="4"
                                maxlength="80"
                                placeholder="Ej: Se perdió por el barrio sur, collar azul..."
                                class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm resize-none focus:ring-1 focus:ring-[#000066] focus:border-[#000066]"
                            ></textarea>

                            @error('descriptionLost')

                                <p class="text-xs text-red-500 mt-2">
                                    {{ $message }}
                                </p>

                            @enderror

                            <p class="mt-2 text-xs text-gray-400">
                                Máximo 80 caracteres.
                            </p>

                        </div>

                    </div>

                @else

                    <!-- Opciones -->
                    <div>

                        <p class="text-sm font-semibold text-[#000066] mb-3">
                            ¿Cómo querés continuar?
                        </p>

                        <div class="space-y-3">

                            <!-- Publicar -->
                            <button
                                type="button"
                                wire:click="$set('showDescriptionForm', true)"
                                class="w-full text-left bg-white border-2 border-[#000066] rounded-2xl px-5 py-4 transition hover:bg-[#F1F5F9]"
                            >

                                <p class="text-sm font-semibold text-[#000066]">
                                    Publicar alerta
                                </p>

                                <p class="mt-1 text-xs text-gray-500 leading-relaxed">
                                    Crear una publicación para que la comunidad pueda ayudar a encontrarla.
                                </p>

                            </button>


                            <!-- Solo marcar -->
                            <button
                                type="button"
                                wire:click="markAsLostWithoutPost"
                                class="w-full text-left bg-white border border-gray-200 rounded-2xl px-5 py-4 transition hover:bg-[#F1F5F9]"
                            >

                                <p class="text-sm font-semibold text-gray-800">
                                    Solo marcar como perdida
                                </p>

                                <p class="mt-1 text-xs text-gray-500 leading-relaxed">
                                    Cambiar el estado de la mascota sin publicar una alerta.
                                </p>

                            </button>

                        </div>

                    </div>

                @endif

            </div>


            <!-- Footer -->
            <div class="px-6 py-5 border-t border-gray-200 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 shrink-0">

                @if($showDescriptionForm)

                    <button
                        type="button"
                        wire:click="$set('showDescriptionForm', false)"
                        class="inline-flex items-center justify-center rounded-xl border-2 border-[#000066] bg-white px-5 py-2.5 text-sm font-semibold text-[#000066] transition hover:bg-[#F1F5F9]"
                    >
                        Volver
                    </button>

                    <button
                        type="button"
                        wire:click="markAsLostWithPost"
                        class="inline-flex items-center justify-center rounded-xl border-2 border-[#000066] bg-white px-5 py-2.5 text-sm font-semibold text-[#000066] transition hover:bg-[#F1F5F9]"
                    >
                        Publicar alerta
                    </button>

                @else

                    <button
                        type="button"
                        wire:click="closeLostConfirmModal"
                        class="inline-flex items-center justify-center rounded-xl border-2 border-[#000066] bg-white px-5 py-2.5 text-sm font-semibold text-[#000066] transition hover:bg-[#F1F5F9]"
                    >
                        Cancelar
                    </button>

                @endif

            </div>

        </div>

    </div>
    @endif


@push('scripts')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('livewire:init', () => {
    window.addEventListener('show-map', (event) => {
        setTimeout(() => renderPetMap('map', event.detail.points), 150);
    });
});
</script>

@endpush
</div>