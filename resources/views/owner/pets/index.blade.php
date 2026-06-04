<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mascotas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('owner.qrplates.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Asociar QR a Mascota</a>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <!-- Index con modal y Livewire -->
                @livewire('owner.pets-table')
            </div>
        </div>
    </div>
</x-app-layout>
