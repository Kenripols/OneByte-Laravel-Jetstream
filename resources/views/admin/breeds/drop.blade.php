<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Eliminar una raza') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="block mb-8">
                    
                <form action="{{ route('admin.breeds.destroy', $breed) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="mb-4">
                        <label for="animalType" class="block text-gray-700 font-bold mb-2">Tipo de Animal:</label>
                        {{ $breed->animalType }}

                    </div>
                    <div class="mb-4">
                        <label for="breedName" class="block text-gray-700 font-bold mb-2">Nombre de la Raza:</label>
                        {{ $breed->breedName }}
                    </div>
                    <div class="mb-4">
                        <label for="size" class="block text-gray-700 font-bold mb-2">Tamaño:</label>
                        {{ $breed->size }}"
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">¿Esta seguro de que desea eliminar esta Raza?</button>
            </div>
        </div>
    </div>
</x-app-layout>

                     
                
