<div>@if($showModal && $pet)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-[500px] shadow-lg">
        <h2 class="text-xl font-bold mb-4">{{ $pet->name }}</h2>

        <p><strong>ID:</strong> {{ $pet->id }}</p>
        <p><strong>Raza:</strong> {{ $pet->breed?->name ?? 'No disponible' }}</p>
        <p><strong>Dueño:</strong> {{ $pet->owner?->fName1 }} {{ $pet->owner?->sName1 }}</p>
        <p><strong>Estado:</strong> {{ $pet->currentState?->state ?? 'No disponible' }}</p>

        <button wire:click="closePetModal"
                class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
            Cerrar
        </button>
    </div>
</div>
@endif</div>
