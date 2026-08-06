<div>
    <!-- Filtros -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div class="flex flex-wrap gap-3">
        <input
            type="text"
            wire:model.live="searchId"
            placeholder="ID"
            class="w-full sm:w-24 rounded-xl border border-gray-300 px-3 py-2 text-sm
                focus:ring-1 focus:ring-[#000066] focus:border-[#000066]" />

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
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($pets as $pet)
                    <tr class="hover:bg-[#F8FAFC] transition-all duration-200">

                        <!-- ID -->
                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-600 whitespace-nowrap">
                            {{ $pet->id }}
                        </td>

                        <!-- Nombre -->
                        <td wire:click="openModal({{ $pet->id }})"
                            class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm font-semibold text-blue-600 cursor-pointer hover:underline whitespace-nowrap">
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
                        <td colspan="7" class="text-center py-6 text-gray-400">
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

    <!-- MODAL DETALLE / EDICIÓN -->
    @if($showModal && $selectedPet)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-2xl w-full max-w-sm max-h-[90vh] overflow-y-auto shadow-2xl">

            <!-- HEADER -->
            <div class="flex items-center justify-between px-5 pt-5 pb-3 border-b">
                <h2 class="text-lg font-bold text-gray-800">
                    @if($showReadingsMap)
                        Historial de {{ $selectedPet->name }}
                    @elseif($editMode)
                        Editar mascota
                    @else
                        {{ $selectedPet->name }}
                    @endif
                </h2>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>

            <div class="px-5 py-4 space-y-4">

                @if(!$showReadingsMap)
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

                <!-- CAMPOS -->
                <div class="space-y-3">

                    <!-- Nombre -->
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

                    <!-- Fecha de nacimiento -->
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

                    <!-- Raza -->
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

                    <!-- Estado -->
                    @if(!$editMode)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Estado</label>
                        @php
                            $stateClass = $selectedPet->isLost()
                                ? 'bg-red-100 text-red-600'
                                : ($selectedPet->current_state === \App\Enums\PetState::DEAD
                                    ? 'bg-gray-200 text-gray-600'
                                    : 'bg-green-100 text-green-600');
                        @endphp
                        <span class="inline-block px-2 py-1 text-xs rounded-full {{ $stateClass }}">
                            {{ $selectedPet->current_state?->label() ?? 'Sin estado' }}
                        </span>
                    </div>
                    @endif

                </div>

                @endif {{-- !showReadingsMap --}}

                <!-- MAPA DE LECTURAS -->
                @if($showReadingsMap)
                    <div class="border-t pt-4">
                        <h3 class="text-sm font-semibold text-gray-700 mb-2">Mapa de lecturas QR</h3>
                        <div id="map" wire:ignore class="w-full rounded-lg border border-gray-200" style="height: 220px;"></div>
                    </div>
                    @if(!empty($readings))
                        <div class="mt-3 p-3 bg-gray-50 rounded-lg text-sm max-h-40 overflow-y-auto">
                            <p class="font-semibold text-gray-700 mb-2">Historial</p>
                            @foreach($readings as $r)
                                <div class="text-xs text-gray-600 mb-1 border-b border-gray-100 pb-1 last:border-0">
                                    {{ $r['created_at'] ?? '' }} — {{ $r['lat'] ?? '' }}, {{ $r['lng'] ?? '' }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif

            </div>

            <!-- FOOTER -->
            <div class="px-5 pb-5 border-t pt-4 flex justify-between items-center gap-3">
                @if($showReadingsMap)
                    <button wire:click="closeModal"
                        class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                        Cerrar
                    </button>
                @elseif($editMode)
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

<!-- MODAL DE CONFIRMACIÓN PARA MARCAR COMO PERDIDA -->
@if($showLostConfirmModal)
<div class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[85vh] overflow-y-auto">
        <!-- Header -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 px-4 py-3 rounded-t-lg">
            <h3 class="text-base font-bold text-white leading-snug">
                Marcar a {{ $petNameToMarkLost }} como perdida
            </h3>
        </div>

        <!-- Body -->
        <div class="p-4 space-y-3 text-sm">
            <p class="text-gray-700">
                ¿Querés publicar una alerta para que otros ayuden a encontrar a <strong>{{ $petNameToMarkLost }}</strong>?
            </p>

            <div class="bg-amber-50 border-l-4 border-amber-500 p-3 rounded text-amber-900 text-xs leading-relaxed">
                <strong>Publicar alerta:</strong> escribí un breve mensaje visible en la comunidad.
            </div>

            <!-- Descripción (solo si quiere publicar) -->
            @if($showDescriptionForm)
            <div class="space-y-2 p-3 bg-red-50 rounded-lg border border-red-200">
                <div>
                    <label for="descriptionLost" class="block text-xs font-medium text-gray-700 mb-1">
                        Mensaje de la alerta
                    </label>
                    <textarea
                        wire:model.live="descriptionLost"
                        id="descriptionLost"
                        rows="3"
                        maxlength="80"
                        placeholder="Ej: Se perdió por el barrio sur, collar azul…"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 resize-none"></textarea>
                    @error('descriptionLost')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            @endif

            <!-- Acciones -->
            <div class="flex flex-col gap-2 pt-3 border-t border-gray-100">
                @if($showDescriptionForm)
                    <button
                        type="button"
                        wire:click="markAsLostWithPost"
                        class="w-full px-3 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                        Publicar alerta
                    </button>
                    <button
                        type="button"
                        wire:click="$set('showDescriptionForm', false)"
                        class="w-full px-3 py-2 text-sm text-red-700 bg-red-50 rounded-lg hover:bg-red-100 font-medium">
                        Volver
                    </button>
                @else
                    <button
                        type="button"
                        wire:click="$set('showDescriptionForm', true)"
                        class="w-full px-3 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                        Publicar alerta
                    </button>

                    <button
                        type="button"
                        wire:click="markAsLostWithoutPost"
                        class="w-full px-3 py-2 text-sm rounded-lg font-medium border-2 border-amber-600 bg-amber-50 text-amber-950 hover:bg-amber-100">
                        Solo marcar como perdida (sin publicar)
                    </button>
                @endif

                <button
                    type="button"
                    wire:click="closeLostConfirmModal"
                    class="w-full px-3 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                    Cancelar
                </button>
            </div>
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