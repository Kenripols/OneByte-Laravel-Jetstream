<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Mascotas') }}
        </h2>
    </x-slot>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Raza</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Nacimiento</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($pets as $pet)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pet->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pet->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pet->breed }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pet->bDate }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $pets->links() }} <!-- Paginación -->
