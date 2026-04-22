<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle de Mascota') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">{{ $pet->name }}</h1>

        <p><strong>Nombre:</strong> {{ $pet->name }}</p>
        <p><strong>Fecha de Nacimiento:</strong> {{ $pet->bDate ? $pet->bDate->format('d/m/Y') : 'No disponible' }}</p>
        <p><strong>Tipo de Animal:</strong> {{ $pet->breed ? $pet->breed->animalType : 'Sin tipo' }}</p>
        <p><strong>Raza:</strong> {{ $pet->breed ? $pet->breed->breedName : 'Sin raza' }}</p>

        <p><strong>Dueño:</strong> 
            @if($pet->owner)
                {{ $pet->owner->fName1 }} {{ $pet->owner->sName1 }} ({{ $pet->owner->user->email }})
            @else
                Sin dueño asignado
            @endif
        </p>

        @if($pet->photo)
            <div class="mt-4">
                <img src="{{ asset('storage/' . $pet->photo) }}" 
                     alt="Foto de {{ $pet->name }}" 
                     class="w-48 h-48 object-cover rounded">
            </div>
        @endif

        {{-- MAPA --}}
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-2"> Últimas ubicaciones</h3>
            <div id="map" style="height: 400px; border-radius: 10px;"></div>
        </div>

        {{-- OPCIONES OWNER --}}
        @role('owner')
        <div class="mt-6">
            <a href="{{ route('owner.pets.edit', $pet) }}" 
               class="text-blue-600 hover:text-blue-900">
               Editar Mascota
            </a>
        </div>
        @endrole
    </div>

    @push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {

        const map = L.map('map');

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const points = @json($points);

        // sin datos
        if (!points || points.length === 0) {
            map.setView([-34.9, -56.16], 13); // fallback Montevideo
            console.log("Sin ubicaciones");
            return;
        }

        //  punto de mapa + último
        points.forEach((p, index) => {
            const isLast = index === points.length - 1;

            L.marker([p.lat, p.lng], {
                icon: isLast
                    ? L.icon({
                        iconUrl: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
                        iconSize: [32, 32]
                      })
                    : undefined
            })
            .addTo(map)
            .bindPopup(
                isLast
                    ? "Última ubicación"
                    : '${p.time}'
            );
        });

        //recorrido
        if (points.length > 1) {
            const latlngs = points.map(p => [p.lat, p.lng]);

            L.polyline(latlngs, {
                color: 'red',
                weight: 4
            }).addTo(map);

            map.fitBounds(latlngs, { padding: [30, 30] });
        } else {
            // solo un punto
            map.setView([points[0].lat, points[0].lng], 15);
        }

    });
    </script>
    @endpush

</x-app-layout>