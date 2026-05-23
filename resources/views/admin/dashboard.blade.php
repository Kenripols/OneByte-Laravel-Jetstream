<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Bienvenida -->
            <section class="bg-white rounded-2xl border border-blue-500 p-8">

                <h1 class="text-3xl font-bold text-[#000066]">
                    Bienvenido, {{ Auth::user()->name ?: Auth::user()->email }}
                </h1>

                <p class="mt-2 text-gray-500 text-lg">
                    Resumen general del sistema PetFinder
                </p>

            </section>


            <!-- CARRUSEL -->
            <section class="bg-white rounded-2xl border border-blue-500 p-6">

                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    Últimas publicaciones
                </h2>

                <div class="h-48 flex items-center justify-center rounded-xl bg-gray-100 text-gray-400">
                    Carrusel próximamente
                </div>

            </section>


            <!-- KPIs -->
            <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

                <!-- Usuarios -->
                <div class="bg-white rounded-2xl border border-blue-500 p-6">

                    <p class="text-sm font-medium text-gray-500">
                        Usuarios
                    </p>

                    <p class="mt-2 text-4xl font-bold text-blue-500">
                        --
                    </p>

                </div>

                <!-- Mascotas -->
                <div class="bg-white rounded-2xl border border-blue-500 shadow-sm p-6">

                    <p class="text-sm font-medium text-gray-500">
                        Mascotas
                    </p>

                    <p class="mt-2 text-4xl font-bold text-[#000066]">
                        {{ $totalPets }}
                    </p>

                </div>

                <!-- Perdidas -->
                <div class="bg-white rounded-2xl border border-blue-500 p-6">

                    <p class="text-sm font-medium text-gray-500">
                        Perdidas
                    </p>

                    <p class="mt-2 text-4xl font-bold text-yellow-500">
                        {{ $lostPets }}
                    </p>

                </div>

                <!-- Encontradas -->
                <div class="bg-white rounded-2xl border border-blue-500 p-6">

                    <p class="text-sm font-medium text-gray-500">
                        Encontradas
                    </p>

                    <p class="mt-2 text-4xl font-bold text-green-500">
                        {{ $foundPets }}
                    </p>

                </div>

            </section>


            <!-- GRÁFICA -->
            <section class="bg-white rounded-2xl border border-blue-500 p-6">

                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    Estadísticas
                </h2>

                <div class="h-72 flex items-center justify-center rounded-xl bg-gray-100 text-gray-400">
                    Gráfica próximamente
                </div>

            </section>


            <!-- ACTIVIDAD -->
            <section class="bg-white rounded-2xl border border-blue-500 p-6">

                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    Actividad reciente
                </h2>

                <div class="h-48 flex items-center justify-center rounded-xl bg-gray-100 text-gray-400">
                    Tabla próximamente
                </div>

            </section>

        </div>

    </div>
</x-app-layout>
