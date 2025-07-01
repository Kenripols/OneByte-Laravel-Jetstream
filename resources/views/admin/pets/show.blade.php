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
        <p><strong>Tipo de Animal</strong> {{ $pet->breed ? $pet->breed->animalType : 'Sin tipo' }}</p>
        <p><strong>Raza:</strong> {{ $pet->breed ? $pet->breed->breedName : 'Sin raza' }}</p>
        <p><strong>Dueño:</strong> 
            @if($pet->owner)
                {{ $pet->owner->fname }} {{ $pet->owner->sName1 }} {{ $pet->owner->user->email}}
            @else
                Sin dueño asignado
            @endif
        </p>
        @if($pet->photo)
            <div class="mt-4">
                <img src="{{ asset('storage/' . $pet->photo) }}" alt="Foto de {{ $pet->name }}" class="w-48 h-48 object-cover rounded">
            </div>
        @endif
<!-- OPCIONES DE OWNER para Editar/ Eliminar Logicamente Mascota -->
        @role('owner')
            <div class="mt-6">
                <a href="{{ route('owner.pets.edit', $pet) }}" class="text-blue-600 hover:text-blue-900">Editar Mascota</a>
            </div>
            
            @endrole

        
    </div>
</x-app-layout>