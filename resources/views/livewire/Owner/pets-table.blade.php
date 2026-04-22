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



            <!-- Acciones -->
            <td class="px-6 py-4 text-right">
                <div class="flex justify-end items-center gap-4 text-sm">

                  
                    @if($pet->isLost())
                        <button wire:click.stop="markAsFound({{ $pet->id }})"
                            class="text-green-600 hover:underline">
                             Encontrada!!
                        </button>
                    @else
                        <button wire:click.stop="markAsLost({{ $pet->id }})"
                            class="text-red-600 hover:underline">
                            Está Perdida
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
    <!-- Paginación -->
    <div class="mt-4">
        {{ $pets->links() }}
    </div>

    <!-- MODAL DETALLE -->
    @if($showModal && $selectedPet)

<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl transition-all">

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
        <div class="mt-4">
            <div id="map" wire:ignore style="height: 400px;"></div>
        </div>
        @if($readings && count($readings))
            <div class="mt-4 p-4 bg-gray-100 rounded">
                <h3 class="font-bold mb-2"> Historial de lecturas</h3>

                @foreach($readings as $r)
                    <div class="text-sm mb-1">
                        {{ $r->created_at }} → {{ $r->lat }}, {{ $r->lng }}
                    </div>
                @endforeach
            </div>
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
@push('scripts')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('livewire:init', () => {

    window.addEventListener('show-map', (event) => {

        console.log("MAPA OK", event.detail);

        const points = event.detail.points;

        if (!points || points.length === 0) {
            console.log("sin puntos");
            return;
        }

        let tries = 0;

        const waitForMap = setInterval(() => {
            const mapContainer = document.getElementById('map');

            if (mapContainer) {
                clearInterval(waitForMap);

                if (window.mapInstance) {
                    window.mapInstance.remove();
                }

                setTimeout(() => {

                    const map = L.map('map', {
                        preferCanvas: true
                    });

                    window.mapInstance = map;

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap'
                    }).addTo(map);

                    const latlngs = points.map(p => [p.lat, p.lng]);

                    //  línea del recorrido
                    L.polyline(latlngs, {
                        color: 'red',
                        weight: 4
                    }).addTo(map);

                    //  markers + popup
                    points.forEach((p, i) => {

                        const isLast = i === points.length - 1;

                        let icon = L.icon({
                            iconUrl: isLast
                                ? 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
                                : 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                            iconSize: isLast ? [32, 32] : [28, 28],
                            iconAnchor: isLast ? [16, 32] : [14, 28]
                        });

                        const imageUrl = p.photo 
                            ? `/storage/${p.photo}` 
                            : null;

                        const popupContent = `
                            <div style="width:200px;">

                                ${imageUrl ? `
                                    <img src="${imageUrl}" 
                                        style="width:100%; height:120px; object-fit:cover; border-radius:8px; margin-bottom:6px;" />
                                ` : ``}

                                ${p.message ? `
                                    <div style="font-size:13px; margin-bottom:6px;">
                                         ${p.message}
                                    </div>
                                ` : `
                                    <div style="font-size:12px; color:gray;">
                                        Sin mensaje
                                    </div>
                                `}

                                <div style="font-size:11px; color:gray;">
                                    ${isLast ? "Última ubicación" : p.time}
                                </div>

                            </div>
                        `;

                        L.marker([p.lat, p.lng], { icon })
                            .addTo(map)
                            .bindPopup(popupContent);
                    });

                    //  esto va FUERA del foreach
                    map.fitBounds(latlngs, { padding: [30, 30] });

                    setTimeout(() => {
                        map.invalidateSize();
                    }, 200);

                }, 200);
            }

            tries++;
            if (tries > 15) {
                clearInterval(waitForMap);
                console.log("map nunca apareció");
            }

        }, 100);

    });

});
</script>

@endpush
</div>