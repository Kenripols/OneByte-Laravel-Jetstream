<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Usuario') }}</h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Perfil de Usuario</h1>

        <p><strong>Nombre de Usuario:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>

        @if($user->owner)
            <h2 class="text-xl font-semibold mt-6">Datos de Dueño</h2>
            <p><strong>Tipo de Documento:</strong> {{ $user->owner->docType }}</p>
            <p><strong>Numero de documento:</strong> {{ $user->owner->docNum }}</p>
            <p><strong>Primer Nombre:</strong> {{ $user->owner->fName1 }}</p>
            <p><strong>Segundo Nombre:</strong> {{ $user->owner->fName2 }}</p>
            <p><strong>Primer Apellido:</strong> {{ $user->owner->sName1 }}</p>
            <p><strong>Segundo Apellido:</strong> {{ $user->owner->sName2 }}</p>


            @if($user->owner->pets->isNotEmpty())
                <h2 class="text-xl font-semibold mt-6">Mascotas</h2>
                <ul class="list-disc list-inside">
                    @foreach ($user->owner->pets as $pet)
                        <li>
                            {{ $pet->name }} ({{ $pet->breed ? $pet->breed->name : 'Sin raza' }}) -
                            <a href="{{ route('admin.pets.show', $pet) }}" class="text-blue-600 hover:text-blue-900">Ver Detalles</a>
                            <a href="{{ route('admin.pets.edit', $pet) }}" class="text-green-600 hover:text-green-900 ml-2">Editar</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 mt-4">No hay mascotas registradas para este owner.</p>
            @endif
        @else
            <p class="text-gray-500 mt-4">Este usuario no tiene perfil de owner asociado.</p>
        @endif
    </div>            

    <div class="mb-4 mt-6">
        <a href="{{ route('admin.users.index') }}" 
                class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Volver</a>
    </div>
</x-app-layout>