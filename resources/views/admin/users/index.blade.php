<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <!-- Nombre de columnas -->
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo Electrónico</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Creación</th>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Para cada usuario crear una fila donde las columnas sean los atributos ID , email y fecha de creación -->
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->created_at }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- Agrego botones para editar los datos de usuario -->
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900">Ver Datos</a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $users->links() }} <!-- Paginación -->
            </div>
        </div>
    </div>
                        </x-app-layout>