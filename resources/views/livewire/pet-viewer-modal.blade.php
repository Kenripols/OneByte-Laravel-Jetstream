

<!-- Este modal se muestra al ver datos de una mascota desde el index de admin al ver detalles de usuario y clickear una mascota de las que tiene -->
<div>@if($showModal && $pet)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-[500px] shadow-lg">
        <h2 class="text-xl font-bold mb-4">{{ $pet->name }}</h2>
@if($pet->photo)
    <img src="{{ asset('storage/' . $pet->photo) }}"
         alt="Foto de {{ $pet->name }}"
         class="w-40 h-40 object-cover rounded mb-4">
@else
    <div class="w-40 h-40 bg-gray-200 rounded mb-4 flex items-center justify-center text-gray-500">
        Sin foto
    </div>
@endif
        <p><strong>ID:</strong> {{ $pet->id }}</p>
        <p><strong>Especie:</strong> {{ $pet->breed?->animalType ?? 'No disponible' }}</p>
        <p><strong>Raza:</strong> {{ $pet->breed?->breedName ?? 'No disponible' }}</p>
        <p><strong>Dueño:</strong> {{ $pet->owner?->fName1 }} {{ $pet->owner?->sName1 }}</p>
        <p><strong>Estado:</strong> {{ $pet->currentState?->state ?? 'No disponible' }}</p>
<!-- Muestra última lectura de QR -->
    @php
    $lastReading = $pet->qrPlate?->lastReading;
@endphp

<p>
    <strong>Última lectura:</strong>
    {{ $lastReading?->created_at?->format('d/m/Y H:i') ?? 'Sin lecturas' }}
</p>

@if($lastReading?->lat && $lastReading?->lng)
    <p>
        <strong>Ubicación:</strong>
        {{ $lastReading->lat }}, {{ $lastReading->lng }}
    </p>
@endif

        <button wire:click="closePetModal"
                class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
            Cerrar
        </button>
    </div>
</div>
@endif</div>
