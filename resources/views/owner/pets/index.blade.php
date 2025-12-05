<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mascotas') }}
        </h2>
    </x-slot>
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @role('owner')
       <!-- Boton de agregar mascota para owner -->
       <div class="block mb-8">
                <a href="{{ route('owner.pets.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Agregar nueva mascota</a>
            </div>
            @endrole
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <!-- Index con modal y Livewire -->
               @livewire('owner-pets-table')


                
            </div>
        </div>
    </div>
</x-app-layout>
