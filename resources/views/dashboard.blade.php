<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bienvenido a PetFindr') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="py-8 space-y-8">

        <!-- Bienvenida -->
        <div>
            <h1 class="text-3xl font-bold text-gray-800 text-center">
                Bienvenido: {{ Auth::user()->name }}
            </h1>
            <p class="text-2xl text-gray-500 mt-8 font-bold text-center">
                Información General del Sistema
            </p>
        </div>

        <!-- Tarjetas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 m-6">

            <!-- Usuarios -->
            <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full text-xl">
                    &#128100;
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-500">Usuarios</p>
                    <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                </div>
            </div>

            <!-- Mascotas -->
            <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
                <div class="bg-purple-100 text-purple-600 p-3 rounded-full text-xl">
                    &#128062;
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-500">Mascotas</p>
                    <p class="text-3xl font-bold">{{ $totalPets }}</p>
                </div>
            </div>

            <!-- Perdidas -->
            <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full text-xl">
                    &#128269;
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-500">Perdidas</p>
                    <p class="text-3xl font-bold">{{ $lostPets }}</p>
                </div>
            </div>

            <!-- Encontradas -->
            <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
                <div class="bg-green-100 text-green-600 p-3 rounded-full text-xl">
                    &#10084;
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-500">Encontradas</p>
                    <p class="text-3xl font-bold">{{ $foundPets }}</p>
                </div>
            </div>

        </div>

    </div>
                

            </div>
        </div>
    </div>
</x-app-layout>
