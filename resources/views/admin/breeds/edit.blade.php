<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar una raza') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="block mb-8">
                    
                <form action="{{ route('admin.breeds.update', $breed) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="animalType" class="block text-gray-700 font-bold mb-2">Tipo de Animal:</label>
                        <input type="text" name="animalType" id="animalType" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $breed->animalType }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="breedName" class="block text-gray-700 font-bold mb-2">Nombre de la Raza:</label>
                        <input type="text" name="breedName" id="breedName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $breed->breedName }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="size" class="block text-gray-700 font-bold mb-2">Tamaño:</label>
                        <input type="text" name="size" id="size" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $breed->size}}" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Actualizar Raza</button>
            </div>
        </div>
    </div>
</x-app-layout>

                     
                
