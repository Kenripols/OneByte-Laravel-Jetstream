<div>
    <!-- Filtros -->
    <div class="flex space-x-4 mb-4">
        <input type="text" wire:model.live="searchId" placeholder="Buscar por ID" class="border p-2 rounded" />
        <input type="text" wire:model.live="searchName" placeholder="Buscar por Nombre" class="border p-2 rounded" />
    </div>


    <!-- Botón crear (esto permite crear mascota sin QR, con el modelo actual es veneno)
    <div class="mb-4">
        <button type="button"
            wire:click="openCreateModal"
            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            + Nueva mascota
        </button>
    </div>
-->
    <!-- Tabla -->
    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">

    <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
        <tr>
            <th class="px-6 py-3 text-left">ID</th>
            <th class="px-6 py-3 text-left">Nombre</th>
            <th class="px-6 py-3 text-left">Estado</th>
            <th class="px-6 py-3 text-left">QR</th>
            <th class="px-6 py-3 text-left">Nacimiento</th>
<th class="px-6 py-3 text-left">Historial de Ubicacion</th>
            <th class="px-6 py-3 text-right">Acciones</th>
        </tr>
    </thead>

    <tbody class="bg-white divide-y">

    @forelse ($pets as $pet)
        <tr >

            <!-- ID -->
            <td class="px-6 py-4 text-sm text-gray-500">
                {{ $pet->id }}
            </td>

            <!-- Nombre -->
            <td wire:click="openModal({{ $pet->id }})"
                class="px-6 py-4 text-sm font-semibold text-blue-600 cursor-pointer">
                {{ $pet->name }}
            </td>

            <!-- Estado -->
            <td class="px-6 py-4">
                <span class="px-2 py-1 text-xs rounded whitespace-nowrap
                    @if($pet->isLost()) bg-red-100 text-red-600
                    @elseif($pet->current_state === \App\Enums\PetState::DEAD) bg-gray-200 text-gray-600
                    @else bg-green-100 text-green-600
                    @endif">

                    {{ $pet->current_state?->label() ?? 'Sin estado' }}

                </span>
            </td>

            <!-- QR -->
            <td class="px-6 py-4">
                @if($pet->hasQR())
                    <span class="px-2 py-1 text-xs bg-green-100 text-green-600 rounded whitespace-nowrap">
                        Activo
                    </span>

                @elseif($pet->isExpired())
                    <span class="px-2 py-1 text-xs bg-gray-200 text-gray-600 rounded whitespace-nowrap">
                        Caducado
                    </span>

                @else
                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-600 rounded whitespace-nowrap">
                        Pendiente
                    </span>
                @endif
            </td>

            <!-- Fecha -->
            <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                {{ $pet->bDate?->format('d/m/Y') ?? '-' }}
            </td>
            <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                @if($pet->hasQR())
                <button wire:click.stop="showReadings({{ $pet->id }})" class="text-indigo-600 hover:underline">
                    @if($pet->isLost())
                        Ubicaciones
                    @else
                        Historial
                    @endif
                </button>
                @endif
            </td>

            <!-- Acciones -->
            <td class="px-6 py-4 text-right">
                <div class="flex justify-end items-center gap-4 text-sm">

                    @if($pet->isLost())
                        <button wire:click.stop="markAsFound({{ $pet->id }})"
                            class="text-green-600 hover:underline">
                             Encontrada!!
                        </button>
                    @else
                        <button wire:click.stop="openLostConfirmModal({{ $pet->id }})"
                            class="text-red-600 hover:underline font-medium">
                            Está Perdida
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
    <!-- Paginación -->
    <div class="mt-4">
        {{ $pets->links() }}
    </div>

    <!-- MODAL DETALLE -->
    @if($showModal && $selectedPet)

<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

    <div class="bg-white rounded-xl p-5 w-full max-w-md max-h-[90vh] overflow-y-auto shadow-xl transition-all">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">
                {{ $selectedPet->name }}
            </h2>

            <!-- SWITCH -->
            <label class="flex items-center cursor-pointer">
                <span class="mr-2 text-sm text-gray-500">Editar</span>

                <div class="relative">
                    <input type="checkbox"
                        wire:model="editMode"
                        class="sr-only">

                    <div class="w-10 h-5 bg-gray-300 rounded-full shadow-inner"></div>

                    <div class="dot absolute left-0 top-0 w-5 h-5 bg-white rounded-full shadow transition
                        @if($this->editMode) translate-x-full bg-blue-500 @endif">
                    </div>
                </div>
            </label>
        </div>

        <!-- FOTO -->
       

        <!-- NOMBRE -->
        <div class="mb-3">
            <label class="text-xs text-gray-500">Nombre</label>

            @if(!$this->editMode)
                <p class="font-semibold">{{ $selectedPet->name }}</p>
            @else
                <input type="text" wire:model.defer="name"
                    class="w-full border p-2 rounded">
            @endif
        </div>

        <!-- FECHA -->
        <div class="mb-3">
            <label class="text-xs text-gray-500">Nacimiento</label>

            @if(!$this->editMode)
                <p>{{ $selectedPet->bDate?->format('d/m/Y') ?? '-' }}</p>
            @else
                <input type="date" wire:model.defer="bDate"
                    class="w-full border p-2 rounded">
            @endif
        </div>

        <!-- RAZA -->
        <div class="mb-3">
            <label class="text-xs text-gray-500">Raza</label>

            @if(!$this->editMode)
                <p>{{ $selectedPet->breed?->breedName ?? '-' }}</p>
            @else
                <select wire:model.defer="breed_id"
                    class="w-full border p-2 rounded">
                    @foreach($breeds as $breed)
                        <option value="{{ $breed->id }}">
                            {{ $breed->breedName }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        @if($showReadingsMap)
            <div class="mt-4 border-t pt-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Mapa de lecturas QR</h3>
                <div id="map" wire:ignore class="w-full rounded-lg border border-gray-200" style="height: 220px;"></div>
            </div>
            @if(!empty($readings))
                <div class="mt-3 p-3 bg-gray-50 rounded-lg text-sm max-h-40 overflow-y-auto">
                    <p class="font-semibold text-gray-700 mb-2">Historial</p>
                    @foreach($readings as $r)
                        <div class="text-xs text-gray-600 mb-1 border-b border-gray-100 pb-1 last:border-0">
                            {{ $r['created_at'] ?? '' }} → {{ $r['lat'] ?? '' }}, {{ $r['lng'] ?? '' }}
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        <!-- FOOTER -->
        <div class="flex justify-between mt-6">

            <button wire:click="closeModal"
                class="px-4 py-2 bg-gray-300 rounded">
                Cerrar
            </button>

            @if($this->editMode)
                <button wire:click="updatePet"
                    class="px-4 py-2 bg-green-600 text-white rounded">
                    Guardar cambios
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
                        wire:model="descriptionLost"
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
        renderPetMap('map', event.detail.points);
    });

});
</script>

@endpush
</div>