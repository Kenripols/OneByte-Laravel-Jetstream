<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Razas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h1>Lista de Razas</h1>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($breeds as $breed)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $breed->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $breed->breedName }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- Aquí puedes agregar botones para editar o eliminar la raza -->
                                    <a href="{{ route('admin.breeds.edit', $breed) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                    |
                                    <form action="{{ route('admin.breeds.destroy', $breed) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
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