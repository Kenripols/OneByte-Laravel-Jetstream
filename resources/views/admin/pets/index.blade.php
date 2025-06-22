<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mascotas') }}
        </h2>

    </x-slot>

    <div class="py-12">
       
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
                        <!-- Para cada raza crear una fila donde las columnas sean los atributos ID , Tipo de Animal y nombre de la raza -->
                        @foreach ($pets as $pet)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pet->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pet->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pet->bDate }}</td>
                                <td class="px-6 py-4 whitespace-nowrap"> 
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $pets->links() }} <!-- Paginación -->
            </div>
        </div>
    </div>
    </x-app-layout>