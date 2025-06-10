<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Razas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="block mb-8">
                <a href="{{ route('admin.breeds.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Agregar raza</a>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <!-- Nombre de columnas -->
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo de animal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Raza</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tamaño</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Para cada raza crear una fila donde las columnas sean los atributos ID , Tipo de Animal y nombre de la raza -->
                        @foreach ($breeds as $breed)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $breed->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $breed->animalType }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $breed->breedName }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $breed->size }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- Agrego botones para editar la raza -->
                                    <a href="{{ route('admin.breeds.edit', $breed) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $breeds->links() }} <!-- Paginación -->
            </div>
        </div>
    </div>
</x-app-layout>