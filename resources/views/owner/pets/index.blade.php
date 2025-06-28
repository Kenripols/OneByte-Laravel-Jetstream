<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mascotas') }}
        </h2>

    </x-slot>
    <!-- Muestro mensaje de error -->
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @role('owner')
       <!-- Boton de agregar mascota para owner -->
       <div class="block mb-8">
                <a href="{{ route('owner.pets.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Agregar nueva mascota</a>
            </div>
            @endrole

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <!-- Nombre de columnas -->
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Nacimiento</th>
                            
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($pets as $pet)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pet->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pet->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pet->bDate }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- Distingo entre rol admin y rol owner para mostrar botón -->
                                    @role('admin')
                                    <a href="{{ route('admin.pets.show', $pet) }}" class="text-blue-600 hover:text-blue-900">Ver Detalles</a> 
                                    @endrole
                                    @role('owner')
                                    <a href="{{ route('owner.pets.show', $pet) }}" class="text-blue-600 hover:text-blue-900">Ver Detalles</a>
                                    @endrole
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $pets->links() }} <!-- Paginación -->
            </div>
        </div>
    </div>
</div>
    </x-app-layout>